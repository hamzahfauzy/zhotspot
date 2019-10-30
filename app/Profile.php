<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $guarded = [];

    public function bridge()
    {
    	return $this->hasOne(Bridge::class);
    }

    public function hotpots()
    {
    	return $this->hasMany(Hotspot::class);
    }

    public function logs()
    {
    	return $this->hasMany(Log::class);
    }
}
