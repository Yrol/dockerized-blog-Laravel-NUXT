<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Repositories\Contracts\IArticle;
use Illuminate\Http\Request;

class SearchArticlesController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected $articles;

    public function __construct(IArticle $article)
    {
        $this->articles = $article;
    }

    public function __invoke(Request $request)
    {
        //search function implemented in ArticleRepository
        $articles = $this->articles->search($request);
        return ArticleResource::collection($articles);
    }
}
