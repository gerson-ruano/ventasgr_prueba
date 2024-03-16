<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'Ventas GR' }}</title>
    <!-- Agrega tus estilos CSS, scripts JavaScript, etc. aquí -->
</head>
<body>
    
    <x-header />
    
    <x-navigation />

    <div class="content">
        {{ $slot }}
    </div>

    <x-footer />
</body>
</html>
