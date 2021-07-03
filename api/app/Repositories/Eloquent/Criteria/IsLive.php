<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

/*
* Class consist of logic to get articles that are only published
* Using "Solid Principles" to do perform only one job
*/
class IsLive implements ICriterion
{
    public function apply($model)
    {
        return $model->where('is_live', true);
    }
}
