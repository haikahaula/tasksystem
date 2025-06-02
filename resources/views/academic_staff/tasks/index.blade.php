@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tasks for Academic Staff</h1>

        @if($tasks->isEmpty())
            <p>No tasks found.</p>
        @else
            <ul>
                @foreach($tasks as $task)
                    <li>
                        <a href="{{ route('academic-staff.tasks.show', $task->id) }}">
                            {{ $task->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
