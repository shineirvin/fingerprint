<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensiasdos extends Model
{
	protected $table = 'presensiasdos';

	public $timestamps = false;
	
    protected $fillable = [
        'nim',
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
