<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
    // Initialize theme from localStorage or default to dark
    if (localStorage.theme === 'light' || (!('theme' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: light)').matches)) {
        document.documentElement.classList.remove('dark')
        document.documentElement.classList.add('light')
    } else {
        document.documentElement.classList.add('dark')
        document.documentElement.classList.remove('light')
    }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
</head>

{{-- CORREÇÃO DEFINITIVA: As classes de fundo foram adicionadas diretamente aqui na tag

<body> --}}

<body
    class="font-sans antialiased transition-colors duration-300 dark:bg-gradient-to-br dark:from-gray-900 dark:via-slate-900 dark:to-gray-800 bg-gradient-to-br from-gray-50 via-blue-50 to-gray-100">

    <div class="min-h-screen">
        @include('layouts.navigation')

        @isset($header)
        <header class="bg-transparent">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>