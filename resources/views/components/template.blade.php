<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
    <meta name="supported-color-schemes" content="light dark">
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings xmlns:o="urn:schemas-microsoft-com:office:office">
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <style>
        td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family: "Segoe UI", sans-serif; mso-line-height-rule: exactly;}
    </style>
    <![endif]-->

    <title>Secure {{ config('app.name') }} Login Link</title>
    <style>
        /* Your custom CSS resets for email */
        /*
         * Here is where you can add your global email CSS resets.
         *
         * We use a custom, email-specific CSS reset, instead
         * of Tailwind's web-optimized `base` layer.
         *
         * Styles defined here will be inlined.
        */
        img {
            max-width: 100%;
            vertical-align: middle
        }
        /* Tailwind CSS components */
        /**
         * @import here any custom CSS components - that is, CSS that
         * you'd want loaded before the Tailwind utilities, so the
         * utilities can still override them.
        */
        /* Tailwind CSS utility classes */
        .absolute {
            position: absolute
        }
        .m-0 {
            margin: 0px
        }
        .my-12 {
            margin-top: 3rem;
            margin-bottom: 3rem
        }
        .mb-1 {
            margin-bottom: 0.25rem
        }
        .mb-4 {
            margin-bottom: 1rem
        }
        .mb-6 {
            margin-bottom: 1.5rem
        }
        .inline-block {
            display: inline-block
        }
        .table {
            display: table
        }
        .hidden {
            display: none
        }
        .w-1\/2 {
            width: 50%
        }
        .w-12 {
            width: 3rem
        }
        .w-\[552px\] {
            width: 552px
        }
        .w-\[600px\] {
            width: 600px
        }
        .w-full {
            width: 100%
        }
        .max-w-full {
            max-width: 100%
        }
        .rounded {
            border-radius: 0.25rem
        }
        .rounded-lg {
            border-radius: 0.5rem
        }
        .rounded-xl {
            border-radius: 0.75rem
        }
        .bg-slate-300 {
            --tw-bg-opacity: 1;
            background-color: rgb(203 213 225 / var(--tw-bg-opacity))
        }
        .bg-slate-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(248 250 252 / var(--tw-bg-opacity))
        }
        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }
        .bg-cover {
            background-size: cover
        }
        .bg-top {
            background-position: top
        }
        .bg-no-repeat {
            background-repeat: no-repeat
        }
        .p-0 {
            padding: 0px
        }
        .p-12 {
            padding: 3rem
        }
        .p-6 {
            padding: 1.5rem
        }
        .px-12 {
            padding-left: 3rem;
            padding-right: 3rem
        }
        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }
        .px-8 {
            padding-left: 2rem;
            padding-right: 2rem
        }
        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem
        }
        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }
        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem
        }
        .pb-8 {
            padding-bottom: 2rem
        }
        .pl-4 {
            padding-left: 1rem
        }
        .pr-4 {
            padding-right: 1rem
        }
        .text-left {
            text-align: left
        }
        .text-center {
            text-align: center
        }
        .text-right {
            text-align: right
        }
        .align-top {
            vertical-align: top
        }
        .font-sans {
            font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
        }
        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem
        }
        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem
        }
        .text-base {
            font-size: 1rem;
            line-height: 1.5rem
        }
        .text-base\/none {
            font-size: 1rem;
            line-height: 1
        }
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem
        }
        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }
        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }
        .font-bold {
            font-weight: 700
        }
        .font-medium {
            font-weight: 500
        }
        .font-semibold {
            font-weight: 600
        }
        .uppercase {
            text-transform: uppercase
        }
        .leading-6 {
            line-height: 1.5rem
        }
        .leading-8 {
            line-height: 2rem
        }
        .text-black {
            --tw-text-opacity: 1;
            color: rgb(0 0 0 / var(--tw-text-opacity))
        }
        .text-gray-700 {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity))
        }
        .text-indigo-700 {
            --tw-text-opacity: 1;
            color: rgb(67 56 202 / var(--tw-text-opacity))
        }
        .text-slate-500 {
            --tw-text-opacity: 1;
            color: rgb(100 116 139 / var(--tw-text-opacity))
        }
        .text-slate-600 {
            --tw-text-opacity: 1;
            color: rgb(71 85 105 / var(--tw-text-opacity))
        }
        .text-slate-700 {
            --tw-text-opacity: 1;
            color: rgb(51 65 85 / var(--tw-text-opacity))
        }
        .text-slate-950 {
            --tw-text-opacity: 1;
            color: rgb(2 6 23 / var(--tw-text-opacity))
        }
        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }
        .no-underline {
            text-decoration-line: none
        }
        .shadow-md {
            --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }
        .shadow-sm {
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }
        .\[-webkit-font-smoothing\:antialiased\] {
            -webkit-font-smoothing: antialiased
        }
        .\[text-decoration\:none\] {
            text-decoration: none
        }
        .\[word-break\:break-word\] {
            word-break: break-word
        }
        /* Your custom utility classes */
        /*
         * Here is where you can define your custom utility classes.
         *
         * We wrap them in the `utilities` @layer directive, so
         * that Tailwind moves them to the correct location.
         *
         * More info:
         * https://tailwindcss.com/docs/functions-and-directives#layer
        */
        .hover\:bg-gray-800:hover {
            --tw-bg-opacity: 1 !important;
            background-color: rgb(31 41 55 / var(--tw-bg-opacity)) !important
        }
        .hover\:text-indigo-500:hover {
            --tw-text-opacity: 1 !important;
            color: rgb(99 102 241 / var(--tw-text-opacity)) !important
        }
        .hover\:\!\[text-decoration\:underline\]:hover {
            text-decoration: underline !important
        }
        @media (min-width: 640px) {
            .sm\:my-8 {
                margin-top: 2rem !important;
                margin-bottom: 2rem !important
            }
            .sm\:inline-block {
                display: inline-block !important
            }
            .sm\:w-6 {
                width: 1.5rem !important
            }
            .sm\:w-full {
                width: 100% !important
            }
            .sm\:px-0 {
                padding-left: 0px !important;
                padding-right: 0px !important
            }
            .sm\:px-4 {
                padding-left: 1rem !important;
                padding-right: 1rem !important
            }
            .sm\:px-6 {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important
            }
            .sm\:py-8 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important
            }
            .sm\:pb-8 {
                padding-bottom: 2rem !important
            }
            .sm\:text-3xl {
                font-size: 1.875rem !important;
                line-height: 2.25rem !important
            }
            .sm\:leading-10 {
                line-height: 2.5rem !important
            }
            .sm\:leading-8 {
                line-height: 2rem !important
            }
        }

    </style>

