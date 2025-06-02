@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-3xl font-bold mb-6">{{ $task->title }}</h2>

    <div class="mb-4">
        <strong>Description:</strong>
        <p class="mt-1 whitespace-pre-line">{{ $task->description ?? 'No description provided.' }}</p>
    </div>

    <div class="mb-4">
        <strong>Due Date:</strong>
        <p>{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}</p>
    </div>

    <div class="mb-4">
        <strong>Assigned To:</strong>
        <div class="mt-1">
            @if ($task->users && $task->users->count())
                @foreach ($task->users as $user)
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1">
                        {{ $user->name }} ({{ $user->email }})
                    </span>
                @endforeach
            @elseif ($task->assignedGroup)
                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                    {{ $task->assignedGroup->name }}
                </span>
            @else
                <span class="text-gray-500 text-sm">Unassigned</span>
            @endif
        </div>
    </div>

    @if($task->document)
        <div class="mb-4">
            <strong>Document:</strong>
            <p>
                <a href="{{ asset('storage/' . $task->document) }}" target="_blank" class="text-blue-600 underline hover:text-blue-800">
                    View / Download
                </a>
            </p>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('academic-head.tasks.index') }}" class="text-blue-600 underline hover:text-blue-800">← Back to Tasks</a>
    </div>
</div>
@endsection
