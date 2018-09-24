<?php

use Faker\Generator as Faker;

$factory->define(App\RideRequest::class, function (Faker $faker) {
    return [
        'requester_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'ride_id' => function () {
            return factory(\App\Ride::class)->create()->id;
        },
        'enroute_city_id' => null,
        'status' => 'submitted' // default enum in database
    ];
});
