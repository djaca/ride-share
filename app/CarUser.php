<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CarUser extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'car_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['registration_number', 'img_path'];

    /**
     *  Get car image path.
     *
     * @param $img
     *
     * @return string
     */
    public function getImgPathAttribute($img)
    {
        return asset($img ?: 'images/cars/no_car_img.jpg');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Car::class)->select(['make', 'model', 'year']);
    }
}
