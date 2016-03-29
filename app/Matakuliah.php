<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
	protected $table = 'matakuliah';

	public $timestamps = false;

    protected $primaryKey = 'kode_matakuliah';

    public $incrementing = false;
	
    protected $fillable = [
    	'kode_matakuliah',
    	'nama_matakuliah',
    	'sks',
    	'recstatus'
    ];

    public function kelasmk()
    {
        $this->belongsTo('App\Kelasmk');
    }

}