<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

class EagerLoadWithCount implements ICriterion
{
    protected $relationship;

    public function __construct($relationship)
    {
        $this->relationship = $relationship;
    }

    public function apply($model)
    {
        return $model->withCount($this->relationship);
    }
}
