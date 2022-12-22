<?php

namespace Tests\Unit;

use App\Models\Grocery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroceryUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_groceries_can_be_toggled_between_todo_and_done()
    {
        User::factory()->create();
        $grocery = Grocery::factory()->create();

        $this->assertEquals(0, Grocery::first()->done);
        $this->assertCount(1, Grocery::all());

        $grocery->toggle();

        $this->assertEquals(1, Grocery::first()->done);

        $grocery->toggle();

        $this->assertEquals(0, Grocery::first()->done);
    }

    public function test_get_grocery_user()
    {
        User::factory()->count(2)->create();
        Grocery::factory()->create();
        $grocery = Grocery::first();

        $response = $grocery->user->toArray();

        $this->assertCount(2, User::all());
        $this->assertEquals(1, $response['id']);
        $this->assertEquals(6, count($response));
    }
}
