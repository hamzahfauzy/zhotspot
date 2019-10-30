<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotspot extends Model
{
    //
    protected $guarded = [];

    public function device()
    {
    	return $this->hasOne(Device::class);
    }

    public function profile()
    {
    	return $this->hasOne(Profile::class);
    }

    public function logs()
    {
    	return $this->hasMany(Log::class);
    }
}
