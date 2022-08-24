<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $casts = [
        'ingredients' => 'array'
    ];

    protected $fillable = [
        'name',
        'cook_time',
        'prep_time',
        'servings',
        'difficulty',
        'directions',
        'user_id'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Food::class);
    }
}
