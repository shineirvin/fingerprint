<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
	protected $table = 'ruang';

	public $timestamps = false;
	
    protected $fillable = [
    	'nama_ruang',
    	'kapasitas',
    	'jenisruang_id',
    	'recstatus'
    ];

    public function jenisruang()
    {
    	 return $this->hasMany('App\Jenisruang', 'id', 'jenisruang_id');
    }

    public function ipfingerprint()
    {
         return $this->hasOne('App\Ipfingerprint', 'ruang_id', 'id');
    }

}
