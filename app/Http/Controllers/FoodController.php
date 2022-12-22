<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function index(Food $food)
    {
        $food = $this->get_one_food_item($food);

        return view('food.index', [
            'food' => $food
        ]);
    }

    public function food_editview(Food $food)
    {
        $food = $this->get_one_food_item($food);

        return view('food.food_edit', [
            'food' => $food
        ]);
    }

    public function store()
    {
        $food = Food::create($this->validateRequest());

        return redirect('/food/' . $food->id);
    }

    public function get_one_food_item(Food $food)
    {
        $foodItem = Food::where('id', $food->id)->get();

        return $foodItem;
    }

    public function get_all_food()
    {
        $food = DB::table('food')->get();

        return $food;
    }

    public function update_one_food_item(Food $food)
    {
        $data = $this->validateRequest();
        $food->update($data);

        return redirect('/food/' . $food->id);
    }

    public function delete_one_food_item(Food $food)
    {
        $food->delete();

        return redirect('/food');
    }

    private function validateRequest()
    {
        return request()->validate([
            'name' => 'required',
            'servings' => 'required'
        ]);
    }
}
