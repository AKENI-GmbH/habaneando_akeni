<!DOCTYPE html>
<html class="h-full bg-white" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Habaneando') }} @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->


    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body>
    <div class="flex min-h-full">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="">
                <div>
                    <a href="{{ route('frontend.home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt=""
                            class="w-auto h-16 sm:h-16 md:hidden lg:block lg:h-20" />
                        <img src="{{ asset('images/logo.png') }}" alt=""
                            class="hidden w-auto h-20 md:block lg:hidden" />
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/header.jpeg') }}"
                alt="">
        </div>
    </div>

    @livewireScripts
    @vite('resources/js/app.js')
</body>

</html>
