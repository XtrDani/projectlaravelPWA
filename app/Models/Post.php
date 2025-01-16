<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    ////////////////////////////////


    public function votes()
    {
        return $this->hasMany(Vote::class, 'post_id');
    }

    public function upvotes()
    {
        return $this->votes()->where('is_upvote', true);
    }

    public function downvotes()
    {
        return $this->votes()->where('is_upvote', false);
    }


}
