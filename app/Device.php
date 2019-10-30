<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $guarded = [];

    public function bridge()
    {
    	return $this->belongsTo(Bridge::class);
    }

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }
}
