<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        //Adding the additional functionality (create a slug using the title) whenever this model gets created (during HTTP requests when creating a Category & etc)
        static::creating(function ($category) {
            $category->slug = str_slug($category->title);
        });

        //Adding the additional functionality (create a slug using the title) whenever this model gets updated (during HTTP requests when creating a Category & etc)
        static::updating(function ($category) {
            $category->slug = str_slug($category->title);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get the route key for the model.
     * Using the column "slug" value instead of the ID to retrieve a single Category
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
