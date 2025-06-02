<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Task System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-yxQFHZwz5E2z2eR7LZbZoXU4y6Dd1E64UYOuypND+7HXc13+6hPb7JzrYx1Bd8O+HkJXzHtp2zpKtvwOAA6LVA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <div class="min-h-screen">
            @include('layouts.navigation')

        <!-- Custom Task Navigation -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3 shadow">
            <div class="max-w-7xl mx-auto flex space-x-4">
                @if (request()->is('academic-staff/*'))
                    <a href="{{ url('academic-staff/dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
                    <a href="{{ url('academic-staff/tasks.show') }}" class="text-blue-600 dark:text-blue-400 hover:underline">View Tasks</a>
                    <a href="{{ url('academic-staff/groups') }}" class="text-blue-600 dark:text-blue-400 hover:underline">View Groups</a>
                @elseif (request()->is('academic-head/*'))
                    <a href="{{ url('academic-head/dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
                    <a href="{{ route('academic-head.tasks.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">All Tasks</a>
                    <a href="{{ route('academic-head.tasks.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Create Task</a>
                    <a href="{{ route('academic-head.groups.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Create Group</a>
                    <a href="{{ route('academic-head.groups.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Groups</a>
                @else
                    <span class="text-gray-500">Select a dashboard</span>
                @endif
            </div>
        </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>
