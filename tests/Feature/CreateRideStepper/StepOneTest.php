<?php

namespace Tests\Feature\CreateRideStepper;

use App\CarUser;
use App\City;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StepOneTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_make_ride()
    {
        $this->post(route('offer.step.one'))
             ->assertStatus(302)
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_add_cities_and_ride_time()
    {
        $user = factory(User::class)->create();
        factory(CarUser::class)->create(['user_id' => $user->id]);
        $cities = factory(City::class, 4)->create();
        $time = now()->addDay()->toDateTimeString();

        $data = [
            'source_city_id' => $cities[0]->id,
            'destination_city_id' => $cities[1]->id,
            'enroute_city_id' => [$cities[2]->id, $cities[3]->id, 999],
            'time' => $time
        ];

        $this->signIn($user)
             ->post(route('offer.step.one'), $data)
             ->assertSessionHas('ride')
             ->assertSessionHas('enrouteCities');

        $rideSession = session()->get('ride');
        $this->assertEquals($time, $rideSession->time);
        $this->assertEquals($cities[0]->name, $rideSession->sourceCity->name);
        $this->assertEquals($cities[1]->name, $rideSession->destinationCity->name);

        $enrouteCitiesSession = session()->get('enrouteCities');
        $this->assertCount(2, $enrouteCitiesSession);
        $this->assertEquals($cities[2]->name, $enrouteCitiesSession->first()->city->name);
        $this->assertEquals(1, $enrouteCitiesSession->first()->order_from_source);
        $this->assertEquals(2, $enrouteCitiesSession->last()->order_from_source);
    }

    /** @test */
    public function it_requires_a_time()
    {
        $this->signIn()
            ->post(route('offer.step.one'), ['time' => null])
             ->assertSessionHasErrors('time');
    }

    /** @test */
    public function it_requires_a_source_city()
    {
        $this->signIn()
             ->post(route('offer.step.one'), ['source_city_id' => null])
             ->assertSessionHasErrors('source_city_id');
    }

    /** @test */
    public function it_requires_a_destination_city()
    {
        $this->signIn()
             ->post(route('offer.step.one'), ['destination_city_id' => null])
             ->assertSessionHasErrors('destination_city_id');
    }
}
