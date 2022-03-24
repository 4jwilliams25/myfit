<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodDiaryController extends Controller
{
    public function index()
    {
        return view('food_diary.index');
    }
}
