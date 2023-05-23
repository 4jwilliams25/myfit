@extends('layouts.app')

@section('content')

<div>
    <button>
        <a class="text-slate-700 hover:text-slate-400 m-5" href="{{ url('/workouts/' . Auth::user()->id) }}">Back to My Workouts</a>
    </button>
</div>

<div>
    <button class="bg-blue-600 hover:bg-blue-700 transform transition-all duration-300 hover:scale-110 px-3 py-1 rounded text-white m-5">
        <a href="/workout/create">Create a Workout</a>
    </button>
</div>

<form class="w-full max-w-lg border border-gray-200 rounded p-2 m-3" action="{{ url('/workouts/' . $workout->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="flex flex-wrap mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">Workout Name</label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" name="name" value="{{ $workout->name }}">
        </div>
    </div>
    <div class="flex flex-wrap mx-3">
        <div class="w-full md:w-1/2 px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="description">Workout Description</label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="textarea" name="description" value="{{ $workout->description }}">
        </div>
    </div>
    <div class="flex flex-wrap mx-3 my-2">
        <button class="bg-green-600 hover:bg-green-700 transform transition-all duration-300 hover:scale-110 px-3 py-1 rounded text-white m-5" type="submit">Update Workout</button>
    </div>
</form>

<form action="{{ route('workout.delete', $workout->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="bg-red-600 hover:bg-red-700 transform transition-all duration-300 hover:scale-110 px-3 py-1 rounded text-white m-5" type="submit">
        Delete Workout
    </button>
</form>

@include('exercises.modal')

@if (session('status'))
    <div id="status_alert" class="w-1/2 bg-green-100 border border-green-400 text-green-700 px-4 py-3 m-5 rounded relative">
        <span class="block sm:inline">{{ session('status') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <button class="close_status_alert hover:text-green-300">&cross;</button>
        </span>
    </div>
@endif

<div>
    <h4>Exercises</h4>
    @if (count($workoutExercises) > 0)
        <ul id="workout_exercise_list">
            @foreach ($workoutExercises as $exercise)

            
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

<script type="text/javascript" src="{{ asset('assets/workout_edit.js') }}"></script>

@endsection