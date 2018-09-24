<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class RidesOfferedController extends Controller
{
    public function index()
    {
        $status = request()->status;

        if (!in_array($status, ['active', 'inactive'])) {
            return redirect(route('rides.offered.index', ['status' => 'active']));
        }

        $rides = auth()->user()
                       ->rides()
                       ->where('time', $status == 'active' ? '>=' : '<', now()->toDateTimeString())
                       ->orderBy('time')
                       ->paginate(5);

        return view('dashboard.ridesOffered.index', compact('rides', 'status'));
    }
}
