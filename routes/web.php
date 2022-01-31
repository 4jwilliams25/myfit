<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Recipes
Route::get('/recipes', function () {
    return 'Recipes';
});

// Browse for Recipes
Route::get('/recipes/browse', function () {
    return 'Browse for recipes';
});

// Groceries
Route::get('/groceries', function () {
    return 'Groceries';
});

// Food Diary
Route::get('/eats', function () {
    return 'Food Diary';
});

// Nutritional Breakdown
Route::get('/eats/nutrition', function () {
    return 'Nutritional breakdown';
});

// Workout Plans
Route::get('/workout', function () {
    return 'Workouts';
});

// Workout Diary
Route::get('/workout/diary', function () {
    return 'Workout Diary';
});
