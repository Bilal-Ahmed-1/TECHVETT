<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateSqa extends Model
{
    use HasFactory;

    protected $connection = 'candidate_portal_mysql';
    protected $table = 'candidate_sqa';

    protected $fillable = [
        'user_id',
        'email',
        'name',
        'field',
        'jobrole',
        'qualification',
        'age',
        'location',
        'cnic',
    ];
}
