<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Category;
use App\Repositories\Contracts\IArticle;
use App\Repositories\Eloquent\Criteria\ForCategory;
use App\Repositories\Eloquent\Criteria\IsLive;

class ArticlesByCategoryController extends Controller
{
    /**
     * Controller retrieves articles by category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected $article;

    public function __construct(IArticle $article)
    {
        $this->article = $article;
    }

    public function __invoke(Category $category) //using route model binding for categories
    {
        $resource = $this->article->withCriteria([
            new ForCategory($category->id),
            new IsLive(),
        ])->paginate(5);

        return ArticleResource::collection($resource);
    }
}
