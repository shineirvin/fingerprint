<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
	protected $table = 'hari';

	public $timestamps = false;

	protected $fillable = [
    	'nama',
        'recstatus',
    ];
	

}
