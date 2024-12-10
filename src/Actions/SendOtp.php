<?php

namespace BenBjurstrom\Otpz\Actions;

use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
use BenBjurstrom\Otpz\Mail\OtpzMail;
use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Support\Facades\Mail;

/**
 * @method static Otp run(string $email)
 *
 * @throws OtpThrottleException
 */
class SendOtp
{
    public function handle(string $email): Otp
    {
        $mailable = config('otpz.mailable', OtpzMail::class);
        $user = (new GetUserFromEmail)->handle($email);
        [$otp, $code] = (new CreateOtp)->handle($user);

        Mail::to($user)->send(new $mailable($otp, $code));

        return $otp;
    }
}
