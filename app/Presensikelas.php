<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensikelas extends Model
{
	protected $table = 'presensikelas';

	public $timestamps = false;
	
    protected $fillable = [
    	'NIK',
        'NIM',
        'waktu',
        'keterangan',
        'kelasmk_id',
    	'pertemuan',
    ];

    /**
     * Presensikelas belongs to Kelasmk.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Kelasmk()
    {
        return $this->belongsTo('App\Kelasmk');
    }

}
