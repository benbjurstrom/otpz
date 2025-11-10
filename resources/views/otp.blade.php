<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap"
            rel="stylesheet"
        />

        <!-- Alpine Plugins -->
        <script
            defer
            src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"
        ></script>

        <!-- Alpine Core -->
        <script
            defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
        ></script>

        <!-- Style -->
        {{-- @vite(['resources/css/app.css']) --}}
        <style>
            *, ::before, ::after {--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / 0.5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: ;}::backdrop {--tw-border-spacing-x: 0;--tw-border-spacing-y: 0;--tw-translate-x: 0;--tw-translate-y: 0;--tw-rotate: 0;--tw-skew-x: 0;--tw-skew-y: 0;--tw-scale-x: 1;--tw-scale-y: 1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness: proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: rgb(59 130 246 / 0.5);--tw-ring-offset-shadow: 0 0 #0000;--tw-ring-shadow: 0 0 #0000;--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: ;}*, ::before, ::after {box-sizing: border-box;border-width: 0;border-style: solid;border-color: #e5e7eb;}::before, ::after {--tw-content: '';}html, :host {line-height: 1.5;-webkit-text-size-adjust: 100%;-moz-tab-size: 4;tab-size: 4;font-family: Inter;font-feature-settings: normal;font-variation-settings: normal;-webkit-tap-highlight-color: transparent;}body {margin: 0;line-height: inherit;}hr {height: 0;color: inherit;border-top-width: 1px;}abbr:where([title]) {text-decoration: underline dotted;}h1, h2, h3, h4, h5, h6 {font-size: inherit;font-weight: inherit;}a {color: inherit;text-decoration: inherit;}b, strong {font-weight: bolder;}code, kbd, samp, pre {font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-feature-settings: normal;font-variation-settings: normal;font-size: 1em;}small {font-size: 80%;}sub, sup {font-size: 75%;line-height: 0;position: relative;vertical-align: baseline;}sub {bottom: -0.25em;}sup {top: -0.5em;}table {text-indent: 0;border-color: inherit;border-collapse: collapse;}button, input, optgroup, select, textarea {font-family: inherit;font-feature-settings: inherit;font-variation-settings: inherit;font-size: 100%;font-weight: inherit;line-height: inherit;letter-spacing: inherit;color: inherit;margin: 0;padding: 0;}button, select {text-transform: none;}button, input:where([type='button']), input:where([type='reset']), input:where([type='submit']) {-webkit-appearance: button;background-color: transparent;background-image: none;}:-moz-focusring {outline: auto;}:-moz-ui-invalid {box-shadow: none;}progress {vertical-align: baseline;}::-webkit-inner-spin-button, ::-webkit-outer-spin-button {height: auto;}[type='search'] {-webkit-appearance: textfield;outline-offset: -2px;}::-webkit-search-decoration {-webkit-appearance: none;}::-webkit-file-upload-button {-webkit-appearance: button;font: inherit;}summary {display: list-item;}blockquote, dl, dd, h1, h2, h3, h4, h5, h6, hr, figure, p, pre {margin: 0;}fieldset {margin: 0;padding: 0;}legend {padding: 0;}ol, ul, menu {list-style: none;margin: 0;padding: 0;}dialog {padding: 0;}textarea {resize: vertical;}input::placeholder, textarea::placeholder {opacity: 1;color: #9ca3af;}button, [role="button"] {cursor: pointer;}:disabled {cursor: default;}img, svg, video, canvas, audio, iframe, embed, object {display: block;vertical-align: middle;}img, video {max-width: 100%;height: auto;}[hidden]:where(:not([hidden="until-found"])) {display: none;}[type='text'],input:where(:not([type])),[type='email'],[type='url'],[type='password'],[type='number'],[type='date'],[type='datetime-local'],[type='month'],[type='search'],[type='tel'],[type='time'],[type='week'],[multiple],textarea,select {appearance: none;background-color: #fff;border-color: #6b7280;border-width: 1px;border-radius: 0px;padding-top: 0.5rem;padding-right: 0.75rem;padding-bottom: 0.5rem;padding-left: 0.75rem;font-size: 1rem;line-height: 1.5rem;--tw-shadow: 0 0 #0000;}[type='text']:focus, input:where(:not([type])):focus, [type='email']:focus, [type='url']:focus, [type='password']:focus, [type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus, [type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus, textarea:focus, select:focus {outline: 2px solid transparent;outline-offset: 2px;--tw-ring-inset: var(--tw-empty, );--tw-ring-offset-width: 0px;--tw-ring-offset-color: #fff;--tw-ring-color: #2563eb;--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow);border-color: #2563eb;}input::placeholder,textarea::placeholder {color: #6b7280;opacity: 1;}::-webkit-datetime-edit-fields-wrapper {padding: 0;}::-webkit-date-and-time-value {min-height: 1.5em;text-align: inherit;}::-webkit-datetime-edit {display: inline-flex;}::-webkit-datetime-edit,::-webkit-datetime-edit-year-field,::-webkit-datetime-edit-month-field,::-webkit-datetime-edit-day-field,::-webkit-datetime-edit-hour-field,::-webkit-datetime-edit-minute-field,::-webkit-datetime-edit-second-field,::-webkit-datetime-edit-millisecond-field,::-webkit-datetime-edit-meridiem-field {padding-top: 0;padding-bottom: 0;}select {background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");background-position: right 0.5rem center;background-repeat: no-repeat;background-size: 1.5em 1.5em;padding-right: 2.5rem;print-color-adjust: exact;}[multiple],[size]:where(select:not([size="1"])) {background-image: initial;background-position: initial;background-repeat: unset;background-size: initial;padding-right: 0.75rem;print-color-adjust: unset;}[type='checkbox'],[type='radio'] {appearance: none;padding: 0;print-color-adjust: exact;display: inline-block;vertical-align: middle;background-origin: border-box;-webkit-user-select: none;user-select: none;flex-shrink: 0;height: 1rem;width: 1rem;color: #2563eb;background-color: #fff;border-color: #6b7280;border-width: 1px;--tw-shadow: 0 0 #0000;}[type='checkbox'] {border-radius: 0px;}[type='radio'] {border-radius: 100%;}[type='checkbox']:focus,[type='radio']:focus {outline: 2px solid transparent;outline-offset: 2px;--tw-ring-inset: var(--tw-empty, );--tw-ring-offset-width: 2px;--tw-ring-offset-color: #fff;--tw-ring-color: #2563eb;--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow);}[type='checkbox']:checked,[type='radio']:checked {border-color: transparent;background-color: currentColor;background-size: 100% 100%;background-position: center;background-repeat: no-repeat;}[type='checkbox']:checked {background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");}[type='radio']:checked {background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");}[type='checkbox']:checked:hover,[type='checkbox']:checked:focus,[type='radio']:checked:hover,[type='radio']:checked:focus {border-color: transparent;background-color: currentColor;}[type='checkbox']:indeterminate {background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 16 16'%3e%3cpath stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 8h8'/%3e%3c/svg%3e");border-color: transparent;background-color: currentColor;background-size: 100% 100%;background-position: center;background-repeat: no-repeat;}[type='checkbox']:indeterminate:hover,[type='checkbox']:indeterminate:focus {border-color: transparent;background-color: currentColor;}[type='file'] {background: unset;border-color: inherit;border-width: 0;border-radius: 0;padding: 0;font-size: unset;line-height: inherit;}[type='file']:focus {outline: 1px solid ButtonText;outline: 1px auto -webkit-focus-ring-color;}@layer __play_components__;.mx-6 {margin-left: 1.5rem;margin-right: 1.5rem;}.mb-2 {margin-bottom: 0.5rem;}.mt-2 {margin-top: 0.5rem;}.mt-3 {margin-top: 0.75rem;}.mt-4 {margin-top: 1rem;}.block {display: block;}.inline {display: inline;}.flex {display: flex;}.inline-flex {display: inline-flex;}.hidden {display: none;}.h-10 {height: 2.5rem;}.h-20 {height: 5rem;}.h-px {height: 1px;}.min-h-screen {min-height: 100vh;}.w-20 {width: 5rem;}.w-80 {width: 20rem;}.w-full {width: 100%;}.max-w-80 {max-width: 20rem;}.max-w-md {max-width: 28rem;}.shrink {flex-shrink: 1;}.shrink-0 {flex-shrink: 0;}.grow {flex-grow: 1;}.flex-col {flex-direction: column;}.items-center {align-items: center;}.justify-center {justify-content: center;}.gap-2 {gap: 0.5rem;}.gap-3 {gap: 0.75rem;}.gap-6 {gap: 1.5rem;}.space-y-6 > :not([hidden]) ~ :not([hidden]) {--tw-space-y-reverse: 0;margin-top: calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom: calc(1.5rem * var(--tw-space-y-reverse));}.whitespace-nowrap {white-space: nowrap;}.rounded-lg {border-radius: 0.5rem;}.rounded-xl {border-radius: 0.75rem;}.border-0 {border-width: 0px;}.border-zinc-300 {--tw-border-opacity: 1;border-color: rgb(212 212 216 / var(--tw-border-opacity, 1));}.bg-white {--tw-bg-opacity: 1;background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1));}.bg-zinc-100 {--tw-bg-opacity: 1;background-color: rgb(244 244 245 / var(--tw-bg-opacity, 1));}.bg-zinc-800 {--tw-bg-opacity: 1;background-color: rgb(39 39 42 / var(--tw-bg-opacity, 1));}.bg-zinc-800\/15 {background-color: rgb(39 39 42 / 0.15);}.fill-current {fill: currentColor;}.px-4 {padding-left: 1rem;padding-right: 1rem;}.px-6 {padding-left: 1.5rem;padding-right: 1.5rem;}.text-center {text-align: center;}.font-mono {font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;}.text-2xl {font-size: 1.5rem;line-height: 2rem;}.text-sm {font-size: 0.875rem;line-height: 1.25rem;}.text-xl {font-size: 1.25rem;line-height: 1.75rem;}.font-bold {font-weight: 700;}.font-medium {font-weight: 500;}.font-semibold {font-weight: 600;}.uppercase {text-transform: uppercase;}.text-inherit {color: inherit;}.text-red-500 {--tw-text-opacity: 1;color: rgb(239 68 68 / var(--tw-text-opacity, 1));}.text-white {--tw-text-opacity: 1;color: rgb(255 255 255 / var(--tw-text-opacity, 1));}.text-zinc-500 {--tw-text-opacity: 1;color: rgb(113 113 122 / var(--tw-text-opacity, 1));}.text-zinc-800 {--tw-text-opacity: 1;color: rgb(39 39 42 / var(--tw-text-opacity, 1));}.no-underline {text-decoration-line: none;}.decoration-zinc-800\/20 {text-decoration-color: rgb(39 39 42 / 0.2);}.underline-offset-\[6px\] {text-underline-offset: 6px;}.antialiased {-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;}.opacity-50 {opacity: 0.5;}.placeholder\:lowercase::placeholder {text-transform: lowercase;}.placeholder\:text-zinc-300::placeholder {--tw-text-opacity: 1;color: rgb(212 212 216 / var(--tw-text-opacity, 1));}.hover\:bg-zinc-900:hover {--tw-bg-opacity: 1;background-color: rgb(24 24 27 / var(--tw-bg-opacity, 1));}.hover\:text-zinc-800:hover {--tw-text-opacity: 1;color: rgb(39 39 42 / var(--tw-text-opacity, 1));}.hover\:decoration-current:hover {text-decoration-color: currentColor;}.focus\:border-zinc-400:focus {--tw-border-opacity: 1;border-color: rgb(161 161 170 / var(--tw-border-opacity, 1));}.focus\:ring-zinc-100:focus {--tw-ring-opacity: 1;--tw-ring-color: rgb(244 244 245 / var(--tw-ring-opacity, 1));}.disabled\:pointer-events-none:disabled {pointer-events: none;}.disabled\:cursor-default:disabled {cursor: default;}.disabled\:opacity-50:disabled {opacity: 0.5;}.dark\:border-zinc-700:where(.dark, .dark *) {--tw-border-opacity: 1;border-color: rgb(63 63 70 / var(--tw-border-opacity, 1));}.dark\:bg-white:where(.dark, .dark *) {--tw-bg-opacity: 1;background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1));}.dark\:bg-white\/20:where(.dark, .dark *) {background-color: rgb(255 255 255 / 0.2);}.dark\:bg-zinc-800:where(.dark, .dark *) {--tw-bg-opacity: 1;background-color: rgb(39 39 42 / var(--tw-bg-opacity, 1));}.dark\:bg-zinc-900:where(.dark, .dark *) {--tw-bg-opacity: 1;background-color: rgb(24 24 27 / var(--tw-bg-opacity, 1));}.dark\:text-red-400:where(.dark, .dark *) {--tw-text-opacity: 1;color: rgb(248 113 113 / var(--tw-text-opacity, 1));}.dark\:text-white:where(.dark, .dark *) {--tw-text-opacity: 1;color: rgb(255 255 255 / var(--tw-text-opacity, 1));}.dark\:text-white\/70:where(.dark, .dark *) {color: rgb(255 255 255 / 0.7);}.dark\:text-zinc-200:where(.dark, .dark *) {--tw-text-opacity: 1;color: rgb(228 228 231 / var(--tw-text-opacity, 1));}.dark\:text-zinc-300:where(.dark, .dark *) {--tw-text-opacity: 1;color: rgb(212 212 216 / var(--tw-text-opacity, 1));}.dark\:text-zinc-400:where(.dark, .dark *) {--tw-text-opacity: 1;color: rgb(161 161 170 / var(--tw-text-opacity, 1));}.dark\:text-zinc-800:where(.dark, .dark *) {--tw-text-opacity: 1;color: rgb(39 39 42 / var(--tw-text-opacity, 1));}.dark\:decoration-white\/20:where(.dark, .dark *) {text-decoration-color: rgb(255 255 255 / 0.2);}.dark\:placeholder-zinc-600:where(.dark, .dark *)::placeholder {--tw-placeholder-opacity: 1;color: rgb(82 82 91 / var(--tw-placeholder-opacity, 1));}.dark\:shadow-none:where(.dark, .dark *) {--tw-shadow: 0 0 #0000;--tw-shadow-colored: 0 0 #0000;box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);}.dark\:hover\:bg-zinc-100:hover:where(.dark, .dark *) {--tw-bg-opacity: 1;background-color: rgb(244 244 245 / var(--tw-bg-opacity, 1));}.dark\:hover\:text-white:hover:where(.dark, .dark *) {--tw-text-opacity: 1;color: rgb(255 255 255 / var(--tw-text-opacity, 1));}.dark\:focus\:border-zinc-600:focus:where(.dark, .dark *) {--tw-border-opacity: 1;border-color: rgb(82 82 91 / var(--tw-border-opacity, 1));}.dark\:focus\:ring-zinc-700:focus:where(.dark, .dark *) {--tw-ring-opacity: 1;--tw-ring-color: rgb(63 63 70 / var(--tw-ring-opacity, 1));}.dark\:disabled\:opacity-75:disabled:where(.dark, .dark *) {opacity: 0.75;}:where(.\[\:where\(\&\)\]\:size-5) {width: 1.25rem;height: 1.25rem;}
        </style>
    </head>

    <body
        class="dark min-h-screen flex flex-col items-center justify-center bg-white antialiased dark:bg-zinc-900"
    >
        <div class="flex w-full max-w-md flex-col items-center space-y-6 px-6">
            <div class="flex justify-center opacity-50">
                <a href="/" class="group flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 42" class="h-20 w-20 fill-current text-zinc-800 dark:text-zinc-400">
                        <path
                            fill="currentColor"
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M17.2 5.633 8.6.855 0 5.633v26.51l16.2 9 16.2-9v-8.442l7.6-4.223V9.856l-8.6-4.777-8.6 4.777V18.3l-5.6 3.111V5.633ZM38 18.301l-5.6 3.11v-6.157l5.6-3.11V18.3Zm-1.06-7.856-5.54 3.078-5.54-3.079 5.54-3.078 5.54 3.079ZM24.8 18.3v-6.157l5.6 3.111v6.158L24.8 18.3Zm-1 1.732 5.54 3.078-13.14 7.302-5.54-3.078 13.14-7.3v-.002Zm-16.2 7.89 7.6 4.222V38.3L2 30.966V7.92l5.6 3.111v16.892ZM8.6 9.3 3.06 6.222 8.6 3.143l5.54 3.08L8.6 9.3Zm21.8 15.51-13.2 7.334V38.3l13.2-7.334v-6.156ZM9.6 11.034l5.6-3.11v14.6l-5.6 3.11v-14.6Z"
                        />
                    </svg>
                </a>
            </div>

            <div
                class="mb-2 text-center text-2xl font-medium text-zinc-800 dark:text-white"
            >
                Sign-in to {{ config('app.name') }}
                <div class="mt-2 text-sm text-zinc-500 dark:text-white/70">
                    Enter the alpha numeric code sent to
                    <span class="font-semibold">{{ $email ?? 'test@example.com' }}</span>.
                    The code is case insensitive and dashes will be added
                    automatically.
                </div>
            </div>

            <form
                autocomplete="off"
                method="POST"
                action="{{ $url }}"
                class="mt-4 flex w-80 max-w-80 flex-col gap-6"
            >
                @csrf
                <div>
                    <div class="flex justify-center">
                        <input
                            x-data="{}"
                            id="code"
                            type="text"
                            name="code"
                            placeholder="xxxxx-xxxxx"
                            autocomplete="off"
                            required
                            autofocus
                            class="block w-80 rounded-xl border-zinc-300 bg-zinc-100 text-center font-mono text-xl font-bold uppercase placeholder:lowercase placeholder:text-zinc-300 focus:border-zinc-400 focus:ring-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:placeholder-zinc-600 dark:focus:border-zinc-600 dark:focus:ring-zinc-700"
                            x-mask="*****-*****"
                            aria-labelledby="otp-heading"
                            aria-describedby="otp-description {{ $errors->has('form.code') ? 'otp-error' : '' }}"
                            aria-invalid="{{ $errors->has('form.code') ? 'true' : 'false' }}"
                            maxlength="11"
                        />
                        <input
                            type="hidden"
                            name="email"
                            value="{{ $email }}"
                        />
                    </div>

                    @if ($errors->get('code'))
                        <div
                            aria-live="assertive"
                            class="mt-3 text-sm font-medium text-red-500 dark:text-red-400"
                        >
                            <svg
                                class="[:where(&amp;)]:size-5 inline shrink-0"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            @foreach ((array) $errors->get('code') as $message)
                                {{ $message }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <button
                    type="submit"
                    class="inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-lg bg-zinc-800 px-4 text-sm font-medium text-white hover:bg-zinc-900 disabled:pointer-events-none disabled:cursor-default disabled:opacity-50 dark:bg-white dark:text-zinc-800 dark:shadow-none dark:hover:bg-zinc-100 dark:disabled:opacity-75"
                >
                    Submit Code
                </button>

                <div class="flex w-full items-center" role="none">
                    <div
                        class="h-px w-full grow border-0 bg-zinc-800/15 dark:bg-white/20"
                    ></div>

                    <span
                        class="mx-6 shrink whitespace-nowrap text-sm font-medium text-zinc-500 dark:text-zinc-300"
                    >
                        or
                    </span>

                    <div
                        class="h-px w-full grow border-0 bg-zinc-800/15 dark:bg-white/20"
                    ></div>
                </div>

                <div class="text-center">
                    <a
                        class="inline text-sm font-medium text-inherit text-zinc-500 no-underline decoration-zinc-800/20 underline-offset-[6px] hover:text-zinc-800 hover:decoration-current dark:text-white/70 dark:decoration-white/20 dark:hover:text-white"
                        href="{{ route('login') }}"
                    >
                        Request a new code
                    </a>
                </div>
            </form>
        </div>
    </body>
</html>
