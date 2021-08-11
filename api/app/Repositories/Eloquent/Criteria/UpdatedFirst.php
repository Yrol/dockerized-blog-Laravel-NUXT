<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

/*
* Class consist of logic to get latest data
* Using "Solid Principles" to do perform only one job (getting latest data )
*/
class UpdatedFirst implements ICriterion
{
    public function apply($model)
    {
        return $model->orderby('updated_at', 'desc');
    }
}
