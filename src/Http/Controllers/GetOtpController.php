<?php

namespace BenBjurstrom\Otpz\Http\Controllers;

use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class GetOtpController
{
    public function __invoke(Request $request, string $id): View|RedirectResponse
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

        return view('otpz::otp', [
            'email' => $otp->user->email,
            'url' => $url,
            'code' => $request->code,
        ]);
    }
}
