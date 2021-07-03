<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Repositories\Contracts\IArticle;
use Illuminate\Http\Response;

class LikeUnlikeArticleController extends Controller
{
    /**
     * Controller for liking and unliking articles
     */
    protected $articles;

    public function __construct(IArticle $article)
    {
        $this->articles = $article;
    }

    public function __invoke(Article $article)
    {
        $this->articles->like($article->id);
        return response()->json(['message' => 'successful'], Response::HTTP_OK);
    }
}
