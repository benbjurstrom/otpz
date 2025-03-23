<x-mail::message>
{{-- Greeting --}}
# {{ __('otpz::otp.mail.notification.greeting') }}

{{-- Intro Lines --}}
{{ __('otpz::otp.mail.notification.intro') }}

{{-- Action Button --}}
<x-mail::button :url="$url">
{{ __('otpz::otp.mail.notification.action') }} {{ config('app.name') }}
</x-mail::button>

{{-- Outro Lines --}}
{{ __('otpz::otp.mail.notification.outro') }}

{{-- Salutation --}}
{{ __('otpz::otp.mail.notification.salutation') }} {{ config('app.name') }}!

{{-- Subcopy --}}
<x-slot:subcopy>
    {{ __('otpz::otp.mail.notification.subcopy', [
        'actionText' => 'Sign-In to ' .  config('app.name'),
    ]) }}

<span class="break-all">[{{ $url }}]({{ $url }})</span>
</x-slot:subcopy>
</x-mail::message>
