<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

/*
* Class consist of logic to get user by user Id
* Using "Solid Principles" to do perform only one job (getting latest data )
*/
class ForUser implements ICriterion
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function apply($model)
    {
        return $model->where('user_id', $this->user_id);
    }
}
