<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class MeController extends Controller
{
    public function getMe()
    {
        if(auth()->check()){
            $user = auth()->user();

            //with Resource - UserResource
            return new UserResource($user);

            //without wrapping in Laravel resource.
            //return response()->json(['user' => auth()->user()], Response::HTTP_ACCEPTED);
        }
        return response()->json(null, Response::HTTP_UNAUTHORIZED);
    }
}
