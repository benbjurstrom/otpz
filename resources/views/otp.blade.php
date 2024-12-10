<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans text-zinc-900 antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-zinc-100 dark:bg-zinc-950">
    <div class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-zinc-900 shadow-md overflow-hidden sm:rounded-2xl">
        <section class="mx-auto w-full max-w-xl py-6">
            <div class="text-center dark:text-zinc-100">
                <form autocomplete="off" class="space-y-6" method="POST" action="{{ $url }}">
                    @csrf
                    <div>
                        <h2 id="otp-heading" class="mb-2 text-3xl font-bold">
                            Sign in to {{ config('app.name') }}
                        </h2>
                        <p
                            id="otp-description"
                            class="mb-8 text-sm text-zinc-600 dark:text-zinc-400"
                        >
                            Enter the alpha numeric code sent to {{ $email }}. The
                            code is case insensitive and dashes will be added
                            automatically.
                        </p>

                        <div class="flex justify-center">
                            <input
                                x-data="{}"
                                id="code"
                                type="text"
                                name="code"
                                autocomplete="false"
                                required
                                autofocus
                                class="block w-72 rounded-xl border-zinc-300 p-4 text-center text-2xl uppercase focus:border-zinc-500 focus:ring-zinc-100 font-bold placeholder:text-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 dark:placeholder-zinc-600 dark:focus:ring-zinc-700 dark:text-zinc-200"
                                x-mask="***-***-***"
                                placeholder="XXX-XXX-XXX"
                                aria-labelledby="otp-heading"
                                aria-describedby="otp-description {{ $errors->has('form.code') ? 'otp-error' : '' }}"
                                aria-invalid="{{ $errors->has('form.code') ? 'true' : 'false' }}"
                                maxlength="11"
                            />
                            <input type="hidden" name="email" value="{{$email}}">
                        </div>
                        @if ($errors->get('code'))
                            <ul
                                id="otp-error"
                                class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1"
                            >
                                @foreach ((array) $errors->get('code') as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 bg-zinc-800 dark:bg-zinc-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-zinc-800 uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-white focus:bg-zinc-700 dark:focus:bg-white active:bg-zinc-900 dark:active:bg-zinc-300 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 disabled:opacity-50 transition ease-in-out duration-150 w-72">
                            Submit Code
                        </button>
                    </div>

                    <div aria-live="polite" class="sr-only">
                        @if ($errors->has('form.code'))
                            {{ implode(', ', $errors->get('form.code')) }}
                        @endif
                    </div>
                </form>

                <div
                    class="text-sm text-zinc-500 dark:text-zinc-400 mt-10"
                    role="region"
                    aria-label="Additional options"
                >
                    <a
                        href="{{ route('login') }}"
                        class="font-medium text-zinc-700 underline decoration-zinc-500/50 underline-offset-2 hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 dark:text-zinc-300 dark:decoration-zinc-400/50 dark:hover:text-zink-100 dark:focus:ring-offset-zinc-800"
                        aria-describedby="resend-prompt"
                    >
                        Request a new code
                    </a>
                </div>
            </div>
            <!-- END Form -->
        </section>
    </div>
</div>
</body>
</html>
