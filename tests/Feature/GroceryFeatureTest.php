<?php

namespace Tests\Feature;

use App\Http\Controllers\GroceriesController;
use App\Models\Grocery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GroceryFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_one_grocery()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $this->withoutExceptionHandling();

        $this->actingAs($user)->withSession(['banned' => false])->post('/groceries', $this->data($user->id));

        $this->assertCount(1, Grocery::all());
        $this->assertEquals('milk', Grocery::first()->item);
        $this->assertEquals(1, Grocery::first()->id);
    }

    public function test_get_all_groceries()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $this->actingAs($user)->withSession(['banned' => false])->post('/groceries', $this->data($user->id));
        $this->actingAs($user)->withSession(['banned' => false])->post('/groceries', [
            'item' => 'honey',
            'done' => 0,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/groceries/all');

        $response->assertStatus(200);
        $this->assertEquals('milk', $response[0]['item']);
        $this->assertEquals('honey', $response[1]['item']);
        $this->assertCount(2, Grocery::all());
    }

    public function test_get_one_grocery()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        Grocery::factory()->count(2)->create();
        $grocery1 = Grocery::first();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/grocery/' . $grocery1->id);

        $this->assertCount(2, Grocery::all());
        $response->assertJsonCount(1);
        $this->assertEquals($grocery1->item, $response[0]['item']);
        $this->assertEquals($grocery1->done, $response[0]['done']);
    }

    public function test_update_one_grocery()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $this->actingAs($user)->withSession(['banned' => false])->post('/groceries', $this->data($user->id));
        $grocery = Grocery::first();

        $response = $this->actingAs($user)->withSession(['banned' => false])->patch('/groceries/' . $grocery->id, [
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
        $this->create_authenticated_user();
        $user = Auth::user();
        $this->actingAs($user)->withSession(['banned' => false])->post('/groceries', $this->data($user->id));
        $grocery = Grocery::first();

        $this->actingAs($user)->withSession(['banned' => false])->delete('/groceries/' . $grocery->id);

        $this->assertCount(0, Grocery::all());
    }

    public function test_grocery_item_is_required()
    {
        $this->create_authenticated_user();
        $user = Auth::user();

        $grocery = array_merge($this->data($user->id), [
            'item' => ''
        ]);

        $response = $this->actingAs($user)->withSession(['banned' => false])->post('/groceries', $grocery);

        $this->assertCount(0, Grocery::all());
        $response->assertSessionHasErrors('item');
    }

    private function create_authenticated_user()
    {
        $user = User::factory()->create();
        Auth::login($user);
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
