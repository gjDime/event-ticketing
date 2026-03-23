<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <a href="{{ route('events.index') }}" class="text-xl font-bold text-gray-800">
                                EventHub
                            </a>
                            <a href="{{ route('events.index') }}" class="ml-8 text-sm text-gray-600 hover:text-gray-900">Events</a>
                        </div>
                        <div class="flex items-center space-x-4">
                            @auth
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Admin</a>
                                @endif
                                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Log Out</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Log In</a>
                                <a href="{{ route('register') }}" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Register</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            @isset($header)
                <header class="bg-white shadow">
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
