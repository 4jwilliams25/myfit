<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grocery extends Model
{
    use HasFactory;

    protected $fillable = [
        'item', 'done', 'user_id'
    ];

    public function toggle()
    {
        $this->update([
            'done' => !$this->done
        ]);
    }
}
