<!DOCTYPE html>
<html lang="en" data-theme="halloween">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Castle' }}</title>
    <link href="{{ asset('vendor/Castle/css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>

<body>

    <div id="app">
        <n-loading-bar-provider>
            <n-message-provider>
                <n-notification-provider>
                    <n-dialog-provider>
                        <n-config-provider>
                            {{-- <x-Castle::layout.flash /> --}}
                            <flashMessage type="success" message="mariojgt" />

                            {{ $slot }}
                        </n-config-provider>
                    </n-dialog-provider>
                </n-notification-provider>
            </n-message-provider>
        </n-loading-bar-provider>
    </div>

    <script src="{{ asset('vendor/Castle/js/app.js') }}" defer></script>
    <script src="{{ asset('vendor/Castle/js/vue.js') }}" defer></script>
    @stack('js')
</body>

</html>
