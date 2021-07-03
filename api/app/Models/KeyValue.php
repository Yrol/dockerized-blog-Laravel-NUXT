<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyValue extends Model
{
    protected $table = 'keyvalues';

    protected $fillable = [
        'key',
        'description',
        'slug',
        'value',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($keyvalue) {
            $keyvalue->slug = str_slug($keyvalue->key);
        });

        static::updating(function ($keyvalue) {
            $keyvalue->slug = str_slug($keyvalue->key);
        });
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
