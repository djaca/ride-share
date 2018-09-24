<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddPhotoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_add_a_photo()
    {
        $this->post(route('photo'))
             ->assertStatus(302)
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_valid_photo_must_be_provided()
    {
        $this->signIn()
             ->post(route('photo'), ['photo' => 'not-a-photo'])
             ->assertSessionHasErrors('photo');
    }

    /** @test */
    public function an_user_can_add_photo_to_their_profile()
    {
        Storage::fake('public');

        $this->signIn()
             ->post(route('photo'), [
                 'photo' => $file = UploadedFile::fake()->image('photo.jpg')
             ]);

        $this->assertEquals(asset('images/photos/' . $file->hashName()), auth()->user()->photo_path);

        Storage::disk('public')->assertExists('images/photos/' . $file->hashName());
    }
}
