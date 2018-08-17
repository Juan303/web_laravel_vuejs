<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Teacher::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'biography' => $faker->paragraph,
        'website_url' => $faker->url,
        'user_id' => User::all()->random()->id,
    ];
});
