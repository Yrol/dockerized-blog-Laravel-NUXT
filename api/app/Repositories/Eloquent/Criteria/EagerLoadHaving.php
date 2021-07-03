<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;
use Illuminate\Support\Arr;

/*
* Class consist of logic for Eager loading - having
*/
class EagerLoadHaving implements ICriterion
{
    protected $relationships;

    public function __construct(array $relationships)
    {
        $this->relationships = Arr::flatten($relationships);
    }

    public function apply($model)
    {
        return $model->having(...$this->relationships);
    }
}
