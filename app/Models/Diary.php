<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class)->withTimestamps();
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)->withTimestamps();
    }

    public function food()
    {
        return $this->belongsToMany(Food::class)->withTimestamps();
    }
}
