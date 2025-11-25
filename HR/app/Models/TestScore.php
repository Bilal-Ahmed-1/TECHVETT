<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestScore extends Model
{
    protected $connection = 'candidate_portal_mysql';
    protected $table = 'test_score';
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'name', 'field', 'jobrole', 'experience', 'stage1', 'stage2', 'stage3', 'status', 'result'
    ];
}
