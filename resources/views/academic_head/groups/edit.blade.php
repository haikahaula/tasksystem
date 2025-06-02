@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Group</h1>

    <form method="POST" action="{{ route('academic-head.groups.update', $group->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-semibold">Name:</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name', $group->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold">Description:</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="4">{{ old('description', $group->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="users" class="block font-semibold">Team Members:</label>
            <select name="users[]" multiple class="w-full border p-2 rounded">
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ $group->users->contains($user->id) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-top: 50px;">
            <button type="submit" style="background-color: rgb(11, 91, 195); color: white; padding: 10px;">
                Update Group
            </button>  
        </div>
    </form>

    <div class="mt-4">
        <a href="{{ route('academic-head.groups.index') }}" class="text-blue-500 hover:underline">Back to Groups</a>
    </div>
@endsection
