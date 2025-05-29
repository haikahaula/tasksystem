@extends('layouts.app')

@section('content')
    <h1>Edit Task</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Title:</label>
        <input type="text" name="title" value="{{ $task->title }}" required><br>

        <label>Description:</label>
        <textarea name="description">{{ $task->description }}</textarea><br>

        <label>Assign to:</label>
        <select name="assigned_to_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $task->assigned_to_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select><br>

        <label>Due Date:</label>
        <input type="date" name="due_date" value="{{ $task->due_date }}" required><br>

        <label>Document:</label>
        <input type="file" name="document"><br>
        @if ($task->document)
            <a href="{{ asset('storage/' . $task->document) }}" target="_blank">Current Document</a><br>
        @endif

        <button type="submit">Update Task</button>
    </form>
@endsection
