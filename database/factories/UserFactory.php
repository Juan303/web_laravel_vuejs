<?php

use Faker\Generator as Faker;
use App\Role;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $name = $faker->name;
    $lastName = $faker->lastName;
    return [
        'name' => $name,
        'last_name' => $lastName,
        'slug' => str_slug($name.' '.$lastName, '-'),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'image' => \Faker\Provider\Image::image(storage_path().'\app\public\users', 200, 200, 'people', false ),

        //campos cashier
        /*'stripe_id' => ,
        'card_brand' => ,
        'card_last_four' => ,
        'trial_ends_at' => ,*/

        'role_id' => Role::all()->random()->id,

    ];
});
