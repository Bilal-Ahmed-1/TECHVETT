<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage2Answer extends Model
{
    protected $table = 'stage2_responses';

    protected $fillable = [
        'user_id',
        'stage2_question_id',
        'selected_option',
        'reason',
    ];

    /**
     * Get the question associated with the answer.
     */
    public function question()
    {
        return $this->belongsTo(Stage2Question::class, 'stage2_question_id');
    }
}