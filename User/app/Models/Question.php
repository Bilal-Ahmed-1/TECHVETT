<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'level_id', 'question_text', 'type', 'media_path'];

    public function options() {
        return $this->hasMany(Option::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
