<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTestResult extends Model
{
    use HasFactory;
    protected $fillable = ['test_id', 'correct_answers', 'total_questions'];

    public function test() {
        return $this->belongsTo(Test::class);
    }
}
