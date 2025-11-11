<div align="center">
    <img src="https://github.com/benbjurstrom/otpz/blob/main/art/email.png?raw=true" alt="OTPz Screenshot">
</div>

# First Factor One-Time Passwords for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/benbjurstrom/otpz.svg?style=flat-square)](https://packagist.org/packages/benbjurstrom/otpz)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/benbjurstrom/otpz/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/benbjurstrom/otpz/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/benbjurstrom/otpz/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/benbjurstrom/otpz/actions?query=workflow%3A\"Fix+PHP+code+style+issues\"+branch%3Amain)

This package provides secure first factor one-time passwords (OTPs) for Laravel applications. Users enter their email and receive a one-time code to sign in—no passwords required.

## Features

- ✅ **Session-locked** - OTPs only work in the browser session that requested them
- ✅ **Rate-limited** - Configurable throttling with multi-tier limits
- ✅ **Time-based expiration** - Default 5 minutes, fully configurable
- ✅ **Invalidated after first use** - One-time use only
- ✅ **Attempt limiting** - Invalidated after 3 failed attempts
- ✅ **Signed URLs** - Cryptographic signature validation
- ✅ **Detailed error messages** - Clear feedback for users
- ✅ **Customizable templates** - Bring your own email design
- ✅ **Auditable** - Full event logging via Laravel events

---

## Quick Start

### Prerequisites

