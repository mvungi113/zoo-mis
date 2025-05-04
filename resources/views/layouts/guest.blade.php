
<!-- resources/views/layouts/guest.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZooM - Real-Time Zoo Surveillance & Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gradient-to-r from-purple-600 to-indigo-600">
        {{ $slot }}
    </div>
</body>
</html> 