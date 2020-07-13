<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserFavoritePhoto;
use Faker\Generator as Faker;

$factory->define(UserFavoritePhoto::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'photo_id' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
