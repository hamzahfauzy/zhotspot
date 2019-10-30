<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    protected $guarded = [];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function payment()
    {
    	return $this->belongsTo(Payment::class);
    }
}
