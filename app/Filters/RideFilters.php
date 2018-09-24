<?php
/**
 * Created by PhpStorm.
 * User: djaca
 * Date: 21.9.18.
 * Time: 20.23
 */

namespace App\Filters;


use App\City;
use Illuminate\Support\Carbon;

class RideFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['fc', 'dc', 'date'];

    /**
     * Filter the query by a given source city.
     *
     * @param $name
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function fc($name)
    {
        $sourceCity = $this->findCity($name);

        if ($sourceCity) {
            return $this->builder->where('source_city_id', $sourceCity->id);
        }
    }

    /**
     * Filter the query by a given destination city.
     *
     * @param $name
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function dc($name)
    {
        $destinationCity = $this->findCity($name);

        if ($destinationCity) {
            return $this->builder->where('destination_city_id', $destinationCity->id)
                                 ->orWhereHas('enrouteCities', function ($query) use ($destinationCity) {
                                     $query->where('city_id', $destinationCity->id);
                                 });
        }
    }

    /**
     * Filter the query by a given date.
     *
     * @param $date
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function date($date)
    {
        $date = Carbon::parse($date);

        $builder = $this->builder->whereDate('time', '=', $date->toDateString());

        if ($date->isToday()) {
            $builder = $builder->whereTime('time', '>=', now()->toTimeString());
        }

        return $builder;
    }

    /**
     * Find city by name.
     *
     * @param $name
     *
     * @return mixed
     */
    private function findCity($name)
    {
        return City::where(compact('name'))->firstOrFail();
}
}
