<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ipfingerprint extends Model
{
	protected $table = 'ipfingerprint';

	public $timestamps = false;
	
    protected $fillable = [
    	'ruang_id',
    	'ip_address',
    ];

    public function ruang() {
        return $this->belongsTo('App\Ruang', 'ruang_id', 'id');
    }

}
