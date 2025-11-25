<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateNetworking extends Model
{
    use HasFactory;

    protected $table = 'candidate_networking';

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
