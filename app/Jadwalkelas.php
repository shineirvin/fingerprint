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
        'user_id',
        'hari_id',
        'id_ruang',
        'time_start',
        'time_end',
        'status',
    ];

    public function praktikum()
    {
         return $this->hasMany('App\Praktikum', 'id', 'id_praktikum');
    }

    public function scopeDosenName($query)
    {
        $user = User::where('id', $this->user_id)->first();
        return $user->name;
    }

    public function scopeNamaRuang($query)
    {
        $ruang = Ruang::where('id', $this->id_ruang)->first();
        return $ruang->nama;
    }


    public function scopeAllRuang($query)
    {
        $ruang = Ruang::lists('nama', 'id');
        return $ruang;
    }

    public function scopeSelectedRuang($query)
    {
        $ruang = Ruang::where('id', $this->id_ruang)->first();
        return $ruang->id;
    }




    public function scopeNamaHari($query)
    {
        $hari = Hari::where('id', $this->hari_id)->first();
        return $hari->nama;
    }

    public function scopeAllHari($query)
    {
        $hari = Hari::lists('nama', 'id');
        return $hari;
    }

    public function scopeSelectedHari($query)
    {
        $hari = Hari::where('id', $this->hari_id)->first();
        return $hari->id;
    }


}