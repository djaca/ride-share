<?php

namespace Tests\Unit;

use App\CarUser;
use App\City;
use App\EnrouteCitiesCollection;
use App\Ride;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RideTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_all_fields()
    {
        $ride = factory(Ride::class)->create([
            'time' => $time = now()->addHour()->toDateTimeString(),
            'seats_offered' => 2,
            'price_per_seat' => 400
        ]);

        $this->assertEquals($time, $ride->time);
        $this->assertInstanceOf(CarUser::class, $ride->carUser);
        $this->assertInstanceOf(City::class, $ride->sourceCity);
        $this->assertInstanceOf(City::class, $ride->destinationCity);
        $this->assertEquals(2, $ride->seats_offered);
        $this->assertEquals(400, $ride->price_per_seat);
    }

    /** @test */
    public function it_has_enroute_cities()
    {
        $ride = factory(Ride::class)->create();

        $this->assertInstanceOf(EnrouteCitiesCollection::class, $ride->enrouteCities);
    }

    /** @test */
    public function it_has_ride_requests()
    {
        $ride = factory(Ride::class)->create();

        $this->assertInstanceOf(Collection::class, $ride->rideRequests);
    }

    /** @test */
    public function it_can_check_for_available_seats()
    {
        $ride = factory(Ride::class)->create(['seats_offered' => 0]);

        $this->assertFalse($ride->hasAvailableSeats());
    }

    /** @test */
    public function it_parse_time_to_human_readable_format()
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 2, 12, 0, 0));

        $ride = factory(Ride::class)->create(['time' => now()]);

        $this->assertEquals('Today 02 Jan - 12:00', $ride->getHumanReadableTime());

        $ride = factory(Ride::class)->create(['time' => now()->addDay()]);

        $this->assertEquals('Tomorrow 03 Jan - 12:00', $ride->getHumanReadableTime());

        $ride = factory(Ride::class)->create(['time' => now()->subDay()]);

        $this->assertEquals('Yesterday 01 Jan - 12:00', $ride->getHumanReadableTime());

        $anyOtherDay = now()->addDays(2);
        $ride = factory(Ride::class)->create(['time' => $anyOtherDay]);

        $this->assertEquals("{$anyOtherDay->shortEnglishDayOfWeek} 04 Jan - 12:00", $ride->getHumanReadableTime());

        $ride = factory(Ride::class)->create(['time' => now()->subDay()]);

        $this->assertEquals('Yesterday 01 Jan', $ride->getHumanReadableTime(false));
    }
}
