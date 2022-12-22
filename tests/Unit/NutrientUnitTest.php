<?php

use App\Models\Food;
use App\Models\Serving;
use App\Models\Nutrient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NutrientUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_serving_type_for_one_nutrient()
    {
        Food::factory()->create();
        Serving::factory()->count(2)->create();
        Nutrient::factory()->create();
        $nutrient = Nutrient::first();

        $response = $nutrient->servingType->toArray();

        $this->assertCount(2, Serving::all());
        $this->assertEquals(5, count($response));
        $this->assertEquals($nutrient->serving_id, $response['id']);
    }
}
