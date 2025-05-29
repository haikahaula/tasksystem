@extends('layouts.app')

@section('content')
    <h1>Task Details</h1>

    <p><strong>Title:</strong> {{ $task->title }}</p>
    <p><strong>Description:</strong> {{ $task->description }}</p>
    <p><strong>Assigned To:</strong> {{ $task->assignedTo->name ?? 'N/A' }}</p>
    <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
    <p><strong>Document:</strong>
        @if ($task->document)
            <a href="{{ asset('storage/' . $task->document) }}" target="_blank">View Document</a>
        @else
            No document uploaded.
        @endif
    </p>

    <a href="{{ route('tasks.edit', $task->id) }}">Edit</a> |
    <a href="{{ route('tasks.index') }}">Back to List</a>

    <hr>

    <h2>Comments</h2>

    @foreach ($task->comments as $comment)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <p><strong>{{ $comment->user->name }}:</strong></p>
            <p>{{ $comment->content }}</p>

            @if ($comment->user_id === auth()->id())
                <a href="{{ route('comments.edit', $comment->id) }}">Edit</a> |
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            @endif
        </div>
    @endforeach

    <h3>Add Comment</h3>
    <form action="{{ route('comments.store', $task->id) }}" method="POST">
        @csrf
        <textarea name="content" rows="4" class="form-control" required></textarea><br>
        <button type="submit" class="btn btn-primary">Add Comment</button>
    </form>
@endsection
