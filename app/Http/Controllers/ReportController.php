<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Model
use App\User;
use App\Matakuliah;
use App\Jenisruang;
use App\Ruang;
use App\Kelasmk;
use App\Hari;
use App\Presensikelas;

use Auth;

use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function indexDosen()
    {
    	return view('report.indexDosen');
    }

    public function reportDosenData()
    {
        $lecturerSchedules = Kelasmk::select('*')->where('dosen_id', Auth::user()->username)->get();
        return Datatables::of($lecturerSchedules)
            ->editColumn('nama_matakuliah', function ($lecturerSchedules) {
                $Matakuliah = Matakuliah::findOrFail($lecturerSchedules->matakuliah_id);
                return $Matakuliah->nama_matakuliah;
            })
            ->editColumn('sks', function ($lecturerSchedules) {
                $sks = Matakuliah::findOrFail($lecturerSchedules->matakuliah_id);
                return $sks->sks;
            })
            ->editColumn('1', function ($lecturerSchedules) {
            	$classes = \DB::table('presensikelas')
		            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
		            ->select('keterangan')
		            ->where('kelasmk_id', $kelasmk->id)
		            ->where('pertemuan', '1')
		            ->first();
		        if (!$classes) {
		        	return '';
		        }
		        else {
                	return $classes->keterangan;
		        }
            })
            ->editColumn('2', function ($lecturerSchedules) {
            	$classes = \DB::table('presensikelas')
		            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
		            ->select('pertemuan')
		            ->where('kelasmk_id', $lecturerSchedules->id)
		            ->where('pertemuan', '2')
		            ->first();
		        if (!$classes) {
		        	return '';
		        }
		        else {
                	return $classes->pertemuan;
		        }
            })
            ->make(true);   
    }

    public function indexMahasiswa()
    {
    	return view('report.indexMahasiswa');
    }

    public function reportMahasiswaData()
    {
    	$attendance = Presensikelas::select('*')->where('NIM', Auth::user()->username)->get();
        return Datatables::of($attendance)
            ->editColumn('nama_matakuliah', function ($attendance) {
            	$kelasmk = Kelasmk::find($attendance->kelasmk_id);
                $Matakuliah = Matakuliah::findOrFail($kelasmk->matakuliah_id);
                return $Matakuliah->nama_matakuliah;
            })
            ->editColumn('matakuliah_id', function ($attendance) {
            	$kelasmk = Kelasmk::find($attendance->kelasmk_id);
                return $kelasmk->matakuliah_id;
            })
            ->editColumn('kelas', function ($attendance) {
            	$kelasmk = Kelasmk::find($attendance->kelasmk_id);
                return $kelasmk->kelas;
            })
            ->editColumn('sks', function ($attendance) {
            	$kelasmk = Kelasmk::find($attendance->kelasmk_id);
                $sks = Matakuliah::findOrFail($kelasmk->matakuliah_id);
                return $sks->sks;
            })
            ->editColumn('1', function ($attendance) {
            	$kelasmk = Kelasmk::find($attendance->kelasmk_id);
            	$classes = \DB::table('presensikelas')
		            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
		            ->select('keterangan')
		            ->where('kelasmk_id', $kelasmk->id)
		            ->where('pertemuan', '1')
		            ->first();
		        if (!$classes) {
		        	return '';
		        }
		        else {
                	return $classes->keterangan;
		        }
            })
            ->editColumn('2', function ($lecturerSchedules) {
            	$classes = \DB::table('presensikelas')
		            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
		            ->select('pertemuan')
		            ->where('kelasmk_id', $lecturerSchedules->id)
		            ->where('pertemuan', '2')
		            ->first();
		        if (!$classes) {
		        	return '';
		        }
		        else {
                	return $classes->pertemuan;
		        }
            })
            ->make(true);   
    }

}
