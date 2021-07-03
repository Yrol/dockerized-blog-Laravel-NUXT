<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Setting;
use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;
use App\Policies\KeyValuePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',

        //Policy for Article CRUD operations
        Article::class => ArticlePolicy::class,
        Comment::class => CommentPolicy::class,
        Setting::class => KeyValuePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
