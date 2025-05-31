@extends('layouts.bootstrap')

@section('content')
<div class="container">
    <h2>My Groups</h2>
    <table class="table table-striped table-hover table-bordered mt-4">
        <thead>
            <tr>
                <th>No.</th>
                <th>Group Name</th>
                <th>Description</th>
                <th>Team Members</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($groups as $index => $group)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->description }}</td>
                    <td>{{ $group->users_count }}</td>
                    <td>
                        <a href="{{ route('academic-staff.groups.show', $group->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No groups assigned.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
