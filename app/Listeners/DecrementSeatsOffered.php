<?php

namespace App\Listeners;

use App\Events\RideRequestApproved;

class DecrementSeatsOffered
{
    /**
     * Handle the event.
     *
     * @param  ApprovedRideRequest $event
     *
     * @return void
     */
    public function handle(RideRequestApproved $event)
    {
        $event->rideRequest
            ->ride()
            ->update(['seats_offered' => $event->rideRequest->ride->seats_offered - 1]);
    }
}
