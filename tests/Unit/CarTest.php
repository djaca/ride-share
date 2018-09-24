<?php

namespace Tests\Unit;

use App\Car;
use App\CarUser;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_all_fields()
    {
        $user = factory(Car::class)->create([
            'make' => 'Opel',
            'model' => 'Corsa',
            'year' => 2015,
        ]);

        $this->assertEquals('Opel', $user->make);
        $this->assertEquals('Corsa', $user->model);
        $this->assertEquals(2015, $user->year);
    }

    /** @test */
    public function it_has_a_car_user()
    {
        $car = factory(Car::class)->create();
        factory(CarUser::class)->create(['car_id' => $car->id]);

        $this->assertInstanceOf(CarUser::class, $car->carUser);
    }
}