OTPz requires one of the official [Laravel Breeze starter kits](https://laravel.com/docs/starter-kits#laravel-breeze):
- Laravel Breeze with **React** (Inertia.js)
- Laravel Breeze with **Vue** (Inertia.js)
- Laravel Breeze with **Livewire** (Volt)

> **Note:** OTPz components are designed to work with the official Laravel Breeze starter kits and use their existing UI components (Button, Input, Label, etc.). For reference implementations, see the [starter kit diffs](#starter-kit-reference).

---

## Installation

### 1. Install the Package

```bash
composer require benbjurstrom/otpz
```

### 2. Run Migrations

```bash
php artisan vendor:publish --tag="otpz-migrations"
php artisan migrate
```

### 3. Add Interface and Trait to User Model

```php
// app/Models/User.php
namespace App\Models;

use BenBjurstrom\Otpz\Models\Concerns\HasOtps;
use BenBjurstrom\Otpz\Models\Concerns\Otpable;
// ...

class User extends Authenticatable implements Otpable
{
    use HasFactory, Notifiable, HasOtps;

    // ...
}
```

---

## Framework-Specific Setup

Choose your frontend framework:

### React (Inertia.js)

#### 1. Install Frontend Components

```bash
npx shadcn@latest add https://benbjurstrom.github.io/otpz/r/react.json
```

This installs:
- `resources/js/pages/auth/otpz-login.tsx` - Email entry page
- `resources/js/pages/auth/otpz-verify.tsx` - OTP code entry page
- `app/Http/Controllers/Auth/OtpzController.php` - Backend controller

#### 2. Add Routes

Add to `routes/web.php`:

```php
use App\Http\Controllers\Auth\OtpzController;

Route::middleware('guest')->group(function () {
    Route::get('otpz/{id}', [OtpzController::class, 'get'])
        ->name('otpz.get')
        ->middleware('signed');

    Route::post('otpz/{id}', [OtpzController::class, 'store'])
        ->name('otpz.post')
        ->middleware('signed');
});
```

#### 3. Update Your Login Flow

Replace your existing password-based login with OTP authentication. Update your login controller to:

```php
use BenBjurstrom\Otpz\Actions\SendOtp;
use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;

// In your login method:
try {
    $otp = (new SendOtp)->handle($email, $remember);
} catch (OtpThrottleException $e) {
    throw ValidationException::withMessages([
        'email' => $e->getMessage(),
    ]);
}

return Inertia::location($otp->url);
```

---

### Vue (Inertia.js)

#### 1. Install Frontend Components

```bash
npx shadcn@latest add https://benbjurstrom.github.io/otpz/r/vue.json
```

This installs:
- `resources/js/pages/auth/OtpzLogin.vue` - Email entry page
- `resources/js/pages/auth/OtpzVerify.vue` - OTP code entry page
- `app/Http/Controllers/Auth/OtpzController.php` - Backend controller

#### 2. Add Routes

Add to `routes/web.php`:

```php
use App\Http\Controllers\Auth\OtpzController;

Route::middleware('guest')->group(function () {
    Route::get('otpz/{id}', [OtpzController::class, 'get'])
        ->name('otpz.get')
        ->middleware('signed');

    Route::post('otpz/{id}', [OtpzController::class, 'store'])
        ->name('otpz.post')
        ->middleware('signed');
});
```

#### 3. Update Your Login Flow

Replace your existing password-based login with OTP authentication. Update your login controller to:

```php
use BenBjurstrom\Otpz\Actions\SendOtp;
use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;

// In your login method:
try {
    $otp = (new SendOtp)->handle($email, $remember);
} catch (OtpThrottleException $e) {
    throw ValidationException::withMessages([
        'email' => $e->getMessage(),
    ]);
}

return Inertia::location($otp->url);
```

---

### Livewire (Volt)

#### 1. Publish Views

```bash
php artisan vendor:publish --tag="otpz-livewire"
```

This publishes:
- `resources/views/livewire/pages/auth/otpz-login.blade.php` - Email entry page
- `resources/views/livewire/pages/auth/otpz-verify.blade.php` - OTP code entry page

#### 2. Add Routes

The OTP verification route is already provided by the package. You only need to ensure your login page route uses the published Volt component:

```php
// In your routes/web.php
Volt::route('login', 'livewire.pages.auth.otpz-login')
    ->middleware('guest')
    ->name('login');
```

The package provides the `PostOtpController` for handling OTP submissions, so no additional controller setup is needed.

---

## Configuration

### Publish Configuration File (Optional)

```bash
php artisan vendor:publish --tag="otpz-config"
```

Available options:

```php
return [
    // OTP expiration time in minutes (default: 5)
    'expiration' => 5,

    // Multi-tier rate limiting
    'limits' => [
        ['limit' => 1, 'minutes' => 1],   // 1 request per minute
        ['limit' => 3, 'minutes' => 5],   // 3 requests per 5 minutes
        ['limit' => 5, 'minutes' => 30],  // 5 requests per 30 minutes
    ],

    // User model
    'models' => [
        'authenticatable' => App\Models\User::class,
    ],

    // Custom mailable class
    'mailable' => BenBjurstrom\Otpz\Mail\OtpzMail::class,

    // Email template
    'template' => 'otpz::mail.otpz',

    // User resolver (for finding/creating users by email)
    'user_resolver' => BenBjurstrom\Otpz\Actions\GetUserFromEmail::class,
];
```

---

## Customization

### Email Templates

Publish the email templates to customize styling:

```bash
php artisan vendor:publish --tag="otpz-views"
```

This publishes:
```
resources/views/vendor/otpz/
├── mail/
│   ├── otpz.blade.php          # Custom styled template
│   └── notification.blade.php  # Laravel notification template
└── components/
    └── template.blade.php
```

Switch between templates in `config/otpz.php`:
```php
'template' => 'otpz::mail.notification', // Use Laravel's default styling
```

### Custom User Resolution

By default, OTPz creates new users when an email doesn't exist. Customize this behavior:

```php
// Create your own resolver
namespace App\Actions;

use BenBjurstrom\Otpz\Contracts\UserResolver;

class MyUserResolver implements UserResolver
{
    public function resolve(string $email): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        // Your custom logic
        return User::where('email', $email)->firstOrFail();
    }
}
```

Update `config/otpz.php`:
```php
'user_resolver' => App\Actions\MyUserResolver::class,
```

---

## Starter Kit Reference

For complete integration examples with Laravel Breeze, see these diffs showing all required changes:

### React Starter Kit
View the complete diff: [Laravel React Starter Kit → OTPz React](https://github.com/laravel/react-starter-kit/compare/main...benbjurstrom:otpz-react-starter-kit:main)

**Create new project:**
```bash
laravel new --using benbjurstrom/otpz-react-starter-kit my-app
```

### Vue Starter Kit
View the complete diff: [Laravel Vue Starter Kit → OTPz Vue](https://github.com/laravel/vue-starter-kit/compare/main...benbjurstrom:otpz-vue-starter-kit:main)

**Create new project:**
```bash
laravel new --using benbjurstrom/otpz-vue-starter-kit my-app
```

### Livewire Starter Kit
View the complete diff: [Laravel Livewire Starter Kit → OTPz Livewire](https://github.com/laravel/livewire-starter-kit/compare/main...benbjurstrom:otpz-livewire-starter-kit:main)

**Create new project:**
```bash
laravel new --using benbjurstrom/otpz-livewire-starter-kit my-app
```

---

## How It Works

### Security Features

1. **Session Locking**
   - OTPs are tied to the browser session that requested them
   - Prevents OTP reuse across different browsers/devices

2. **Rate Limiting**
   - Multi-tier throttling prevents abuse
   - Default: 1/min, 3/5min, 5/30min

3. **Signed URLs**
   - All OTP entry URLs are cryptographically signed
   - Invalid signatures are rejected

4. **Automatic Invalidation**
   - Used after first successful authentication
   - Expired after configured time (default: 5 minutes)
   - Invalidated after 3 failed attempts
   - Superseded when new OTP is requested

### Architecture

```
SendOtp Action
    ↓
Creates OTP → Sends Email
    ↓
User Clicks Link (Signed URL)
    ↓
AttemptOtp Action → Validates:
    - URL signature
    - Session ID match
    - Status (ACTIVE)
    - Expiration
    - Attempt count
    - Code hash
    ↓
Success → User Authenticated
```

---

## Testing

```bash
composer test
```

---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ben Bjurstrom](https://github.com/benbjurstrom)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
