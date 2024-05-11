<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VentasGR') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

{{--<script type="text/javascript" src="{{ asset('js/pages/dashboard.js') }}"></script>--}}
    <link rel="stylesheet" href="{{'fontawesome-free-5.15.4/css/all.min.css'}}">

    <!-- Scripts -->
    {{--@vite(['resources/css/app.css', 'resources/js/app.js'])--}}
    @vite(['resources/js/pages/dashboard.js', 'resources/css/app.css'])
    @livewireStyles
    <title>{{ $title ?? 'Ventas GR' }}</title>
    
</head>

<body class="fondo-app font-sans antialiased">

    {{--<div class="min-h-screen bg-gray-100 dark:bg-gray-900">--}}
    <div>
        <livewire:layout.navigation />
        <x-menu-modulos />

        <!-- Page Heading -->
        @if (isset($header))
        <header class="menu lg:menu-horizontal w-full">
            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main style="min-height: 80vh;">
        {{--style="min-height: 100vh;"--}}
            {{ $slot }}
        </main>
        <x-footer />
        <!-- Scripts -->
    </div>
    
    @livewireScripts
    
</body>

</html>