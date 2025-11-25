<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = ['field', 'final_score', 'rating'];

    public function answers()
    {
        return $this->hasMany(InterviewAnswers::class);
    }
}
