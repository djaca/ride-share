<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnrouteCity extends Model
{
    protected $with = ['city'];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array $models
     *
     * @return \App\EnrouteCitiesCollection
     */
    public function newCollection(array $models = [])
    {
        return new EnrouteCitiesCollection($models);
    }
}
