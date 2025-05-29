@extends('layouts.app')

@section('content')
    <h1>Create Task</h1>

    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Title:</label>
        <input type="text" name="title" required><br>

        <label>Description:</label>
        <textarea name="description"></textarea><br>

        <label>Assign to:</label>
        <select name="assigned_to_id" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select><br>

        <label>Due Date:</label>
        <input type="date" name="due_date" required><br>

        <label>Document:</label>
        <input type="file" name="document"><br>

        <button type="submit">Create Task</button>
    </form>
@endsection
