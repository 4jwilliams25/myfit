<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\Serving;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ServingFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_serving_type()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        Food::factory()->create();

        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/servings', $this->data());
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

    public function test_update_one_serving_type()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        Food::factory()->count(2)->create();
        $this->actingAs($user)->withSession(['banned' => false])->post('/servings', $this->data());
        $servingType = Serving::first();

        $response = $this->actingAs($user)->withSession(['banned' => false])->patch('/servings/' . $servingType->id, [
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
        $this->create_authenticated_user();
        $user = Auth::user();
        Food::factory()->create();
        $this->actingAs($user)->withSession(['banned' => false])->post('/servings', $this->data());
        $servingType = Serving::first();

        $response = $this->actingAs($user)->withSession(['banned'])->delete('/servings/' . $servingType->id);

        $this->assertCount(0, Serving::all());
        $response->assertRedirect('/servings');
    }

    private function create_authenticated_user()
    {
        $user = User::factory()->create();
        Auth::login($user);
    }

    private function data()
    {
        return [
            'unit_of_measure' => 'grams',
            'food_id' => 1
        ];
    }
}
