<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensidosen extends Model
{
	protected $table = 'presensidosen';

	public $timestamps = false;
	
    protected $fillable = [
        'nik',
        'waktu',
        'keterangan',
        'kelasmk_id',
    	'pertemuan',
    ];

    /**
     * Presensidosen belongs to Kelasmk.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Kelasmk()
    {
        return $this->belongsTo('App\Kelasmk');
    }

}
