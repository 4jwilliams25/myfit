<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'servings'];

    protected $casts = [
        'serving_types' => 'array',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)->withTimestamps();
    }

    public function servingTypes()
    {
        return $this->hasMany(Serving::class);
    }

    public function diaries()
    {
        return $this->belongsToMany(Diary::class)->withTimestamps();
    }
}
