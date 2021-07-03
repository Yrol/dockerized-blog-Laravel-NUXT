<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\Contracts\ICategory;
use App\Repositories\Eloquent\Criteria\EagerLoadWithCount;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(ICategory $category)
    {
        $this->category = $category;
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /*
    * Fetch all categories
    */
    public function index()
    {
        //$categories = $this->category->all(); // without any criteria

        /*
        * Fetching all categories with the article count
        */
        $categories = $this->category->withCriteria([
            new LatestFirst(),
            new EagerLoadWithCount('articles')
        ])->all();

        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        $resource = $this->category->find($category->id);
        return new CategoryResource($resource);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        $request->merge(['slug' => str_slug($request->title)]);

        $this->validate($request, [
            'title' => ['required', 'regex:/^[\pL\s\-]+$/u', 'string', 'min:3', 'max:50', 'unique:categories,title'],
            'slug' => ['required_with:title', 'string', 'unique:categories,slug']
        ]);

        $resource = $this->category->create($request->only('title', 'user_id'));
        return response(new CategoryResource($resource), Response::HTTP_CREATED);
    }

    public function update(Request $request, Category $category)
    {
        $request->merge(['slug' => str_slug($request->title)]);

        $this->validate($request, [
            'title' => ['required', 'regex:/^[\pL\s\-]+$/u', 'string', 'min:3', 'max:50', "unique:categories,title,{$category->id}"], //unique category ID except the current one
            'slug' => ['required_with:title', 'string', "unique:categories,slug, {$category->slug}"] //unique category slug except the current one
        ]);

        $resource = $this->category->update($category->id, $request->only('title'));

        return response()->json(new CategoryResource($resource), Response::HTTP_ACCEPTED);
    }
}
