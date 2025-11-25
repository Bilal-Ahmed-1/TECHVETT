<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestScore extends Model
{
    use HasFactory;

    protected $table = 'test_score';

    protected $fillable = [
    'user_id', 'name', 'field', 'jobrole', 'experience',
    'stage1', 'stage2', 'stage3',
    ];
}
