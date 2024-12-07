<?php

return [
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
