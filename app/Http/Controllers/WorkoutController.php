<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function store()
    {
        $workout = Workout::create($this->validateRequest());

        return redirect('/workouts/' . $workout->id);
    }

    public function workout_editview(Workout $workout)
    {
        $data = $workout->exercises;

        return view('workouts.workout_edit', [
            'exercises' => $data
        ]);
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

        return redirect('/workouts/' . $workout->id);
    }

    public function destroy(Workout $workout)
    {
        $workout->delete();

        return redirect('/workouts');
    }

    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'description' => ''
        ]);
    }
}
