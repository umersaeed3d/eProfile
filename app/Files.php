<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    public function directories()
    {
    	return $this->belongsTo('App\Album');
    }

     public function names()
    {
    	return $this->hasMany('App\Names');
    }
}

