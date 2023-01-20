<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FoodFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_food()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/food', $this->data());
        $food = Food::first();

        $this->assertCount(1, Food::all());
        $this->assertEquals(1, $food->servings);
        $this->assertEquals('Chicken Thighs', $food->name);
        $response->assertRedirect('/food/' . $food->id);
    }

    public function test_get_one_food_item()
    {
        $foodItem = Food::factory()->create();
        Food::factory()->create();

        $response = $this->get('/food/' . $foodItem->id);

        $this->assertCount(2, Food::all());
        $response->assertJsonCount(1);
        $this->assertEquals($response[0]['name'], $foodItem->name);
        $this->assertEquals($response[0]['servings'], $foodItem->servings);
    }

    public function test_get_all_food_items()
    {
        Food::factory()->count(5)->create();

        $response = $this->get('/food');

        $this->assertCount(5, Food::all());
        $response->assertJsonCount(5);
    }

    public function test_edit_one_food_item()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $this->actingAs($user)->withSession(['banned' => false])->post('/food', $this->data());
        $foodItem = Food::first();

        $response = $this->actingAs($user)->withSession(['banned' => false])->patch('/food/' . $foodItem->id, array_merge($this->data(), [
            'name' => 'Chicken Breast',
            'servings' => 1.5
        ]));

        $this->assertCount(1, Food::all());
        $this->assertEquals('Chicken Breast', Food::first()->name);
        $this->assertEquals(1.5, Food::first()->servings);
        $response->assertRedirect('/food/' . $foodItem->id);
    }

    public function test_delete_one_food_item()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $foodItem = Food::factory()->create();
        $this->assertCount(1, Food::all());

        $response = $this->actingAs($user)->withSession(['banned' => false])->delete('/food/' . $foodItem->id);

        $this->assertCount(0, Food::all());
        $response->assertRedirect('/food');
    }

    private function create_authenticated_user()
    {
        $user = User::factory()->create();
        Auth::login($user);
    }

    private function data()
    {
        return [
            'name' => 'Chicken Thighs',
            'servings' => 1
        ];
    }
}
