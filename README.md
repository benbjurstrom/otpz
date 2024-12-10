<div align="center">
    <img src="https://github.com/benbjurstrom/plink/blob/main/art/plink.png?raw=true" alt="Plink Screenshot">
</div>

# Passwordless Log-In Links for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/benbjurstrom/plink.svg?style=flat-square)](https://packagist.org/packages/benbjurstrom/plink)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/benbjurstrom/plink/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/benbjurstrom/plink/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/benbjurstrom/plink/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/benbjurstrom/plink/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/benbjurstrom/plink.svg?style=flat-square)](https://packagist.org/packages/benbjurstrom/plink)

This package provides full-featured passwordless log-in links for Laravel applications.

- ✅ Rate limited
- ✅ Invalidated after first use
- ✅ Locked to the user's session
- ✅ Configurable expiration
- ✅ Detailed error messages
- ✅ Customizable mail template
- ✅ Auditable logs

## Installation

### 1. Install the package via composer

```bash
composer require benbjurstrom/plink
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
php artisan vendor:publish --tag="plink-views"
```

This package publishes the following views:
```bash
resources/
└── views/
    └── vendor/
        └── plink/
            ├── error.blade.php
            ├── components/
                └── template.blade.php
            └── mail/
                ├── notification.blade.php
                └── plink.blade.php
```

### 6. (Optional) Publish the config file

```bash
php artisan vendor:publish --tag="plink-config"
```

This is the contents of the published config file:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Model Configuration
    |--------------------------------------------------------------------------
    |
    | This setting determines the model used by Plink to store and retrieve
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
    | This setting determines the Mailable class used by Plink to send emails.
    | Change this to your own Mailable class if you want to customize the email
    | sending behavior.
    |
    */

    'mailable' => BenBjurstrom\Plink\Mail\OtpMail::class,

    /*
    |--------------------------------------------------------------------------
    | Template Configuration
    |--------------------------------------------------------------------------
    |
    | This setting determines the email template used by Plink to send emails.
    | Switch to 'plink::mail.notification' if you prefer to use the default 
    | Laravel notification template.
    |
    */

    'template' => 'plink::mail.plink',
    // 'template' => 'plink::mail.notification',
];
```

## Usage

1. Replace the Laravel Breeze [LoginForm authenticate method](https://github.com/laravel/breeze/blob/2.x/stubs/livewire-common/app/Livewire/Forms/LoginForm.php#L29C6-L29C41) with a sendEmail method that runs the SendPlink action. For example:
```php
    public function sendEmail(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();
        RateLimiter::hit($this->throttleKey(), 300);

        try {
            (new SendPlink)->handle($this->email);
        } catch (PlinkThrottleException $e) {
            throw ValidationException::withMessages([
                'form.email' => $e->getMessage(),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }
````

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
