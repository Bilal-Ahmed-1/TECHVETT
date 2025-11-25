<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateSqa extends Model
{
    use HasFactory;

    protected $table = 'candidate_sqa';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'location',
        'cnic',
        'age',
        'field',
        'jobrole',
        'experience',
        'qualification',
    ];

}
