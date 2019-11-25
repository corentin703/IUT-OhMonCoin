<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertFollow extends Model
{
    protected $fillable = [
        'advert',
        'user',
    ];

    public function advert()
    {
        return $this->belongsTo('App\Advert');
    }

    public function setAdvertAttribute($value)
    {
        $this->attributes['advert_id'] = $value->id;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function setUserAttribute($value)
    {
        $this->attributes['user_id'] = $value->id;
    }
}
