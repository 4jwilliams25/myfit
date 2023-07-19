<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    // Index method takes an optional workout
    public function index()
    {
        $target_workout = '';
        $diary = '';

        $launchPoint = session()->get('launchPoint');
        $launchPointId = basename($launchPoint);

        if (str_contains($launchPoint, 'workout')) {
            $target_workout = DB::table('workouts')
                ->where('id', $launchPointId)
                ->first();
        }

        $exercises = $this->get_all_exercises();

        return view('exercises.index', [
            'exercises' => $exercises,
            'workout' => $target_workout,
            'diary' => $diary,
            'launchPointId' => $launchPointId
        ]);
    }

    public function exercise_createview()
    {
        return view('exercises.exercise_create');
    }

    // GET ONE EXERCISE
    public function get_one_exercise($id)
    {
        $exercise = DB::table('exercises')
            ->where('id', $id)
            ->get()[0];

        return view('exercises.exercise_edit', [
            'exercise' => $exercise
        ]);
    }

    // GET ALL EXERCISES
    protected function get_all_exercises()
    {
        $exercises = DB::table('exercises')->get();

        return $exercises;
    }

    // ADD AN EXERCISE
    public function store()
    {
        $user = Auth::user();
        $response = Exercise::create($this->validateRequest());
        $user->exercises()->attach($response);

        return redirect('/exercises/list')->with('status', 'Exercise saved successfully!');;
    }

    // ADD AN EXERCISE TO A WORKOUT
    public function add_exercise_to_workout(Exercise $exercise, Workout $workout)
    {
        $workout->exercises()->attach($exercise);

        return redirect('/exercises/list/' . $workout->id);
    }

    // REMOVE AN EXERCISE FROM A WORKOUT
    public function remove_exercise_from_workout(Exercise $exercise, Workout $workout)
    {
        $workout->exercises()->detach($exercise->id);

        return redirect('/workout/edit/' . $workout->id);
    }

    // UPDATE AN EXERCISE
    public function update(Exercise $exercise)
    {
        $data = $this->validateRequest();
        $exercise->update($data);

        return redirect('/exercise/' . $exercise->id);
    }

    // DELETE AN EXERCISE
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect('/exercises/list');
    }

    private function validateRequest()
    {
        try {
            request()->validate([
                'name' => 'required',
                'repetitions' => '',
                'sets' => '',
                'weight' => '',
                'notes' => '',
            ]);

            return request()->all();
        } catch (Exception $e) {
            return $e->getMessage();
        };
    }
}
