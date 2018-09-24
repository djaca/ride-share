<?php

use Faker\Generator as Faker;

$factory->define(App\EnrouteCity::class, function (Faker $faker) {
    return [
        'ride_id' => function () {
            return factory(\App\Ride::class)->create()->id;
        },
        'city_id' => function () {
            return factory(\App\City::class)->create()->id;
        },
        'order_from_source' => 1,
        'prorated_price' => rand(20, 60)
    ];
});
