<?php

use App\Http\Controllers\DiaryController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\GroceriesController;
use App\Http\Controllers\NutrientsController;
use App\Http\Controllers\RecipeBrowserController;
use App\Http\Controllers\FoodController;
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
});

Route::get('/home', function () {
    dd(Auth::user());
})->middleware(middleware: 'auth');

Route::get('/mystuff', function () {
    return view('my_stuff.index');
});

// Recipes
Route::post('/recipes', [RecipesController::class, 'store']);
Route::get('/recipes/{user}', [RecipesController::class, 'index']);
Route::get('/recipe/{recipe}', [RecipesController::class, 'get_one_recipe']);
Route::get('/recipe/details/{recipe}', [RecipesController::class, 'recipe_detailview']);
Route::get('/recipe/edit/{recipe}', [RecipesController::class, 'recipe_editview']);
Route::patch('/recipe/{recipe}', [RecipesController::class, 'update_one_recipe']);
Route::delete('/recipe/{recipe}', [RecipesController::class, 'delete_one_recipe']);

// Browse for Recipes
Route::get('/recipes/browse', [RecipeBrowserController::class, 'index']);

// Groceries
Route::get('/groceries/all', [GroceriesController::class, 'get_all_groceries']);
Route::get('/groceries/{user}', [GroceriesController::class, 'index']);
Route::get('/grocery/{grocery}', [GroceriesController::class, 'get_one_grocery']);
Route::post('/groceries', [GroceriesController::class, 'add_one_grocery_item']);
Route::patch('/groceries/{grocery}', [GroceriesController::class, 'update']);
Route::delete('/groceries/{grocery}', [GroceriesController::class, 'destroy']);

// Diary
Route::get('/diary', [DiaryController::class, 'index']);
Route::get('/diary/nutrition', [DiaryController::class, 'daily_breakdown']);

// Nutritional Breakdown
Route::post('/nutrients', [NutrientsController::class, 'store']);
Route::get('/nutrients', [NutrientsController::class, 'get_all_nutrients']);
Route::get('/nutrient/{nutrient}', [NutrientsController::class, 'get_one_nutrient']);
Route::patch('/nutrients/{nutrient}', [NutrientsController::class, 'update_one_nutrient']);
Route::delete('/nutrient/{nutrient}', [NutrientsController::class, 'delete_one_nutrient']);

// Foods
Route::get('/food/details/{food}', [FoodController::class, 'index']);
Route::get('/food/edit/{food}', [FoodController::class, 'food_editview']);
Route::post('/food', [FoodController::class, 'store']);
Route::get('/food/{food}', [FoodController::class, 'get_one_food_item']);
Route::get('/food', [FoodController::class, 'get_all_food']);
Route::patch('/food/{food}', [FoodController::class, 'update_one_food_item']);
Route::delete('food/{food}', [FoodController::class, 'delete_one_food_item']);

// Serving Types
Route::post('/servings', [ServingController::class, 'store']);
Route::get('/serving/{serving}', [ServingController::class, 'get_one_serving_type']);
Route::patch('/servings/{serving}', [ServingController::class, 'update_one_serving_type']);
Route::delete('/servings/{serving}', [ServingController::class, 'delete_one_serving_type']);

// Exercises
Route::get('/exercises/list', [ExerciseController::class, 'index']);
Route::get('/exercises', [ExerciseController::class, 'get_all_exercises']);
Route::get('/exercise/{exercise}', [ExerciseController::class, 'get_one_exercise'])->where('exercise', '[0-9]+');
Route::post('/exercises', [ExerciseController::class, 'store']);
Route::patch('/exercises/{exercise}', [ExerciseController::class, 'update']);
Route::delete('/exercise/{exercise}', [ExerciseController::class, 'destroy']);

// Workouts
Route::post('/workouts', [WorkoutController::class, 'store']);
Route::get('/workout/{workout}', [WorkoutController::class, 'get_one_workout']);
Route::get('/workouts/{user}', [WorkoutController::class, 'index']);
Route::get('/workout/edit/{workout}', [WorkoutController::class, 'workout_editview']);
Route::get('/workouts', [WorkoutController::class, 'get_all_workouts']);
Route::patch('/workouts/{workout}', [WorkoutController::class, 'update_one_workout']);
Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy']);
