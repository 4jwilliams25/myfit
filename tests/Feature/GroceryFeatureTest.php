<?php

namespace Tests\Feature;

use App\Http\Controllers\GroceriesController;
use App\Models\Grocery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroceryFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_grocery()
    {
        $user = User::factory()->create();
        $this->withoutExceptionHandling();

        $this->post('/groceries', $this->data($user->id));

        $this->assertCount(1, Grocery::all());
        $this->assertEquals('milk', Grocery::first()->item);
        $this->assertEquals(1, Grocery::first()->id);
    }

    public function test_get_all_groceries()
    {
        $user = User::factory()->create();
        $this->post('/groceries', $this->data($user->id));
        $this->post('/groceries', [
            'item' => 'honey',
            'done' => 0,
            'user_id' => $user->id
        ]);

        $response = $this->get('/groceries')
            ->assertStatus(200);

        $data = $response->getOriginalContent()->getData();
        $groceries = $data['groceries']->all();

        $this->assertEquals('milk', $groceries[0]->item);
        $this->assertEquals('honey', $groceries[1]->item);
        $this->assertCount(2, Grocery::all());
    }

    public function test_update_one_grocery()
    {
        $user = User::factory()->create();
        $this->post('/groceries', $this->data($user->id));
        $grocery = Grocery::first();

        $response = $this->patch('/groceries/' . $grocery->id, [
            'item' => 'new item',
            'done' => 1
        ]);

        $this->assertCount(1, Grocery::all());
        $this->assertEquals('new item', Grocery::first()->item);
        $this->assertEquals(1, Grocery::first()->done);
        $response->assertRedirect('/groceries');
    }

    public function test_delete_one_grocery()
    {
        $user = User::factory()->create();
        $this->post('/groceries', $this->data($user->id));
        $grocery = Grocery::first();

        $this->delete('/groceries/' . $grocery->id);

        $this->assertCount(0, Grocery::all());
    }

    public function test_grocery_item_is_required()
    {
        $user = User::factory()->create();

        $grocery = array_merge($this->data($user->id), [
            'item' => ''
        ]);

        $response = $this->post('/groceries', $grocery);

        $this->assertCount(0, Grocery::all());
        $response->assertSessionHasErrors('item');
    }

    private function data($userId)
    {
        return [
            'item' => 'milk',
            'done' => 0,
            'user_id' => $userId
        ];
    }
}
