@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Task Status</h2>

    <form action="{{ route('academic-staff.tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">Task Status</label>
            <select name="status" id="status" class="border rounded w-full p-2 bg-white dark:bg-gray-900">
                <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in progress" {{ $task->status === 'in progress' ? 'selected' : '' }}>In Progress</option>
                <option value="finished" {{ $task->status === 'finished' ? 'selected' : '' }}>Finished</option>
            </select>
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            Update Status
        </button>
    </form>
</div>
@endsection
