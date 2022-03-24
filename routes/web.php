<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseDiaryController;
use App\Http\Controllers\FoodDiaryController;
use App\Http\Controllers\GroceriesController;
use App\Http\Controllers\NutrientsController;
use App\Http\Controllers\RecipeBrowserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\WorkoutDiaryController;
use App\Http\Controllers\WorkoutsController;

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
Route::get('/recipes', [RecipesController::class, 'index']);

Route::get('/recipes/{id}', [RecipesController::class, 'show'])->where('id', '[0-9]+');

// Browse for Recipes
Route::get('/recipes/browse', [RecipeBrowserController::class, 'index']);

// Groceries
Route::get('/groceries', [GroceriesController::class, 'index']);

// Food Diary
Route::get('/eats', [FoodDiaryController::class, 'index']);

// Nutritional Breakdown
Route::get('/eats/nutrition', [NutrientsController::class, 'index']);

// Exercises
Route::get('/exercises', [ExerciseController::class, 'index']);

Route::get('/exercises/{id}', [ExerciseController::class, 'show'])->where('id', '[0-9]+');

// Exercise Diary
Route::get('/workouts', [ExerciseDiaryController::class, 'index']);
