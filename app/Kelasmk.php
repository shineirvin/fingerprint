<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelasmk extends Model
{
	protected $table = 'kelasmk';

	public $timestamps = false;
	
    protected $fillable = [
    	'semester',
        'matakuliah_id',
        'kelas',
        'dosen_id',
        'hari_id',
        'ruang_id',
        'waktu',
        'recstatus',
    	'batashadir',
    ];

    public function matakuliah()
    {
         return $this->hasMany('App\Matakuliah', 'kode_matakuliah', 'matakuliah_id');
    }

    /**
     * Kelasmk has many Presensikelas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Presensikelas()
    {
        return $this->hasMany('App\Presensikelas', 'id', 'kelasmk_id');
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