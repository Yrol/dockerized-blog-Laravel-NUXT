<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Client\Request;

/*
* Interface for Articles
*/
interface IArticle
{
    public function applyTags($id, array $tags);
    public function addComment($id, $comment);
    public function like($id);
    public function hasAlreadyLikedByUser($id);
    public function search(Request $request);
}
