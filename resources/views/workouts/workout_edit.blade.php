@extends('layouts.app')

@section('content')

@php
    session()->put('launchPoint', url()->full());
@endphp

<div>
    <button>
        <a href="{{ url('/workouts/' . Auth::user()->id) }}">Go to My Workouts</a>
    </button>
</div>

<div>
    <button>
        <a href="/workout/create">Create a Workout</a>
    </button>
</div>

<form action="{{ url('/workouts/' . $workout->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <label for="name">Workout Name</label>
    <input type="text" name="name" value="{{ $workout->name }}">
    <br>
    <label for="description">Workout Description</label>
    <input type="textarea" name="description" value="{{ $workout->description }}">
    <button type="submit">Update Workout</button>
</form>

<form action="{{ route('workout.delete', $workout->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">
        Delete Workout
    </button>
</form>

<div>
    <button>
        <a href="{{ url('/exercises/list') }}">Add Exercises</a>
    </button>
</div>

<div>
    <h4>Exercises</h4>
    @if (count($exercises) > 0)
        <ul>
            @foreach ($exercises as $exercise)
                <li>
                    <div style="border: 2px solid black; margin: 3px; width: 500px; padding: 3px;">
                        <h5>{{$exercise->name}}</h5>
                        <p>Reps: {{$exercise->repetitions}}</p>
                        <p>Sets: {{$exercise->sets}}</p>
                        <p>Weight: {{$exercise->weight}}</p>
                        <form action="{{ route('exercise.remove', ['exercise' => $exercise->id, 'workout' => $workout->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                Remove
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>Currently no exercises in this workout</p>
    @endif
    
</div>

@endsection