<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use BenBjurstrom\Otpz\Enums\OtpStatus;
use BenBjurstrom\Otpz\Models\Otp;
use BenBjurstrom\Otpz\Actions\AttemptOtp;

new #[Layout('components.layouts.auth')] class extends Component {
    public $email = '';
    public $url = '';

    #[Validate('required|string')]
    public $code = '';

    public function mount()
    {
        if (! request()->hasValidSignature()) {
            $message = OtpStatus::SIGNATURE->errorMessage();
            Session::flash('status', __($message));

            return $this->redirectRoute('login');
        }

        if (request()->sessionId !== request()->session()->getId()) {
            $message = OtpStatus::SESSION->errorMessage();
            Session::flash('status', __($message));

            return $this->redirectRoute('login');
        }

        $otp = Otp::findOrFail(request()->id);
        $this->email = $otp->user->email;
        $this->url = URL::temporarySignedRoute(
            'otpz.verify', now()->addMinutes(5), [
            'id' => $otp->id,
            'sessionId' => request()->session()->getId(),
        ],
        );
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header title="Use your code to login" description="Enter the login code that was sent to {{ $email }}. Note that the code is case insensitive." />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" action="{{ $url }}" class="flex flex-col gap-6">
        @csrf
        <flux:field>
            <flux:label>Login Code</flux:label>

            <input type="text" class="w-full text-center border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] pl-3 pr-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 uppercase placeholder:lowercase" wire:model="code" label="Code" required="required" autofocus="autofocus" placeholder="xxxxx-xxxxx" autocomplete="off" maxlength="11" name="code" x-mask="*****-*****" data-flux-control="" data-flux-group-target="">

            <flux:error name="code" />
        </flux:field>


        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Submit Code') }}</flux:button>
        </div>
    </form>

    <flux:separator/>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        Didn't receive it?
        <flux:link :href="route('login')" wire:navigate>Request a new code</flux:link>
    </div>
</div>
