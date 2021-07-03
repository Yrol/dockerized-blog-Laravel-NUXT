<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IUser;
use App\User;

class UserRepository extends BaseRepository implements IUser
{
    //returning the current model
    public function model()
    {
        return User::class; //this returns the model namespace - App\User
    }
}
