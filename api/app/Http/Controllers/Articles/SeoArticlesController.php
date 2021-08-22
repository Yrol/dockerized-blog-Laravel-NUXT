<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IArticle;
use App\Repositories\Eloquent\Criteria\UpdatedFirst;
use App\Http\Resources\SeoArticleResource;
use App\Repositories\Eloquent\Criteria\IsLive;

class SeoArticlesController extends Controller
{
    protected $articles;

    public function __construct(IArticle $articles)
    {
        $this->articles = $articles;
    }

    public function __invoke()
    {
        $articles =  $this->articles->withCriteria([
                    new IsLive(),
                    new UpdatedFirst(),
                ])->all();
        return SeoArticleResource::collection($articles);
    }
}
