<?php

namespace BenBjurstrom\Otpz\Http\Controllers;

use BenBjurstrom\Otpz\Actions\AttemptOtp;
use BenBjurstrom\Otpz\Exceptions\OtpAttemptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostOtpController
{
    public function __invoke(Request $request, int $id): RedirectResponse|View
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'size:9'],
        ]);

        try {
            $otp = (new AttemptOtp)->handle($id, $data['code']);

            Auth::loginUsingId($otp->user_id); // fires Illuminate\Auth\Events\Login;
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
