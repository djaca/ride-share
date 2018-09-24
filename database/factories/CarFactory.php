<?php

use Faker\Generator as Faker;

$factory->define(App\Car::class, function (Faker $faker) {
    return [
        'make' => $faker->word,
        'model' => $faker->word,
        'year' => $faker->year
    ];
});
