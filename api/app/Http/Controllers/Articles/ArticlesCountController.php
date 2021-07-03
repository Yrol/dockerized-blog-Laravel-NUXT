<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IArticle;
use Illuminate\Http\Response;

class ArticlesCountController extends Controller
{
    protected $articles;

    public function __construct(IArticle $articles)
    {
        $this->articles = $articles;
    }

    public function __invoke()
    {
        $count =  $this->articles->withCriteria([])->all()->count();
        return response()->json(['count' => $count], Response::HTTP_OK);
    }
}
