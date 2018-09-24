<?php

namespace App;

use App\Filters\RideFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Ride extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'seats_offered' => 'integer'
    ];

    /**
     * @var array
     */
    protected $with = ['sourceCity', 'destinationCity'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['time'];

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('time', '>=', now());
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder     $query
     * @param  RideFilters $filters
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, RideFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * @param bool $withTime
     *
     * @return string
     */
    public function getHumanReadableTime($withTime = true)
    {
        $day = $this->time->format('D');

        if ($this->time->isToday()) {
            $day = 'Today';
        }

        if ($this->time->isTomorrow()) {
            $day = 'Tomorrow';
        }

        if ($this->time->isYesterday()) {
            $day = 'Yesterday';
        }

        if ($withTime) {
            return "{$day} {$this->time->format('d M')} - {$this->time->format('H:i')}";
        }

        return "{$day} {$this->time->format('d M')}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carUser()
    {
        return $this->belongsTo(CarUser::class);
    }

    /**
     * Get driver for this drive.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->carUser->user()
                             ->select('id', 'first_name', 'last_name', 'photo_path', 'year_of_birth')
                             ->first();
    }

    /**
     * Get car for this ride.
     *
     * @return mixed
     */
    public function car()
    {
        return $this->carUser->car()->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sourceCity()
    {
        return $this->belongsTo(City::class, 'source_city_id')->select(['id', 'name']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destinationCity()
    {
        return $this->belongsTo(City::class)->select(['id', 'name']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrouteCities()
    {
        return $this->hasMany(EnrouteCity::class)->orderBy('order_from_source');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rideRequests()
    {
        return $this->hasMany(RideRequest::class, 'ride_id');
    }

    /**
     * @return bool
     */
    public function hasAvailableSeats()
    {
        return $this->seats_offered !== 0;
    }

    /**
     * @return mixed
     */
    public function passengers()
    {
        return $this->rideRequests()
                    ->approved()
                    ->with([
                        'requester' => function ($query) {
                            $query->select('id', 'first_name', 'last_name', 'photo_path');
                        }
                    ])
                    ->select('id', 'requester_id')
                    ->get()
                    ->map(function ($item, $key) {
                        return $item->requester;
                    });
    }
}
