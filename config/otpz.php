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
