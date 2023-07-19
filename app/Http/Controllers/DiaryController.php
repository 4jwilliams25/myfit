<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Models\Exercise;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiaryController extends Controller
{
    public function index()
    {
        $diary = '';
        $date = date('Ymd');
        $user = Auth::user();

        if (!DB::table('diaries')->where('date', $date)->exists()) {
            $this->add_one_diary($date);
            $diary = DB::table('diaries')->where('date', $date)->get();
        } else {
            $diary = DB::table('diaries')->where('date', $date)->get();
        }

        $diary = Diary::hydrate($diary->all())[0];

        $food = Food::all();
        $exercises = Exercise::all();

        return view('diary.index', [
            'diary' => $diary,
            'food' => $food,
            'recipes' => $user->recipes,
            'userExercises' => $user->exercises,
            'allExercises' => $exercises,
            'workouts' => $user->workouts
        ]);
    }

    public function daily_breakdown()
    {
        $diary = Diary::where('date', date('Ymd'));

        return view('diary.daily_nutritional_breakdown', [
            'diary' => $diary
        ]);
    }

    private function add_one_diary($date)
    {
        $userId = Auth::user()->id;

        $diary = Diary::create([
            'date' => $date,
            'user_id' => $userId,
        ]);

        return $diary;
    }
}
