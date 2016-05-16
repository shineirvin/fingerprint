<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensilab extends Model
{
    protected $table = 'presensilab';

    public $timestamps = false;
    
    protected $fillable = [
        'nim',
        'waktu',
        'keterangan',
        'jadwal_kelas_id',
        'pertemuan',
    ];

    /**
     * Presensikelas belongs to Jadwalkelas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Jadwalkelas()
    {
        return $this->belongsTo('App\Jadwalkelas');
    }

}
