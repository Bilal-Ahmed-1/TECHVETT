<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpcomingActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_candidate',
        'user_id',
        'field_or_job_role',
        'meeting_with_candidate_name',
        'time',
        'meeting_type',
        'condition_of_meeting',
    ];
}