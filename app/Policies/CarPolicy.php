<?php

namespace App\Policies;

use App\User;
use App\Car;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the car.
     *
     * @param  \App\User  $user
     * @param  \App\Car  $car
     * @return mixed
     */
    public function update(User $user, Car $car)
    {
        return $user->id == $car->carUser->user_id;
    }
}
