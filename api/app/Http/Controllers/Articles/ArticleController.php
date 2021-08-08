<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Repositories\Contracts\IArticle;
use App\Repositories\Eloquent\Criteria\IsLive;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use App\Rules\ExistingArticleUpdate;
use App\Rules\UniqueCategoryName;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    protected $articles;

    /*
    *  Injecting IArticle interface to the constructor
    */
    public function __construct(IArticle $articles)
    {
        $this->articles = $articles;
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /*
    * Display all articles
    */
    public function index()
    {
        //paginate defined in BaseRepository
        $articles =  $this->articles->withCriteria([
            new LatestFirst(),
            new IsLive(),
        ])->paginate(5);
        return ArticleResource::collection($articles);
    }
    /**
     * Display a specific article by ID.
     * @param  \App\Model\Articles $articles
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //return new ArticleResource($article); // we could also do this since we have route model binding
        //find defined in BaseRepository
        $resource = $this->articles->find($article->id);
        return new ArticleResource($resource);
    }

    public function store(Request $request)
    {
        $category_id = $request->input('category_id');

        $this->validate($request, [
            'title' => ['required', new UniqueCategoryName($category_id), 'string'],
            'description' => ['required', 'string'],
            'category_id' => ['required', Rule::exists('categories', 'id')->where(function ($query) use ($category_id) {
                $query->where('id', $category_id);
            })],
            'body' => ['required', 'string'],
            'is_live' => ['required', 'boolean'],
            'close_to_comments' => ['required', 'boolean'],
            'tags' => ['nullable']
        ]);

        $request->merge(['user_id' => auth()->user()->id]);

        // //$article = auth()->user()->articles()->create($request->all()); //user ID will be added automatically to the 'user_id' foreign field of articles
        //create defined in BaseRepository
        $article = $this->articles->create($request->all());

        $tags = $request->input('tags');

        if ($tags) {
            $this->articles->applyTags($article->id, json_decode($request->input('tags'), true));
        }

        return response(new ArticleResource($article), Response::HTTP_CREATED);
    }

    /*
    * Updating articles
    */
    public function update(Request $request, Article $article)
    {
        //Using the policy defined in app/Policies/ArticlePolicy.php and referencing the 'update' method in it
        $this->authorize('update', $article);

        $category_id = $article->category_id;

        $this->validate($request, [
            'title' => ['required', new ExistingArticleUpdate($category_id, $article->id), 'string'],
            'description' => ['required', 'string'],
            'body' => ['required', 'string'],
            'is_live' => ['required', 'boolean'],
            'close_to_comment' => ['required', 'boolean'],
            'tags' => ['nullable']
        ]);

        //$article->update($request->all());
        //update defined in BaseRepository
        $resource = $this->articles->update($article->id, $request->only('title', 'body', 'description', 'is_live', 'close_to_comment', 'tags'));

        /*
        * retag is a method of Taggable library [/vendor/cviebrock/eloquent-taggable/src/Taggable.php]
        * Taggable has been defined in Article model as a trait (i.e. use Taggable)
        */
        //$article->retag($request->input('tags'));
        //applyTags defined in BaseRepository
        $tags = $request->input('tags');

        if ($tags) {
            $this->articles->applyTags($article->id, json_decode($request->input('tags'), true));
        }

        return response()->json(new ArticleResource($resource), Response::HTTP_ACCEPTED);
    }

    /*
    * Deleting Articles
    */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        //delete defined in BaseRepository
        if ($this->articles->delete($article->id)) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return response()->json(null, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
