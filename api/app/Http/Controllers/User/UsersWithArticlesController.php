<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\EagerloadWith;

class UsersWithArticlesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected $users;

    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    public function __invoke()
    {
        return $this->users->withCriteria([
            new EagerloadWith(['articles'])
        ])->paginate(5);
    }
}
