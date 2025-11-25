<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptedRejectedCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_candidate',
        'user_id',
        'field_or_job_role',
        'candidate_name',
        'progress',
        'year',
    ];
}