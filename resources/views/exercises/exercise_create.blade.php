@extends('layouts.app')

@section('content')

    <form action="{{ url('/exercises') }}" method="post">
        @csrf
        <label for="name">Exercise Name</label>
        <input type="text" name="name">
        <br>
        <label for="sets">Exercise Sets</label>
        <input type="text" name="sets">
        <br>
        <label for="repetitions">Exercise Repetitions</label>
        <input type="text" name="repetitions">
        <br>
        <label for="weight">Exercise Weight</label>
        <input type="text" name="weight">
        <br>
        <label for="notes">Exercise Notes</label>
        <input type="textarea" name="notes">
        <br>
        <button type="submit">Create Exercise</button>
    </form>
@endsection