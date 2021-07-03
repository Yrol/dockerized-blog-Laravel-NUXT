<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IArticle;
use App\Repositories\Eloquent\Criteria\ForUser;
use App\Repositories\Eloquent\Criteria\IsLive;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use Illuminate\Http\Request;

class ArticlesByUserController extends Controller
{
    /**
     * Controller retrieves article by user ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected $article;

    public function __construct(IArticle $article)
    {
        $this->article = $article;
    }

    public function __invoke(Request $request)
    {
        return $this->article->withCriteria([
            new ForUser($request->id),
            new LatestFirst(),
            new IsLive(),
        ])->paginate(5);
    }
}
