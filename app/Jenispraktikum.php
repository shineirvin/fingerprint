<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenispraktikum extends Model
{
	protected $table = 'jenis_praktikum';

    public $timestamps = false;
	
    protected $fillable = [
    	'nama',
    	'recstatus',
    ];

}
