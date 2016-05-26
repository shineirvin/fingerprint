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
use App\Dpmk;

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

    public function indexMahasiswa()
    {
        return view('report.indexMahasiswa');
    }

    public function indexAdmin()
    {
        return view('report.indexAdmin');
    }

    public function reportMahasiswaData()
    {
    	$studentSubjects = Dpmk::select('*')->where('nim', Auth::user()->username)->get();
        return Datatables::of($studentSubjects)
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
            	$kelasmk = Kelasmk::find($studentSubjects->kelasmk_id);
                $Matakuliah = Matakuliah::findOrFail($kelasmk->matakuliah_id);
                return $Matakuliah->nama_matakuliah;
            })
            ->editColumn('matakuliah_id', function ($studentSubjects) {
            	$kelasmk = Kelasmk::find($studentSubjects->kelasmk_id);
                return $kelasmk->matakuliah_id;
            })
            ->editColumn('kelas', function ($studentSubjects) {
            	$kelasmk = Kelasmk::find($studentSubjects->kelasmk_id);
                return $kelasmk->kelas;
            })
            ->editColumn('sks', function ($studentSubjects) {
            	$kelasmk = Kelasmk::find($studentSubjects->kelasmk_id);
                $sks = Matakuliah::findOrFail($kelasmk->matakuliah_id);
                return $sks->sks;
            })
            ->editColumn('0', function ($studentSubjects) {
                return '';
            })
            ->editColumn('jml_hadir', function ($studentSubjects) {
            	$kelasmk = Kelasmk::find($studentSubjects->kelasmk_id);
            	$classes = \DB::table('presensikelas')
		            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
		            ->select('keterangan')
                    ->where('keterangan', '1')
		            ->where('kelasmk_id', $kelasmk->id)
		            ->where('nim', Auth::user()->username)
		            ->count('keterangan'); 	
		        if ( !$classes ) {
		        	return '';
		        }
		        else {
                	return $classes;
		        }
            })
            ->editColumn('0', function ($studentSubjects) {
                return '';
            })
            ->editColumn('1', function ($studentSubjects) {
            	$kelasmk = Kelasmk::find($studentSubjects->kelasmk_id);
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
            ->editColumn('2', function ($studentSubjects) {
            	$kelasmk = Kelasmk::find($studentSubjects->kelasmk_id);
            	$classes = \DB::table('presensikelas')
		            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
		            ->select('keterangan')
		            ->where('kelasmk_id', $kelasmk->id)
		            ->where('pertemuan', '2')
		            ->first();
		        if (!$classes) {
		        	return '';
		        }
		        else {
                	return $classes->keterangan;
		        }
            })
            ->make(true);   
    }

    public function reportAdminData()
    {
        $studentSubjects = Kelasmk::select('*')->get();
        return Datatables::of($studentSubjects)
            ->editColumn('nama_dosen', function ($studentSubjects) {
                $LecturerNames = User::select('name')->where('username', $studentSubjects->dosen_id)->first();
                return $LecturerNames->name;
            })
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
                $Matakuliah = Matakuliah::findOrFail($studentSubjects->matakuliah_id);
                return $Matakuliah->nama_matakuliah;
            })
            ->editColumn('matakuliah_id', function ($studentSubjects) {
                return $studentSubjects->matakuliah_id;
            })
            ->editColumn('kelas', function ($studentSubjects) {
                return $studentSubjects->kelas;
            })
            ->editColumn('sks', function ($studentSubjects) {
                $sks = Matakuliah::findOrFail($studentSubjects->matakuliah_id);
                return $sks->sks;
            })
            ->editColumn('0', function ($studentSubjects) {
                return '';
            })
            ->editColumn('jml_hadir', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('keterangan', '1')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('NIK', $studentSubjects->dosen_id)
                    ->count('pertemuan');  
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes;
                }
            })
            ->editColumn('1', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('pertemuan', '1')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('2', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('pertemuan', '2')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('3', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('pertemuan', '3')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('4', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('pertemuan', '4')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('5', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('pertemuan', '5')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('6', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('pertemuan', '6')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('7', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('pertemuan', '7')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('8', function ($studentSubjects) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
                    ->where('pertemuan', '8')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->make(true);   
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
            ->editColumn('0', function ($studentSubjects) {
                return '';
            })
            ->editColumn('jml_hadir', function ($lecturerSchedules) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('keterangan', '1')
                    ->where('kelasmk_id', $lecturerSchedules->id)
                    ->where('NIK', Auth::user()->username)
                    ->count('keterangan');  
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes;
                }
            })
            ->editColumn('1', function ($lecturerSchedules) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $lecturerSchedules->id)
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
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $lecturerSchedules->id)
                    ->where('pertemuan', '2')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('3', function ($lecturerSchedules) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $lecturerSchedules->id)
                    ->where('pertemuan', '3')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('4', function ($lecturerSchedules) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $lecturerSchedules->id)
                    ->where('pertemuan', '4')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('5', function ($lecturerSchedules) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $lecturerSchedules->id)
                    ->where('pertemuan', '5')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('6', function ($lecturerSchedules) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $lecturerSchedules->id)
                    ->where('pertemuan', '6')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->editColumn('7', function ($lecturerSchedules) {
                $classes = \DB::table('presensidosen')
                    ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $lecturerSchedules->id)
                    ->where('pertemuan', '7')
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
            })
            ->make(true);   
    }

}
