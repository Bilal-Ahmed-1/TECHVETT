<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage2Question extends Model
{
    use HasFactory;

    protected $fillable = [  
        'image_path',  
        'question_text',  
        'option_1',  
        'option_2',  
        'option_3',  
        'option_4',  
        'option_5',  
        'correct_option',
        'category_id',  
        'level_id',  
    ];  

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
