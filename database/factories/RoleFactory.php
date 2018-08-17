<?php

use Faker\Generator as Faker;
use App\Role;

$factory->define(App\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement([Role::ADMIN, Role::STUDENT, Role::STUDENT]),
        'description' => $faker->sentence,
    ];
});
