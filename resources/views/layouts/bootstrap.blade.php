<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Task System') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-yxQFHZwz5E2z2eR7LZbZoXU4y6Dd1E64UYOuypND+7HXc13+6hPb7JzrYx1Bd8O+HkJXzHtp2zpKtvwOAA6LVA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-light text-dark">

    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Task System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if (request()->is('academic-staff/*'))
                        <li class="nav-item"><a class="nav-link" href="{{ url('academic-staff/dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('academic-staff/tasks') }}">View Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('academic-staff/groups') }}">View Groups</a></li>
                    @elseif (request()->is('academic-head/*'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">All Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tasks.create') }}">Create Task</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('groups.create') }}">Create Group</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('groups.index') }}">Groups</a></li>
                    @else
                        <li class="nav-item"><span class="nav-link text-muted">Select a dashboard</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
