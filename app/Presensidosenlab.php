<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensidosenlab extends Model
{
	protected $table = 'presensidosenlab';

	public $timestamps = false;
	
    protected $fillable = [
        'nik',
        'waktu',
        'keterangan',
        'jadwal_kelas_id',
    	'pertemuan',
    ];

    /**
     * Presensidosen belongs to Jadwalkelas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Jadwalkelas()
    {
        return $this->belongsTo('App\Jadwalkelas');
    }

}
