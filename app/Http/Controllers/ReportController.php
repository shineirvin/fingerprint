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
use Carbon\Carbon;

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

    public function indexAdmin($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month < 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('report.indexAdmin', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));

    }

    public function indexMhsAdmin($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month < 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('report.indexMhsAdmin', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
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
            ->editColumn('jml_hadir', function ($studentSubjects) {
            	return $this->jumlahHadirMahasiswa($studentSubjects);
            })
            ->editColumn('1', function ($studentSubjects) {
            	return $this->pertemuanMahasiswa($studentSubjects, '1');
            })
            ->editColumn('2', function ($studentSubjects) {
            	return $this->pertemuanMahasiswa($studentSubjects, '2');
            })
            ->editColumn('3', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '3');
            })
            ->editColumn('4', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '4');
            })
            ->editColumn('5', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '5');
            })
            ->editColumn('6', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '6');
            })
            ->editColumn('7', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '7');
            })
            ->editColumn('8', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '8');
            })
            ->editColumn('9', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '9');
            })
            ->editColumn('10', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '10');
            })
            ->editColumn('11', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '11');
            })
            ->editColumn('12', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '12');
            })
            ->editColumn('13', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '13');
            })
            ->editColumn('14', function ($studentSubjects) {
                return $this->pertemuanMahasiswa($studentSubjects, '14');
            })

            ->make(true);   
    }

    public function reportAdminData($semester)
    {
        $studentSubjects = Kelasmk::select('*')->where('semester', $semester)->get();
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
            ->editColumn('jml_hadir', function ($studentSubjects) {
                return $this->jumlahHadirSemuaDosen($studentSubjects);
            })
            ->editColumn('1', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '1');
            })
            ->editColumn('2', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '2');
            })
            ->editColumn('3', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '3');
            })
            ->editColumn('4', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '4');
            })
            ->editColumn('5', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '5');
            })
            ->editColumn('6', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '6');
            })
            ->editColumn('7', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '7');
            })
            ->editColumn('8', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '8');
            })
            ->editColumn('9', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '9');
            })
            ->editColumn('10', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '10');
            })
            ->editColumn('11', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '11');
            })
            ->editColumn('12', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '12');
            })
            ->editColumn('13', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '13');
            })
            ->editColumn('14', function ($studentSubjects) {
                return $this->pertemuanSemuaDosen($studentSubjects, '14');
            })

            ->make(true);   
    }

    public function reportMhsAdminData($semester)
    {
        $studentSubjects =  \DB::table('dpmk')
                            ->join('kelasmk', 'dpmk.kelasmk_id', '=', 'kelasmk.id')
                            ->select('kelasmk.*', 'dpmk.nim')
                            ->where('semester', $semester)
                            ->get();
        $studentSubjects = collect($studentSubjects);

        return Datatables::of($studentSubjects)
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
                $Matakuliah = Matakuliah::findOrFail($studentSubjects->matakuliah_id);
                return $Matakuliah->nama_matakuliah;
            })
            ->editColumn('nama_mahasiswa', function ($studentSubjects) {
                $nama = User::where('username', $studentSubjects->nim)->first();
                return $nama->name;
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
            ->editColumn('jml_hadir', function ($studentSubjects) {
                return $this->jumlahHadirSemuaMahasiswa($studentSubjects);
            })
            ->editColumn('1', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '1');
            })
            ->editColumn('2', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '2');
            })
            ->editColumn('3', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '3');
            })
            ->editColumn('4', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '4');
            })
            ->editColumn('5', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '5');
            })
            ->editColumn('6', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '6');
            })
            ->editColumn('7', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '7');
            })
            ->editColumn('8', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '8');
            })
            ->editColumn('9', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '9');
            })
            ->editColumn('10', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '10');
            })
            ->editColumn('11', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '11');
            })
            ->editColumn('12', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '12');
            })
            ->editColumn('13', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '13');
            })
            ->editColumn('14', function ($studentSubjects) {
                return $this->pertemuanSemuaMahasiswa($studentSubjects, '14');
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
            ->editColumn('jml_hadir', function ($lecturerSchedules) {
                return $this->jumlahHadirDosen($lecturerSchedules);
            })
            ->editColumn('1', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '1');
            })
            ->editColumn('2', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '2');
            })
            ->editColumn('3', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '3');
            })
            ->editColumn('4', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '4');
            })
            ->editColumn('5', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '5');
            })
            ->editColumn('6', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '6');
            })
            ->editColumn('7', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '7');
            })
            ->editColumn('8', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '8');
            })
            ->editColumn('9', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '9');
            })
            ->editColumn('10', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '10');
            })
            ->editColumn('11', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '11');
            })
            ->editColumn('12', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '12');
            })
            ->editColumn('13', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '13');
            })
            ->editColumn('14', function ($lecturerSchedules) {
                return $this->pertemuanDosen($lecturerSchedules, '14');
            })
            ->make(true);   
    }





    public function pertemuanMahasiswa($studentSubjects, $pertemuan)
    {
        $kelasmk = Kelasmk::find($studentSubjects->kelasmk_id);
        $classes = \DB::table('presensikelas')
                    ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $kelasmk->id)
                    ->where('pertemuan', $pertemuan)
                    ->where('nim', Auth::user()->username)
                    ->first();
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes->keterangan;
                }
    }

    public function jumlahHadirMahasiswa($studentSubjects)
    {
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
    }

    public function pertemuanDosen($lecturerSchedules, $pertemuan)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('kelasmk_id', $lecturerSchedules->id)
            ->where('pertemuan', $pertemuan)
            ->where('nik', Auth::user()->username)
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }

    public function jumlahHadirDosen($lecturerSchedules)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('keterangan', '1')
            ->where('kelasmk_id', $lecturerSchedules->id)
            ->where('nik', Auth::user()->username)
            ->count('keterangan');  
        if (!$classes) {
            return '';
        }
        else {
            return $classes;
        }
    }

    public function jumlahHadirSemuaDosen($studentSubjects)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('keterangan', '1')
            ->where('kelasmk_id', $studentSubjects->id)
            ->where('nik', $studentSubjects->dosen_id)
            ->count('pertemuan');  
        if (!$classes) {
            return '';
        }
        else {
            return $classes;
        }
    }

    public function pertemuanSemuaDosen($studentSubjects, $pertemuan)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('kelasmk_id', $studentSubjects->id)
            ->where('pertemuan', $pertemuan)
            ->where('nik', $studentSubjects->dosen_id)
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }

    public function jumlahHadirSemuaMahasiswa($studentSubjects)
    {
        $classes = \DB::table('presensikelas')
            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('keterangan', '1')
            ->where('kelasmk_id', $studentSubjects->id)
            ->where('nim', $studentSubjects->nim)
            ->count('keterangan');  
        if ( !$classes ) {
            return '';
        }
        else {
            return $classes;
        }
    }

    public function pertemuanSemuaMahasiswa($studentSubjects, $pertemuan)
    {
        $classes = \DB::table('presensikelas')
            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('kelasmk_id', $studentSubjects->id)
            ->where('pertemuan', $pertemuan)
            ->where('nim', $studentSubjects->nim)
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }

}
