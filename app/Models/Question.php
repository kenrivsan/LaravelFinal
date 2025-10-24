<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function answers() { return $this->hasMany(Answer::class); }
    public function comments() { return $this->morphMany(Comment::class, 'commentable'); }
    public function hearts() { return $this->morphMany(Heart::class, 'heartable'); }

    public function isHearted(?User $user = null): bool
    {
        $user = $user ?: auth()->user();
        if (!$user) return false;
        return $this->hearts()->where('user_id', $user->id)->exists();
    }
}
