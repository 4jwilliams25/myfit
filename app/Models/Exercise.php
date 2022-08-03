<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'repetitions', 'sets', 'weight', 'notes', 'user_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
