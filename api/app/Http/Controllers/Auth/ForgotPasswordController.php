<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    //override the sendResetLinkEmail with rule hasVerifiedEmail
    /*
    * Overriding the sendResetLinkEmail defined in SendsPasswordResetEmails trait above to make sure only the registered
    */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::where('email', $request->email)->first();

        if (!$user->hasVerifiedEmail()) {
            return response()->json(['errors' => ['message' => 'Email has not been been verified. Please verify your email first.']], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    /*
    * Overriding the sendResetLinkResponse defined in SendsPasswordResetEmails trait above to return our own custom JSON response
    */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json(['status' => trans($response)], Response::HTTP_OK);
    }

    /*
    * Overriding the sendResetLinkResponse defined in SendsPasswordResetEmails trait above to return our own custom JSON response
    */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['email' => trans($response)], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
