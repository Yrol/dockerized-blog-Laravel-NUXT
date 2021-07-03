<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//providing the namespace for the repositories that is going to be used
use App\Repositories\Contracts\IArticle;
use App\Repositories\Contracts\ICategory;
use App\Repositories\Contracts\IUser;
use App\Repositories\Contracts\IComment;
use App\Repositories\Contracts\IKeyValue;
use App\Repositories\Eloquent\ArticleRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\KeyValueRepository;

/*
* Service provider for managing custom repositories.
* Repositories we add to '/app/Repositories/Eloquent' need to be registered in the "boot" method
* This service provider has been registered in "config/app.php" as a provider.
*/
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //binding the interface and the implementation of  Users and Articles
        $this->app->bind(IArticle::class, ArticleRepository::class);
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(ICategory::class, CategoryRepository::class);
        $this->app->bind(IComment::class, CommentRepository::class);
        $this->app->bind(IKeyValue::class, KeyValueRepository::class);
    }
}
