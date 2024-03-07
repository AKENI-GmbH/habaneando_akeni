<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Habaneando') }} @yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <link
        href="https://fonts.googleapis.com/css2?family=Gochi+Hand&family=Inter:wght@400;500;600;700;800&family=Lexend:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @yield('css')
</head>

<body>
    <livewire:frontendTopNavigation />
    {{ $slot }}
    <x-footer />

    @livewireScripts

    @yield('js')
</body>

</html>
