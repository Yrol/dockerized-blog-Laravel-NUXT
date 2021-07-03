<?php

namespace App\Repositories\Criteria;

/*
* The base interface of criteria for Eloquent queries
*/
interface ICriteria
{
    // accepts a list or an array (using ...)
    public function withCriteria(...$criteria);
}
