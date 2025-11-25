<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage2Response extends Model
{
    use HasFactory;

    protected $fillable = [  
        'stage2_question_id',  
        'user_id',  
        'selected_option',  
        'reason',  
    ];  

    public function question()  
    {  
        return $this->belongsTo(Stage2Question::class, 'stage2_question_id');  
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
