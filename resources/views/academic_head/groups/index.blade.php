@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Groups</h2>

        <table class="w-full table-auto border-collapse bg-white rounded shadow">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="px-4 py-2 border">No.</th>
                    <th class="px-4 py-2 border">Group Name</th>
                    <th class="px-4 py-2 border">Team Members</th>
                    <th class="px-4 py-2 border">Description</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groups as $index => $group)
                    <tr class="border-t hover:bg-gray-100">
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $group->name }}</td>
                        <td class="px-4 py-2 border">
                            @foreach($group->users as $user)
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1">{{ $user->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 border">{{ $group->description }}</td>
                        <td class="px-4 py-2 border space-x-2">
                            <a href="{{ route('academic-head.groups.show', $group->id) }}" title="View" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('academic-head.groups.edit', $group->id) }}" title="Edit" class="text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('academic-head.groups.destroy', $group->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
