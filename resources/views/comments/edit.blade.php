@extends('layouts.app')

@section('content')
    <h1>Edit Comment</h1>

    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="content">Comment:</label><br>
            <textarea name="content" id="content" rows="4" class="form-control" required>{{ $comment->content }}</textarea>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">Update Comment</button>
        <a href="{{ route('tasks.show', $comment->task_id) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
