<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage3Result extends Model
{
    use HasFactory;

    protected $fillable = [
         'user_id',
        'transcript',
        'score',
        'rating',
        // Add this if you're linking the result to a user
    ];

    // Optional: If you're associating results with users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
