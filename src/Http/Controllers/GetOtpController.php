<?php

namespace BenBjurstrom\Otpz\Http\Controllers;

use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class GetOtpController
{
    public function __invoke(Request $request, int $id): View|RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')->withErrors(['email' => OtpStatus::EXPIRED->errorMessage()])->withInput();
        }

        $otp = Otp::findOrFail($id);

        $url = URL::temporarySignedRoute(
            'otp.post', now()->addMinutes(5), ['id' => $otp->id]
        );

        return view('otpz::otp', [
            'email' => $otp->user->email,
            'url' => $url,
            'code' => $request->code,
        ]);
    }
}
