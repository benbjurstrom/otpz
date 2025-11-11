<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BenBjurstrom\Otpz\Actions\SendOtp;
use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class OtpzLoginController extends Controller
{
    /**
     * Display the OTP login form where users enter their email.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/OtpzLogin', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle the OTP request by sending an email with the code.
     */
    public function store(Request $request): SymfonyResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'remember' => ['boolean'],
        ]);

        $this->ensureIsNotRateLimited($request);

        RateLimiter::hit($this->throttleKey($request), 300);

        try {
            $otp = (new SendOtp)->handle(
                $request->input('email'),
                $request->boolean('remember')
            );
        } catch (OtpThrottleException $e) {
            throw ValidationException::withMessages([
                'email' => $e->getMessage(),
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        return Inertia::location($otp->url);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->string('email')).'|'.$request->ip());
    }
}
