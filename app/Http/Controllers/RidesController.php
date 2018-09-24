<?php

namespace App\Http\Controllers;

use App\EnrouteCity;
use App\Ride;

class RidesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $rides = Ride::active()
                     ->oldest('time')
                     ->select(['id', 'time', 'source_city_id', 'destination_city_id', 'price_per_seat'])
                     ->take(3)
                     ->get();

        return view('rides.index', compact('rides'));
    }

    /**
     * @param \App\Ride $ride
     *
     * @param int       $orderFromSource
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Ride $ride, $orderFromSource = null)
    {
        $driver = $ride->user();

        $car = $ride->car();

        $enrouteCities = $ride->enrouteCities
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->city->name,
                    'order_from_source' => $item->order_from_source,
                    'price' => $item->prorated_price
                ];
            });

        $passengers = $ride->passengers();

        $enrouteCitySelected = $enrouteCities->firstWhere('order_from_source', $orderFromSource);

        return view(
            'rides.show',
            compact('ride', 'driver', 'car', 'enrouteCities', 'enrouteCitySelected', 'passengers')
        );
    }
}
