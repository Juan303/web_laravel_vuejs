<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'user_id' => null,
    ];
});
