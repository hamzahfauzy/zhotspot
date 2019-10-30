<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = [];

    public function payments()
    {
    	return $this->hasMany(Payment::class);
    }
}
