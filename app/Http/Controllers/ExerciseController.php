<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = $this->get_all_exercises();

        return view('exercises.index', [
            'exercises' => $exercises
        ]);
    }

    // GET ONE EXERCISE
    public function get_one_exercise($id)
    {
        $exercise = DB::table('exercises')
            ->where('id', $id)
            ->get();

        return $exercise;
    }

    // GET ALL EXERCISES
    protected function get_all_exercises()
    {
        $exercises = DB::table('exercises')->get();

        return $exercises;
    }

    // GET ALL EXERCISES FOR ONE USER
    public function get_all_users_exercises($userId)
    {
        $exercises = Exercise::where('user_id', $userId)->get();

        return $exercises;
    }

    // ADD AN EXERCISE
    public function store()
    {
        $exercise = Exercise::create($this->validateRequest());
        redirect('/exercise/' . $exercise->id);

        return $exercise;
    }

    // UPDATE AN EXERCISE
    public function update(Exercise $exercise)
    {
        $data = $this->validateRequest();
        $exercise->update($data);

        return redirect('/exercises/' . $exercise->id);
    }

    // DELETE AN EXERCISE
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect('/exercises');
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
                'user_id' => 'required'
            ]);

            return request()->all();
        } catch (Exception $e) {
            return $e->getMessage();
        };
    }
}
