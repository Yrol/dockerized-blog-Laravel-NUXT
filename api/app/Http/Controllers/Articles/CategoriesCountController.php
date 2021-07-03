<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ICategory;
use Illuminate\Http\Response;

class CategoriesCountController extends Controller
{
    protected $categories;

    public function __construct(ICategory $categories)
    {
        $this->categories = $categories;
    }

    public function __invoke()
    {
        $count =  $this->categories->withCriteria([])->all()->count();
        return response()->json(['count' => $count], Response::HTTP_OK);
    }
}
