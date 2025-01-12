<?php

namespace BenBjurstrom\Otpz\Enums;

enum OtpStatus: int
{
    case ACTIVE = 0;
    case SUPERSEDED = 1;
    case EXPIRED = 2;
    case ATTEMPTED = 3;
    case USED = 4;
    case INVALID = 5;
    case SIGNATURE = 6;
    case SESSION = 7;

    public function errorMessage(): string
    {
        return match ($this) {
            self::ACTIVE => 'The code is still active.',
            self::SUPERSEDED => 'The active code has been superseded. Please request a new code.',
            self::EXPIRED => 'The active code has expired. Please request a new code.',
            self::ATTEMPTED => 'Too many attempts. Please request a new code.',
            self::USED => 'The active code has already been used. Please request a new code.',
            self::INVALID => 'The given code is invalid.',
            self::SIGNATURE => 'The route signature is invalid.',
            self::SESSION => 'The sign-in code was requested in a different session. Please login using the same browser that requested the code.',
        };
    }
}
