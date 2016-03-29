<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = [
		'name'
	];

	// get di article associated with the given tags
    public function articles()
    {
    	 return $this->belongsToMany('App\Article');
    }
}
