<?php

namespace Tests\Feature;

use App\City;
use App\EnrouteCity;
use App\Ride;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchRidesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_search_rides_providing_source_city_only()
    {
        $sourceCity = factory(City::class)->create();
        $otherRide = factory(Ride::class)->create();

        $ride = factory(Ride::class)->create(['source_city_id' => $sourceCity->id]);

        $this->get(route('search', ['fc' => $sourceCity->name]))
             ->assertSee('$' . $ride->price_per_seat)
             ->assertSee("{$ride->seats_available} available seats")
             ->assertDontSee('$' . $otherRide->price_per_seat);
    }

    /** @test */
    public function anyone_can_search_rides_providing_destination_city_only()
    {
        $destinationCity = factory(City::class)->create();
        $otherRide = factory(Ride::class)->create();

        $ride = factory(Ride::class)->create(['destination_city_id' => $destinationCity->id]);

        $this->get(route('search', ['dc' => $destinationCity->name]))
             ->assertSee('$' . $ride->price_per_seat)
             ->assertSee("{$ride->seats_available} available seats")
             ->assertDontSee('$' . $otherRide->price_per_seat);
    }

    /** @test */
    public function in_order_to_search_for_rides_user_must_provide_either_source_or_destination_city()
    {
        $this->get(route('search', ['date' => now()->toDateString()]))
             ->assertRedirect('/');
    }

    /** @test */
    public function anyone_can_search_for_rides_providing_both_source_and_destination_city()
    {
        $sourceCity = factory(City::class)->create();
        $destinationCity = factory(City::class)->create();
        $otherRide = factory(Ride::class)->create();

        $ride = factory(Ride::class)->create([
            'source_city_id' => $sourceCity->id,
            'destination_city_id' => $destinationCity->id,
        ]);

        $this->get(route('search', ['fc' => $sourceCity->name, 'dc' => $destinationCity->name]))
             ->assertSee('$' . $ride->price_per_seat)
             ->assertSee("{$ride->seats_available} available seats")
             ->assertDontSee('$' . $otherRide->price_per_seat);
    }

    /** @test */
    public function anyone_can_search_for_rides_providing_enroute_city_as_destination_city()
    {
        $sourceCity = factory(City::class)->create();
        $destinationCity = factory(City::class)->create();
        $otherRide = factory(Ride::class)->create();
        $enrouteCity = factory(City::class)->create();

        $ride = factory(Ride::class)->create([
            'source_city_id' => $sourceCity->id,
            'destination_city_id' => $destinationCity->id,
        ]);

        factory(EnrouteCity::class)->create([
            'ride_id' => $ride->id,
            'city_id' => $enrouteCity->id,
        ]);

        $this->get(route('search',
            ['fc' => $sourceCity->name, 'dc' => $enrouteCity->name]))
             ->assertSee('$' . $enrouteCity->prorated_price)
             ->assertSee("{$ride->seats_available} available seats")
             ->assertDontSee('$' . $ride->price_per_seat)
             ->assertDontSee('$' . $otherRide->price_per_seat);
    }

    /** @test */
    public function return_active_rides_if_date_is_not_provided()
    {
        $sourceCity = factory(City::class)->create();
        $otherRide = factory(Ride::class)->create([
            'time' => now()->subMinute(),
            'source_city_id' => $sourceCity->id
        ]);

        $ride = factory(Ride::class)->create(['source_city_id' => $sourceCity->id]);
        $rideTwo = factory(Ride::class)->create([
            'time' => now()->addMinute(),
            'source_city_id' => $sourceCity->id
        ]);

        $this->get(route('search', ['fc' => $sourceCity->name]))
             ->assertSee('$' . $ride->price_per_seat)
             ->assertSee('$' . $rideTwo->price_per_seat)
             ->assertSee("{$ride->seats_available} available seats")
             ->assertSee("{$rideTwo->seats_available} available seats")
             ->assertDontSee('$' . $otherRide->price_per_seat);
    }

    /** @test */
    public function user_can_specify_date()
    {
        $city = factory(City::class)->create();
        $otherRide = factory(Ride::class)->create([
            'time' => now(),
            'source_city_id' => $city->id
        ]);

        $ride = factory(Ride::class)->create(['source_city_id' => $city->id]);
        $rideTwo = factory(Ride::class)->create(['source_city_id' => $city->id]);

        $this->get(route('search', ['fc' => $city->name, 'date' => now()->addDay()->toDateString()]))
             ->assertSee('$' . $ride->price_per_seat)
             ->assertSee('$' . $rideTwo->price_per_seat)
             ->assertSee("{$ride->seats_available} available seats")
             ->assertSee("{$rideTwo->seats_available} available seats")
             ->assertDontSee('$' . $otherRide->price_per_seat);
    }


}
