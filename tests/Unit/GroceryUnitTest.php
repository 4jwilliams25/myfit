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
}
