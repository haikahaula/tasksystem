@extends('layouts.app')

@section('content')
    <h1>Create Group</h1>
<form method="POST" action="{{ isset($group) ? route('groups.update', $group->id) : route('groups.store') }}">
    @csrf
    @if(isset($group))
        @method('PUT')
    @endif

    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name', $group->name ?? '') }}">
    </div>

    <div>
        <label for="description">Description:</label>
        <textarea name="description">{{ old('description', $group->description ?? '') }}</textarea>
    </div>

    <div>
        <label for="users">Team Members:</label>
        <select name="users[]" multiple>
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                    {{ isset($group) && $group->users->contains($user->id) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

        <button type="submit">
            {{ isset($group) && $group ? 'Update Group' : 'Create Group' }}
        </button>
</form>
@endsection
