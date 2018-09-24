<?php

namespace Tests\Feature\CreateRideStepper;

use App\CarUser;
use App\City;
use App\EnrouteCity;
use App\Ride;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StepTwoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_view_step_two()
    {
        $this->get(route('offer.step.two'))
             ->assertStatus(302)
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_add_price_per_seat_and_enroute_city_price_per_seat_at_step_two()
    {
        $time = now()->addDay()->toDateTimeString();
        $user = factory(User::class)->create();
        factory(CarUser::class)->create(['user_id' => $user->id]);
        $cities = factory(City::class, 4)->create();

        $ride = factory(Ride::class)->make([
            'time' => $time,
            'source_city_id' => $cities[0]->id,
            'destination_city_id' => $cities[1]->id,
        ]);

        $enrouteCities = collect([
            factory(EnrouteCity::class)->make(['city_id' => $cities[2]->id, 'order_from_source' => 1]),
            factory(EnrouteCity::class)->make(['city_id' => $cities[3]->id, 'order_from_source' => 2]),
        ]);

        $this->session(compact('ride', 'enrouteCities'));

        $data = [
            "enroute_price_per_seat" => [$cities[2]->name => 50, $cities[3]->name =>30],
            "price_per_seat" => 100,
            "seats_offered" => 2,
        ];

        $this->signIn($user)
             ->post(route('offer.step.two'), $data)
             ->assertSessionHas('ride')
             ->assertSessionHas('enrouteCities');

        $rideSession = session()->get('ride');
        $this->assertEquals(100, $rideSession->price_per_seat);
        $this->assertEquals(2, $rideSession->seats_offered);

        $enrouteCitiesSession = session()->get('enrouteCities');
        $this->assertEquals(50, $enrouteCitiesSession->first()->prorated_price);
        $this->assertEquals(30, $enrouteCitiesSession->last()->prorated_price);
    }

    /** @test */
    public function it_requires_price_per_seat_to_be_positive_value()
    {
        $this->session(['ride' => factory(Ride::class)->make()]);

        $this->signIn()
             ->post(route('offer.step.two'), ['price_per_seat' => null])
             ->assertSessionHasErrors('price_per_seat');

        $this->signIn()
             ->post(route('offer.step.two'), ['price_per_seat' => 0])
             ->assertSessionHasErrors('price_per_seat');
    }

    /** @test */
    public function enroute_price_per_seat_must_be_an_array_and_positive_value()
    {
        $ride = factory(Ride::class)->make();

        $this->session([
            'ride' => $ride,
            'enrouteCities' => collect($enrouteCity = factory(EnrouteCity::class)->make())
        ]);

        $this->signIn()
             ->post(route('offer.step.two'), ['enroute_price_per_seat' => 'not-array'])
             ->assertSessionHasErrors('enroute_price_per_seat');

        $this->signIn()
             ->post(route('offer.step.two'), ['enroute_price_per_seat' => [null, null]])
             ->assertSessionHasErrors('enroute_price_per_seat.0')
             ->assertSessionHasErrors('enroute_price_per_seat.1');

        $this->signIn()
             ->post(route('offer.step.two'), ['enroute_price_per_seat' => [$enrouteCity->name => 'not-numeric']])
             ->assertSessionHasErrors("enroute_price_per_seat.{$enrouteCity->name}");

        $this->signIn()
             ->post(route('offer.step.two'), ['enroute_price_per_seat' => [$enrouteCity->name => 0]])
             ->assertSessionHasErrors("enroute_price_per_seat.{$enrouteCity->name}");
    }

    /** @test */
    public function it_requires_seats_offered_to_be_a_numeric_with_min_and_max()
    {
        $this->session(['ride' => factory(Ride::class)->make()]);

        $this->signIn()
             ->post(route('offer.step.two'), ['seats_offered' => null])
             ->assertSessionHasErrors('seats_offered');

        $this->signIn()
             ->post(route('offer.step.two'), ['seats_offered' => 'not-a-number'])
             ->assertSessionHasErrors('seats_offered');

        $this->signIn()
             ->post(route('offer.step.two'), ['seats_offered' => 0])
             ->assertSessionHasErrors('seats_offered');

        $this->signIn()
             ->post(route('offer.step.two'), ['seats_offered' => 4])
             ->assertSessionHasErrors('seats_offered');
    }
}
