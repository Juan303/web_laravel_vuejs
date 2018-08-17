<?php

use Faker\Generator as Faker;
use App\Course;

$factory->define(App\Goal::class, function (Faker $faker) {
    return [
        'goal' => $faker->sentence,
        'course_id' => Course::all()->random()->id,
    ];
});
