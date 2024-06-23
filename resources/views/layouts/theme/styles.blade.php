<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{  config('app.name')}}</title>
<link rel="shortcut icon" href="{{ asset('img/favicongr.ico') }}">
{{--<link rel="icon" type="image/x-icon" href="assets/img/favicongr.ico" />--}}

<!-- Fonts -->
{{--<link rel="preconnect" href="https://fonts.bunny.net">--}}
{{--<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />--}}

{{--<script type="text/javascript" src="{{ asset('js/pages/dashboard.js') }}"></script>--}}
<link rel="stylesheet" href="{{'fontawesome-free-5.15.4/css/all.min.css'}}">

<!-- Scripts -->
{{--@vite(['resources/js/pages/dashboard.js','resources/css/app.css'])--}}
@vite(['resources/js/pages/dashboard.js', 'resources/js/app.js','resources/css/app.css'])
@livewireStyles

{{--<script src="//unpkg.com/alpinejs" defer></script>--}}