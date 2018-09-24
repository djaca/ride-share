<?php

namespace Tests\Feature\CreateRideStepper;

use App\CarUser;
use App\City;
use App\EnrouteCity;
use App\Ride;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StepThreeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_view_step_two()
    {
        $this->get(route('offer.step.three'))
             ->assertStatus(302)
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_review_ride_and_choose_car_at_step_three_as_final_step()
    {
        $time = now()->addDay()->toDateTimeString();
        $carUser = factory(CarUser::class)->create();
        $cities = factory(City::class, 4)->create();

        $ride = factory(Ride::class)->make([
            'time' => $time,
            'source_city_id' => $cities[0]->id,
            'destination_city_id' => $cities[1]->id,
            'seats_offered' => 2,
            'price_per_seat' => 50
        ]);

        $enrouteCities = collect([
            EnrouteCity::make(['city_id' => $cities[2]->id, 'prorated_price' => 30, 'order_from_source' => 1]),
            EnrouteCity::make(['city_id' => $cities[3]->id, 'prorated_price' => 20, 'order_from_source' => 2]),
        ]);

        $this->session(compact('ride', 'enrouteCities'));

        $this->signIn($carUser->user)
             ->post(route('offer.step.three'), ['car_user_id' => $carUser->id]);

        $this->assertDatabaseHas('rides', [
            'time' => $time,
            'car_user_id' => $carUser->id,
            'source_city_id' => $cities[0]->id,
            'destination_city_id' => $cities[1]->id,
            'seats_offered' => 2,
            'price_per_seat' => 50
        ]);

        $this->assertDatabaseHas('enroute_cities', [
            'city_id' => $cities[2]->id,
            'prorated_price' => 30,
            'order_from_source' => 1
        ]);

        $this->assertDatabaseHas('enroute_cities', [
            'city_id' => $cities[3]->id,
            'prorated_price' => 20,
            'order_from_source' => 2
        ]);
    }

    /** @test */
    public function it_requires_a_valid_car()
    {
        $this->session(['ride' => factory(Ride::class)->make()]);

        $this->signIn()
             ->post(route('offer.step.three'), ['car_user_id' => null])
             ->assertSessionHasErrors('car_user_id');

        $carUser = factory(CarUser::class)->create();

        $this->signIn($carUser->user)
             ->post(route('offer.step.three'), ['car_user_id' => 999])
             ->assertSessionHasErrors('car_user_id');
    }
}
