<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrient extends Model
{
    use HasFactory;

    protected $fillable = ['serving_id', 'title', 'amount', 'unit'];

    public function servingType()
    {
        return $this->belongsTo(Serving::class, 'id');
    }
}
