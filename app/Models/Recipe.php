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

    public function food()
    {
        return $this->belongsToMany(Food::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function diaries()
    {
        return $this->belongsToMany(Diary::class)->withTimestamps();
    }
}
