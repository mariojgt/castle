<!DOCTYPE html>
<html lang="en" data-theme="{{ config('castle.castle_theme') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Castle Media Manager' }}</title>
    @vite('resources/vendor/Castle/js/app.js', 'vendor/Castle')
    @vite('resources/vendor/Castle/js/vue.js', 'vendor/Castle')
    @vite('resources/vendor/Castle/sass/app.scss', 'vendor/Castle')
    @stack('css')
</head>

<body>
    <div id="app" >
        {{-- Naive ui stuff --}}
        <n-loading-bar-provider>
            <n-message-provider>
                <n-notification-provider>
                    <n-dialog-provider>
                        <n-config-provider>
                            <x-castle::layout.flash />
                        </n-config-provider>
                    </n-dialog-provider>
                </n-notification-provider>
            </n-message-provider>
        </n-loading-bar-provider>
        {{ $slot }}
    </div>
    @stack('js')
</body>

</html>
