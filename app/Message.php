<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'advert',
        'receiver',
        'sender',
        'content',
    ];

    public function advert()
    {
        return $this->belongsTo('App\Advert', 'advert_id');
    }

    public function setAdvertAttribute($value)
    {
        $this->attributes['advert_id'] = $value->id;
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }

    public function setReceiverAttribute($value)
    {
        $this->attributes['receiver_id'] = $value->id;
    }

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function setSenderAttribute($value)
    {
        $this->attributes['sender_id'] = $value->id;
    }
}
