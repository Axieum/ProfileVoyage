<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName . " " . $faker->lastName,
        'birth_year' => $faker->year,
        'country' => $faker->country
    ];
});
