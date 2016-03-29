<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenisruang extends Model
{
	protected $table = 'jenisruang';

	public $timestamps = false;
	
    protected $fillable = [
    	'jenis_ruang',
    	'recstatus',
    ];

    public function ruang()
    {
    	$this->belongsTo('App\Ruang');
    }

}
