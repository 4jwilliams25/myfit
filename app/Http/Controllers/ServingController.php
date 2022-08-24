<?php

namespace App\Http\Controllers;

use App\Models\Serving;
use Illuminate\Http\Request;

class ServingController extends Controller
{
    public function store()
    {
        $servingType = Serving::create($this->validateRequest());

        return redirect('/servings/' . $servingType->id);
    }

    public function get_one_serving_type(Serving $serving)
    {
        $servingType = Serving::where('id', $serving->id)->get();

        return $servingType;
    }

    public function get_all_serving_types_for_one_food($foodId)
    {
        $servings = Serving::where('food_id', $foodId)->get();

        return $servings;
    }

    public function update_one_serving_type(Serving $serving)
    {
        $data = $this->validateRequest();
        $serving->update($data);

        return redirect('/serving/' . $serving->id);
    }

    public function delete_one_serving_type(Serving $serving)
    {
        $serving->delete();

        return redirect('/servings');
    }

    private function validateRequest()
    {
        return request()->validate([
            'unit_of_measure' => 'required',
            'food_id' => 'required'
        ]);
    }
}
