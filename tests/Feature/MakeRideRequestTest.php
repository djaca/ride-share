<?php

namespace Tests\Feature;

use App\CarUser;
use App\City;
use App\EnrouteCity;
use App\Exceptions\HasRequstedRideException;
use App\Exceptions\OwnsRideException;
use App\Exceptions\RideDepartedException;
use App\Exceptions\SeatsLimitException;
use App\Ride;
use App\RideRequest;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakeRideRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Ride
     */
    protected $ride;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->ride = factory(Ride::class)->create();
    }

    /** @test */
    public function guest_cannot_make_a_ride_request()
    {
        $this->post(route('requests.store'), [])
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_make_new_ride_request()
    {
        $this->withoutExceptionHandling()
             ->signIn($this->user)
             ->post(route('requests.store'), ['ride_id' => $this->ride->id, 'privacy_policy' => 'on']);

        $this->assertEquals($this->ride->id, $this->user->rideRequests()->first()->ride_id);
        $this->assertEquals($this->user->id, $this->ride->rideRequests()->first()->requester_id);
        $this->assertEquals('submitted', $this->user->rideRequests()->first()->status);
    }

    /** @test */
    public function user_can_make_drive_request_with_enroute_city_as_destination()
    {
        $enrouteCity = factory(EnrouteCity::class)->create(['ride_id' => $this->ride->id]);

        $this->signIn()
             ->post(
                 route('requests.store'),
                 ['ride_id' => $this->ride->id, 'enroute_city_id' => $enrouteCity->id, 'privacy_policy' => 'on']
             );

        $this->assertEquals($enrouteCity->id, RideRequest::first()->enroute_city_id);
    }

    /** @test */
    public function it_requires_valid_ride()
    {
        $this->signIn()
             ->post(route('requests.store'), ['ride_id' => null])
             ->assertSessionHasErrors('ride_id');

        $this->signIn()
             ->post(route('requests.store'), ['ride_id' => 999])
             ->assertSessionHasErrors('ride_id');
    }

    /** @test */
    public function it_has_optional_enroute_city_that_must_be_valid()
    {
        factory(City::class, 2)->create();

        $this->signIn()
             ->post(route('requests.store'), ['enroute_city_id' => 999])
             ->assertSessionHasErrors('enroute_city_id');
    }

    /** @test */
    public function it_requires_privacy_policy()
    {
        $this->signIn()
             ->post(route('requests.store'), ['ride_id' => $this->ride->id])
             ->assertSessionHasErrors('privacy_policy');
    }

    /** @test */
    public function cannot_make_ride_request_if_all_seats_are_occupied()
    {
        $this->expectException(SeatsLimitException::class);
        $this->ride->seats_offered = 0;
        $this->ride->save();

        $this->withoutExceptionHandling()
             ->signIn()
             ->post(route('requests.store'), ['ride_id' => $this->ride->id, 'privacy_policy' => 'on']);
    }

    /** @test */
    public function user_cannot_make_ride_request_to_ride_he_created()
    {
        $this->expectException(OwnsRideException::class);
        $carUser = factory(CarUser::class)->create(['user_id' => $this->user->id]);
        $ride = factory(Ride::class)->create(['car_user_id' => $carUser->id]);

        $this->withoutExceptionHandling()
             ->signIn($this->user)
             ->post(route('requests.store'), ['ride_id' => $ride->id, 'privacy_policy' => 'on']);

        $this->assertEmpty($ride->rideRequests);
    }

    /** @test */
    public function user_cannot_make_more_then_one_request_for_same_ride()
    {
        $this->expectException(HasRequstedRideException::class);
        factory(RideRequest::class)->create(['requester_id' => $this->user->id, 'ride_id' => $this->ride->id]);

        $this->assertCount(1, $this->ride->rideRequests);

        $this->withoutExceptionHandling()
             ->signIn($this->user)
             ->post(route('requests.store'), ['ride_id' => $this->ride->id, 'privacy_policy' => 'on']);

        $this->assertCount(1, $this->ride->fresh()->rideRequests);
    }

    /** @test */
    public function user_cannot_make_ride_request_to_departed_ride()
    {
        $this->expectException(RideDepartedException::class);
        $ride = factory(Ride::class)->create(['time' => now()->subSecond()]);

        $this->withoutExceptionHandling()
             ->signIn()
             ->post(route('requests.store'), ['ride_id' => $ride->id, 'privacy_policy' => 'on']);
    }
}
