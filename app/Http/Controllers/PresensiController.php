<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

// Model
use App\User;
use App\Matakuliah;
use App\Jenisruang;
use App\Ruang;
use App\Kelasmk;
use App\Dami;
use App\Hari;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PresensiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    	$datas = Kelasmk::select('*')->where('dosen_id', Auth::user()->username)->get();
    	return view('presensi.index', compact('datas'));
    }

    public function getDataJadwalDosen()
    {
        $lecturerSchedules = Kelasmk::select('*')->where('dosen_id', Auth::user()->username)->get();
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="presensi/'.$lecturerSchedules->id.'" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
            })
            ->editColumn('recstatus', function ($lecturerSchedules) {
                return ($lecturerSchedules->recstatus == '1' ? 'Active' : 'Non Active');
            })
            ->editColumn('semester', function ($lecturerSchedules) {
                return strtoupper($lecturerSchedules->semester);
            })
            ->editColumn('hari_id', function ($lecturerSchedules) {
                $hari = Hari::findOrFail($lecturerSchedules->hari_id);
                return $hari->namahari;
            })
            ->editColumn('matakuliah_id', function ($lecturerSchedules) {
                $hari = Matakuliah::findOrFail($lecturerSchedules->matakuliah_id);
                return $hari->nama_matakuliah;
            })
            ->editColumn('ruang_id', function ($lecturerSchedules) {
                $ruang = Ruang::findOrFail($lecturerSchedules->ruang_id);
                return $ruang->nama_ruang;
            })
            ->make(true);   
    }

    public function getDataPresensiMahasiswa($id)
    {
        $datas = Kelasmk::select('waktu', 'matakuliah_id')->where('id', $id)->get();
        foreach($datas as $data) {
            $collections = $data->matakuliah;
            $time = $data->waktu;
            foreach($collections as $collection) {
                $matakuliah = $collection->sks;
            }   
        }
        // select from external database where time >= start and <= end of lecture (based on sks)
        $result = Dami::select('datetime','id')->where('datetime', '>=', Carbon::parse($time))->where('datetime', '<=', Carbon::parse($time)->addHours($matakuliah))->get();
        
        // $result = Dami::select('datetime','id')->where('datetime', '>=', "2016-03-21 06:46:32")->where('datetime', '<=', "2016-03-21 19:49:48")->get();

        return Datatables::of($result)
            ->addColumn('action', function ($result) {
                return '<a href="presensi/'.$result->id.'" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
            })
            ->make(true);   
    }

    public function validasi($id)
    {
        $idjadwal = $id;        
        return view('presensi.validasi', compact('idjadwal'));
    }

}
