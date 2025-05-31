@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Tasks Assigned by Academic Head</h1>

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">No.</th>
                <th class="border px-4 py-2">Assigned By</th>
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Team</th>
                <th class="border px-4 py-2">Due Date</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $index => $task)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $task->assignedBy->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $task->title }}</td>
                    <td class="border px-4 py-2">{{ $task->description }}</td>
                    <td class="border px-4 py-2">
                        {{ $task->group ? $task->group->name : '-' }}
                    </td>
                    <td class="border px-4 py-2">{{ $task->due_date }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($task->status) }}</td>
                    <td class="border px-4 py-2">
                        <a href="#" class="text-blue-500">View</a> |
                        <a href="#" class="text-green-500">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
