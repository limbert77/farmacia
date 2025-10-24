<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="flex items-center justify-between bg-blue-600 p-4 shadow-md">
        <img src="/img/Logo.png" alt="Logo" class="h-16 w-auto">
        <p class="text-white text-3xl font-bold font-mono">Farmacia "Sana Sana"</p>
    </header>
    @yield('content')
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
