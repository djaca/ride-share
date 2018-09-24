<?php

namespace App\Policies;

use App\User;
use App\Ride;
use Illuminate\Auth\Access\HandlesAuthorization;

class RidePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ride.
     *
     * @param  \App\User  $user
     * @param  \App\Ride  $ride
     * @return mixed
     */
    public function view(User $user, Ride $ride)
    {
        return $user->id === $ride->user()->id;
    }
}
