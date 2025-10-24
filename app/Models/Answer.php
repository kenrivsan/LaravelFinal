<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHeart;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory, HasHeart ;

    protected $fillable = ['content','question_id','user_id'];


    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    

  

   
}
