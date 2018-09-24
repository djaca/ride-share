<?php

namespace App\Http\Controllers\User;

use App\Ride;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $rides = $user->rides()
                      ->active()
                      ->with([
                          'rideRequests' => function ($query) {
                              $query->where('status', 'submitted');
                          },
                          'rideRequests.enrouteCity'
                      ])
                      ->whereHas('rideRequests', function ($query) {
                          $query->where('status', 'submitted');
                      })
                      ->get();

        return view('dashboard.index', compact('user', 'rides'));
    }
}
