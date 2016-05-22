<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dami extends Model
{
	protected $table = 'dami';

    public $timestamps = false;
	
    protected $fillable = [
    	'id',
    	'identity',
    	'datetime',
    ];

}
