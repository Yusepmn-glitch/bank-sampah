<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bank Sampah Desa Sukaresik') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Simple CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
    @include('layouts.navigation')

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
