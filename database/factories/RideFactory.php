<?php

use Faker\Generator as Faker;

$factory->define(App\Ride::class, function (Faker $faker) {
    return [
        'time' => now()->addDay()->toDateTimeString(),
        'car_user_id' => function () {
            return factory(\App\CarUser::class)->create()->id;
        },
        'source_city_id' => function () {
            return factory(\App\City::class)->create()->id;
        },
        'destination_city_id' => function () {
            return factory(\App\City::class)->create()->id;
        },
        'seats_offered' => rand(1, 3),
        'price_per_seat' => rand(20, 100)
    ];
});
