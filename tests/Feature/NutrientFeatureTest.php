<?php

namespace Tests\Feature;

use App\Models\Nutrient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NutrientFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_nutrient()
    {
        $response = $this->post('/nutrients', $this->data());

        $nutrient = Nutrient::first();

        $this->assertCount(1, Nutrient::all());
        $this->assertEquals(1, $nutrient->serving_id);
        $this->assertEquals('protein', $nutrient->title);
        $this->assertEquals(25, $nutrient->amount);
        $this->assertEquals('gram', $nutrient->unit);
        $response->assertRedirect('/nutrient/' . $nutrient->id);
    }

    public function test_get_all_nutrients()
    {
        Nutrient::factory()->count(5)->create();

        $response = $this->get('/nutrients');

        $this->assertCount(5, Nutrient::all());
        $response->assertJsonCount(5);
    }

    public function test_get_all_nutrients_for_one_serving()
    {
        Nutrient::factory()->createMany([
            ['serving_id' => 1],
            ['serving_id' => 1],
            ['serving_id' => 2]
        ]);

        $response = $this->get('/nutrients/' . 1);

        // $response->assertStatus(200);
        $response->assertJsonCount(2);
        $this->assertCount(3, Nutrient::all());
        $this->assertEquals(1, $response[0]['serving_id']);
        $this->assertEquals(1, $response[1]['serving_id']);
    }

    public function test_get_one_nutrient()
    {
        $nutrient1 = Nutrient::factory()->create();
        $nutrient2 = Nutrient::factory()->create();

        $response = $this->get('/nutrient/' . $nutrient2->id);

        $this->assertCount(2, Nutrient::all());
        $response->assertJsonCount(1);
        $this->assertEquals($response[0]['id'], $nutrient2->id);
        $this->assertEquals($response[0]['title'], $nutrient2->title);
    }

    public function test_update_one_nutrient()
    {
        $response = $this->post('/nutrients', $this->data());
        $nutrient = Nutrient::first();

        $response = $this->patch('/nutrients/' . $nutrient->id, array_merge($this->data(), [
            'title' => 'fat',
            'unit' => 'calorie'
        ]));

        $this->assertCount(1, Nutrient::all());
        $this->assertEquals('fat', Nutrient::first()->title);
        $this->assertEquals('calorie', Nutrient::first()->unit);
        $this->assertEquals(25, Nutrient::first()->amount);
        $response->assertRedirect('/nutrient/' . $nutrient->id);
    }

    public function test_delete_one_nutrient()
    {
        $this->withoutExceptionHandling();

        $nutrient = Nutrient::factory()->create();

        $this->assertCount(1, Nutrient::all());

        $response = $this->delete('/nutrient/' . $nutrient->id);

        $this->assertCount(0, Nutrient::all());
        $response->assertRedirect('/nutrients');
    }

    private function data()
    {
        return [
            'serving_id' => 1,
            'title' => 'protein',
            'amount' => 25,
            'unit' => 'gram'
        ];
    }
}
