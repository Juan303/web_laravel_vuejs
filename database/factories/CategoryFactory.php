<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['PHP', 'HTML', 'SERVIDORES', 'DISEÑO WEB', 'BASES DE DATOS', 'PROGRAMACION', 'JAVA']),
        'description' => $faker->sentence,
    ];
});
