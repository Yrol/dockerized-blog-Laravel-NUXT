<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\LatestFirst;

class UserController extends Controller
{
    protected $users;

    /*
    *  Injecting IUser interface to the constructor
    */
    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users =  $this->users->withCriteria([
            new LatestFirst()
        ])->all();
        return UserResource::collection($users);
    }
}
