<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelaspenggantilab extends Model
{
	protected $table = 'kelaspenggantilab';

    public $timestamps = false;
	
    protected $fillable = [
    	'id',
    	'jadwalkelas_id',
    	'waktu',
    	'ruang_id',
    	'status',
    ];

}
