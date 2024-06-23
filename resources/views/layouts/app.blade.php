<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.theme.styles')
</head>

<body class="fondo-app font-sans antialiased">

    {{--<div class="min-h-screen bg-gray-100 dark:bg-gray-900">--}}
    <div>

        <!-- Menu Modulos -->
        @include('layouts.theme.menu-modulos')

        <!-- Menu Login -->
        <livewire:layout.navigation />

        {{--@if (isset($header))
        <header class="menu lg:menu-horizontal w-full">
            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                {{ $header }}
    </div>
    </header>
    @endif--}}

    <!-- Page Heading -->
    @if (View::hasSection('header'))
    <header class="menu lg:menu-horizontal w-full">
        <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
            @yield('header')
        </div>
    </header>
    @endif

    <!-- Page Content -->
    <main style="min-height: 78vh;">
        {{--$slot--}}
        @yield('content')
    </main>

    </div>
    <!-- Footer -->
    @include('layouts.theme.footer')

    <!-- Scripts -->
    {{--@stack('scripts')--}}
    @include('layouts.theme.scripts')
    
</body>

</html>