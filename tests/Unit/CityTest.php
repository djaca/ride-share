<?php

namespace Tests\Unit;

use App\City;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_all_fields()
    {
        $city = factory(City::class)->create([
            'name' => 'Belgrade',
            'country' => 'Serbia',
        ]);

        $this->assertEquals('Belgrade', $city->name);
        $this->assertEquals('Serbia', $city->country);
    }
}
