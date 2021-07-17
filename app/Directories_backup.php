<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directories extends Model
{
    public function files()
    {
    	return $this->hasMany('App\Files');
    }
}
