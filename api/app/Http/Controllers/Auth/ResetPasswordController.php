<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /*
    * Overriding the sendResetResponse of ResetsPasswords trait above since by default it returns redirect path, instead we return a JSON response
    */
    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json(['status' => trans($response)], Response::HTTP_OK);
    }

    /*
    * Overriding the sendResetFailedResponse of ResetsPasswords trait above since by default it returns redirect path, instead we return a JSON response
    */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json(['email' => trans($response)], Response::HTTP_OK);
    }
}
