<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dami extends Model
{
	protected $table = 'dami';

    public $incrementing = false;
	
    protected $fillable = [
    	'id',
    	'datetime',
    	'verified',
    	'status'
    ];

}
