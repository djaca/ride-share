<?php

namespace App\Http\Controllers;

use App\Exceptions\HasRequstedRideException;
use App\Exceptions\OwnsRideException;
use App\Exceptions\RideDepartedException;
use App\Exceptions\SeatsLimitException;
use App\Http\Requests\ReviewRideRequest;
use App\Ride;
use App\RideRequest;
use Illuminate\Http\Request;

class RideRequestsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $request->validate([
            'ride_id' => 'required|exists:rides,id',
            'enroute_city_id' => 'exists:cities,id',
            'privacy_policy' => 'required'
        ]);

        auth()->user()->makeRideRequest($request->only(['ride_id', 'enroute_city_id']));

        flash()->success('Ride successfully requested.');

        return back();
    }

    /**
     * @param \App\Http\Requests\ReviewRideRequest $request
     * @param \App\RideRequest                     $rideRequest
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function review(ReviewRideRequest $request, RideRequest $rideRequest)
    {
        $rideRequest->{$request->status}();

        flash("You {$request->status}ed request from {$rideRequest->requester->name}");

        return back();
    }
}
