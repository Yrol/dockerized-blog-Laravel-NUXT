<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

/*
* Class consist of logic to get latest data
* Using "Solid Principles" to do perform only one job (getting latest data )
*/
class LatestFirst implements ICriterion
{
    public function apply($model)
    {
        //return $model->orderby('created_at'); //method 1

        //using the Laravel's query builder to apply "latest" to the scope
        return $model->latest();
    }
}
