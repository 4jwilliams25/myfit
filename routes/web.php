<?php

use App\Http\Controllers\DiaryController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\GroceriesController;
use App\Http\Controllers\NutrientsController;
use App\Http\Controllers\RecipeBrowserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\GoalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\ServingController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Auth;

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
})->middleware(middleware: 'auth');

Route::get('/mystuff', function () {
    return view('my_stuff.index');
})->middleware(middleware: 'auth');

// Recipes
Route::post('/recipes', [RecipesController::class, 'store']);
Route::get('/recipes/{user}', [RecipesController::class, 'index'])->middleware(middleware: 'auth');
Route::get('/recipe/{recipe}', [RecipesController::class, 'get_one_recipe']);
Route::get('/recipe/details/{recipe}', [RecipesController::class, 'recipe_detailview']);
Route::get('/recipe/edit/{recipe}', [RecipesController::class, 'recipe_editview'])->middleware(middleware: 'auth');
Route::patch('/recipe/{recipe}', [RecipesController::class, 'update_one_recipe'])->middleware(middleware: 'auth');
Route::delete('/recipe/{recipe}', [RecipesController::class, 'delete_one_recipe'])->middleware(middleware: 'auth');

// Browse for Recipes
Route::get('/recipes/browse', [RecipeBrowserController::class, 'index']);

// Groceries
Route::get('/groceries/all', [GroceriesController::class, 'get_all_groceries'])->middleware(middleware: 'auth');
Route::get('/groceries/{user}', [GroceriesController::class, 'index'])->middleware(middleware: 'auth');
Route::get('/grocery/{grocery}', [GroceriesController::class, 'get_one_grocery'])->middleware(middleware: 'auth');
Route::post('/groceries', [GroceriesController::class, 'add_one_grocery_item'])->middleware(middleware: 'auth');
Route::patch('/groceries/{grocery}', [GroceriesController::class, 'update'])->middleware(middleware: 'auth');
Route::delete('/groceries/{grocery}', [GroceriesController::class, 'destroy'])->middleware(middleware: 'auth');

// Diary
Route::get('/diary', [DiaryController::class, 'index'])->middleware(middleware: 'auth');
Route::get('/diary/nutrition', [DiaryController::class, 'daily_breakdown'])->middleware(middleware: 'auth');

// Nutritional Breakdown
Route::post('/nutrients', [NutrientsController::class, 'store'])->middleware(middleware: 'auth');
Route::get('/nutrients', [NutrientsController::class, 'get_all_nutrients']);
Route::get('/nutrient/{nutrient}', [NutrientsController::class, 'get_one_nutrient']);
Route::patch('/nutrients/{nutrient}', [NutrientsController::class, 'update_one_nutrient'])->middleware(middleware: 'auth');
Route::delete('/nutrient/{nutrient}', [NutrientsController::class, 'delete_one_nutrient'])->middleware(middleware: 'auth');

// Foods
Route::get('/food/details/{food}', [FoodController::class, 'index']);
Route::get('/food/edit/{food}', [FoodController::class, 'food_editview'])->middleware(middleware: 'auth');
Route::get('/food/list', [FoodController::class, 'food_listview']);
Route::post('/food', [FoodController::class, 'store'])->middleware(middleware: 'auth');
Route::get('/food/{food}', [FoodController::class, 'get_one_food_item']);
Route::get('/food', [FoodController::class, 'get_all_food']);
Route::patch('/food/{food}', [FoodController::class, 'update_one_food_item'])->middleware(middleware: 'auth');
Route::delete('food/{food}', [FoodController::class, 'delete_one_food_item'])->middleware(middleware: 'auth');

// Serving Types
Route::post('/servings', [ServingController::class, 'store'])->middleware(middleware: 'auth');
Route::get('/serving/{serving}', [ServingController::class, 'get_one_serving_type']);
Route::patch('/servings/{serving}', [ServingController::class, 'update_one_serving_type'])->middleware(middleware: 'auth');
Route::delete('/servings/{serving}', [ServingController::class, 'delete_one_serving_type'])->middleware(middleware: 'auth');

// Exercises
Route::get('/exercises/list', [ExerciseController::class, 'index']);
Route::get('/exercise/create', [ExerciseController::class, 'exercise_createview'])->middleware(middleware: 'auth');
Route::get('/exercises', [ExerciseController::class, 'get_all_exercises']);
Route::get('/exercise/{exercise}', [ExerciseController::class, 'get_one_exercise'])->where('exercise', '[0-9]+');
Route::post('/exercise/{exercise}/{workout}', [ExerciseController::class, 'add_exercise_to_workout'])->middleware(middleware: 'auth');
Route::post('/exercises', [ExerciseController::class, 'store'])->middleware(middleware: 'auth');
Route::patch('/exercises/{exercise}', [ExerciseController::class, 'update'])->middleware(middleware: 'auth');
Route::delete('/exercise/{exercise}/{workout}', [ExerciseController::class, 'remove_exercise_from_workout'])->name('exercise.remove')->middleware(middleware: 'auth');
Route::delete('/exercise/{exercise}', [ExerciseController::class, 'destroy'])->name('exercise.destroy')->middleware(middleware: 'auth');

// Workouts
Route::post('/workouts', [WorkoutController::class, 'store'])->middleware(middleware: 'auth');
Route::get('/workout/create', [WorkoutController::class, 'workout_createview'])->middleware(middleware: 'auth');
Route::get('/workout/{workout}', [WorkoutController::class, 'get_one_workout']);
Route::get('/workouts/{user}', [WorkoutController::class, 'index'])->middleware(middleware: 'auth');
Route::get('/workout/edit/{workout}', [WorkoutController::class, 'workout_editview'])->middleware(middleware: 'auth');
Route::get('/workouts', [WorkoutController::class, 'get_all_workouts']);
Route::patch('/workouts/{workout}', [WorkoutController::class, 'update_one_workout'])->middleware(middleware: 'auth');
Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy'])->name('workout.delete')->middleware(middleware: 'auth');

// Goals
Route::post('/goals', [GoalController::class, 'store'])->middleware(middleware: 'auth');
Route::patch('/goals/{user}', [GoalController::class, 'update'])->middleware(middleware: 'auth');
Route::delete('/goals/{user}', [GoalController::class, 'destroy'])->middleware(middleware: 'auth');
Route::get('/goals/details/{user}', [GoalController::class, 'goals_detailview'])->middleware(middleware: 'auth');
Route::get('/goals/edit/{user}', [GoalController::class, 'goals_editview'])->middleware(middleware: 'auth');
