<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function index()
    {
        return view('diary.index');
    }

    public function daily_breakdown()
    {
        return view('diary.daily_nutritional_breakdown');
    }
}
