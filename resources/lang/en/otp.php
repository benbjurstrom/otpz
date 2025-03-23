<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Otpz Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during OTP generation for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'status' => [
        'active' => 'The code is still active.',
        'superseded' => 'The active code has been superseded. Please request a new code.',
        'expired' => 'The active code has expired. Please request a new code.',
        'attempted' => 'Too many attempts. Please request a new code.',
        'used' => 'The active code has already been used. Please request a new code.',
        'invalid' => 'The given code is invalid.',
        'signature' => 'The route signature is invalid.',
        'session' => 'The sign-in code was requested in a different session. Please login using the same browser that requested the code.',
    ],

    'exception' => [
        'invalid_authenticatable_model' => 'The model `:model` does not use the `:interface` interface.',
        'not_extending_model' => 'The model `:model` does not extend `Illuminate\Database\Eloquent\Model`.',
        'throttle' => 'Too many codes requested. Please wait :minutes minutes and :seconds seconds before trying again.',
    ],

    'views' => [
        'template' => [
            'title' => 'Sign-in to',
        ],
        'otp' => [
            'title' => 'Sign-in to',
            'description' => 'Enter the alpha numeric code sent to your email. The code is case insensitive and dashes will be added automatically.',
            'submit' => 'Submit Code',
            'or' => 'or',
            'back' => 'Request a new code',
        ],
    ],
    'mail' => [
        'notification' => [
            'greeting' => 'Hello!',
            'intro' => 'Click the button below to securely log in to your account:',
            'action' => 'Sign-in to',
            'outro' => 'This link expires after 5 minutes and can only be used once.',
            'subcopy' => 'If you\'re having trouble clicking the ":actionText" button, copy and paste the URL below\n into your web browser:',
            'salutation' => 'Thank you for using',
        ],
        'otpz' => [
            'subject' => 'Sign in to ',
            'greeting' => 'Sign in to',
            'copy' => 'We received a sign-in request for the account :email. Use the code below to sign in.',
            'subcopy' => 'If you didn\'t request this login link, you can safely ignore this email.',
            'security' => 'Security Reminder:',
            'footer' => 'Fraudulent websites may try to steal your login code. Only enter this code at :url. Never enter this code on any other website or share it with anyone.'
        ]
    ]

];
