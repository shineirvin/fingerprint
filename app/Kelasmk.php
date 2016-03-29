<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelasmk extends Model
{
	protected $table = 'kelasmk';

	public $timestamps = false;
	
    protected $fillable = [
    	'semester',
        'matakuliah_id',
        'kelas',
        'dosen_id',
        'hari_id',
        'ruangid',
        'waktu',
    	'recstatus',
    ];

    public function matakuliah()
    {
         return $this->hasMany('App\Matakuliah', 'kode_matakuliah', 'matakuliah_id');
    }


}