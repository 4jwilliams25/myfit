<?php

namespace Tests\Unit;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoalUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_goals()
    {
        User::factory()->count(2)->create();
        Goal::factory()->createMany([
            ['user_id' => 1],
            ['user_id' => 2]
        ]);
        $user = User::first();
        $firstGoal = Goal::first();

        $this->assertCount(2, Goal::all());
        $this->assertCount(8, $user->goals->toArray());
        $this->assertEquals($firstGoal->total_calories, $user->goals->total_calories);
        $this->assertEquals($firstGoal->protein, $user->goals->protein);
        $this->assertEquals($firstGoal->carbs, $user->goals->carbs);
        $this->assertEquals($firstGoal->fat, $user->goals->fat);
    }
}
