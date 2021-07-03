<?php

namespace App\Repositories\Eloquent;

use App\Models\Comment;
use App\Repositories\Contracts\IComment;

class CommentRepository extends BaseRepository implements IComment
{
    //returning the current model
    public function model()
    {
        return Comment::class; //this returns the model namespace - App\Model\Category
    }
}
