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
    public function handle(string $email, bool $remember = false): Otp
    {
        $mailable = config('otpz.mailable', OtpzMail::class);
        $userResolver = config('otpz.user_resolver', GetUserFromEmail::class);

        $user = (new $userResolver)->handle($email);
        [$otp, $code] = (new CreateOtp)->handle($user, $remember);

        Mail::to($user)->send(new $mailable($otp, $code));

        return $otp;
    }
}
