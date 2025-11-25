<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['interview_id', 'question', 'answer'];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }
}
