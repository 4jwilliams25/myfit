<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grocery;
use Illuminate\Http\Request;

class GroceriesController extends Controller
{
    public function index(User $user)
    {
        $usersGroceries = $user->groceries;

        return view('groceries.index', [
            'groceries' => $usersGroceries
        ]);
    }

    public function add_one_grocery_item()
    {
        Grocery::create($this->validateRequest());

        return redirect('/');
    }

    public function get_one_grocery(Grocery $grocery)
    {
        $groceryItem = Grocery::where('id', $grocery->id)->get();

        return $groceryItem;
    }

    public function get_all_groceries()
    {
        return Grocery::all();
    }

    // public function get_all_groceries_for_one_user($userId)
    // {
    //     $groceries = Grocery::where('user_id', $userId)->get();

    //     return $groceries;
    // }

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
            'done' => '',
            'user_id' => 'required'
        ]);
    }
}
