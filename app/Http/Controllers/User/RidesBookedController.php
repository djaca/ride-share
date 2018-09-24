<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class RidesBookedController extends Controller
{
    public function index()
    {
        $status = request()->status;

        if (!in_array($status, ['active', 'inactive'])) {
            return redirect(route('rides.booked.index', ['status' => 'active']));
        }

        $ridesRequests = auth()->user()
                               ->rideRequests()
                               ->whereHas('ride', function ($query) use ($status) {
                                   $query->where(
                                       'time', $status == 'active' ? '>=' : '<',
                                       now()->toDateTimeString());
                               })
                               ->with('ride', 'ride.sourceCity', 'ride.destinationCity', 'ride.carUser',
                                   'ride.carUser.user')
                               ->paginate(10);

        return view('dashboard.ridesBooked.index', compact('ridesRequests', 'status'));
    }
}
