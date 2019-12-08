<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function getMessagesAttribute()
    {
        $messages = $this->messages()->get();

        $sortedMessages = [];
        foreach ($messages as $message)
        {
            if ($message->receiver->id == Auth::id())
                $sortedMessages[$message->sender->id][] = $message;
            else
                $sortedMessages[$message->receiver->id][] = $message;
        }

        return $sortedMessages;
    }

    public function pictures()
    {
        return $this->hasMany('App\Picture');
    }

    public function getPicturesAttribute()
    {
        $pictures = $this->pictures()->get();

        if ($this->trashed())
            $pictures = $this->pictures()->withTrashed();

        return $pictures;
    }

    public function follower()
    {
        return $this->belongsToMany('App\User', 'advert_follows')->using( 'App\AdvertFollow');
//        return $this->hasMany('App\AdvertFollow');
    }
}
