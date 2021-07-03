<?php

namespace App;

use App\Model\Comment;
use App\Models\Article;
use App\Models\Category;
use App\Notifications\CustomEmailVerification;
use App\Notifications\ResetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;//using Spatialtrait for location

/*
* JWTSubject - Tymon JWT implementation (3rd party)
* MustVerifyEmail - Laravel's email confirmation strategy when registering a user (built-in). Using the "email_verified_at" defined below in the class and has a column in the Users table associated with it
*/
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable, SpatialTrait;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'tagline', 'about', 'username',  'location', 'available_to_hire'
    ];

    // Spatialtrait for location
    protected $spatialFields = [
        'location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    * Overriding the "sendEmailVerificationNotification" inherited from MustVerifyEmail to our own needs to send email when registering
    * We are using our own Notification class - "CustomEmailVerification" created using artisan [php artisan make:CustomEmailVerification] which extends Laravel's Notification base class
    */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomEmailVerification);
    }


    /*
    * Overriding the "sendPasswordResetNotification" in "vendor/laravel/framework/src/Illuminate/Contracts/Auth/CanResetPassword.php"
    * We are using our own Notification class - "ResetPassword" created using artisan [php artisan make:ResetPassword] which extends Laravel's Notification base class
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /*
    * User and articles relationship
    * A user can have many articles
    */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /*
    * Users and Categories  relationship
    * A user can have many categories
    */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /*
    * Users and comments  relationship
    * A user can have add many comments
    */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
