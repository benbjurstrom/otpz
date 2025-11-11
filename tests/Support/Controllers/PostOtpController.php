<?php

namespace BenBjurstrom\Otpz\Tests\Support\Controllers;

use BenBjurstrom\Otpz\Actions\AttemptOtp;
use BenBjurstrom\Otpz\Exceptions\OtpAttemptException;
use BenBjurstrom\Otpz\Http\Requests\OtpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostOtpController
{
    public function __invoke(OtpRequest $request, string $id): RedirectResponse|View
    {
        try {
            $data = $request->safe()->only(['code', 'sessionId']);

            $otp = (new AttemptOtp)->handle($id, $data['code'], $data['sessionId']);

            Auth::loginUsingId($otp->user_id, $otp->remember); // fires Illuminate\Auth\Events\Login;
            Session::regenerate();

            if (! $otp->user->hasVerifiedEmail()) {
                $otp->user->markEmailAsVerified();
            }

            return redirect()->intended('/dashboard');
        } catch (OtpAttemptException $e) {
            throw ValidationException::withMessages(['code' => $e->getMessage()]);
        }
    }
}
