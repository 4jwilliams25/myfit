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

        if (!DB::table('diaries')->where('date', $date)->exists()) {
            $this->add_one_diary($date);
            $diary = DB::table('diaries')->where('date', $date)->get();
        } else {
            $diary = DB::table('diaries')->where('date', $date)->get();
        }

        $diary = Diary::hydrate($diary->all())[0];

        return view('diary.index', [
            'diary' => $diary,
            'food' => $diary->food,
            'recipes' => $diary->recipes,
            'exercises' => $diary->exercises,
            'workouts' => $diary->workouts
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
