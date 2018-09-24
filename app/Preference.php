<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
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
        'dialog_allowed' => 'boolean',
        'music_allowed' => 'boolean',
        'smoking_allowed' => 'boolean',
        'pet_allowed' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dialog()
    {
        return $this->dialog_allowed ? 'I love to chat' : 'I`m the quiet type';
    }

    public function music()
    {
        return $this->music_allowed ? 'Music is always on' : 'Silence is golden';
    }

    public function smoking()
    {
        return $this->smoking_allowed ? 'Smoking doesn`t bother me' : 'No smoking please';
    }

    public function pet()
    {
        return $this->pet_allowed ? 'Pets are most welcomed' : 'No pets please';
    }
}
