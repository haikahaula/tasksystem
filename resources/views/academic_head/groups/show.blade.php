@extends('layouts.app')

@section('content')
    <h1>{{ $group->name }}</h1>
    <p>{{ $group->description }}</p>
    <a href="{{ route('academic-head.groups.index') }}">Back to Groups</a>
@endsection
