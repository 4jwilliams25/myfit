<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseDiaryController;
use App\Http\Controllers\FoodDiaryController;
use App\Http\Controllers\GroceriesController;
use App\Http\Controllers\NutrientsController;
use App\Http\Controllers\RecipeBrowserController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\ServingController;
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
Route::post('/recipes', [RecipesController::class, 'store']);
Route::get('/recipes', [RecipesController::class, 'index']);
Route::get('/recipes/{recipe}', [RecipesController::class, 'get_one_recipe']);
Route::get('/user/recipes/{userId}', [RecipesController::class, 'get_all_recipes_for_one_user']);
Route::patch('/recipe/{recipe}', [RecipesController::class, 'update_one_recipe']);
Route::delete('/recipe/{recipe}', [RecipesController::class, 'delete_one_recipe']);

// Browse for Recipes
Route::get('/recipes/browse', [RecipeBrowserController::class, 'index']);

// Groceries
Route::get('/groceries', [GroceriesController::class, 'index']);
Route::get('/grocery/{grocery}', [GroceriesController::class, 'get_one_grocery']);
Route::get('/groceries/{userId}', [GroceriesController::class, 'get_all_groceries_for_one_user']);
Route::post('/groceries', [GroceriesController::class, 'add_one_grocery_item']);
Route::patch('/groceries/{grocery}', [GroceriesController::class, 'update']);
Route::delete('/groceries/{grocery}', [GroceriesController::class, 'destroy']);

// Food Diary
Route::get('/eats', [FoodDiaryController::class, 'index']);

// Nutritional Breakdown
Route::post('/nutrients', [NutrientsController::class, 'store']);
Route::get('/eats/nutrition', [NutrientsController::class, 'index']);
Route::get('/nutrients', [NutrientsController::class, 'get_all_nutrients']);
Route::get('/nutrients/{serving}', [NutrientsController::class, 'get_all_nutrients_for_one_serving']);
Route::get('/nutrient/{nutrient}', [NutrientsController::class, 'get_one_nutrient']);
Route::patch('/nutrients/{nutrient}', [NutrientsController::class, 'update_one_nutrient']);
Route::delete('/nutrient/{nutrient}', [NutrientsController::class, 'delete_one_nutrient']);

// Foods
Route::post('/food', [FoodController::class, 'store']);
Route::get('/food/{food}', [FoodController::class, 'get_one_food_item']);
Route::get('/food', [FoodController::class, 'get_all_food']);
Route::patch('/food/{food}', [FoodController::class, 'update_one_food_item']);
Route::delete('food/{food}', [FoodController::class, 'delete_one_food_item']);

// Serving Types
Route::post('/servings', [ServingController::class, 'store']);
Route::get('/serving/{serving}', [ServingController::class, 'get_one_serving_type']);
Route::get('/servings/{id}', [ServingController::class, 'get_all_serving_types_for_one_food']);
Route::patch('/servings/{serving}', [ServingController::class, 'update_one_serving_type']);
Route::delete('/servings/{serving}', [ServingController::class, 'delete_one_serving_type']);

// Exercises
Route::get('/exercises', [ExerciseController::class, 'get_all_exercises']);
Route::get('/exercise/{id}', [ExerciseController::class, 'get_one_exercise'])->where('id', '[0-9]+');
Route::get('/exercises/{userID}', [ExerciseController::class, 'get_all_users_exercises']);
Route::post('/exercises/{exercise}', [ExerciseController::class, 'store']);
Route::patch('/exercises/{exercise}', [ExerciseController::class, 'update']);
Route::delete('/exercise/{exercise}', [ExerciseController::class, 'destroy']);

// Workouts
// Route::get('/workouts', [ExerciseDiaryController::class, 'index']);
