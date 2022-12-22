<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serving extends Model
{
    use HasFactory;

    protected $fillable = ['unit_of_measure', 'food_id'];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function nutrients()
    {
        return $this->hasMany(Nutrient::class);
    }
}
