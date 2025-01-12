<x-otpz::template>
<x-slot:logo>
<img src="https://raw.githubusercontent.com/benbjurstrom/otpz/refs/heads/main/art/logo.png" width="100" alt="{{ config('app.name') }}">
</x-slot>

<x-slot:greeting>
Sign in to {{ config('app.name') }}
</x-slot>

<x-slot:copy>
We received a sign-in request for the account {{ $email }}. Use the code below to sign in.
</x-slot>

<x-slot:code>
{{ $code }}
</x-slot>

<x-slot:subcopy>
If you didn't request this login link, you can safely ignore this email.
</x-slot>

<x-slot:footer>
<strong>Security Reminder:</strong> Fraudulent websites may try to steal your login code. Only enter this code at {{ config('app.url') }}. Never enter this code on any other website or share it with anyone.
</x-slot>
</x-otpz::template>
