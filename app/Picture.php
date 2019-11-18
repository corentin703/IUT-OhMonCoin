<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Picture extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'link',
        'advert',
    ];

    public function advert()
    {
        $this->belongsTo('App\Advert');
    }

    public function setAdvertAttribute($value)
    {
        $this->attributes['advert_id'] = $value->id;
    }
}
