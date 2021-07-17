<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Names extends Model
{
     public function files()
    {
    	return $this->belongsTo('App\Files');
    }
}
