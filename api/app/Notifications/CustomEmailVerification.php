<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail as Notification;
use Illuminate\Support\Facades\URL;

class CustomEmailVerification extends Notification
{
    protected function verificationUrl($notifiable)
    {
        //client URL defined in '/config/app.php'
        $appUrl = config('app.client_url');

        /*
        * Creating a temporary URL using "verification.verify" route defined in 'api.php' and it'll only be valid for 60 mins from now (Using Carbon for date/time), the we notify the User using the user ID
        * this will generate a URL like: " http://localhost:8080/api/verification/register?timestamp+userID+signature"
        */
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinute(60),
            ['user' => $notifiable->id]
        );

        /*
        * We want to replace the above URL with the client side URL, hence we remove up to  "http://localhost/api/" replace as below - this will become - http://localhost:3000/verification/verify?timestamp+userID+signature
        * This temporary signed URL will be senti via email to the user
        */
        return str_replace(url('/api'), $appUrl, $url);
    }
}
