<x-plink::template :url="$url">
<x-slot:logo>
<img src="https://raw.githubusercontent.com/benbjurstrom/plink/refs/heads/main/art/logo.png" width="100" alt="{{ config('app.name') }}">
</x-slot>

<x-slot:greeting>
Hello
</x-slot>

<x-slot:copy>
Click the button below to securely log in to your account. Note that this link expires after 5 minutes and can only be used once.
</x-slot>

<x-slot:buttontext>
Sign-in to {{ config('app.name') }} &rarr;
</x-slot>

<x-slot:footer>
If you didn't request this login link, you can safely ignore this email.
</x-slot>

<x-slot:subcopy>
If you're having trouble clicking the "Sign-In to {{ config('app.name') }}" button, copy and paste the following URL into your web browser:
<a href="{{ $url }}" class="text-gray-700 [text-decoration:none] hover:![text-decoration:underline] text-sm break-all">{{ $url }}</a>
</x-slot>
</x-plink::template>



