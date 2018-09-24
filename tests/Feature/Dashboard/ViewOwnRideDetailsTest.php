<?php

namespace Tests\Feature;

use App\CarUser;
use App\Ride;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewOwnRideDetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cannot_view_ride_details_of_another_user()
    {
        $user = factory(User::class)->create();

        $ride = factory(Ride::class)->create([
            'car_user_id' => function () use ($user) {
                return factory(CarUser::class)->create([
                    'user_id' => $user->id
                ]);
            },
            'seats_offered' => 5
        ]);

        $this->signIn()
             ->get(route('user.ride.show', ['ride_id' => $ride->id]))
             ->assertStatus(403);
    }
}
