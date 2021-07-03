<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Repositories\Contracts\IArticle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HasUserLikedArticleController extends Controller
{
    /**
     * Check if user has already liked the article (return bool)
     */
    protected $articles;

    public function __construct(IArticle $article)
    {
        $this->articles = $article;
    }

    public function __invoke(Article $article)
    {
        $isLiked =  $this->articles->hasAlreadyLikedByUser($article->id);
        return response()->json(['message' => $isLiked], Response::HTTP_OK);
    }
}
