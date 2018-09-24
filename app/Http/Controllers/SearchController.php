<?php

namespace App\Http\Controllers;

use App\Filters\RideFilters;
use App\Http\Requests\SearchRidesRequest;
use App\Ride;

class SearchController extends Controller
{
    /**
     * @param \App\Http\Requests\SearchRidesRequest $request
     *
     * @param \App\Filters\RideFilters              $filters
     *
     * @return string
     */
    public function index(SearchRidesRequest $request, RideFilters $filters)
    {
        $rides = Ride::filter($filters)
                     ->oldest('time')
                     ->with([
                         'sourceCity',
                         'destinationCity',
                         'enrouteCities',
                         'enrouteCities.city',
                         'carUser',
                         'carUser.user'
                     ]);

        if(!$request->date) {
            $rides->active();
        }

        $rides = $rides->paginate(10);

        return view('search.index', compact('rides'));
    }
}
