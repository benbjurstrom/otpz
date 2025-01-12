<?php

declare(strict_types=1);

namespace BenBjurstrom\Otpz\Actions;

use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Exceptions\OtpAttemptException;
use BenBjurstrom\Otpz\Models\Concerns\Otpable;
use BenBjurstrom\Otpz\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @method static Otp run(string $id, string $code)
 */
class AttemptOtp
{
    /**
     * @throws OtpAttemptException
     */
    public function handle(string $id, string $code, string $sessionId): Otp
    {
        $this->validateSignature();
        $this->validateSession($sessionId);
        $otp = Otp::findOrFail($id);
        $this->validateStatus($otp);
        $this->validateNotExpired($otp);
        $this->validateAttempts($otp);
        $this->validateCode($otp, $code);

        // if everything above passes mark the otp as used
        $otp->update(['status' => OtpStatus::USED]);

        return $otp;
    }

    protected function getOtp(Otpable $user): ?Otp
    {
        return $user->otps()
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    /**
     * @throws OtpAttemptException
     */
    protected function validateSession(string $sessionId): void
    {
        if ($sessionId !== session()->getId()) {
            throw new OtpAttemptException(OtpStatus::SESSION->errorMessage());
        }
    }

    /**
     * @throws OtpAttemptException
     */
    protected function validateStatus(Otp $otp): void
    {
        if ($otp->status !== OtpStatus::ACTIVE) {
            throw new OtpAttemptException($otp->status->errorMessage());
        }
    }

    /**
     * @throws OtpAttemptException
     */
    protected function validateNotExpired(Otp $otp): void
    {
        $expiration = Carbon::now()->subMinutes(config('otpz.expiration', 5));
        if ($otp->created_at->lt($expiration)) {
            $otp->update(['status' => OtpStatus::EXPIRED]);
            throw new OtpAttemptException($otp->status->errorMessage());
        }
    }

    /**
     * @throws OtpAttemptException
     */
    protected function validateAttempts(Otp $otp): void
    {
        if ($otp->attempts >= 3) {
            $otp->update(['status' => OtpStatus::ATTEMPTED]);
            throw new OtpAttemptException($otp->status->errorMessage());
        }
    }

    /**
     * @throws OtpAttemptException
     */
    protected function validateCode(Otp $otp, string $code): void
    {
        if (! Hash::check($code, $otp->code)) {
            $otp->increment('attempts');
            throw new OtpAttemptException(OtpStatus::INVALID->errorMessage());
        }
    }

    /**
     * @throws OtpAttemptException
     */
    protected function ValidateSignature(): void
    {
        if (! request()->hasValidSignature()) {
            if (! url()->signatureHasNotExpired(request())) {
                throw new OtpAttemptException(OtpStatus::SIGNATURE->errorMessage());
            }

            throw new OtpAttemptException(OtpStatus::SIGNATURE->errorMessage());
        }
    }
}
