<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cars Wiki') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
            .glass {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
        </style>
    </head>
    <body class="antialiased bg-black text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/login-bg.png') }}" alt="Background" class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black"></div>
            </div>

            <div class="z-10">
                <a href="/">
                    <div class="flex items-center gap-2 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 transition-transform group-hover:rotate-12">
                        <span class="text-2xl font-bold tracking-tighter uppercase italic">Cars<span class="text-blue-500">Wiki</span></span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 glass shadow-2xl overflow-hidden sm:rounded-2xl z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
