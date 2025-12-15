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

    'mail' => [
        'otpz' => [
            'subject' => 'Sign in to ',
        ],
    ],

];
