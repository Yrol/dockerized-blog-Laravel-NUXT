<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

/*
* Class consist of logic for Eager loading
* Eager loading is a way of retrieving data and related data as chunk (on one go) instead of making multiple queries to the DB
* Using "Solid Principles" to do perform only one job
*/
class EagerloadWith implements ICriterion
{
    protected $relationships;

    public function __construct($relationships)
    {
        $this->relationships = $relationships;
    }

    public function apply($model)
    {
        //with is equivalent to SQL "IN" - this will resolve the N+1 problem
        return $model->with($this->relationships);
    }
}
