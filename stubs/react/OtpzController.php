<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BenBjurstrom\Otpz\Actions\AttemptOtp;
use BenBjurstrom\Otpz\Actions\SendOtp;
use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Exceptions\OtpAttemptException;
use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
use BenBjurstrom\Otpz\Http\Requests\OtpRequest;
use BenBjurstrom\Otpz\Models\Otp;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class OtpzController extends Controller
{
    /**
     * Display the OTP login form where users enter their email.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('auth/otpz-login', [
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
     * Display the OTP verification form where users enter their code.
     */
    public function show(Request $request, string $id): Response|RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            $message = OtpStatus::SIGNATURE->errorMessage();
            Session::flash('status', __($message));

            return redirect()->route('otpz.index');
        }

        if ($request->sessionId !== request()->session()->getId()) {
            $message = OtpStatus::SESSION->errorMessage();
            Session::flash('status', __($message));

            return redirect()->route('otpz.index');
        }

        $otp = Otp::findOrFail($id);

        $url = URL::temporarySignedRoute(
            'otpz.verify',
            now()->addMinutes(5),
            [
                'id' => $otp->id,
                'sessionId' => request()->session()->getId(),
            ],
        );

        return Inertia::render('auth/otpz-verify', [
            'email' => $otp->user->email,
            'url' => $url,
        ]);
    }

    /**
     * Verify the OTP code and authenticate the user.
     */
    public function verify(OtpRequest $request, string $id): RedirectResponse
    {
        try {
            $data = $request->safe()->only(['code', 'sessionId']);

            $otp = (new AttemptOtp)->handle($id, $data['code'], $data['sessionId']);

            Auth::loginUsingId($otp->user_id, $otp->remember);
            Session::regenerate();

            if (! $otp->user->hasVerifiedEmail()) {
                $otp->user->markEmailAsVerified();
            }

            return redirect()->intended('/dashboard');
        } catch (OtpAttemptException $e) {
            throw ValidationException::withMessages(['code' => $e->getMessage()]);
        }
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
