<?php

namespace Tests\Feature;

use App\CarUser;
use App\Ride;
use App\RideRequest;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewRideRequestTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $ride;

    protected $rideRequest;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->ride = factory(Ride::class)->create([
            'car_user_id' => function () {
                return factory(CarUser::class)->create([
                    'user_id' => $this->user->id
                ]);
            },
            'seats_offered' => 5
        ]);

        $this->rideRequest = factory(RideRequest::class)->create(['ride_id' => $this->ride->id]);
    }

    /** @test */
    public function user_can_reject_ride_request_for_his_ride()
    {
        $this->signIn($this->user)
             ->post(
                 route('rides.requests.review', ['ride_request_id' => $this->rideRequest->id]),
                 ['status' => 'reject']
             );

        $this->assertEquals('rejected', $this->rideRequest->fresh()->status);
        $this->assertEquals(5, $this->ride->fresh()->seats_offered);
    }

    /** @test */
    public function user_can_approve_ride_request_for_his_ride()
    {
        $this->signIn($this->user)
             ->post(
                 route('rides.requests.review', ['ride_request_id' => $this->rideRequest->id]),
                 ['status' => 'approve']
             );

        $this->assertEquals('approved', $this->rideRequest->fresh()->status);
        $this->assertEquals(4, $this->ride->fresh()->seats_offered);
    }
}
