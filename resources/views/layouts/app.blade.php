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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap for dropdown (optional if you already use another UI lib) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <!-- Notifications -->
    @auth
        <div class="container mt-3 text-end me-4">
            <div class="dropdown d-inline-block">
                <a class="btn position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-bell" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 1.985-1.75H6.015A2 2 0 0 0 8 16zm.104-14.59a1 1 0 1 1-1.208 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 2.417-1.336 3.566-.26.373-.13.89.283 1.106.318.168.737.091.969-.185C3.763 9.425 4 8.707 4 8V6a4 4 0 0 1 8 0v2c0 .707.237 1.425.584 1.487.232.276.651.353.969.185.413-.216.543-.733.283-1.106C13.5 8.417 13 7.098 13 6a5.002 5.002 0 0 0-4.896-4.59z"/>
                    </svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ auth()->user()->unreadNotifications->count() }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <li>
                            <a class="dropdown-item" href="{{ route('academic-staff.tasks.show', $notification->data['task_id']) }}">
                                {{ $notification->data['message'] }}
                            </a>
                        </li>
                    @empty
                        <li><span class="dropdown-item">No new notifications</span></li>
                    @endforelse
                </ul>
            </div>
        </div>
    @endauth

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
</div>
</body>
</html>
