<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Praktikum extends Model
{
	protected $table = 'praktikum';

    public $timestamps = false;
	
    protected $fillable = [
    	'jenis_praktikum',
    	'id_matakuliah',
    	'nama',
    	'recstatus',
    ];

}
