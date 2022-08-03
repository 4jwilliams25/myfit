<?php

namespace App\Http\Controllers;

use App\Models\Grocery;
use Illuminate\Http\Request;

class GroceriesController extends Controller
{
    public function index()
    {
        $groceryData = Grocery::all();

        return view('groceries.index', [
            'groceries' => $groceryData
        ]);
    }

    public function add_one_grocery_item()
    {
        Grocery::create($this->validateRequest());

        return redirect('/');
    }

    public function update(Grocery $grocery)
    {
        $data = [
            'item' => request()->item,
            'done' => request()->done
        ];

        $grocery->update($data);

        return redirect('/groceries');
    }

    public function destroy(Grocery $grocery)
    {
        $grocery->delete();
    }

    private function validateRequest()
    {
        return request()->validate([
            'item' => 'required',
            'done' => ''
        ]);
    }
}
