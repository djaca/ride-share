<?php

namespace Tests\Unit;

use App\Car;
use App\CarUser;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CarUser
     */
    protected $carUser;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->carUser = factory(CarUser::class)->create();
    }

    /** @test */
    public function it_has_additional_fields()
    {
        $carUser = factory(CarUser::class)->create([
            'registration_number' => '123ABC',
            'img_path' => 'img',
        ]);

        $this->assertEquals('123ABC', $carUser->registration_number);
        $this->assertEquals(asset('img'), $carUser->img_path);
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $this->assertInstanceOf(User::class, $this->carUser->user);
    }

    /** @test */
    public function it_belongs_to_a_car()
    {
        $this->assertInstanceOf(Car::class, $this->carUser->car);
    }

    /** @test */
    public function a_car_user_can_determine_its_img_path()
    {
        $this->assertEquals(asset('images/cars/no_car_img.jpg'), $this->carUser->img_path);

        $this->carUser->img_path = 'cars/foo.jpg';

        $this->assertEquals(asset('cars/foo.jpg'), $this->carUser->img_path);
    }
}
