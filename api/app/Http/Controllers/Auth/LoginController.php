<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    //vendor/laravel/ui/auth-backend/AuthenticatesUsers.php
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /*
    * Overriding the "attemptLogin" function of AuthenticatesUsers defined/used above
    * attemptLogin will attempt to log user in when credentials are provided
    * attemptLogin will return boolean
    */
    protected function attemptLogin(Request $request)
    {
        //Using the Auth Guard interface available to AuthenticatesUsers. Guard is in "/vendor/laravel/framework/src/Illuminate/Contracts/Auth/Guard.php"
        $token = $this->guard()->attempt($this->credentials($request));

        if(!$token){
            return false;
        }

        //Get the authenticated user
        $user = $this->guard()->user();

        //MustVerifyEmail comes from the User model, it implements MustVerifyEmail, and then check if user has already verified the email
        if($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()){
            return false;
        }

        //set user's token defined using the setToken method coming from "tymon/jwt-auth"
        $this->guard()->setToken($token);

        return true;
    }


    /*
    * Overriding the "sendLoginResponse" function of AuthenticatesUsers defined/used above
    * The reason to override sendLoginResponse is because it creates a session which is only suitable for web but not api
    */
    protected function sendLoginResponse(Request $request)
    {
        //clear login attempt data if any
        $this->clearLoginAttempts($request);

        //once we get the token from authentication guard (JWT)
        $token = (string)$this->guard()->getToken();

        //extract token and change the expiry
        $expiration = $this->guard()->getPayload()->get('exp');

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ]);
    }


    /*
    * Overriding the "sendFailedLoginResponse" method in "vendor/laravel/ui/auth-backend/AuthenticatesUsers.php"
    */
    protected function sendFailedLoginResponse()
    {
        $user = $this->guard()->user();

        if($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()){
            return response()->json(["errors" => ["message" => "Email has not verified. Please verify and try again."]], Response::HTTP_FORBIDDEN);
        }

        //throw Laravel validation exception
        throw ValidationException::withMessages([
            $this->username() => "Authentication failed. Invalid credential detected" // $this->username() is a base method in Laravel, which in this case returns the email
        ]);
    }


    //Logout logic
    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
