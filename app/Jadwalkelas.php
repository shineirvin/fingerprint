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

    public function scopeDosenName($query)
    {
        $user = User::where('username', $this->dosen_id)->first();
        return $user->name;
    }

    public function scopeNamaRuang($query)
    {
        $ruang = Ruang::where('id', $this->ruang_id)->first();
        return $ruang->nama_ruang;
    }


    public function scopeAllRuang($query)
    {
        $ruang = Ruang::lists('nama_ruang', 'id');
        return $ruang;
    }

    public function scopeSelectedRuang($query)
    {
        $ruang = Ruang::where('id', $this->ruang_id)->first();
        return $ruang->id;
    }




    public function scopeNamaHari($query)
    {
        $hari = Hari::where('id', $this->hari_id)->first();
        return $hari->namahari;
    }

    public function scopeAllHari($query)
    {
        $hari = Hari::lists('namahari', 'id');
        return $hari;
    }

    public function scopeSelectedHari($query)
    {
        $hari = Hari::where('id', $this->hari_id)->first();
        return $hari->id;
    }


}