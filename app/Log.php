<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    protected $guarded = [];

    public function hotspot()
    {
    	return $this->hasOne(Hotspot::class);
    }

    public function profile()
    {
    	return $this->hasOne(Profile::class);
    }
}
