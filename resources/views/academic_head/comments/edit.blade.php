@extends('layouts.app')

@section('content')
    <h1>Edit Comment</h1>

    <form action="{{ route('academic-head.comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="content">Comment:</label><br>
            <textarea name="content" id="content" rows="4" class="form-control" required>{{ $comment->content }}</textarea>
        </div>

        <br>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Update Comment
        </button>

        <a href="{{ route('academic-head.tasks.show', $comment->task_id) }}"
            class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
            Cancel
        </a>
    </form>
@endsection
