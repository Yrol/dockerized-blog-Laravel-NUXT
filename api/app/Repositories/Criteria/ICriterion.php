<?php

namespace App\Repositories\Criteria;

/*
* The base interface of criterions
*/
interface ICriterion
{
    public function apply($model);
}
