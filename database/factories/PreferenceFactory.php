<?php

use Faker\Generator as Faker;

$factory->define(App\Preference::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'dialog_allowed' => true,
        'music_allowed' => true,
        'smoking_allowed' => false,
        'pet_allowed' => false,
    ];
});
