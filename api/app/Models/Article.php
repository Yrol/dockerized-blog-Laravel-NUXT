<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\Likable;
use App\User;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * Taggable - Custom lib for tags
     * Likable - For likes
     * Commentable - For comments
     * Publishable - For publish and unpublish
    */

    use Taggable, Likable, Commentable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'body',
        'slug',
        'category_id',
        'tags',
        'close_to_comment',
        'is_live'
    ];

    protected static function boot()
    {
        parent::boot();

        //Adding the additional functionality (create a slug using the title) whenever this model gets created (during HTTP requests when creating an article & etc)
        static::creating(function ($article) {
            $article->slug = str_slug($article->title);
        });

        //Adding the additional functionality (create a slug using the title) whenever this model gets updated (during HTTP requests when creating an article & etc)
        static::updating(function ($article) {
            $article->slug = str_slug($article->title);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // /*
    // * Polymorphic relationship to add comments
    // * 'commentable' is the polymorphic relationship ID defined in Comment model
    // */
    // public function comments()
    // {
    //     return $this->morphMany(Comment::class, 'commentable')->orderBy('created_at', 'asc');
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the route key for the model.
     * Using the column "slug" value instead of the ID to retrieve a single Article. ex: http://localhost:8080/api/articles/reprehenderit-consequuntur-consequatur-nihil
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
