<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'repetitions', 'sets', 'weight', 'notes', 'user_id'];

    protected $table = 'exercises';

    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function diaries()
    {
        return $this->belongsToMany(Diary::class)->withTimestamps();
    }

    public function workouts()
    {
        return $this->belongsToMany(Workout::class)->withTimestamps();
    }
}
