<?php

use Faker\Generator as Faker;

$factory->define(App\CarUser::class, function (Faker $faker) {
    return [
        'car_id' => function () {
            return factory(\App\Car::class)->create()->id;
        },
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'registration_number' => $faker->creditCardNumber,
        'img_path' => null
    ];
});
