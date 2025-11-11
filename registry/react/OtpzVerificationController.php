<?php

namespace App\Http\Controllers\Auth;

use BenBjurstrom\Otpz\Actions\AttemptOtp;
use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Exceptions\OtpAttemptException;
use BenBjurstrom\Otpz\Http\Requests\OtpRequest;
use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class OtpzVerificationController
{
    public function show(Request $request, string $id): InertiaResponse|RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            $message = OtpStatus::SIGNATURE->errorMessage();
            Session::flash('status', __($message));

            return redirect()->route('login');
        }

        if ($request->sessionId !== request()->session()->getId()) {
            $message = OtpStatus::SESSION->errorMessage();
            Session::flash('status', __($message));

            return redirect()->route('login');
        }

        $otp = Otp::findOrFail($id);

        $url = URL::temporarySignedRoute(
            'otpz.post', now()->addMinutes(5), [
                'id' => $otp->id,
                'sessionId' => request()->session()->getId(),
            ],
        );

        return Inertia::render('auth/otpz-verify', [
            'email' => $otp->user->email,
            'url' => $url,
        ]);
    }

    public function store(OtpRequest $request, string $id): RedirectResponse|View
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
