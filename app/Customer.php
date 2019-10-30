<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $guarded = [];

    public function bridges()
    {
    	return $this->hasMany(Bridge::class);
    }

    public function subscriptions()
    {
    	return $this->hasMany(Subscription::class);
    }

    public function subscription()
    {
    	return $this->hasOne(Subscription::class);
    }

    public function payments()
    {
    	return $this->hasMany(Payment::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
