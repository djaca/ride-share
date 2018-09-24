<?php

namespace Tests\Feature\Dashboard\Car;

use App\Car;
use App\CarUser;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Car
     */
    protected $car;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->car = factory(Car::class)->create();
    }

    /** @test */
    public function guest_cannot_add_car()
    {
        $this->get(route('cars.create'))
             ->assertRedirect(route('login'));

        $this->post(route('cars.store'))
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_add_new_car()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('car.jpg');

        $this->signIn($this->user)
             ->post(route('cars.store'), [
                 'make' => 'Opel',
                 'model' => 'Corsa',
                 'year' => 2015,
                 'registration_number' => '123ABC',
                 'img' => $file
             ]);

        $car = $this->user->cars()->first();

        $this->assertEquals('Opel', $car->make);
        $this->assertEquals('Corsa', $car->model);
        $this->assertEquals(2015, $car->year);
        $this->assertEquals('123ABC', $car->carUser->registration_number);
        $this->assertEquals(asset('cars/' . $file->hashName()), $car->carUser->img_path);
        Storage::disk('public')->assertExists('cars/' . $file->hashName());
    }

    /** @test */
    public function a_car_requires_a_make()
    {
        $this->signIn()
             ->post(route('cars.store'), ['make' => null])
             ->assertSessionHasErrors('make');
    }

    /** @test */
    public function a_car_requires_a_model()
    {
        $this->signIn()
             ->post(route('cars.store'), ['model' => null])
             ->assertSessionHasErrors('model');
    }

    /** @test */
    public function a_car_requires_a_year()
    {
        $this->signIn()
             ->post(route('cars.store'), ['year' => null])
             ->assertSessionHasErrors('year');
    }

    /** @test */
    public function car_requires_a_registration_number_to_be_unique()
    {
        $this->signIn()
             ->post(route('cars.store'), ['registration_number' => null])
             ->assertSessionHasErrors('registration_number');

        $carUser = factory(CarUser::class)->create();

        $this->signIn()
             ->post(route('cars.store'), ['registration_number' => $carUser->registration_number])
             ->assertSessionHasErrors('registration_number');

    }

    /** @test */
    public function an_optional_valid_car_img_must_be_provided()
    {
        $this->signIn()
             ->post(route('cars.store'), ['img' => 'not-an-image'])
             ->assertSessionHasErrors('img');
    }
}
