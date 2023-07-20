<?php

namespace Tests\Feature;

use App\Models\Diary;
use App\Models\Exercise;
use App\Models\Food;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DiaryFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_diary_gets_related_data()
    {
        $this->create_authenticated_user();
        $user = Auth::user();
        $date = date('Ymd');
        $diary = Diary::create([
            'date' => $date,
            'user_id' => $user->id,
        ]);
        $recipes = Recipe::factory()->count(2)->create();
        $foods = Food::factory()->count(6)->create();
        $exercises = Exercise::factory()->count(6)->create();
        $workout = Workout::factory()->create();
        $diary->recipes()->attach($recipes, ['meal' => 'Breakfast']);
        $diary->food()->attach($foods, ['meal' => 'Lunch']);
        $diary->exercises()->attach($exercises);
        $diary->workouts()->attach($workout);

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/diary');

        $response->assertStatus(200);
        $response->assertViewIs('diary.index');
        $response->assertViewHas('diary');
        $response->assertViewHas('food');
        $response->assertViewHas('recipes');
        $response->assertViewHas('exercises');
        $response->assertViewHas('workouts');
        $this->assertEquals($diary->id, $response['diary']->id);
        $this->assertCount(6, $response['food']);
        $this->assertCount(2, $response['recipes']);
        $this->assertCount(6, $response['exercises']);
        $this->assertCount(1, $response['workouts']);
    }

    public function test_blank_diary_gets_related_data()
    {
        $this->withoutExceptionHandling();

        $this->create_authenticated_user();
        $user = Auth::user();

        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/diary');

        $response->assertStatus(200);
        $response->assertViewIs('diary.index');
        $response->assertViewHas('diary');
        $response->assertViewHas('food');
        $response->assertViewHas('recipes');
        $response->assertViewHas('exercises');
        $response->assertViewHas('workouts');
        $this->assertCount(9, $response['diary']->toArray());
    }

    private function create_authenticated_user()
    {
        $user = User::factory()->create();
        Auth::login($user);
    }
}
