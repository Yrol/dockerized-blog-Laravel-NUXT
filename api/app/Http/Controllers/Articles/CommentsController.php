<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Repositories\Contracts\IArticle;
use App\Repositories\Contracts\IComment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentsController extends Controller
{
    protected $comments;
    protected $articles;

    public function __construct(IComment $comments, IArticle $articles)
    {
        $this->comments = $comments;
        $this->articles = $articles;
    }

    //adding route model binding - "Article $article"
    // public function store(Request $request, Article $article)
    // {
    //     $this->validate($request, [
    //         'body' => ['required']
    //     ]);

    //     $comment = $this->articles->addComment($article->id, [
    //         'body' => $request->body,
    //         'user_id' => auth()->id()
    //     ]);

    //     return response(new CommentResource($comment), Response::HTTP_CREATED);
    // }

    /*
    * Using the Update policy - only the owner can update
    * Using route model binding for Comments
    */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $resource = $this->comments->update($comment->id, $request->all());
        return response()->json(new CommentResource($resource), Response::HTTP_ACCEPTED);
    }

    /*
    * Using the policy to delete the comment - only the owner can delete the comment
    * Using route model binding for Comments
    */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        if ($this->comments->delete($comment->id)) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return response()->json(null, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
