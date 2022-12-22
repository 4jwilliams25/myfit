<?php

use App\Models\Food;
use App\Models\Nutrient;
use App\Models\Serving;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServingUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_food_for_one_serving_type()
    {
        Food::factory()->count(2)->create();
        Serving::factory()->create();
        $serving = Serving::first();

        $response = $serving->food->toArray();

        $this->assertCount(2, Food::all());
        $this->assertEquals(5, count($response));
        $this->assertEquals(1, $response['id']);
    }

    public function test_get_all_nutrients_for_one_serving()
    {
        Food::factory()->create();
        Serving::factory()->count(2)->create();
        Nutrient::factory()->createMany([
            ['serving_id' => 1],
            ['serving_id' => 1],
            ['serving_id' => 2],
        ]);
        $serving = Serving::first();

        $response = $serving->nutrients->toArray();

        $this->assertCount(2, Serving::all());
        $this->assertCount(3, Nutrient::all());
        $this->assertEquals(2, count($response));
        $this->assertEquals(1, $response[0]['serving_id']);
        $this->assertEquals(1, $response[1]['serving_id']);
    }
}
