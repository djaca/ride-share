<?php

namespace Tests\Unit;

use App\Preference;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PreferenceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_all_fields()
    {
        $preference = factory(Preference::class)->create([
            'dialog_allowed' => true,
            'music_allowed' => true,
            'smoking_allowed' => false,
            'pet_allowed' => true,
        ]);

        $this->assertInstanceOf(User::class, $preference->user);
        $this->assertTrue($preference->dialog_allowed);
        $this->assertTrue($preference->music_allowed);
        $this->assertFalse($preference->smoking_allowed);
        $this->assertTrue($preference->pet_allowed);
    }
}
