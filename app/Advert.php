<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advert extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'date',
        'content',
        'user',
        'category',
        'user',
    ];

    protected $dates = [
        'date',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function setCategoryAttribute($value)
    {
        $this->attributes['category_id'] = $value->id;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function setUserAttribute($value)
    {
        $this->attributes['user_id'] = $value->id;
    }

    public function pictures()
    {
        return $this->hasMany('App\Picture');
    }
}
