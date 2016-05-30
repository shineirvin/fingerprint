<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwalkelas extends Model
{
    protected $table = 'jadwal_kelas';

    protected $primaryKey = 'id_kelas';

    public $timestamps = false;
    
    protected $fillable = [
        'semester',
        'id_praktikum',
        'kelas',
        'dosen_id',
        'hari_id',
        'ruang_id',
        'time_start',
        'time_end',
        'status',
    ];

    public function praktikum()
    {
         return $this->hasMany('App\Praktikum', 'id', 'id_praktikum');
    }

}