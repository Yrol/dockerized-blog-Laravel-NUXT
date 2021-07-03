<?php

namespace App\Providers;

use App\Models\KeyValue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class KeyValueServiceProvider extends ServiceProvider
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
     * @param \App\KeyValues $keyvalue
     * @return void
     */
    public function boot(KeyValue $keyValues)
    {
        if (Schema::hasTable('keyvalues')) {
            config()->set('keyvalues', $keyValues::pluck('value', 'key')->all());
        }
    }
}
