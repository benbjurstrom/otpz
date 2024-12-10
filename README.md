<div align="center">
    <img src="https://github.com/benbjurstrom/otpz/blob/main/art/otpz.png?raw=true" alt="OTPz Screenshot">
</div>

# First Factor One-Time Passwords for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/benbjurstrom/otpz.svg?style=flat-square)](https://packagist.org/packages/benbjurstrom/otpz)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/benbjurstrom/otpz/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/benbjurstrom/otpz/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/benbjurstrom/otpz/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/benbjurstrom/otpz/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/benbjurstrom/otpz.svg?style=flat-square)](https://packagist.org/packages/benbjurstrom/otpz)

This package provides secure first factor one-time passwords (OTPs) for Laravel applications. Users enter their email and receive a one-time code to sign in.

✅ Rate-limited
✅ Invalidated after use
✅ Configurable expiration
✅ Locked to the user's session
✅ Invalidated after too many failed attempts
✅ Detailed error messages
✅ Customizable mail template
✅ Auditable logs

## Installation

1. Install the package via composer:

```bash
composer require benbjurstrom/otpz
```

### 2. Add the package's interface and trait to your Authenticatable model

```php
// app/Models/User.php
namespace App\Models;

//...
use BenBjurstrom\Otpz\Models\Concerns\HasOtps;
use BenBjurstrom\Otpz\Models\Concerns\Otpable;

class User extends Authenticatable implements Otpable
{
    use HasFactory, Notifiable, HasOtps;
    
    // ...
}
```

### 3. Publish and run the migrations

```bash
php artisan vendor:publish --tag="otpz-migrations"
php artisan migrate
```

### 4. Add the package provided routes

```php
// routes/web.php
Route::otpRoutes();
```

### 5. (Optional) Publish the views for custom styling

```bash
php artisan vendor:publish --tag="otpz-views"
```

This package publishes the following views:
```bash
resources/
└── views/
    └── vendor/
        └── otpz/
            ├── otp.blade.php               (for entering the OTP)
            ├── components/template.blade.php
            └── mail/
                ├── notification.blade.php  (standard template)
                └── otpz.blade.php          (custom template)
```

### 6. (Optional) Publish the config file

```bash
php artisan vendor:publish --tag="otpz-config"
```

This is the contents of the published config file:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Expiration and Throttling
    |--------------------------------------------------------------------------
    |
    | These settings control the security aspects of the generated codes,
    | including their expiration time and the throttling mechanism to prevent
    | abuse.
    |
    */

    'expiration' => 5, // Minutes

    'limits' => [
        ['limit' => 1, 'minutes' => 1],
        ['limit' => 3, 'minutes' => 5],
        ['limit' => 5, 'minutes' => 30],
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Configuration
    |--------------------------------------------------------------------------
    |
    | This setting determines the model used by Otpz to store and retrieve
    | one-time passwords. By default, it uses the 'App\Models\User' model.
    |
    */

    'models' => [
        'authenticatable' => env('AUTH_MODEL', App\Models\User::class),
    ],

    /*
    |--------------------------------------------------------------------------
    | Mailable Configuration
    |--------------------------------------------------------------------------
    |
    | This setting determines the Mailable class used by Otpz to send emails.
    | Change this to your own Mailable class if you want to customize the email
    | sending behavior.
    |
    */

    'mailable' => BenBjurstrom\Otpz\Mail\OtpzMail::class,

    /*
    |--------------------------------------------------------------------------
    | Template Configuration
    |--------------------------------------------------------------------------
    |
    | This setting determines the email template used by Otpz to send emails.
    | Switch to 'otpz::mail.notification' if you prefer to use the default
    | Laravel notification template.
    |
    */

    'template' => 'otpz::mail.otpz',
    // 'template' => 'otpz::mail.notification',
];
```

## Usage
After installing Laravel Breeze or your preferred UI scaffolding, you'll need to replace the login form's login step. Instead of authenticating directly, send the OTP email and redirect the user to the OTP entry page.

### Laravel Breeze Livewire Example
1. Replace the [LoginForm authenticate method](https://github.com/laravel/breeze/blob/2.x/stubs/livewire-common/app/Livewire/Forms/LoginForm.php#L29C6-L29C41) with a sendEmail method that runs the SendOtp action and returns the newly created Otp.

```php
    use BenBjurstrom\Otpz\Actions\SendOtp;
    use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
    use BenBjurstrom\Otpz\Models\Otp;

    ...
    public function sendEmail(): Otp
    {
        $this->validate();

        $this->ensureIsNotRateLimited();
        RateLimiter::hit($this->throttleKey(), 300);

        try {
            (new SendOtp)->handle($this->email);
        } catch (OtpThrottleException $e) {
            throw ValidationException::withMessages([
                'form.email' => $e->getMessage(),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }
````

2. Update the [Login component's login method](https://github.com/laravel/breeze/blob/e05ae1a21954c8d83bb0fcc78db87f157c16ac6c/stubs/livewire/resources/views/livewire/pages/auth/login.blade.php#L19-L23) to call the sendEmail method and redirect to the OTP entry page.
```php
    public function login(): void
    {
        $otp = $this->form->sendEmail();
        
        $this->redirect($otp->url);
    }
``` 

### Laravel Breeze Inertia Example

1. Replace the [LoginForm authenticate method](https://github.com/laravel/breeze/blob/e05ae1a21954c8d83bb0fcc78db87f157c16ac6c/stubs/default/app/Http/Requests/Auth/LoginRequest.php#L40) with a sendEmail method that runs the SendOtp action and returns the newly created Otp.
```php
    public function sendEmail(): Otp
    {
        $this->ensureIsNotRateLimited();
        RateLimiter::hit($this->throttleKey(), 300);

        try {
            $otp = (new SendOtp)->handle($this->email);
        } catch (OtpThrottleException $e) {
            throw ValidationException::withMessages([
                'email' => $e->getMessage(),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        return $otp;
    }
```

2. Update the [AuthenticatedSessionController store method](https://github.com/laravel/breeze/blob/e05ae1a21954c8d83bb0fcc78db87f157c16ac6c/stubs/inertia-common/app/Http/Controllers/Auth/AuthenticatedSessionController.php#L30) to call the sendEmail method and redirect to the OTP entry page.

```php
    public function store(LoginRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $otp = $request->sendEmail();

        return Inertia::location($otp->url);
    }
```

Everything else is handled by the package components.

## Testing

```bash
composer test
```

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
