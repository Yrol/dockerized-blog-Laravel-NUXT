<?php

namespace App\Models\Traits;

use App\Models\Comment;

trait Commentable
{
    public static function bootCommentable()
    {
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->orderBy('created_at', 'asc');
    }

    public function comment($body)
    {
        if (!auth()->check()) {
            return;
        }

        return $this->comments()->create(['user_id' => auth()->id(), 'body' => $body]);
    }

    public function removeComment($commentId)
    {
        return (bool)$this->comments()->where('id', $commentId)->delete();
    }
}
