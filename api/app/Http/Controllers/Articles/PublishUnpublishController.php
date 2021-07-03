<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublishResource;
use App\Models\Article;
use App\Repositories\Contracts\IArticle;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PublishUnpublishController extends Controller
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

    public function __invoke(Request $request, Article $article)
    {
        $this->validate($request, [
            'is_live' => ['required', 'boolean'],
        ]);
        $resource = $this->articles->update($article->id, $request->only(['is_live']));
        return response()->json(new PublishResource($resource), Response::HTTP_ACCEPTED);
    }
}
