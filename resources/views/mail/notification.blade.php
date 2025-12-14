<x-mail::message>
{{-- Greeting --}}
# Hello!

{{-- Intro Lines --}}
Click the button below to securely log in to your account:

{{-- Action Button --}}
<x-mail::button :url="$url">
Sign-In to {{ config('app.name') }}
</x-mail::button>

{{-- Outro Lines --}}
This link expires after 5 minutes and can only be used once.

{{-- Salutation --}}
Thank you for using {{ config('app.name') }}!

{{-- Subcopy --}}
<x-slot:subcopy>
    @lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => 'Sign-In to ' .  config('app.name'),
    ]
)
<span class="break-all">[{{ $url }}]({{ $url }})</span>
</x-slot:subcopy>
</x-mail::message>
