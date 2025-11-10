<div align="center">
    <img src="https://github.com/benbjurstrom/otpz/blob/main/art/email.png?raw=true" alt="OTPz Screenshot">
</div>

# First Factor One-Time Passwords for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/benbjurstrom/otpz.svg?style=flat-square)](https://packagist.org/packages/benbjurstrom/otpz)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/benbjurstrom/otpz/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/benbjurstrom/otpz/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/benbjurstrom/otpz/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/benbjurstrom/otpz/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)

This package provides secure first factor one-time passwords (OTPs) for Laravel applications. Users enter their email and receive a one-time code to sign in.

- ✅ Rate-limited
- ✅ Configurable expiration
- ✅ Invalidated after first use
- ✅ Locked to the user's session
- ✅ Invalidated after too many failed attempts
- ✅ Detailed error messages
- ✅ Customizable mail template
- ✅ Auditable logs

## Starter Kits

### Laravel + React Starter Kit

1. **New Applications**

    Create a new Laravel project using the OTPz + React starter kit with the following command:
    ```bash
    laravel new --using benbjurstrom/otpz-react-starter-kit otpz-react
    ```

 2. **Existing Applications**:

    You can see a diff of all changes needed to integrate OTPz with the official Laravel + React Starter Kit here: https://github.com/laravel/react-starter-kit/compare/main...benbjurstrom:otpz-react-starter-kit:main

### Laravel + Vue Starter Kit

1. **New Applications**

    Create a new Laravel project using the OTPz + Vue starter kit with the following command:
    ```bash
    laravel new --using benbjurstrom/otpz-vue-starter-kit otpz-vue
    ```

 2. **Existing Applications**:

    You can see a diff of all changes needed to integrate OTPz with the official Laravel + Vue Starter Kit here: https://github.com/laravel/vue-starter-kit/compare/main...benbjurstrom:otpz-vue-starter-kit:main

### Laravel + Livewire Starter Kit

1. **New Applications**

    Create a new Laravel project using the OTPz + Livewire starter kit with the following command:
    ```bash
    laravel new --using benbjurstrom/otpz-livewire-starter-kit otpz-livewire
    ```

 2. **Existing Applications**:

    You can see a diff of all changes needed to integrate OTPz with the official Laravel + Livewire Starter Kit here: https://github.com/laravel/livewire-starter-kit/compare/main...benbjurstrom:otpz-livewire-starter-kit:main

## Installation

### 1. Install the package via composer:

```bash
composer require benbjurstrom/otpz
```

### 2. Publish and run the migrations

```bash
php artisan vendor:publish --tag="otpz-migrations"
php artisan migrate
```

### 3. Add the package's interface and trait to your Authenticatable model

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

### 4. (Optional) Add the following routes
Not needed with Laravel 12 starter kits. Instead, see the [Usage](#usage) section for examples.

```php
// routes/auth.php
use BenBjurstrom\Otpz\Http\Controllers\GetOtpController;
use BenBjurstrom\Otpz\Http\Controllers\PostOtpController;
//...
Route::get('otpz/{id}', GetOtpController::class)
    ->name('otpz.show')->middleware('guest');

Route::post('otpz/{id}', PostOtpController::class)
    ->name('otpz.post')->middleware('guest');
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
        'authenticatable' => App\Models\User::class,
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
    
    /*
    |--------------------------------------------------------------------------
    | User Resolver
    |--------------------------------------------------------------------------
    |
    | Defines the class responsible for finding or creating users by email address.
    | The default implementation will create a new user when an email doesn't exist.
    | Replace with your own implementation for custom user resolution logic.
    |
    */

    'user_resolver' => BenBjurstrom\Otpz\Actions\GetUserFromEmail::class,
];
```

## Usage With Breeze

### Laravel Breeze Livewire Example
1. Replace the Breeze provided [App\Livewire\Forms\LoginForm::authenticate](https://github.com/laravel/breeze/blob/2.x/stubs/livewire-common/app/Livewire/Forms/LoginForm.php#L29C6-L29C41) method with a sendEmail method that runs the SendOtp action. Also be sure to remove password from the LoginForm's properties.

```php
    // app/Livewire/Forms/LoginForm.php
    
    use BenBjurstrom\Otpz\Actions\SendOtp;
    use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
    use BenBjurstrom\Otpz\Models\Otp;
    //...
    
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('boolean')]
    public bool $remember = false;
    //...
    
    public function sendEmail(): Otp
    {
        $this->validate();

        $this->ensureIsNotRateLimited();
        RateLimiter::hit($this->throttleKey(), 300);

        try {
            $otp = (new SendOtp)->handle($this->email, $this->remember);
        } catch (OtpThrottleException $e) {
            throw ValidationException::withMessages([
                'form.email' => $e->getMessage(),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        
        return $otp;
    }
````

2. Update [resources/views/livewire/pages/auth/login.blade.php](https://github.com/laravel/breeze/blob/2.x/stubs/livewire/resources/views/livewire/pages/auth/login.blade.php) such that the login function calls our new sendEmail method and redirects to the OTP entry page. You can also remove the password input field in this same file.

```php
    public function login(): void
    {
        $this->validate();
    
        $otp = $this->form->sendEmail();
        
        $this->redirect($otp->url);
    }
``` 

### Laravel Breeze Inertia Example

1. Replace the Breeze provided [App\Http\Requests\Auth\LoginRequest::authenticate](https://github.com/laravel/breeze/blob/e05ae1a21954c8d83bb0fcc78db87f157c16ac6c/stubs/default/app/Http/Requests/Auth/LoginRequest.php) method with a sendEmail method that runs the SendOtp action. Also be sure to remove password from the rules array.

```php
    // app/Http/Requests/Auth/LoginRequest.php

    use BenBjurstrom\Otpz\Actions\SendOtp;
    use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
    use BenBjurstrom\Otpz\Models\Otp;
    //...
    
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email']
        ];
    }
    //...
    
    public function sendEmail(): Otp
    {
        $this->ensureIsNotRateLimited();
        RateLimiter::hit($this->throttleKey(), 300);

        try {
            $otp = (new SendOtp)->handle($this->email, $this->remember);
        } catch (OtpThrottleException $e) {
            throw ValidationException::withMessages([
                'email' => $e->getMessage(),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        return $otp;
    }
```

2. Update the [App\Http\Controllers\Auth\AuthenticatedSessionController::store](https://github.com/laravel/breeze/blob/e05ae1a21954c8d83bb0fcc78db87f157c16ac6c/stubs/inertia-common/app/Http/Controllers/Auth/AuthenticatedSessionController.php) method to call our new sendEmail method and redirect to the OTP entry page.

```php
    public function store(LoginRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $otp = $request->sendEmail();

        return Inertia::location($otp->url);
    }
```

3. Remove the password input field from the [resources/js/Pages/Auth/Login.vue](https://github.com/laravel/breeze/blob/e05ae1a21954c8d83bb0fcc78db87f157c16ac6c/stubs/inertia-vue/resources/js/Pages/Auth/Login.vue) file.

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
