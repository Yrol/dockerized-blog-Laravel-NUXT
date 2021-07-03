<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\IArticle;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use App\Http\Resources\ArticleResource;

class AllArticleController extends Controller
{
    protected $articles;

    public function __construct(IArticle $articles)
    {
        $this->articles = $articles;
    }

    public function __invoke()
    {
        $articles =  $this->articles->withCriteria([
                    new LatestFirst(),
                ])->paginate(5);
        return ArticleResource::collection($articles);
    }
}
