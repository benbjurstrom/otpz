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
    <title>Sign-in to {{ config('app.name') }}</title>
    <style>
        img {
            max-width: 100%;
            vertical-align: middle
        }
        .border-zinc-300 {
            --tw-border-opacity: 1;
            border-color: rgb(212 212 216 / var(--tw-border-opacity))
        }
        .bg-slate-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(241 245 249 / var(--tw-bg-opacity))
        }
        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }
        .bg-zinc-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(244 244 245 / var(--tw-bg-opacity))
        }
        .text-black {
            --tw-text-opacity: 1;
            color: rgb(0 0 0 / var(--tw-text-opacity))
        }
        .text-slate-500 {
            --tw-text-opacity: 1;
            color: rgb(100 116 139 / var(--tw-text-opacity))
        }
        .text-slate-950 {
            --tw-text-opacity: 1;
            color: rgb(2 6 23 / var(--tw-text-opacity))
        }
        @media (min-width: 640px) {
            .sm-my-8 {
                margin-top: 2rem !important;
                margin-bottom: 2rem !important
            }
            .sm-px-4 {
                padding-left: 1rem !important;
                padding-right: 1rem !important
            }
            .sm-px-6 {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important
            }
            .sm-leading-8 {
                line-height: 2rem !important
            }
        }
    </style>
</head>
<body class="bg-white" style="margin: 0px; width: 100%; background-color: rgb(255 255 255 / 1); padding: 0px; -webkit-font-smoothing: antialiased; word-break: break-word">
<div role="article" aria-roledescription="email" aria-label="Sign in to WorkEval" lang="en">
    <div class="bg-white sm-px-4" style="background-color: rgb(255 255 255 / 1); padding-top: 2rem; font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'">
        <table align="center" cellpadding="0" cellspacing="0" role="none">
            <tr>
                <td style="width: 552px; max-width: 100%">
                    <div class="sm-my-8" style="margin-top: 3rem; margin-bottom: 3rem; text-align: center">
                        <a href="{{ config('app.url') }}">
                            {{ $logo }}
                        </a>
                    </div>
                    <table style="width: 100%;" cellpadding="0" cellspacing="0" role="none">
                        <tr>
                            <td class="sm-px-6 text-slate-950 bg-white" style="background-color: rgb(255 255 255 / 1); padding: 3rem; font-size: 1rem; line-height: 1.5rem; color: rgb(2 6 23 / 1)">
                                <h1 class="sm-leading-8 text-black" style="margin: 0px 0px 1.5rem; font-size: 2.25rem; line-height: 2.5rem; font-weight: 700; color: rgb(0 0 0 / 1)">
                                    {{ $greeting }}
                                </h1>
                                <p style="margin: 0px; line-height: 1.5rem">
                                    {{ $copy }}
                                </p>
                                <div role="separator" style="line-height: 24px">&zwj;</div>
                                <div class="bg-zinc-100 border-zinc-300" style="border-radius: 1rem; border: 1px solid rgb(212 212 216 / 1); background-color: rgb(244 244 245 / 1); padding: 1rem; text-align: center">
                                    <div style="font-size: 1.875rem; line-height: 2.25rem; font-weight: 700">
                                        <span style="font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace">{{ $code }}</span>
                                    </div>
                                </div>
                                <div role="separator" style="line-height: 24px">&zwj;</div>
                                <p style="margin: 0px;">
                                    {{ $subcopy }}
                                </p>
                                <div role="separator" class="bg-slate-100" style="background-color: rgb(241 245 249 / 1); height: 1px; line-height: 1px; margin: 24px 0">&zwj;</div>
                                <p class="text-slate-500" style="text-align: center; font-size: 0.875rem; line-height: 1.25rem; color: rgb(100 116 139 / 1)">
                                </p>
                                <p style="text-align: left; font-size: 0.875rem; line-height: 1.25rem">{{ $footer }}
                                </p>
                                <p></p>
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
