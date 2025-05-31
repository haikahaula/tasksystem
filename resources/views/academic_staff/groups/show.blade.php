@extends('layouts.bootstrap')

@section('content')
<div class="container">
    <h2>Group Details</h2>
    <div class="card p-4">
        <p><strong>Group Name:</strong> {{ $group->name }}</p>
        <p><strong>Description:</strong> {{ $group->description }}</p>
        <p><strong>Created By:</strong> {{ $group->creator->name ?? 'Unknown' }}</p>

        <p><strong>Team Members:</strong></p>
        <ul>
            @foreach ($group->users as $user)
                <li>{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
