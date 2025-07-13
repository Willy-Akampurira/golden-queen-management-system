<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('meta')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <nav class="bg-white shadow mb-4">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                <ul class="flex space-x-4">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li><a href="{{ route('admin.dashboard') }}" class="text-gray-800 hover:text-blue-600">Admin</a></li>
                        @elseif(Auth::user()->role === 'worker')
                            <li><a href="{{ route('worker.dashboard') }}" class="text-gray-800 hover:text-yellow-600">Worker</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}" class="text-gray-800 hover:text-blue-600">Dashboard</a></li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-gray-800 hover:text-blue-600">Login</a></li>
                        @if(Route::has('register'))
                            <li><a href="{{ route('register') }}" class="text-gray-800 hover:text-blue-600">Register</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
        </nav>

        {{-- Optional Header --}}
        @isset($header)
            <header class="mb-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $header }}
                </h2>
            </header>
        @endisset

        {{-- Main Content Area --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded border border-red-300">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
