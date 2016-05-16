<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detailkelas extends Model
{
	protected $table = 'detail_kelas';

    public $timestamps = false;
	
    protected $fillable = [
    	'id_jadwal_kelas',
    	'nim',
    ];

}
