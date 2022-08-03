<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->json('serving_types');
            $table->decimal('protein');
            $table->decimal('total_fat');
            $table->decimal('saturated');
            $table->decimal('trans');
            $table->decimal('polyunsaturated');
            $table->decimal('monounsaturated');
            $table->decimal('cholesterol');
            $table->decimal('sodium');
            $table->decimal('fiber');
            $table->decimal('sugars');
            $table->decimal('added_sugars');
            $table->decimal('vitamin_d');
            $table->decimal('calcium');
            $table->decimal('iron');
            $table->decimal('potassium');
            $table->decimal('vitamin_a');
            $table->decimal('vitamin_c');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
}
