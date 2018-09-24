<?php

namespace Tests\Unit;

use App\City;
use App\EnrouteCity;
use App\Ride;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnrouteCityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var EnrouteCity
     */
    protected $enrouteCity;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->enrouteCity = factory(EnrouteCity::class)->create();
    }

    /** @test */
    public function it_has_additional_fields()
    {
        $enrouteCity = factory(EnrouteCity::class)->create([
            'order_from_source' => 1,
            'prorated_price' => 200,
        ]);

        $this->assertEquals(1, $enrouteCity->order_from_source);
        $this->assertEquals(200, $enrouteCity->prorated_price);
    }

    /** @test */
    public function it_belongs_to_ride()
    {
        $this->assertInstanceOf(Ride::class, $this->enrouteCity->ride);
    }

    /** @test */
    public function it_belongs_to_city()
    {
        $this->assertInstanceOf(City::class, $this->enrouteCity->city);
    }
}
