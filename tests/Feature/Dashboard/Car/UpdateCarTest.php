<?php

namespace Tests\Feature\Dashboard\Car;

use App\Car;
use App\CarUser;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCarTest extends TestCase
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
    public function guest_cannot_update_car()
    {
        $this->get(route('cars.edit', ['car_id' => $this->car->id]))
             ->assertRedirect(route('login'));

        $this->patch(route('cars.update', ['car_id' => $this->car->id]))
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthorized_user_cannot_update_car()
    {
        factory(CarUser::class)->create([
            'user_id' => $this->user->id,
            'car_id' => $this->car->id
        ]);

        $this->signIn()
             ->get(route('cars.edit', ['car_id' => $this->car->id]))
             ->assertStatus(403);

        $this->signIn()
             ->patch(route('cars.update', ['car_id' => $this->car->id]))
             ->assertStatus(403);
    }

    /** @test */
    public function a_car_can_be_updated_by_its_driver()
    {
        Storage::fake('public');

        factory(CarUser::class)->create([
            'user_id' => $this->user->id,
            'car_id' => $this->car->id,
            'img_path' => $oldImg = UploadedFile::fake()->image('old_car.jpg')
        ]);

        $this->signIn($this->user)
             ->patch(route('cars.update', $this->car->id), [
                 'make' => 'Opel',
                 'model' => 'Corsa',
                 'year' => 2015,
                 'registration_number' => '123ABC',
                 'img' => $newImg = UploadedFile::fake()->image('new_car.jpg')
             ]);

        $car = $this->user->cars()->first();

        $this->assertEquals('Opel', $car->make);
        $this->assertEquals('Corsa', $car->model);
        $this->assertEquals(2015, $car->year);
        $this->assertEquals('123ABC', $car->carUser->registration_number);
        $this->assertEquals(asset('cars/' . $newImg->hashName()), $car->carUser->img_path);

        Storage::disk('public')->assertExists('cars/' . $newImg->hashName());
        Storage::disk('public')->assertMissing('cars/' . $oldImg->hashName());
    }
}
