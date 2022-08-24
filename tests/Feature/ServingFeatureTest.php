<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\Serving;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServingFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_serving_type()
    {
        Food::factory()->create();

        $response = $this->post('/servings', $this->data());
        $servingType = Serving::first();

        $this->assertCount(1, Serving::all());
        $this->assertEquals(1, $servingType->food_id);
        $this->assertEquals('grams', $servingType->unit_of_measure);
        $response->assertRedirect('/servings/' . $servingType->id);
    }

    public function test_get_one_serving_type()
    {
        Food::factory()->create();
        Serving::factory()->count(5)->create();

        $testServingType = Serving::first();

        $response = $this->get('/serving/' . $testServingType->id);

        $this->assertCount(5, Serving::all());
        $response->assertJsonCount(1);
        $this->assertEquals($response[0]['unit_of_measure'], $testServingType->unit_of_measure);
        $this->assertEquals($response[0]['food_id'], $testServingType->food_id);
    }

    public function test_get_all_serving_types_for_one_food()
    {
        Food::factory()->count(2)->create();
        Serving::factory()->createMany([
            ['food_id' => 1],
            ['food_id' => 1],
            ['food_id' => 2]
        ]);

        $response = $this->get('/servings/' . 1);

        $this->assertCount(3, Serving::all());
        $response->assertJsonCount(2);
        $this->assertEquals(1, $response[0]['food_id']);
        $this->assertEquals(1, $response[1]['food_id']);
    }

    public function test_update_one_serving_type()
    {
        Food::factory()->count(2)->create();
        $this->post('/servings', $this->data());
        $servingType = Serving::first();

        $response = $this->patch('/servings/' . $servingType->id, [
            'unit_of_measure' => 'oz',
            'food_id' => 2
        ]);

        $this->assertCount(1, Serving::all());
        $this->assertEquals('oz', Serving::first()->unit_of_measure);
        $this->assertEquals(2, Serving::first()->food_id);
        $response->assertRedirect('/serving/' . $servingType->id);
    }

    public function test_delete_one_serving_type()
    {
        Food::factory()->create();
        $this->post('/servings', $this->data());
        $servingType = Serving::first();

        $response = $this->delete('/servings/' . $servingType->id);

        $this->assertCount(0, Serving::all());
        $response->assertRedirect('/servings');
    }

    private function data()
    {
        return [
            'unit_of_measure' => 'grams',
            'food_id' => 1
        ];
    }
}
