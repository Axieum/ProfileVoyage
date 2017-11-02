<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'link' => substr($faker->unique()->slug, 0, 16),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
        'api_token' => bin2hex(openssl_random_pseudo_bytes(30))
    ];
});
