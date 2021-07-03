<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id'];

    /*
    * Comment and user relationship
    * A comment belong to a user
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    * Polymorphic relationship for comments - the Comment models can be used in many other places (i.e. to be used as commenting on various things)
    * Using morphTo to create the relationship
    * Relationship should be as: morphMany <> morphTo
    */
    public function commentable()
    {
        $this->morphTo();
    }
}
