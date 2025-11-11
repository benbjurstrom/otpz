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

OTPz works best with the official [Laravel starter kits](https://laravel.com/starter-kits):
- **React** (Inertia.js)
- **Vue** (Inertia.js)
- **Livewire** (Volt)

> **Note:** OTPz frontend components are designed to work out of the box with the Laravel starter kits and use their existing UI components (Button, Input, Label, etc.). You can also install and customize these components for any Laravel application using React, Vue, or Livewire, but you may need to adjust component imports and styling. For reference implementations with the starter kits, see the [starter kit examples](#starter-kit-examples).

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
- `app/Http/Controllers/Auth/OtpzLoginController.php` - Handles email entry and OTP sending
- `app/Http/Controllers/Auth/OtpzVerificationController.php` - Handles OTP verification

> **Note:** These components import shadcn/ui components (`Button`, `Input`, `Label`, `Checkbox`) and layout components (`AuthLayout`) from the Laravel React starter kit. If you're not using the starter kit, you may need to adjust these imports or create these components.

#### 2. Add Routes

Add to `routes/web.php`:

```php
use App\Http\Controllers\Auth\OtpzLoginController;
use App\Http\Controllers\Auth\OtpzVerificationController;

Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('login', [OtpzLoginController::class, 'create'])
        ->name('login');
    Route::post('login', [OtpzLoginController::class, 'store']);

    // OTP verification routes
    Route::get('otpz/{id}', [OtpzVerificationController::class, 'show'])
        ->name('otpz.get')
        ->middleware('signed');
    Route::post('otpz/{id}', [OtpzVerificationController::class, 'store'])
        ->name('otpz.post')
        ->middleware('signed');
});
```

That's it! The controllers handle all the OTP logic for you.

---

### Vue (Inertia.js)

#### 1. Install Frontend Components

```bash
npx shadcn@latest add https://benbjurstrom.github.io/otpz/r/vue.json
```

This installs:
- `resources/js/pages/auth/OtpzLogin.vue` - Email entry page
- `resources/js/pages/auth/OtpzVerify.vue` - OTP code entry page
- `app/Http/Controllers/Auth/OtpzLoginController.php` - Handles email entry and OTP sending
- `app/Http/Controllers/Auth/OtpzVerificationController.php` - Handles OTP verification

> **Note:** These components import shadcn/ui components (`Button`, `Input`, `Label`, `Checkbox`) and layout components (`AuthLayout`) from the Laravel Vue starter kit. If you're not using the starter kit, you may need to adjust these imports or create these components.

#### 2. Add Routes

Add to `routes/web.php`:

```php
use App\Http\Controllers\Auth\OtpzLoginController;
use App\Http\Controllers\Auth\OtpzVerificationController;

Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('login', [OtpzLoginController::class, 'create'])
        ->name('login');
    Route::post('login', [OtpzLoginController::class, 'store']);

    // OTP verification routes
    Route::get('otpz/{id}', [OtpzVerificationController::class, 'show'])
        ->name('otpz.get')
        ->middleware('signed');
    Route::post('otpz/{id}', [OtpzVerificationController::class, 'store'])
        ->name('otpz.post')
        ->middleware('signed');
});
```

That's it! The controllers handle all the OTP logic for you.

---

### Livewire (Volt)

#### 1. Publish Views

```bash
php artisan vendor:publish --tag="otpz-livewire"
```

This publishes:
- `resources/views/livewire/pages/auth/otpz-login.blade.php` - Email entry page
- `resources/views/livewire/pages/auth/otpz-verify.blade.php` - OTP code entry page

> **Note:** These Volt components use Flux UI components and layout components from the Laravel Livewire starter kit. If you're not using the starter kit, you may need to adjust the component markup and styling.

#### 2. Add Routes

Add to `routes/web.php`:

```php
use BenBjurstrom\Otpz\Http\Controllers\PostOtpController;
use Livewire\Volt\Volt;

// Login page
Volt::route('login', 'livewire.pages.auth.otpz-login')
    ->middleware('guest')
    ->name('login');

// OTP verification page
Volt::route('otpz/{id}', 'livewire.pages.auth.otpz-verify')
    ->middleware(['guest', 'signed'])
    ->name('otpz.get');

// OTP submission
Route::post('otpz/{id}', PostOtpController::class)
    ->middleware(['guest', 'signed'])
    ->name('otpz.post');
```

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

## Starter Kit Examples

The following are complete working examples showing OTPz integrated with the Laravel starter kits. These are helpful references but not required—you can integrate OTPz into any Laravel application.

### React Starter Kit
A complete OTPz + React starter kit is available for reference or quick project setup.

**Create new project:**
```bash
laravel new --using benbjurstrom/otpz-react-starter-kit my-app
```

**View the integration diff:**
[Laravel React Starter Kit → OTPz React](https://github.com/laravel/react-starter-kit/compare/main...benbjurstrom:otpz-react-starter-kit:main)

### Vue Starter Kit
A complete OTPz + Vue starter kit is available for reference or quick project setup.

**Create new project:**
```bash
laravel new --using benbjurstrom/otpz-vue-starter-kit my-app
```

**View the integration diff:**
[Laravel Vue Starter Kit → OTPz Vue](https://github.com/laravel/vue-starter-kit/compare/main...benbjurstrom:otpz-vue-starter-kit:main)

### Livewire Starter Kit
A complete OTPz + Livewire starter kit is available for reference or quick project setup.

**Create new project:**
```bash
laravel new --using benbjurstrom/otpz-livewire-starter-kit my-app
```

**View the integration diff:**
[Laravel Livewire Starter Kit → OTPz Livewire](https://github.com/laravel/livewire-starter-kit/compare/main...benbjurstrom:otpz-livewire-starter-kit:main)

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
