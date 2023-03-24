@extends('layouts.app')

@section('content')
<div>
    <button>
        <a href="/workout/create">Create a Workout</a>
    </button>
</div>

<div>
    <h4>My Workouts</h4>
    <ul>
        @foreach ($workouts as $workout)
            <div style="border: 2px solid black; margin: 3px; width: 500px; padding: 3px">
                <h5>{{$workout->name}}</h5>
                <p>{{$workout->description}}</p>
                <a href="{{ url('/workout/edit/' . $workout->id) }}">Edit</a>
                <form action="{{ route('workout.delete', $workout->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        Delete
                    </button>
                </form>
            </div>
        @endforeach
    </ul>
</div>
@endsection

