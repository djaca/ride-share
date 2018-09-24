<?php

namespace Tests\Feature;

use App\Preference;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPreferencesTest extends TestCase
{
    use RefreshDatabase;

//    /** @test */
//    public function only_registered_user_can_set_their_ride_preferences()
//    {
//        $this->post(route('preferences.store'), [])
//             ->assertRedirect(route('login'));
//    }

    /** @test */
    public function add_default_preferences_when_user_register()
    {
        $this->withoutExceptionHandling()
             ->post(url('/register'), [
                 'first_name' => 'John',
                 'last_name' => 'Doe',
                 'email' => 'john@gmail.com',
                 'password' => 'secret',
                 'password_confirmation' => 'secret'
             ]);

        $user = User::first();

        $this->assertTrue($user->preference->dialog_allowed);
        $this->assertTrue($user->preference->music_allowed);
        $this->assertFalse($user->preference->smoking_allowed);
        $this->assertFalse($user->preference->pet_allowed);
    }

    /** @test */
    public function user_can_update_their_preferences()
    {
        $user = factory(User::class)->create();
        factory(Preference::class)->create(['user_id' => $user->id,]);

        $this->signIn($user)
             ->post(route('preferences.store'), [
                 'dialog_allowed' => true,
                 'music_allowed' => false,
                 'smoking_allowed' => false,
                 'pet_allowed' => true,
             ]);

        $user = $user->fresh();

        $this->assertTrue($user->preference->dialog_allowed);
        $this->assertFalse($user->preference->music_allowed);
        $this->assertFalse($user->preference->smoking_allowed);
        $this->assertTrue($user->preference->pet_allowed);
    }
}
