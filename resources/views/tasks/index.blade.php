@extends('layouts.app')

@section('content')
    <h1>Task List</h1>

    <a href="{{ route('tasks.create') }}">Create New Task</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Title</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Document</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->assignedTo->name ?? 'N/A' }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>
                        @if ($task->document)
                            <a href="{{ asset('storage/' . $task->document) }}" target="_blank">View</a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
