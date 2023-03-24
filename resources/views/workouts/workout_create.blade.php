@extends('layouts.app')

@section('content')
    <form action="{{ url('/workouts') }}" method="POST">
        @csrf
        <label for="name">Workout Name</label>
        <input type="text" name="name">
        <br>
        <label for="description">Workout Description</label>
        <input type="textarea" name="description">
        <button type="submit">Create Workout</button>
    </form>
@endsection