<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adverts()
    {
        return $this->hasMany('App\Advert');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function setRoleAttribute($value)
    {
        $this->attributes['role_id'] = $value->id;
    }

    public function followed()
    {
        return $this->belongsToMany('App\Advert', 'advert_follows')->using( 'App\AdvertFollow');
//        return $this->hasManyThrough('App\Advert', 'App\AdvertFollow');
//        return $this->hasMany('App\AdvertFollow');
    }

    public function getFollowedAttribute()
    {
        $adverts = [];
        foreach ($this->followed()->get() as $follow)
            $adverts[] = $follow->advert;

        return collect($adverts);
    }

    public function followPivot()
    {
        return $this->hasMany('App\AdvertFollow');
    }
}
