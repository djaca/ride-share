<?php

namespace App\Http\Controllers\User;

use App\Ride;
use App\Http\Controllers\Controller;

class RidesController extends Controller
{
    public function show(Ride $ride)
    {
        $this->authorize('view', $ride);

        $enrouteCities = $ride->enrouteCities;

        $rideRequests = $ride->rideRequests()
                             ->with('enrouteCity')
                             ->where('status', '!=', 'rejected')
                             ->with([
                                 'requester' => function ($query) {
                                     $query->select('id', 'first_name', 'last_name', 'photo_path');
                                 }
                             ])
                             ->get()
                             ->groupBy(function ($item, $key) {
                                 return $item['status'];
                             });

        return view('dashboard.rides.show', compact('ride', 'enrouteCities', 'rideRequests'));
    }
}
