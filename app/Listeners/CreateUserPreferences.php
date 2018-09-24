<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class CreateUserPreferences
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $event->user->preference()->create();
    }
}
