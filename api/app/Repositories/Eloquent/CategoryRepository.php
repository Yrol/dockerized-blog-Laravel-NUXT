<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\ICategory;

class CategoryRepository extends BaseRepository implements ICategory
{
    //returning the current model
    public function model()
    {
        return Category::class; //this returns the model namespace - App\Model\Category
    }
}
