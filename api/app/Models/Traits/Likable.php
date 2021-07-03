<?php

namespace App\Models\Traits;

use App\Models\Like;

/**
 * Trait for Likes and Unlikes which can be used across multiple models
 */
trait Likable
{
    /**
     * Defining the boot method bootLikable (we cannot just use method name "boot" since this is trait)
     * Boot method in Traits has to be boot<Trait name>. in this case bootLikable
     */
    public static function bootLikable()
    {
        //using the default delete observer for traits - deleting. We could also create custom methods and bind them to the trait
        static::deleting(function ($model) { //passing the current model
            $model->removeLikes();
        });
    }

    //delete likes when model is being deleted
    public function removeLikes()
    {
        if ($this->likes()->count()) {
            $this->likes()->delete();
        }
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Handle like
     */
    public function like()
    {
        //check if user is authenticated
        if (!auth()->check()) {
            return;
        }

        //check if user has already liked the article
        if ($this->isLikedByUser(auth()->id())) {
            return;
        }

        //create Defined in BaseRepository
        $this->likes()->create(['user_id' => auth()->id()]);
    }

    /**
     * Handle unlike
     */
    public function unlike()
    {
        //check if user is authenticated
        if (!auth()->check()) {
            return;
        }


        //check if user has already liked the article
        if (!$this->isLikedByUser(auth()->id())) {
            return;
        }

        //delete() Defined in BaseRepository
        $this->likes()->where('user_id', auth()->id())->delete();
    }

    /**
     * Check if already liked by the user
     */
    public function isLikedByUser($userId)
    {
        return (bool)$this->likes()->where('user_id', $userId)->count();
    }
}
