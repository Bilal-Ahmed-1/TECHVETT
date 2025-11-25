<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopAcceptedCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_or_job_role',
        'candidate_name',
        'total_stages_attempt',
        'aggregate_of_stages',
    ];
}