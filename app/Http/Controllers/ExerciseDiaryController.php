<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExerciseDiaryController extends Controller
{
    public function index()
    {
        return view('exercise_diary.index');
    }
}
