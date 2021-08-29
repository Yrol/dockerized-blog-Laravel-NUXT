<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//public routes

/** ******* Articles ********* */

/**
 * Fetching all the published articles
 * */
Route::get('articles', 'Articles\ArticleController@index');

/**
 * Fetching both published and unpublished articles
 * */
Route::get('articles/all', 'Articles\AllArticleController');

/**
 * Fetching both published and unpublished articles
 * */
Route::get('articles/seo', 'Articles\SeoArticlesController');

/**
 * Fetching a single article
 * Using route model binding - {article} variable matches what's in Route method
 * */
Route::get('articles/{article}', 'Articles\ArticleController@show');

/**
 * Fetching articles all by category
 * */
Route::get('articles/category/{category}', 'Articles\ArticlesByCategoryController');

/**
 * Fetching articles count
 * */
Route::get('count/articles', 'Articles\ArticlesCountController');

/**
 * Fetching categories count
 * */
Route::get('count/categories', 'Articles\CategoriesCountController');

/**
 * Fetching articles by user
 * */
Route::get('articles/user/{id}', 'Articles\ArticlesByUserController');

/** ******* Categories ********* */

/**
 * Fetching all categories
 * */
Route::get('categories', 'Articles\CategoryController@index');

/**
 * Fetching all active categories (ones consist of articles).
 * */
Route::get('categories/active', 'Articles\CategoriesWithArticlesController');

/**
 * Fetch a category
 */
Route::get('categories/{category}', 'Articles\CategoryController@show');

/** ******* Search ********* */

/**
 * Search articles
 */
Route::get('search/articles', 'Articles\SearchArticlesController');

//Route group for authenticated user only
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    //User profile
    Route::put('settings/profile', 'User\UserSettingController@updateProfile');
    Route::put('settings/password', 'User\UserSettingController@updatePassword');

    //Key value
    Route::get('settings/keyvalue', 'Settings\KeyValueSettingsController@index');
    Route::post('settings/keyvalue', 'Settings\KeyValueSettingsController@store');
    Route::delete('settings/keyvalue/{keyvalue}', 'Settings\KeyValueSettingsController@destroy');
    Route::put('settings/keyvalue/{keyvalue}', 'Settings\KeyValueSettingsController@update');

    /*
    * Using route model binding - {article} variable matches what's in Route method- uses slugs to match resources
    * https://youtu.be/XyyGG5qIWoQ
    */
    Route::put('articles/{article}', 'Articles\ArticleController@update');
    Route::post('articles/', 'Articles\ArticleController@store');
    Route::delete('articles/{article}', 'Articles\ArticleController@destroy');


    /**
     * Uploading images to Imgur
     * */
    Route::post('articles/imageupload', 'Articles\ImageUploadController');

    /** ******* Commenting on Articles ********* */
    /*
    * delete and update are using 'comments' route directly (instead of ex: 'articles') since these operation are common regardless of the model
    */
    Route::post('articles/{article}/comments', 'Articles\CommentArticleController');
    Route::delete('comments/{comment}', 'Articles\CommentsController@destroy');
    Route::put('comments/{comment}', 'Articles\CommentsController@update');

    /** ******* Liking and Un-liking articles ********* */
    /*
    * Likes and unlikes
    * Using one route for both like and unlike (if user has already liked will execute the like otherwise execute the like)
    */
    Route::post('articles/{article}/like', 'Articles\LikeUnlikeArticleController');

    /**
     * Check if user has already liked the article
     */
    Route::get('articles/{article}/liked', 'Articles\HasUserLikedArticleController');

    /** ******* Getting the refresh token ********* */
    Route::post('refresh', 'Auth\RefreshTokenController');

    /** ******* publish and unpublish an article ********* */
    Route::post('articles/{article}/publish', 'Articles\PublishUnpublishController');

    /** ******* Categories ********* */
    Route::post('categories/', 'Articles\CategoryController@store');
    Route::put('categories/{category}', 'Articles\CategoryController@update');
    Route::delete('categories/{category}', 'Articles\CategoryController@destroy');


    /** ******* Users ********* */

    /**
     * Get currently logged in user
     * */
    Route::get('me', 'User\MeController@getMe');

    /**
     * Fetching all users
     * */
    Route::get('users', 'User\UserController@index');

    /**
     * Fetching active users (users with articles)
     * */
    Route::get('users/active', 'User\UsersWithArticlesController');
});

//Route group for guest user only
Route::group(['middleware' => ['guest:api']], function () {

    //login and user verification
    Route::post('register', 'Auth\RegisterController@register'); // referring to the register method of the  register controller
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify'); //Route for sending verification emails
    Route::post('verification/resend', 'Auth\VerificationController@resend');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');//Endpoint:"api/password/email". Using the "sendResetLinkEmail" method in ForgotPasswordController (pre-built controller in Laravel auth)
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');//Endpoint:"api/password/reset"
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
