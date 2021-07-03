<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\User;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $word = $faker->word();//randomly generated word by Laravel
    return [
        'title' => $word,
        'slug' => str_slug($word),
        'user_id' => function () {
            return User::all()->random();
        }
    ];
});
