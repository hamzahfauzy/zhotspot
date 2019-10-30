<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bridge extends Model
{
    //
    protected $guarded = [];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function devices()
    {
    	return $this->belongsToMany(Device::class);
    }

    public function profiles()
    {
    	return $this->hasMany(Profile::class);
    }

    public function vouchers()
    {
    	return $this->hasMany(Voucher::class);
    }

    public function hotspots()
    {
    	return $this->hasMany(Hotspot::class);
    }
}
