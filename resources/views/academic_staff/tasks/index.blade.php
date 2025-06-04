@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">My Tasks</h1>

    <table class="w-full table-auto border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">No.</th>
                <th class="px-4 py-2 border">Assigned By</th>
                <th class="px-4 py-2 border">Title</th>
                <th class="px-4 py-2 border">Description</th>
                <th class="px-4 py-2 border">Due Date</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $index => $task)
                <tr>
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $task->assignedBy->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $task->title }}</td>
                    <td class="px-4 py-2 border">{{ Str::limit($task->description, 50) }}</td>
                    <td class="px-4 py-2 border">{{ $task->due_date }}</td>
                    <td class="px-4 py-2 border">{{ ucfirst($task->status) }}</td>
                    <td class="px-4 py-2 border space-x-2">
                        <button
                            onclick="document.getElementById('modal-{{ $task->id }}').classList.remove('hidden')"
                            class="text-blue-600 underline"
                        >
                            View
                        </button>
                        <a href="{{ route('academic-staff.tasks.edit', $task->id) }}" class="text-green-600 underline">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>

        <!-- Place ALL modals after the table -->
        @foreach ($tasks as $task)
            <div id="modal-{{ $task->id }}" class="fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center z-50 hidden flex">
                <div class="bg-white rounded shadow-lg max-w-lg w-full p-6 relative">
                    <button onclick="document.getElementById('modal-{{ $task->id }}').classList.add('hidden')" class="absolute top-2 right-4 text-gray-600 text-xl font-bold">&times;</button>

                    <h2 class="text-xl font-semibold mb-4">Task Details</h2>
                    <p><strong>Title:</strong> {{ $task->title }}</p>
                    <p><strong>Description:</strong> {{ $task->description }}</p>
                    <p><strong>Assigned By:</strong> {{ $task->assignedBy->name ?? '-' }}</p>
                    <p><strong>Due Date:</strong> {{ $task->due_date }}</p>

                    <p class="mt-2"><strong>Document:</strong>
                        @if ($task->document)
                            <a href="{{ asset('storage/' . $task->document) }}" target="_blank" class="text-blue-500 underline">View Document</a>
                        @else
                            No Document
                        @endif
                    </p>

                    <form action="{{ route('academic-staff.comments.store') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <textarea name="content" class="w-full border p-2 rounded mb-2" rows="2" placeholder="Add a comment..." required></textarea>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Submit Comment</button>
                    </form>


                    <div class="mt-4">
                        <h3 class="font-semibold mb-2">Comments</h3>
                        @forelse ($task->comments as $comment)
                            <div class="bg-gray-100 p-2 mb-2 rounded">
                                <p class="text-sm text-gray-700">{{ $comment->user->name }}:</p>
                                <p>{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No comments yet.</p>
                        @endforelse

                            <form action="{{ route('academic-staff.comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <textarea name="content" class="w-full border p-2 rounded mb-2" rows="2" placeholder="Add a comment..." required></textarea>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Submit Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
            </table>
</div>
@endsection
