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
            self::ACTIVE => __('otpz::otp.status.active'),
            self::SUPERSEDED => __('otpz::otp.status.superseded'),
            self::EXPIRED => __('otpz::otp.status.expired'),
            self::ATTEMPTED => __('otpz::otp.status.attempted'),
            self::USED => __('otpz::otp.status.used'),
            self::INVALID => __('otpz::otp.status.invalid'),
            self::SIGNATURE => __('otpz::otp.status.signature'),
            self::SESSION => __('otpz::otp.status.session'),
        };
    }
}
