<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage2Result extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total', 'correct', 'wrong', 'answers'];

    protected $casts = [
        'answers' => 'array', // Cast JSON to array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}