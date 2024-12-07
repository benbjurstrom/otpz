<?php

namespace BenBjurstrom\Otpz\Actions;

use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
use BenBjurstrom\Otpz\Mail\OtpzMail;
use BenBjurstrom\Otpz\Models\Concerns\Otpable;
use Illuminate\Support\Facades\Mail;

/**
 * @method static Otpable run(string $email)
 *
 * @throws OtpThrottleException
 */
class SendOtp
{
    public function handle(string $email): Otpable
    {
        $mailable = config('otpz.mailable', OtpzMail::class);
        $user = (new GetUserFromEmail)->handle($email);
        list($otp, $code) = (new CreateOtp)->handle($user);

        Mail::to($user)->send(new $mailable($otp, $code));

        return $user;
    }
}