</head>
<body class="m-0 p-0 w-full [word-break:break-word] [-webkit-font-smoothing:antialiased] bg-white">
<div role="article" aria-roledescription="email" aria-label="Secure {{ config('app.name') }} Login Link" lang="en">

    <div class="bg-white sm:px-4 font-sans">
        <table align="center" cellpadding="0" cellspacing="0" role="none">
            <tr>
                <td class="w-[552px] max-w-full">
                    <div class="my-12 sm:my-8 text-center">
                        <a href="{{ config('app.url') }}">
                            {{ $logo }}
                        </a>
                    </div>

                    <table class="w-full" cellpadding="0" cellspacing="0" role="none">
                        <tr>
                            <td class="p-12 sm:px-6 text-base text-slate-950 bg-white rounded-xl shadow-sm">
                                <h1 class="m-0 mb-6 text-4xl sm:leading-8 text-black font-bold font-outfit">
                                    {{ $greeting }},
                                </h1>

                                <p class="m-0 leading-6">
                                    {{ $copy }}
                                </p>
                                <div role="separator" style="line-height: 24px">&zwj;</div>
                                <div>
                                    <a href="{{ $url }}" class="inline-block px-8 py-3 font-medium no-underline rounded-lg text-base/none shadow-md hover:bg-gray-800" style="color: #ffffff; background-color: #030712">
                                        <!--[if mso]>
                                              <i class="mso-font-width-[150%]" style="mso-text-raise: 30px;" hidden="">&emsp;</i>
                                        <![endif]-->
                                        <span style="mso-text-raise: 16px">{{ $buttontext }}</span>
                                        <!--[if mso]>
                                          <i class="mso-font-width-[150%]" hidden="">&emsp;&#8203;</i>
                                        <![endif]-->
                                    </a>
                                </div>
                                <div role="separator" style="line-height: 24px">&zwj;</div>
                                <p class="m-0">
                                    {{ $footer }}
                                </p>
                            </td>
                        </tr>
                        <tr role="separator">
                            <td class="leading-12">&zwj;</td>
                        </tr>
                        <tr>
                            <td class="text-center text-slate-600 text-sm py-6 px-12 sm:px-6">
                                <p class="m-0 text-left text-sm">
                                    {{ $subcopy }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>

