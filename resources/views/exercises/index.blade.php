@extends('layouts.app')

@section('content')

@if ($workout)
    <button>
        <a href="{{ url('/workout/edit/' . $workout->id) }}">Back to Workout</a>
    </button>
@endif

<div>
    <button>
        <a href="{{ url('/exercise/create') }}">Create an Exercise</a>
    </button>
</div>

<div>
    <h4>Exercises</h4>
    @if (count($exercises) <= 0)
        <p>There are currently no exercises in the system</p>
    @endif

    <ul>
        @foreach ($exercises as $exercise)
        <li>
            <div style="border: 2px solid black; margin: 3px; width: 500px; padding: 3px">
                <h5>{{$exercise->name}}</h5>
                <p>Reps: {{$exercise->repetitions}}</p>
                <p>Sets: {{$exercise->sets}}</p>
                <p>Weight: {{$exercise->weight}}</p>
                @if ($workout)
                    <form action="{{ url('/exercise/' . $exercise->id . '/' . $workout->id) }}" method="post">
                        @csrf
                        <button type="submit">
                            Add to Workout
                        </button>
                    </form>
                @endif
                <a href="{{ url('/exercise/' . $exercise->id) }}">Edit</a>
                <form action="{{ route('exercise.destroy', $exercise->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        Delete
                    </button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection