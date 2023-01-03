<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    public function index(User $user)
    {
        $user_recipes = $user->recipes;

        return view('recipes.index', [
            'recipes' => $user_recipes
        ]);
    }

    public function store()
    {
        $recipe = Recipe::create($this->validateRequest());

        return redirect('/recipe/' . $recipe->id);
    }

    public function show($id)
    {
        return $id;
    }

    public function recipe_detailview(Recipe $recipe)
    {
        $data = $this->get_one_recipe($recipe);

        return view('recipes.recipe_details', [
            'recipe' => $data
        ]);
    }

    public function recipe_editview(Recipe $recipe)
    {
        $data = $this->get_one_recipe($recipe);

        return view('recipes.recipe_edit', [
            'recipe' => $data
        ]);
    }

    public function get_one_recipe(Recipe $recipe)
    {
        $result = Recipe::where('id', $recipe->id)->get();

        return $result;
    }

    public function update_one_recipe(Recipe $recipe)
    {
        $data = $this->validateRequest();
        $recipe->update($data);

        return redirect('/recipe/' . $recipe->id);
    }

    public function delete_one_recipe(Recipe $recipe)
    {
        $recipe->delete();

        return redirect('/recipes');
    }

    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'cook_time' => '',
            'prep_time' => '',
            'servings' => 'required',
            'difficulty' => 'required',
            'directions' => ''
        ]);
    }
}
