<?php

namespace BenBjurstrom\Otpz\Exceptions;

use Exception;

final class InvalidAuthenticatableModel extends Exception
{
    public static function missingInterface(string $modelClass, string $interfaceFqcn): self
    {
        return new self(__('otpz::otp.exception.invalid_authenticatable_model', [
            'model' => $modelClass,
            'interface' => $interfaceFqcn,
        ]));
    }

    public static function notExtendingModel(mixed $authenticatableModel)
    {
        return new self(__('otpz::otp.exception.not_extending_model', [
            'model' => get_class($authenticatableModel),
        ]));
    }
}
