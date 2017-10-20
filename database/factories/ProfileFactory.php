<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName . " " . $faker->lastName,
        'date_of_birth' => $faker->date,
        'location' => $faker->country
    ];
});
