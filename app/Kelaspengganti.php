<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelaspengganti extends Model
{
	protected $table = 'kelaspengganti';

    public $timestamps = false;
	
    protected $fillable = [
    	'id',
    	'kelasmk_id',
    	'waktu',
    	'ruang_id',
    	'status',
    ];

}
