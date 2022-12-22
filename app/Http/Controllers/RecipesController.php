<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    public function index()
    {
        return view('recipes.index');
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
