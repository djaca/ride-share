<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $rides = factory(\App\Ride::class, 10)->create();

        $rides->take(5)->each(function ($item, $key) {
            factory(\App\EnrouteCity::class)->create(['ride_id' => $item->id]);
            factory(\App\EnrouteCity::class)->create(['ride_id' => $item->id, 'order_from_source' => 2]);
        });

        $rides->take(-5)->each(function ($item, $key) {
            factory(\App\EnrouteCity::class)->create(['ride_id' => $item->id]);
        });

        $user = factory(\App\User::class)->create(['email' => 'johnDoe@gmail.com', 'phone' => null]);
        $carUser = factory(\App\CarUser::class)->create(['user_id' => $user->id]);
        $userRides = factory(\App\Ride::class, 2)->create(['car_user_id' => $carUser->id]);
        $userRideDeparted = factory(\App\Ride::class)->create([
            'time' => now()->subDay(),
            'car_user_id' => $carUser->id,
            'seats_offered' => 0
        ]);

        factory(\App\RideRequest::class, 3)->create(['requester_id' => $user->id,]);

        factory(\App\RideRequest::class)->create(['ride_id' => $userRides->first()->id,]);
        factory(\App\RideRequest::class)->create(['ride_id' => $userRides->first()->id,]);

        factory(\App\RideRequest::class)->create(['ride_id' => $userRides->last()->id]);
        factory(\App\RideRequest::class)->create(['ride_id' => $userRideDeparted->id, 'status' => 'approved']);

        $users = \App\User::all();

        $users->each(function ($item, $key) {
            $item->preference()->create([]);
        });
    }
}
