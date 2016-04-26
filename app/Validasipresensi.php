<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validasipresensi extends Model
{
	protected $table = 'validasipresensi';

	public $timestamps = false;
	
    protected $fillable = [
    	'NIK',
    	'NIM',
    	'waktu',
    	'keterangan'
    ];


}
