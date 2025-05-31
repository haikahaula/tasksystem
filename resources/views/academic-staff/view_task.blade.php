@extends('layouts.app')

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Tasks Assigned to You</h2>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-2">No.</th>
                    <th class="px-4 py-2">Assigned By</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Team</th>
                    <th class="px-4 py-2">Due Date</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($tasks as $index => $task)
                    <tr>
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $task->assignedBy->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $task->title }}</td>
                        <td class="px-4 py-2">{{ $task->description }}</td>
                        <td class="px-4 py-2">
                            @if ($task->group)
                                {{ $task->group->grouping_name }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $task->due_date }}</td>
                        <td class="px-4 py-2">{{ $task->status }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('academic-staff.tasks.show', $task->id) }}" class="text-blue-500 hover:underline">View</a>
                            <a href="{{ route('academic-staff.tasks.edit', $task->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center text-gray-500">No tasks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
