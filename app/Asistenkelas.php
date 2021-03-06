<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistenkelas extends Model
{
	protected $table = 'asisten_kelas';

	public $timestamps = false;
	
    protected $fillable = [
        'id_kelas',
        'user_id',
        'semester',
        'status',
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
