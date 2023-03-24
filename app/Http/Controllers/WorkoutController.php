<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index(User $user)
    {
        $data = $user->workouts;

        return view('workouts.index', [
            'workouts' => $data
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $workout = Workout::create($this->validateRequest());
        $workout->users()->attach($user);

        return redirect('/workout/edit/' . $workout->id);
    }

    public function workout_editview(Workout $workout)
    {
        $data = $workout->exercises;

        return view('workouts.workout_edit', [
            'workout' => $workout,
            'exercises' => $data
        ]);
    }

    public function workout_createview()
    {
        return view('workouts.workout_create');
    }

    public function get_one_workout(Workout $workout)
    {
        $result = Workout::where('id', $workout->id)->get();

        return $result;
    }

    public function get_all_workouts()
    {
        $result = Workout::all();

        return $result;
    }

    public function update_one_workout(Workout $workout)
    {
        $data = $this->validateRequest();
        $workout->update($data);
        $user = Auth::user();

        return redirect('/workouts/' . $user->id);
    }

    public function destroy(Workout $workout)
    {
        $workout->delete();

        return redirect('/workouts/' . Auth::user()->id);
    }

    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'description' => ''
        ]);
    }
}
