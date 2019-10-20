<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function Adverts()
    {
        $this->hasMany('App\Advert');
    }
}
