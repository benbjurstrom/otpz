<?php

namespace BenBjurstrom\Otpz\Exceptions;

use Exception;

class OtpThrottleException extends Exception
{
    public function __construct(string|int $minutes, string|int $seconds)
    {
        $message = __('otpz::otp.exception.throttle', [
            'minutes' => $minutes,
            'seconds' => $seconds,
        ]);
        parent::__construct($message);
    }
}
