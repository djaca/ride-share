<?php

namespace Tests\Unit;

use App\EnrouteCity;
use App\Ride;
use App\RideRequest;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RideRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_all_fields()
    {
        $rideRequest = factory(RideRequest::class)->create([
            'requester_id' => function () {
                return factory(User::class)->create()->id;
            },
            'ride_id' => function () {
                return factory(Ride::class)->create()->id;
            },
            'enroute_city_id' => function () {
                return factory(EnrouteCity::class)->create()->id;
            },
            'status' => 'approved'
        ]);

        $this->assertInstanceOf(User::class, $rideRequest->requester);
        $this->assertInstanceOf(Ride::class, $rideRequest->ride);
        $this->assertInstanceOf(EnrouteCity::class, $rideRequest->enrouteCity);
        $this->assertEquals('approved', $rideRequest->status);
    }

    /** @test */
    public function it_can_approve_ride_request_and_decrement_ride_seats_offered()
    {
        $ride = factory(Ride::class)->create(['seats_offered' => 3]);
        $rideRequest = factory(RideRequest::class)->create(['ride_id' => $ride->id]);

        $rideRequest->approve();

        $this->assertEquals('approved', $rideRequest->status);
        $this->assertEquals(2, $ride->fresh()->seats_offered);
    }

    /** @test */
    public function it_can_reject_ride_request()
    {
        $ride = factory(Ride::class)->create(['seats_offered' => 3]);
        $rideRequest = factory(RideRequest::class)->create(['ride_id' => $ride->id]);

        $rideRequest->reject();

        $this->assertEquals('rejected', $rideRequest->status);
        $this->assertEquals(3, $ride->fresh()->seats_offered);
    }
}
