<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Repositories\Contracts\IArticle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentArticleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected $articles;

    public function __construct(IArticle $article)
    {
        $this->articles = $article;
    }

    public function __invoke(Article $article, Request $request)
    {
        $this->validate($request, [
            'body' => ['required']
        ]);

        $commentBody = $request->input('body');
        $comment = $this->articles->addComment($article->id, $commentBody);
        return response(new CommentResource($comment), Response::HTTP_CREATED);
    }
}
