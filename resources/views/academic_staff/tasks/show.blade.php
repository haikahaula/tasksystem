@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-4xl mx-auto">
    <a href="{{ route('academic-staff.tasks.index') }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mt-4">
        ← Back to Task List
    </a>

    <h2 class="text-xl font-bold mb-4">Task Details</h2>

    <p><strong>Title:</strong> {{ $task->title }}</p>
    <p><strong>Description:</strong> {{ $task->description }}</p>
    <p><strong>Assigned By:</strong> {{ $task->assignedBy->name ?? '-' }}</p>
    <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
    <p><strong>Document:</strong> 
        @if ($task->document)
            <a href="{{ asset('storage/' . $task->document) }}" class="text-blue-600 underline" target="_blank">View Document</a>
        @else
            No Document
        @endif
    </p>
    <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>

<hr class="my-4">

        <h3 class="text-lg font-semibold">Comments</h3>

        @forelse ($task->comments as $comment)
            <div class="border rounded p-3 mb-2">
                <strong>{{ $comment->user->name }}:</strong>
                <p>{{ $comment->content }}</p>
                <small class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>

                @if (Auth::id() === $comment->user_id)
                    <div class="mt-2">
                        <a href="{{ route('comments.edit', $comment) }}" class="text-blue-600 text-sm mr-2">Edit</a>

                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 text-sm" onclick="return confirm('Delete this comment?')">Delete</button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <p>No comments yet.</p>
        @endforelse

        @include('comments._form', ['task' => $task])
</div>
@endsection
