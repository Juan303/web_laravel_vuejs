<?php

use Faker\Generator as Faker;
use App\User;
use App\Course;

$factory->define(App\Review::class, function (Faker $faker) {
    return [
        'comment' => $faker->sentence,
        'rating' => $faker->randomFloat(2, 0, 5),
        'user_id' => User::all()->random()->id,
        'course_id' => Course::all()->random()->id,
    ];
});
