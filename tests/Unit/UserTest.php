<?php

namespace Tests\Unit;

use App\CarUser;
use App\Preference;
use App\Ride;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

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

        $this->user = factory(User::class)->create();

        $this->carUser = factory(CarUser::class)->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function it_has_all_fields()
    {
        $user = factory(User::class)->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johnDoe@gmail.com',
            'phone' => '123456',
            'year_of_birth' => 2000,
            'photo_path' => 'images/photos/no-photo.jpg'
        ]);

        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
        $this->assertEquals('johnDoe@gmail.com', $user->email);
        $this->assertEquals('123456', $user->phone);
        $this->assertEquals(2000, $user->year_of_birth);
        $this->assertEquals(asset('images/photos/no-photo.jpg'), $user->photo_path);
    }

    /** @test */
    public function it_can_calculate_users_number_of_years()
    {
        $knownDate = Carbon::create(2018);
        Carbon::setTestNow($knownDate);

        $user = factory(User::class)->create([
            'year_of_birth' => 2005
        ]);

        $this->assertEquals(13, $user->yearsOld);
    }

    /** @test */
    public function it_has_preference()
    {
        factory(Preference::class)->create(['user_id' => $this->user->id]);

        $this->assertInstanceOf(Preference::class, $this->user->preference);
    }

    /** @test */
    public function it_has_many_cars()
    {
        $this->assertInstanceOf(Collection::class, $this->user->cars);
    }

    /** @test */
    public function it_has_many_rides_through_car_user()
    {
        factory(Ride::class)->create(['car_user_id' => $this->carUser->id]);

        $this->assertInstanceOf(Collection::class, $this->user->rides);
        $this->assertInstanceOf(Ride::class, $this->user->rides()->first());
    }

    /** @test */
    public function it_can_check_if_user_owns_a_ride()
    {
        $ride = factory(Ride::class)->create(['car_user_id' => $this->carUser->id]);

        $this->assertTrue($this->user->owns($ride));
    }

    /** @test */
    public function it_can_determine_user_photo_path()
    {
        $this->assertEquals(asset('images/photos/no-photo.jpg'), $this->user->photo_path);

        $this->user->photo_path = 'photos/me.jpg';

        $this->assertEquals(asset('photos/me.jpg'), $this->user->photo_path);
    }
}
