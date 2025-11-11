<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use BenBjurstrom\Otpz\Actions\SendOtp;
use BenBjurstrom\Otpz\Exceptions\OtpThrottleException;
use BenBjurstrom\Otpz\Models\Otp;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function sendEmail(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();
        RateLimiter::hit($this->throttleKey(), 300);

        try {
            $otp = (new SendOtp)->handle($this->email, $this->remember);
        } catch (OtpThrottleException $e) {
            throw ValidationException::withMessages([
                'email' => $e->getMessage(),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        $this->redirect($otp->url);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header title="Sign-in with email" description="Request a one time login code below." />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendEmail" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            label="{{ __('Email address') }}"
            type="email"
            name="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" label="{{ __('Remember me') }}" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Send Code') }}</flux:button>
        </div>
    </form>
    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        If you don't have an account one will be created for you.
    </div>
</div>
