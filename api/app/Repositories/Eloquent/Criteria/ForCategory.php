<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

/*
* Class consist of logic to get Articles by category
* Using "Solid Principles" to do perform only one job (getting latest data )
*/
class ForCategory implements ICriterion
{
    protected $categoryId;

    public function __construct($categoryId)
    {
        $this->categoryId =  $categoryId;
    }

    public function apply($model)
    {
        //using the Laravel's query builder to apply where
        return $model->where('category_id', $this->categoryId);
    }
}
