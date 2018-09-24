<?php

namespace App;

use App\Exceptions\HasRequstedRideException;
use App\Exceptions\OwnsRideException;
use App\Exceptions\RideDepartedException;
use App\Exceptions\SeatsLimitException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'year_of_birth',
        'photo_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Format full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the path to the user's photo.
     *
     * @param  string $photo
     *
     * @return string
     */
    public function getPhotoPathAttribute($photo)
    {
        return asset($photo ?: 'images/photos/no-photo.jpg');
    }

    /**
     * Check for photo.
     *
     * @return bool
     */
    public function hasPhoto()
    {
        return !!$this->original['photo_path'];
    }

    /**
     * Calculate how old.
     *
     * @return int
     */
    public function getYearsOldAttribute()
    {
        if (!$this->year_of_birth) {
            return null;
        }

        return (int)now()->year - $this->year_of_birth;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function preference()
    {
        return $this->hasOne(Preference::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cars()
    {
        return $this->belongsToMany(Car::class)
                    ->using(CarUser::class)
                    ->withPivot('id', 'registration_number', 'img_path')
                    ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rideRequests()
    {
        return $this->hasMany(RideRequest::class, 'requester_id');
    }

    /**
     * Check if owns ride.
     *
     * @param \App\Ride $ride
     *
     * @return bool
     */
    public function owns(Ride $ride)
    {
        return $this->id === $ride->user()->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function rides()
    {
        return $this->hasManyThrough(Ride::class, CarUser::class, 'user_id', 'car_user_id');
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function makeRideRequest($data)
    {
        $ride = Ride::find($data['ride_id']);

        throw_if($ride->time->isPast(), RideDepartedException::class);
        throw_if(!$ride->hasAvailableSeats(), SeatsLimitException::class);
        throw_if($this->owns($ride), OwnsRideException::class);
        throw_if($ride->rideRequests->contains('requester_id', $this->id), HasRequstedRideException::class);

        return $this->rideRequests()->create($data);
    }
}
