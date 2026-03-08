<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Golden Rose Admin' }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex flex-col justify-center items-center">
        {{ $slot }}
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @livewireScripts
</body>
</html>