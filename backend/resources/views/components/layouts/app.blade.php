<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-serif bg-zinc-900 text-zinc-100 mt-18 px-4 sm:px-6 lg:px-8">
    @livewire(\App\Livewire\Navigation::class)
    {{ $slot }}
</body>
</html>
