<?php

namespace App\Http\Controllers;

use App\Models\Nutrient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NutrientsController extends Controller
{
    public function index()
    {
        return view('nutrients.index');
    }

    public function store()
    {
        $nutrient = Nutrient::create($this->validateRequest());

        return redirect('/nutrient/' . $nutrient->id);
    }

    public function get_all_nutrients()
    {
        $nutrients = DB::table('nutrients')->get();

        return $nutrients;
    }

    public function get_all_nutrients_for_one_serving($id)
    {
        $nutrients = Nutrient::where('serving_id', $id)->get();

        return $nutrients;
    }

    public function get_one_nutrient(Nutrient $nutrient)
    {
        $nutrient = Nutrient::where('id', $nutrient->id)->get();

        return $nutrient;
    }

    public function update_one_nutrient(Nutrient $nutrient)
    {
        $data = $this->validateRequest();
        $nutrient->update($data);

        return redirect('/nutrient/' . $nutrient->id);
    }

    public function delete_one_nutrient(Nutrient $nutrient)
    {
        $nutrient->delete();

        return redirect('/nutrients');
    }

    private function validateRequest()
    {
        request()->validate([
            'serving_id' => 'required',
            'title' => 'required',
            'amount' => 'required',
            'unit' => 'required'
        ]);

        return request()->all();
    }
}
