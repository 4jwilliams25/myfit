<?php

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_recipe()
    {
        User::factory()->create();

        $response = $this->post('/recipes', $this->data());
        $recipe = Recipe::first();

        $this->assertCount(1, Recipe::all());
        $this->assertEquals('Chicken and Egg Sammich', $recipe->name);
        $this->assertEquals('10 minutes', $recipe->cook_time);
        $this->assertEquals('30 minutes', $recipe->prep_time);
        $this->assertEquals(1, $recipe->servings);
        $this->assertEquals('easy', $recipe->difficulty);
        $this->assertEquals('Prep the chick ahead of time. Then fry an egg with an onion, toast the bread, and throw all the ingredients together', $recipe->directions);
        $response->assertRedirect('/recipe/' . $recipe->id);
    }

    public function test_get_one_recipe()
    {
        User::factory()->create();
        $this->post('/recipes', $this->data());
        Recipe::factory()->create();

        $response = $this->get('/recipes/' . 1);

        $this->assertCount(2, Recipe::all());
        $response->assertJsonCount(1);
        $this->assertEquals('Chicken and Egg Sammich', $response[0]['name']);
        $this->assertEquals('10 minutes', $response[0]['cook_time']);
        $this->assertEquals('30 minutes', $response[0]['prep_time']);
        $this->assertEquals(1, $response[0]['servings']);
        $this->assertEquals('easy', $response[0]['difficulty']);
        $this->assertEquals('Prep the chick ahead of time. Then fry an egg with an onion, toast the bread, and throw all the ingredients together', $response[0]['directions']);
    }

    public function test_edit_one_recipe()
    {
        User::factory()->create();
        $this->post('/recipes', $this->data());
        $recipe = Recipe::first();

        $response = $this->patch('/recipe/' . $recipe->id, array_merge($this->data(), [
            'name' => 'Turkey Burger and Egg Sammich',
            'servings' => 1.5
        ]));

        $this->assertCount(1, Recipe::all());
        $this->assertEquals('Turkey Burger and Egg Sammich', Recipe::first()->name);
        $this->assertEquals(1.5, Recipe::first()->servings);
        $this->assertEquals('10 minutes', Recipe::first()->cook_time);
        $response->assertRedirect('/recipe/' . $recipe->id);
    }

    public function test_delete_one_recipe()
    {
        User::factory()->create();
        $recipe = Recipe::factory()->create();

        $this->assertCount(1, Recipe::all());

        $response = $this->delete('/recipe/' . $recipe->id);

        $this->assertCount(0, Recipe::all());
        $response->assertRedirect('/recipes');
    }

    private function data()
    {
        return [
            'name' => 'Chicken and Egg Sammich',
            'cook_time' => '10 minutes',
            'prep_time' => '30 minutes',
            'servings' => 1,
            'difficulty' => 'easy',
            'directions' => 'Prep the chick ahead of time. Then fry an egg with an onion, toast the bread, and throw all the ingredients together',
        ];
    }
}
