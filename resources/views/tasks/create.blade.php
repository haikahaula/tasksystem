@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Create Task</h1>

    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Title:</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Description:</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="4"></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Assign to:</label>

            <div class="mt-2">
                <label class="block">User:</label>
                <select name="assigned_user_id" class="w-full border p-2 rounded">
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-2">
                <label class="block">Group:</label>
                <select name="assigned_group_id" class="w-full border p-2 rounded">
                    <option value="">-- Select Group --</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <p class="text-sm text-gray-600 mt-2">* Only one (user or group) should be selected.</p>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Due Date:</label>
            <input type="date" name="due_date" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Document:</label>
            <input type="file" name="document" class="w-full">
        </div>

        <div style="margin-top: 50px;">
            <button type="submit" style="background-color: rgb(11, 91, 195); color: white; padding: 10px;">Create Task</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userSelect = document.querySelector('select[name="assigned_user_id"]');
            const groupSelect = document.querySelector('select[name="assigned_group_id"]');

            userSelect.addEventListener('change', function () {
                groupSelect.disabled = this.value !== "";
            });

            groupSelect.addEventListener('change', function () {
                userSelect.disabled = this.value !== "";
            });
        });
    </script>
@endsection
