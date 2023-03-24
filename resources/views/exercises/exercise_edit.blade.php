@extends('layouts.app')

@section('content')
    <div>
        <button>
            <a href="{{ url('exercises/list') }}">Back to Exercise List</a>
        </button>
    </div>

    <form action="{{ url('/exercises/' . $exercise->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <label for="name">Exercise Name</label>
        <input type="text" name="name" value="{{ $exercise->name }}">
        <br>
        <label for="sets">Exercise Sets</label>
        <input type="text" name="sets" value="{{ $exercise->sets }}">
        <br>
        <label for="repetitions">Exercise Repetitions</label>
        <input type="text" name="repetitions" value="{{ $exercise->repetitions }}">
        <br>
        <label for="weight">Exercise Weight</label>
        <input type="text" name="weight" value="{{ $exercise->weight }}">
        <br>
        <label for="notes">Exercise Notes</label>
        <input type="textarea" name="notes" value="{{ $exercise->notes }}">
        <br>
        <button type="submit">Update Exercise</button>
    </form>

    <form action="{{ route('exercise.destroy', $exercise->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            Delete Exercise
        </button>
    </form>
@endsection