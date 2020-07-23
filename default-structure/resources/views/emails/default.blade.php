<!DOCTYPE html>
<html lang="en"
>
<head>
    <meta charset="utf8">
    <meta http-equiv="x-ua-compatible"
          content="ie=edge">
    <meta name="viewport"
          content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
          crossorigin="anonymous">
    <title>{{ config('app.name') }}</title>

    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <style>
        table {
            border-collapse: collapse;
        }

        td, th, div, p, a, h1, h2, h3, h4, h5, h6 {
            font-family: "Segoe UI", sans-serif;
            mso-line-height-rule: exactly;
        }
    </style>
    <![endif]-->
    <style data-embed="">a[x-apple-data-detectors] {
            color: inherit;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            u ~ div .wrapper {
                min-width: 100vw;
            }
        }
    </style>
    <style>
        /*! normalize.css v8.0.0 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        h1 {
            font-size: 2em;
            margin: .67em 0
        }

        hr {
            box-sizing: content-box;
            height: 0;
            overflow: visible
        }

        pre {
            font-family: monospace, monospace;
            font-size: 1em
        }

        a {
            background-color: transparent
        }

        abbr[title] {
            border-bottom: none;
            text-decoration: underline;
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        b, strong {
            font-weight: bolder
        }

        code, kbd, samp {
            font-family: monospace, monospace;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub, sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        img {
            border-style: none
        }

        button, input, optgroup, select, textarea {
            font-family: inherit;
            font-size: 100%;
            line-height: 1.15;
            margin: 0
        }

        button, input {
            overflow: visible
        }

        button, select {
            text-transform: none
        }

        [type=button], [type=reset], [type=submit], button {
            -webkit-appearance: button
        }

        [type=button]::-moz-focus-inner, [type=reset]::-moz-focus-inner, [type=submit]::-moz-focus-inner, button::-moz-focus-inner {
            border-style: none;
            padding: 0
        }

        [type=button]:-moz-focusring, [type=reset]:-moz-focusring, [type=submit]:-moz-focusring, button:-moz-focusring {
            outline: 1px dotted ButtonText
        }

        fieldset {
            padding: .35em .75em .625em
        }

        legend {
            box-sizing: border-box;
            color: inherit;
            display: table;
            max-width: 100%;
            padding: 0;
            white-space: normal
        }

        progress {
            vertical-align: baseline
        }

        textarea {
            overflow: auto
        }

        [type=checkbox], [type=radio] {
            box-sizing: border-box;
            padding: 0
        }

        [type=number]::-webkit-inner-spin-button, [type=number]::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        [type=search]::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        details {
            display: block
        }

        summary {
            display: list-item
        }

        template {
            display: none
        }

        [hidden] {
            display: none
        }

        html {
            box-sizing: border-box;
            font-family: sans-serif
        }

        *, ::after, ::before {
            box-sizing: inherit
        }

        blockquote, dd, dl, figure, h1, h2, h3, h4, h5, h6, p, pre {
            margin: 0
        }

        button {
            background: 0 0;
            padding: 0
        }

        button:focus {
            outline: 1px dotted;
            outline: 5px auto -webkit-focus-ring-color
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        ol, ul {
            margin: 0
        }

        *, ::after, ::before {
            border-width: 0;
            border-style: solid;
            border-color: #dae1e7
        }

        img {
            border-style: solid
        }

        textarea {
            resize: vertical
        }

        img {
            max-width: 100%;
            height: auto
        }

        input:-ms-input-placeholder, textarea:-ms-input-placeholder {
            color: inherit;
            opacity: .5
        }

        input::-ms-input-placeholder, textarea::-ms-input-placeholder {
            color: inherit;
            opacity: .5
        }

        input::placeholder, textarea::placeholder {
            color: inherit;
            opacity: .5
        }

        [role=button], button {
            cursor: pointer
        }

        table {
            border-collapse: collapse
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1200px
            }
        }

        .bg-grey-light {
            background-color: #dae1e7
        }

        .bg-grey-lightest {
            background-color: #f8fafc
        }

        .bg-white {
            background-color: #fff
        }

        .border-grey-dark {
            border-color: #8795a1
        }

        .rounded-sm {
            border-radius: .125rem
        }

        .rounded-t-sm {
            border-top-left-radius: .125rem;
            border-top-right-radius: .125rem
        }

        .border-solid {
            border-style: solid
        }

        .border-0 {
            border-width: 0
        }

        .border {
            border-width: 1px
        }

        .border-t-4 {
            border-top-width: 4px
        }

        .border-b {
            border-bottom-width: 1px
        }

        .flex {
            display: flex
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .justify-between {
            justify-content: space-between
        }

        .h-screen {
            height: 100vh
        }

        .leading-normal {
            line-height: 1.5
        }

        .py-2 {
            padding-top: .5rem;
            padding-bottom: .5rem
        }

        .px-2 {
            padding-left: .5rem;
            padding-right: .5rem
        }

        .py-3 {
            padding-top: .75rem;
            padding-bottom: .75rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem
        }

        .px-8 {
            padding-left: 2rem;
            padding-right: 2rem
        }

        .pt-2 {
            padding-top: .5rem
        }

        .shadow {
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .1)
        }

        .text-center {
            text-align: center
        }

        .text-grey-darkest {
            color: #3d4852
        }

        .text-grey-darker {
            color: #606f7b
        }

        .text-sm {
            font-size: .875rem
        }

        .w-full {
            width: 100%
        }

        @media (min-width: 576px) {
            .sm\:px-12 {
                padding-left: 3rem;
                padding-right: 3rem
            }
        }

        @media (min-width: 768px) {
            .md\:px-24 {
                padding-left: 6rem;
                padding-right: 6rem
            }
        }

    </style>
</head>

<body class="bg-grey-light">

<table class="wrapper w-full bg-grey-lightest all-font-sans h-screen"
       cellpadding="0"
       cellspacing="0"
       lang="{{ $page->language ?? 'en' }}"
       role="presentation">
    <tr>
        <td class="sm-w-full py-48"
            align="center">
            <table class="w-600 sm:w-full"
                   cellpadding="0"
                   cellspacing="0"
                   role="presentation">
                <tr>
                    <td class="w-full flex justify-center py-8">
                        <img src="{{ asset('img/logo.png') }}">
                    </td>
                </tr>
                <tr>
                    <td align="left"
                        class="px-6 md:px-24">
                        <table class="rounded-t-sm border-solid border-t-4 border-0"
                               cellpadding="0"
                               cellspacing="0"
                               role="presentation"
                               style="border-color: #e8c556">
                            <tr>
                                <td class="w-full px-8 py-64 sm:px-12 bg-white rounded-sm shadow text-grey-darkest">

                                    @if (!empty($greeting))
                                        <table class="w-full border-b border-solid border-grey-dark border-0"
                                               cellpadding="0"
                                               cellspacing="0"
                                               role="presentation">
                                            <tr>
                                                <td class="py-4 flex justify-between items-center">
                                                    <table class="text-grey-darker py-3"
                                                           cellpadding="0"
                                                           cellspacing="0"
                                                           role="presentation">
                                                        <tr>
                                                            <td>{{ $greeting }}</td>
                                                        </tr>
                                                    </table>
                                                    <table class="text-grey-darker text-center"
                                                           cellpadding="0"
                                                           cellspacing="0"
                                                           role="presentation">
                                                        <tr>
                                                            <td class="border border-solid px-2"
                                                                style="color: #e8c556; border-color: #e8c556">
                                                                <small>Anti-Phishing</small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="px-2"
                                                                style="background-color: #e8c556">
                                                                <small class="">{{ $antiPhishingCode ?? __('NOT DEFINED') }}</small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    @endif

                                    <table class="pt-2 text-grey-darker leading-normal"
                                           cellpadding="0"
                                           cellspacing="0"
                                           role="presentation">
                                        {{-- Intro Lines --}}
                                        @foreach ($introLines as $line)
                                            <tr>
                                                <td class="py-2"> {!! $line !!} </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                    {{-- Action Button --}}
                                    @isset($actionText)
                                        <?php
                                        switch ($level) {
                                            case 'success':
                                                $color = 'green';
                                                break;
                                            case 'error':
                                                $color = 'red';
                                                break;
                                            case 'warning':
                                                $color = 'orange';
                                                break;
                                            default:
                                                $color = 'blue';
                                        }
                                        ?>
                                        @component('mail::button', ['url' => $actionUrl, 'color' => $color])
                                            {{ $actionText }}
                                        @endcomponent
                                    @endisset

                                    {{-- Outro Lines --}}
                                    <table class="text-grey-darker"
                                           cellpadding="0"
                                           cellspacing="0"
                                           role="presentation">
                                        @foreach ($outroLines as $line)
                                            <tr>
                                                <td class="py-2">{!! $line !!}</td>
                                            </tr>
                                        @endforeach
                                    </table>

                                    {{-- Salutation --}}
                                    @if (!empty($salutation))
                                        <table class="text-grey-darker"
                                               cellpadding="0"
                                               cellspacing="0"
                                               role="presentation">
                                            <tr>
                                                <td class="py-2">{{ $salutation }}</td>
                                            </tr>
                                        </table>
                                    @endif

                                    @if (!empty($disableAccountToken))
                                        <table class="text-grey-darker"
                                               cellpadding="0"
                                               cellspacing="0"
                                               role="presentation">
                                            <tr>
                                                <td class="py-2 text-sm">
                                                    {!! __('If this activity is not your own operation, please :disable your account and contact us immediately.', ['disable' => '<a href="' . url('/disable-account/' . $disableAccountToken) . '?email=' . urlencode($email) . '">' . __('disable') . '</a>']) !!}
                                                    <br><a href="{{ config('app.support_url') }}">{{ config('app.support_url') }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    @endif

                                    <table class="text-grey-darker"
                                           cellpadding="0"
                                           cellspacing="0"
                                           role="presentation">
                                        <tr>
                                            <td class="py-2 text-sm">
                                                {{ config('app.name') }} Team.<br>
                                                {{ __('Automated message. Please do not reply.') }}
                                            </td>
                                        </tr>
                                    </table>

                                    @isset($actionText)
                                        @component('mail::subcopy')
                                            {{ __('If you\'re having trouble clicking the button, copy and paste this URL into your web browser:') }}
                                            [{{ $actionUrl }}]({{ $actionUrl }})
                                        @endcomponent
                                    @endisset
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="w-600 w-full"
                   cellpadding="0"
                   cellspacing="0"
                   role="presentation">
                <tr>
                    <td align="center"
                        class="text-xs text-grey-dark py-8 leading-24">
                        &copy; 2018 {{ config('app.name') }} All Rights Reserved<br>
                        URL: <a href="{{ config('app.url') }}">{{ config('app.url') }}</a> Email:
                        <a href="mailto:{{ config('app.support_email') }}">{{ config('app.support_email') }}</a>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>