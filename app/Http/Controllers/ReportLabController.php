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
use App\Jadwalkelas;
use App\Praktikum;
use App\Detailkelas;
use App\Asistenkelas;

use Auth;
use Carbon\Carbon;
use PHPExcel_Worksheet_Drawing;
use Maatwebsite\Excel\Facades\Excel;

use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportLabController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function indexDosen($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('reportlab.indexDosen', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function reportDosenDetailLab($currentsemesterParams, $currentMatakuliah, $currentKelas)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);

        $allSemester = Jadwalkelas::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }

        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        $allMatkul = \DB::table('jadwal_kelas') 
                    ->join('praktikum', 'jadwal_kelas.id_praktikum', '=', 'praktikum.id')
                    ->select('id', 'id_praktikum', 'praktikum.nama', 'praktikum.id')
                    ->where('dosen_id', Auth::user()->username)
                    ->where('semester', $currentsemesterParams)
                    ->lists('praktikum.nama', 'praktikum.id');

        $mtklDirty = collect($allMatkul);
        $matakuliah = $mtklDirty->unique();

        $allKelas = \DB::table('jadwal_kelas') 
                    ->join('praktikum', 'jadwal_kelas.id_praktikum', '=', 'praktikum.id')
                    ->select('jadwal_kelas.*')
                    ->where('semester', $currentsemesterParams)
                    ->where('id_praktikum', $currentMatakuliah)
                    ->orderBy('kelas')
                    ->lists('kelas', 'kelas');

        $klsDirty = collect($allKelas);
        $kelas = $klsDirty->unique();
        $kelas->prepend('PILIH KELAS', '');

        return view('reportlab.reportDosenDetailLab', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter', 'matakuliah', 'allMatkul', 'currentMatakuliah', 'kelas', 'currentKelas'));
    }

    public function indexMahasiswa($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('reportlab.indexMahasiswa', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function indexAsdos($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('reportlab.indexAsdos', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function indexAllAsdos($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('reportlab.indexAllAsdos', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function indexAdmin($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('reportlab.indexAdmin', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function indexAdminLab($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('report.indexAdminLab', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function indexMhsLabAdmin($currentsemesterParams)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Kelasmk::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }
        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        return view('report.indexMhsLabAdmin', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }


    /**
     * Report semua dosen yang mengajar kelas lab
     */
    public function reportAdminLabData($semester)
    {
        $studentSubjects = Jadwalkelas::select('*')->where('semester', $semester)->get();
        return Datatables::of($studentSubjects)
            ->editColumn('nama_dosen', function ($studentSubjects) {
                $LecturerNames = User::select('name')->where('username', $studentSubjects->dosen_id)->first();
                if (round(($this->jumlahHadirSemuaDosen($studentSubjects)/14 * 100), 2) <= 70) {
                    return '<p style="color:red">'.$LecturerNames->name.'</p>';                    
                }
                return $LecturerNames->name;
            })
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
                $praktikum = Praktikum::findOrFail($studentSubjects->id_praktikum);
                return $praktikum->nama;
            })
            ->editColumn('matakuliah_id', function ($studentSubjects) {
                $Matakuliah = Praktikum::findOrFail($studentSubjects->id_praktikum);
                return $Matakuliah->id_matakuliah;
            })
            ->editColumn('kelas', function ($studentSubjects) {
                return $studentSubjects->kelas;
            })
            ->editColumn('sks', function ($studentSubjects) {
                $praktikum = Praktikum::findOrFail($studentSubjects->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
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
            ->editColumn('presentase', function ($studentSubjects) {
                $presentase = round(($this->jumlahHadirSemuaDosen($studentSubjects)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);   
    }


    public function reportDosenDetailLabData($semester, $matakuliah, $kelas)
    {

        $studentSubjects =  \DB::table('detail_kelas')
                            ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->select('jadwal_kelas.*', 'detail_kelas.nim')
                            ->where('semester', $semester)
                            ->where('id_praktikum', $matakuliah)
                            ->where('kelas', $kelas)
                            ->where('dosen_id', Auth::user()->username)
                            ->get();
        $studentSubjects = collect($studentSubjects);

        return Datatables::of($studentSubjects)
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
                $Matakuliah = Praktikum::findOrFail($studentSubjects->id_praktikum);
                return $Matakuliah->nama;
            })
            ->editColumn('nama_mahasiswa', function ($studentSubjects) {
                $nama = User::where('username', $studentSubjects->nim)->first();
                if (round(($this->jumlahHadirSemuaMahasiswa($studentSubjects)/14 * 100), 2) <= 70) {
                    return '<p style="color:red">'.$nama->name.'</p>';                    
                }
                return $nama->name;
            })
            ->editColumn('matakuliah_id', function ($studentSubjects) {
                return $studentSubjects->id_praktikum;
            })
            ->editColumn('kelas', function ($studentSubjects) {
                return $studentSubjects->kelas;
            })
            ->editColumn('sks', function ($studentSubjects) {
                $praktikum = Praktikum::findOrFail($studentSubjects->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
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
            ->editColumn('presentase', function ($studentSubjects) {
                $presentase = round(($this->jumlahHadirSemuaMahasiswa($studentSubjects)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);   
    }

    public function reportAdminDosenDetailLabData($semester, $dosen, $matakuliah, $kelas)
    {
        if ($semester == '0' || $dosen == '0' || $matakuliah == '0' || $kelas == '0') {
            return json_encode(array('data'=>''));
        }
        $studentSubjects =  \DB::table('detail_kelas')
                            ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->select('jadwal_kelas.*', 'detail_kelas.nim')
                            ->where('semester', $semester)
                            ->where('id_praktikum', $matakuliah)
                            ->where('kelas', $kelas)
                            ->where('dosen_id', $dosen)
                            ->get();
        $studentSubjects = collect($studentSubjects);

        return Datatables::of($studentSubjects)
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
                $Matakuliah = Praktikum::findOrFail($studentSubjects->id_praktikum);
                return $Matakuliah->nama;
            })
            ->editColumn('nama_mahasiswa', function ($studentSubjects) {
                $nama = User::where('username', $studentSubjects->nim)->first();
                if (round(($this->jumlahHadirSemuaMahasiswa($studentSubjects)/14 * 100), 2) <= 70) {
                    return '<p style="color:red">'.$nama->name.'</p>';                    
                }
                return $nama->name;
            })
            ->editColumn('matakuliah_id', function ($studentSubjects) {
                return $studentSubjects->id_praktikum;
            })
            ->editColumn('kelas', function ($studentSubjects) {
                return $studentSubjects->kelas;
            })
            ->editColumn('sks', function ($studentSubjects) {
                $praktikum = Praktikum::findOrFail($studentSubjects->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
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
            ->editColumn('presentase', function ($studentSubjects) {
                $presentase = round(($this->jumlahHadirSemuaMahasiswa($studentSubjects)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);   
    }

    public function reportAllAsdosData($semester)
    {
        $studentSubjects =  \DB::table('asisten_kelas')
                            ->join('jadwal_kelas', 'asisten_kelas.id_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->select('jadwal_kelas.*', 'asisten_kelas.nim')
                            ->where('jadwal_kelas.semester', $semester)
                            ->get();

        $studentSubjects = collect($studentSubjects);
        return Datatables::of($studentSubjects)
            ->editColumn('id_matakuliah', function ($lecturerSchedules) {
                $praktikum = Praktikum::find($lecturerSchedules->id_praktikum);
                return $praktikum->id_matakuliah;
            })
            ->editColumn('nama_matakuliah', function ($lecturerSchedules) {
                $praktikum = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                return $praktikum->nama;
            })
            ->editColumn('nama_mahasiswa', function ($studentSubjects) {
                $nama = User::where('username', $studentSubjects->nim)->first();
                if (round(($this->jumlahHadirSemuaAsdos($studentSubjects)/14 * 100), 2) <= 70) {
                    return '<p style="color:red">'.$nama->name.'</p>';                    
                }
            })
            ->editColumn('kelas', function ($studentSubjects) {
                return $studentSubjects->kelas;
            })
            ->editColumn('sks', function ($lecturerSchedules) {
                $praktikum = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
                return $sks->sks;
            })
            ->editColumn('jml_hadir', function ($studentSubjects) {
                return $this->jumlahHadirSemuaAsdos($studentSubjects);
            })
            ->editColumn('1', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '1');
            })
            ->editColumn('2', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '2');
            })
            ->editColumn('3', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '3');
            })
            ->editColumn('4', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '4');
            })
            ->editColumn('5', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '5');
            })
            ->editColumn('6', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '6');
            })
            ->editColumn('7', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '7');
            })
            ->editColumn('8', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '8');
            })
            ->editColumn('9', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '9');
            })
            ->editColumn('10', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '10');
            })
            ->editColumn('11', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '11');
            })
            ->editColumn('12', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '12');
            })
            ->editColumn('13', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '13');
            })
            ->editColumn('14', function ($studentSubjects) {
                return $this->pertemuanSemuaAsdos($studentSubjects, '14');
            })
            ->editColumn('presentase', function ($studentSubjects) {
                $presentase = round(($this->jumlahHadirSemuaAsdos($studentSubjects)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);   
    }

    /**
     * Report semua mahasiswa yang yang mengambil kelas lab
     */
    public function reportMhsLabAdminData($semester)
    {
        $studentSubjects = \DB::table('detail_kelas')
                            ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->where('semester', $semester)
                            ->get();
        $studentSubjects = collect($studentSubjects);

        return Datatables::of($studentSubjects)
            ->editColumn('nama_mahasiswa', function ($studentSubjects) {
                $nama = User::where('username', $studentSubjects->nim)->first();
                if (round(($this->jumlahHadirSemuaMahasiswa($studentSubjects)/14 * 100), 2) <= 70) {
                    return '<p style="color:red">'.$nama->name.'</p>';                    
                }
                return $nama->name;
            })
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
                $praktikum = Praktikum::findOrFail($studentSubjects->id_praktikum);
                return $praktikum->nama;
            })
            ->editColumn('matakuliah_id', function ($studentSubjects) {
                $Matakuliah = Praktikum::findOrFail($studentSubjects->id_praktikum);
                return $Matakuliah->id_matakuliah;
            })
            ->editColumn('sks', function ($studentSubjects) {
                $praktikum = Praktikum::findOrFail($studentSubjects->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
                return $sks->sks;
            })
            ->editColumn('kelas', function ($studentSubjects) {
                return $studentSubjects->kelas;
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
            ->editColumn('presentase', function ($studentSubjects) {
                $presentase = round(($this->jumlahHadirSemuaMahasiswa($studentSubjects)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);   
    }

    /**
     * Report kehadiran pada dosen yang sedang login
     */
    public function reportDosenData($semester)
    {
        $lecturerSchedules = Jadwalkelas::select('*')->where('semester', $semester)->where('dosen_id', Auth::user()->username)->get();
        return Datatables::of($lecturerSchedules)
            ->editColumn('id_matakuliah', function ($lecturerSchedules) {
                $Matakuliah = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                return $Matakuliah->id_matakuliah;
            })
            ->editColumn('nama_matakuliah', function ($lecturerSchedules) {
                $Matakuliah = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                if (round(($this->jumlahHadirDosen($lecturerSchedules)/14 * 100), 2) <= 70) {
                    return '<p style="color:red">'.$Matakuliah->nama.'</p>';
                }
                return $Matakuliah->nama;
            })
            ->editColumn('sks', function ($lecturerSchedules) {
                $Matakuliah = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                $sks = Matakuliah::findOrFail($Matakuliah->id_matakuliah);
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
            ->editColumn('presentase', function ($studentSubjects) {
                $presentase = round(($this->jumlahHadirDosen($studentSubjects)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);   
    }

    /**
     * Report Kehadiran mahasiswa yang sedang login
     */
    public function reportMahasiswaData($semester)
    {
        $studentSubjects = \DB::table('detail_kelas')
                    ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                    ->where('semester', $semester)
                    ->where('nim', Auth::user()->username)
                    ->get();
        $studentSubjects = collect($studentSubjects);
        return Datatables::of($studentSubjects)
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
                $matakuliah = Praktikum::findOrFail($studentSubjects->id_praktikum);
                if (round(($this->jumlahHadirMahasiswa($studentSubjects)/14 * 100), 2) <= 70) {
                    return '<p style="color:red">'.$matakuliah->nama.'</p>';
                }
                return $matakuliah->nama;
            })
            ->editColumn('matakuliah_id', function ($studentSubjects) {
                $matakuliah = Praktikum::findOrFail($studentSubjects->id_praktikum);
                return $matakuliah->id_matakuliah;
            })
            ->editColumn('kelas', function ($studentSubjects) {
                return $studentSubjects->kelas;
            })
            ->editColumn('sks', function ($studentSubjects) {
                $praktikum = Praktikum::findOrFail($studentSubjects->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
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
            ->editColumn('presentase', function ($studentSubjects) {
                $presentase = round(($this->jumlahHadirMahasiswa($studentSubjects)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);   
    }

    public function reportAdminDosenDetailLab($currentsemesterParams, $currentDosen, $currentMatakuliah, $currentKelas)
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $currentsemester = (substr($currentsemesterDirty, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterDirty, 0, 4);
        $currentsemesterParamsFilter = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        $allSemester = Jadwalkelas::lists('semester');
        foreach ($allSemester as $semester) {
            $smst[] = substr($semester, 0, 4).' '.(substr($semester, -1) == 1 ? 'GANJIL' : 'GENAP');
        }

        $smstDirty = collect($smst);
        $semester = $smstDirty->unique();
        $semester->prepend('PILIH SEMESTER');

        $allMatkul = \DB::table('jadwal_kelas') 
                    ->join('praktikum', 'jadwal_kelas.id_praktikum', '=', 'praktikum.id')
                    ->select('jadwal_kelas.semester', 'jadwal_kelas.dosen_id', 'praktikum.nama', 'praktikum.id')
                    ->where('dosen_id', $currentDosen)
                    ->where('semester', $currentsemesterParams)
                    ->lists('praktikum.nama', 'praktikum.id');
        $mtklDirty = collect($allMatkul);
        $matakuliah = $mtklDirty->unique();
        $matakuliah->prepend('PILIH PRAKTIKUM', '0');

        $allDosen = \DB::table('jadwal_kelas') 
                    ->join('users', 'jadwal_kelas.dosen_id', '=', 'users.username')
                    ->select('jadwal_kelas.dosen_id', 'jadwal_kelas.semester', 'users.name', 'users.username')
                    ->where('jadwal_kelas.semester', $currentsemesterParams)
                    ->lists('users.name', 'users.username');

        $dsnDirty = collect($allDosen);
        $dosen = $dsnDirty->unique();
        $dosen->prepend('PILIH DOSEN', '0');

        $allKelas = \DB::table('jadwal_kelas') 
                    ->join('praktikum', 'jadwal_kelas.id_praktikum', '=', 'praktikum.id')
                    ->select('jadwal_kelas.*')
                    ->where('dosen_id', $currentDosen)
                    ->where('semester', $currentsemesterParams)
                    ->where('id_praktikum', $currentMatakuliah)
                    ->orderBy('kelas')
                    ->lists('kelas', 'kelas');

        $klsDirty = collect($allKelas);
        $kelas = $klsDirty->unique();
        $kelas->prepend('PILIH KELAS', '');

        return view('reportlab.reportAdminDosenDetailLab', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter', 'matakuliah', 'allMatkul', 'currentMatakuliah', 'kelas', 'currentKelas', 'allDosen', 'dosen', 'currentDosen'));
    }


    /**
     * Report kehadiran asods yang sedang login
     */
    public function reportAsdosData($semester) {
        $lecturerSchedules = \DB::table('asisten_kelas')
            ->join('jadwal_kelas', 'asisten_kelas.id_kelas', '=', 'jadwal_kelas.id_kelas')
            ->select('jadwal_kelas.*', 'asisten_kelas.nim')
            ->where('jadwal_kelas.semester', $semester)
            ->where('nim', Auth::user()->username)
            ->get();

        $lecturerSchedules = collect($lecturerSchedules);
        return Datatables::of($lecturerSchedules)
            ->editColumn('id_matakuliah', function ($lecturerSchedules) {
                $praktikum = Praktikum::find($lecturerSchedules->id_praktikum);
                return $praktikum->id_matakuliah;
            })
            ->editColumn('nama_matakuliah', function ($lecturerSchedules) {
                $praktikum = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                if (round(($this->jumlahHadirAsdos($lecturerSchedules)/14 * 100), 2) <= 70) {
                    return '<p style="color:red">'.$praktikum->nama.'</p>';
                }
                return $praktikum->nama;
            })
            ->editColumn('sks', function ($lecturerSchedules) {
                $praktikum = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
                return $sks->sks;
            })
            ->editColumn('kelas', function ($lecturerSchedules) {
                return $lecturerSchedules->kelas;
            })
            ->editColumn('jml_hadir', function ($lecturerSchedules) {
                return $this->jumlahHadirAsdos($lecturerSchedules);
            })
            ->editColumn('1', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '1');
            })
            ->editColumn('2', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '2');
            })
            ->editColumn('3', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '3');
            })
            ->editColumn('4', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '4');
            })
            ->editColumn('5', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '5');
            })
            ->editColumn('6', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '6');
            })
            ->editColumn('7', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '7');
            })
            ->editColumn('8', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '8');
            })
            ->editColumn('9', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '9');
            })
            ->editColumn('10', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '10');
            })
            ->editColumn('11', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '11');
            })
            ->editColumn('12', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '12');
            })
            ->editColumn('13', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '13');
            })
            ->editColumn('14', function ($lecturerSchedules) {
                return $this->pertemuanAsdos($lecturerSchedules, '14');
            })
            ->editColumn('presentase', function ($studentSubjects) {
                $presentase = round(($this->jumlahHadirAsdos($studentSubjects)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);   
    }


    /**
     * Report Excel Semua Dosen ( Admin )
     */
    public function reportAllDosenLabExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "SemuaDosen");
    }

    public function reportAllMahasiswaLabExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "SemuaMahasiswa");
    }
    public function reportAllAsdosLabExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "SemuaAsdos");
    }

    public function reportDosenLabExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "dosen");
    }

    public function reportMahasiswaLabExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "mahasiswa");
    }

    public function reportAsdosExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "asdos");
    }

    public function reportDosenDetailLabExcel($currentsemesterParams, $currentMatakuliah, $currentKelas)
    {
        return $this->excelformatDosen($currentsemesterParams, $currentMatakuliah, $currentKelas, $katakunci = "detaildosen");
    }

    public function reportAdminDosenDetailLabExcel($currentsemesterParams, $currentDosen, $currentMatakuliah, $currentKelas)
    {
        return $this->excelformatDosenDetail($currentsemesterParams, $currentDosen, $currentMatakuliah, $currentKelas, $katakunci = "semuadetaildosen");
    }



    /**
     * Excel format
     */
    public function excelformat($currentsemesterParams, $katakunci)
    {
        $semesterString = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        Excel::create('LAPORAN SEMESTER', function($excel) use ($semesterString, $currentsemesterParams, $katakunci) {
            $excel->sheet('LAPORAN SEMESTER', function($sheet) use($semesterString, $currentsemesterParams, $katakunci) {
                $induk1 = array();
                $induk2 = array();
                $objDrawing = new PHPExcel_Worksheet_Drawing;
                $objDrawing->setPath(public_path('assets/images/img.png')); //your image path
                $objDrawing->setCoordinates('A1');
                $objDrawing->setWorksheet($sheet);

                if ($katakunci == 'SemuaDosen') {
                    $nikOrNim = 'NIK';
                    $roles = 'NAMA DOSEN';
                    $studentSubjects = \DB::table('jadwal_kelas')
                                        ->join('users', 'jadwal_kelas.dosen_id', '=', 'users.username')
                                        ->select('jadwal_kelas.*')
                                        ->where('semester', $currentsemesterParams)
                                        ->orderBy('name', 'asc')
                                        ->get();
                }
                elseif ($katakunci == 'dosen') {
                    $nikOrNim = 'NIK';
                    $roles = 'NAMA DOSEN';
                    $studentSubjects = \DB::table('jadwal_kelas')
                                        ->join('users', 'jadwal_kelas.dosen_id', '=', 'users.username')
                                        ->select('jadwal_kelas.*')
                                        ->where('dosen_id', Auth::user()->username)
                                        ->where('semester', $currentsemesterParams)
                                        ->orderBy('name', 'asc')
                                        ->get();
                }
                elseif ($katakunci == 'SemuaMahasiswa') {
                    $nikOrNim = 'NIM';
                    $roles = 'NAMA MAHASISWA';
                    $studentSubjects = \DB::table('detail_kelas')
                            ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->join('users', 'detail_kelas.nim', '=', 'users.username')
                            ->select('jadwal_kelas.*', 'detail_kelas.nim', 'users.name')
                            ->where('semester', $currentsemesterParams)
                            ->orderBy('users.name', 'asc')
                            ->get();
                }
                elseif($katakunci == 'mahasiswa') {
                    $nikOrNim = 'NIM';
                    $roles = 'NAMA MAHASISWA';
                    $studentSubjects = \DB::table('detail_kelas')
                            ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->join('users', 'detail_kelas.nim', '=', 'users.username')
                            ->select('jadwal_kelas.*', 'detail_kelas.nim', 'detail_kelas.id_jadwal_kelas', 'users.name')
                            ->where('semester', $currentsemesterParams)
                            ->where('nim', Auth::user()->username)
                            ->orderBy('users.name', 'asc')
                            ->get();      
                }
                elseif ($katakunci == 'asdos') {
                    $nikOrNim = 'NIM';
                    $roles = 'NAMA ASDOS';
                    $studentSubjects = \DB::table('asisten_kelas')
                        ->join('jadwal_kelas', 'asisten_kelas.id_kelas', '=', 'jadwal_kelas.id_kelas')
                        ->join('users', 'asisten_kelas.nim', '=', 'users.username')
                        ->select('jadwal_kelas.*', 'asisten_kelas.nim')
                        ->where('jadwal_kelas.semester', $currentsemesterParams)
                        ->where('nim', Auth::user()->username)
                        ->orderBy('users.name', 'asc')
                        ->get();
                }
                elseif ($katakunci == 'SemuaAsdos') {
                    $nikOrNim = 'NIM';
                    $roles = 'NAMA ASDOS';
                    $studentSubjects = \DB::table('asisten_kelas')
                        ->join('jadwal_kelas', 'asisten_kelas.id_kelas', '=', 'jadwal_kelas.id_kelas')
                        ->join('users', 'asisten_kelas.nim', '=', 'users.username')
                        ->select('jadwal_kelas.*', 'asisten_kelas.nim')
                        ->where('jadwal_kelas.semester', $currentsemesterParams)
                        ->orderBy('users.name', 'asc')
                        ->get();
                }


                $sheet->mergeCells('H14:U14');
                $sheet->mergeCells('A14:A15');
                $sheet->mergeCells('B14:B15');
                $sheet->mergeCells('C14:C15');
                $sheet->mergeCells('D14:D15');
                $sheet->mergeCells('E14:E15');
                $sheet->mergeCells('F14:F15');
                $sheet->mergeCells('G14:G15');
                $sheet->mergeCells('V14:V15');
                $sheet->mergeCells('W14:W15');

                $sheet->row(8, array(
                    '', '', '', 'LAPORAN SEMESTER'
                ));
                $sheet->row(10, array(
                    'PROGRAM STUDI TEKNIK INFORMATIKA'
                ));
                $sheet->row(11, array(
                    'DAFTAR KEHADIRAN DOSEN SEMESTER '.$semesterString.' '
                ));
                $sheet->row(12, array(
                    'FAKULTAS TEKNOLOGI INFORMASI UNIVERSITAS TARUMANAGARA'
                ));

                $sheet->row(14, array(
                    'NO',' '.$nikOrNim.' ',' '.$roles.' ', 'KODE MK', 'NAMA MATAKULIAH', 'SKS', 'KELAS', 'MINGGU KE -', '', '', '', '', '', '', '', '', '', '', '', '', '', 'JML HADIR', 'PRESENTASE'
                ));
                $sheet->row(15, array(
                    '', '', '', '', '', '', '', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'
                ));

                $sheet->setWidth(array(
                    'A'     =>  4,
                    'B'     =>  15,
                    'C'     =>  35,
                    'D'     =>  15,
                    'E'     =>  40,
                    'F'     =>  4,
                    'G'     =>  6,
                    'H'     =>  4,
                    'I'     =>  4,
                    'J'     =>  4,
                    'K'     =>  4,
                    'L'     =>  4,
                    'M'     =>  4,
                    'N'     =>  4,
                    'O'     =>  4,
                    'P'     =>  4,
                    'Q'     =>  4,
                    'R'     =>  4,
                    'S'     =>  4,
                    'T'     =>  4,
                    'U'     =>  4,
                    'V'     =>  10,
                    'W'     =>  12,

                ));

                $no = 1;
                foreach ($studentSubjects as $key => $value) {
                    if($katakunci == 'SemuaDosen') {
                        $pertemuan1 = $this->pertemuanSemuaDosen($value, '1');
                        $pertemuan2 = $this->pertemuanSemuaDosen($value, '2');
                        $pertemuan3 = $this->pertemuanSemuaDosen($value, '3');
                        $pertemuan4 = $this->pertemuanSemuaDosen($value, '4');
                        $pertemuan5 = $this->pertemuanSemuaDosen($value, '5');
                        $pertemuan6 = $this->pertemuanSemuaDosen($value, '6');
                        $pertemuan7 = $this->pertemuanSemuaDosen($value, '7');
                        $pertemuan8 = $this->pertemuanSemuaDosen($value, '8');
                        $pertemuan9 = $this->pertemuanSemuaDosen($value, '9');
                        $pertemuan10 = $this->pertemuanSemuaDosen($value, '10');
                        $pertemuan11 = $this->pertemuanSemuaDosen($value, '11');
                        $pertemuan12 = $this->pertemuanSemuaDosen($value, '12');
                        $pertemuan13 = $this->pertemuanSemuaDosen($value, '13');
                        $pertemuan14 = $this->pertemuanSemuaDosen($value, '14');
                        $jmlhadir = $this->jumlahHadirSemuaDosen($value);
                        $presentase = round(($this->jumlahHadirSemuaDosen($value)/14 * 100), 2). '%';
                        $presentaseV = round(($this->jumlahHadirSemuaDosen($value)/14 * 100), 2);
                    }
                    elseif($katakunci == 'SemuaMahasiswa') {
                        $pertemuan1 = $this->pertemuanSemuaMahasiswa($value, '1');
                        $pertemuan2 = $this->pertemuanSemuaMahasiswa($value, '2');
                        $pertemuan3 = $this->pertemuanSemuaMahasiswa($value, '3');
                        $pertemuan4 = $this->pertemuanSemuaMahasiswa($value, '4');
                        $pertemuan5 = $this->pertemuanSemuaMahasiswa($value, '5');
                        $pertemuan6 = $this->pertemuanSemuaMahasiswa($value, '6');
                        $pertemuan7 = $this->pertemuanSemuaMahasiswa($value, '7');
                        $pertemuan8 = $this->pertemuanSemuaMahasiswa($value, '8');
                        $pertemuan9 = $this->pertemuanSemuaMahasiswa($value, '9');
                        $pertemuan10 = $this->pertemuanSemuaMahasiswa($value, '10');
                        $pertemuan11 = $this->pertemuanSemuaMahasiswa($value, '11');
                        $pertemuan12 = $this->pertemuanSemuaMahasiswa($value, '12');
                        $pertemuan13 = $this->pertemuanSemuaMahasiswa($value, '13');
                        $pertemuan14 = $this->pertemuanSemuaMahasiswa($value, '14');
                        $jmlhadir = $this->jumlahHadirSemuaMahasiswa($value);
                        $presentase = round(($this->jumlahHadirSemuaMahasiswa($value)/14 * 100), 2). '%';
                        $presentaseV = round(($this->jumlahHadirSemuaMahasiswa($value)/14 * 100), 2);
                    }
                    elseif($katakunci == 'SemuaAsdos') {
                        $pertemuan1 = $this->pertemuanSemuaAsdos($value, '1');
                        $pertemuan2 = $this->pertemuanSemuaAsdos($value, '2');
                        $pertemuan3 = $this->pertemuanSemuaAsdos($value, '3');
                        $pertemuan4 = $this->pertemuanSemuaAsdos($value, '4');
                        $pertemuan5 = $this->pertemuanSemuaAsdos($value, '5');
                        $pertemuan6 = $this->pertemuanSemuaAsdos($value, '6');
                        $pertemuan7 = $this->pertemuanSemuaAsdos($value, '7');
                        $pertemuan8 = $this->pertemuanSemuaAsdos($value, '8');
                        $pertemuan9 = $this->pertemuanSemuaAsdos($value, '9');
                        $pertemuan10 = $this->pertemuanSemuaAsdos($value, '10');
                        $pertemuan11 = $this->pertemuanSemuaAsdos($value, '11');
                        $pertemuan12 = $this->pertemuanSemuaAsdos($value, '12');
                        $pertemuan13 = $this->pertemuanSemuaAsdos($value, '13');
                        $pertemuan14 = $this->pertemuanSemuaAsdos($value, '14');
                        $jmlhadir = $this->jumlahHadirSemuaAsdos($value);
                        $presentase = round(($this->jumlahHadirSemuaAsdos($value)/14 * 100), 2). '%';
                        $presentaseV = round(($this->jumlahHadirSemuaAsdos($value)/14 * 100), 2);
                    }
                    elseif($katakunci == 'dosen') {
                        $pertemuan1 = $this->pertemuanDosen($value, '1');
                        $pertemuan2 = $this->pertemuanDosen($value, '2');
                        $pertemuan3 = $this->pertemuanDosen($value, '3');
                        $pertemuan4 = $this->pertemuanDosen($value, '4');
                        $pertemuan5 = $this->pertemuanDosen($value, '5');
                        $pertemuan6 = $this->pertemuanDosen($value, '6');
                        $pertemuan7 = $this->pertemuanDosen($value, '7');
                        $pertemuan8 = $this->pertemuanDosen($value, '8');
                        $pertemuan9 = $this->pertemuanDosen($value, '9');
                        $pertemuan10 = $this->pertemuanDosen($value, '10');
                        $pertemuan11 = $this->pertemuanDosen($value, '11');
                        $pertemuan12 = $this->pertemuanDosen($value, '12');
                        $pertemuan13 = $this->pertemuanDosen($value, '13');
                        $pertemuan14 = $this->pertemuanDosen($value, '14');
                        $jmlhadir = $this->jumlahHadirDosen($value);
                        $presentase = round(($this->jumlahHadirDosen($value)/14 * 100), 2). '%';
                        $presentaseV = round(($this->jumlahHadirDosen($value)/14 * 100), 2);
                    }
                    elseif($katakunci == 'mahasiswa') {
                        $pertemuan1 = $this->pertemuanMahasiswa($value, '1');
                        $pertemuan2 = $this->pertemuanMahasiswa($value, '2');
                        $pertemuan3 = $this->pertemuanMahasiswa($value, '3');
                        $pertemuan4 = $this->pertemuanMahasiswa($value, '4');
                        $pertemuan5 = $this->pertemuanMahasiswa($value, '5');
                        $pertemuan6 = $this->pertemuanMahasiswa($value, '6');
                        $pertemuan7 = $this->pertemuanMahasiswa($value, '7');
                        $pertemuan8 = $this->pertemuanMahasiswa($value, '8');
                        $pertemuan9 = $this->pertemuanMahasiswa($value, '9');
                        $pertemuan10 = $this->pertemuanMahasiswa($value, '10');
                        $pertemuan11 = $this->pertemuanMahasiswa($value, '11');
                        $pertemuan12 = $this->pertemuanMahasiswa($value, '12');
                        $pertemuan13 = $this->pertemuanMahasiswa($value, '13');
                        $pertemuan14 = $this->pertemuanMahasiswa($value, '14');
                        $jmlhadir = $this->jumlahHadirMahasiswa($value);
                        $presentase = round(($this->jumlahHadirMahasiswa($value)/14 * 100), 2). '%';
                        $presentaseV = round(($this->jumlahHadirMahasiswa($value)/14 * 100), 2);
                    }
                    elseif($katakunci == 'asdos') {
                        $pertemuan1 = $this->pertemuanAsdos($value, '1');
                        $pertemuan2 = $this->pertemuanAsdos($value, '2');
                        $pertemuan3 = $this->pertemuanAsdos($value, '3');
                        $pertemuan4 = $this->pertemuanAsdos($value, '4');
                        $pertemuan5 = $this->pertemuanAsdos($value, '5');
                        $pertemuan6 = $this->pertemuanAsdos($value, '6');
                        $pertemuan7 = $this->pertemuanAsdos($value, '7');
                        $pertemuan8 = $this->pertemuanAsdos($value, '8');
                        $pertemuan9 = $this->pertemuanAsdos($value, '9');
                        $pertemuan10 = $this->pertemuanAsdos($value, '10');
                        $pertemuan11 = $this->pertemuanAsdos($value, '11');
                        $pertemuan12 = $this->pertemuanAsdos($value, '12');
                        $pertemuan13 = $this->pertemuanAsdos($value, '13');
                        $pertemuan14 = $this->pertemuanAsdos($value, '14');
                        $jmlhadir = $this->jumlahHadirAsdos($value);
                        $presentase = round(($this->jumlahHadirAsdos($value)/14 * 100), 2). '%';
                        $presentaseV = round(($this->jumlahHadirAsdos($value)/14 * 100), 2);
                    }

                    if ($katakunci == 'SemuaDosen' || $katakunci == 'dosen') {
                        $nama = User::where('username', $value->dosen_id)->first();
                        $induk = $value->dosen_id;
                    }
                    elseif ($katakunci == 'SemuaMahasiswa' || $katakunci == 'mahasiswa' || $katakunci == 'asdos' || $katakunci == 'SemuaAsdos') {
                        $nama = User::where('username', $value->nim)->first();
                        $induk = $value->nim;
                    }
                    $praktikum = Praktikum::find($value->id_praktikum);
                    $matakuliah = Matakuliah::findOrFail($praktikum->id_matakuliah);
                    $sheet->row($key+16, array(
                         $no,
                         $induk, 
                         $nama->name, 
                         $praktikum->id_matakuliah, 
                         $matakuliah->nama_matakuliah, 
                         $matakuliah->sks, 
                         $value->kelas, 
                         $pertemuan1, 
                         $pertemuan2, 
                         $pertemuan3,   
                         $pertemuan4,
                         $pertemuan5,
                         $pertemuan6,
                         $pertemuan7,
                         $pertemuan8,
                         $pertemuan9,
                         $pertemuan10,
                         $pertemuan11,
                         $pertemuan12,
                         $pertemuan13,
                         $pertemuan14,
                         $jmlhadir,
                         $presentase,
                    ));

                    if ($induk1) {
                        $induk2 = $induk;
                        if ($induk2 == $induk1) {
                            $sheet->mergeCells('A'.($key+15).':A'.($key+16));
                            $sheet->mergeCells('B'.($key+15).':B'.($key+16));
                            $sheet->mergeCells('C'.($key+15).':C'.($key+16));
                            $no = $key+1;
                        }
                    }
                    $induk1 = $induk;

                    $sheet->cells('W'.($key+16), function($cells) use ($presentaseV) {
                        if($presentaseV <= 70) {
                            $cells->setFontColor('#FF0000');
                        }
                    });
                }
                        
                $sheet->cells('D8', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(16);
                });

                $sheet->cells('A10:A13', function($cells) {
                    $cells->setFontWeight('bold');
                });


                $sheet->setBorder('A14:W'.(count($studentSubjects) + 15), 'thin');

                $sheet->cells('A14:W'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A15:A'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('top');
                });
                $sheet->cells('B15:B'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('top');
                });
                // NAMA DOSEN
                $sheet->cells('C15:C'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('left');
                    $cells->setValignment('top');
                    $cells->setAlignment('left');
                    $cells->setAlignment('top');
                });
                // KODE MK
                $sheet->cells('D15:D'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('left');
                    $cells->setAlignment('left');
                });
                // MATAKULIAH
                $sheet->cells('E15:E'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('left');
                    $cells->setAlignment('left');
                });


        });
        })->export('xls');
    }


    /**
     * Excel format dosen detail
     */
    public function excelformatDosen($currentsemesterParams, $currentMatakuliah, $currentKelas, $katakunci)
    {
        $semesterString = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        Excel::create('LAPORAN SEMESTER DOSEN LAB', function($excel) use ($semesterString, $currentsemesterParams, $currentMatakuliah, $currentKelas, $katakunci) {
            $excel->sheet('LAPORAN SEMESTER DOSEN LAB', function($sheet) use($semesterString, $currentsemesterParams, $currentMatakuliah, $currentKelas, $katakunci) {
                $induk1 = array();
                $induk2 = array();
                $objDrawing = new PHPExcel_Worksheet_Drawing;
                $objDrawing->setPath(public_path('assets/images/img.png')); //your image path
                $objDrawing->setCoordinates('A1');
                $objDrawing->setWorksheet($sheet);

                if ($katakunci == 'detaildosen') {
                    $nikOrNim = 'NIM';
                    $roles = 'NAMA';
                    $studentSubjects = \DB::table('detail_kelas')
                            ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->join('users', 'detail_kelas.nim', '=', 'users.username')
                            ->select('jadwal_kelas.*', 'detail_kelas.nim', 'users.name')
                            ->orderBy('users.name', 'asc')
                            ->where('semester', $currentsemesterParams)
                            ->where('id_praktikum', $currentMatakuliah)
                            ->where('kelas', $currentKelas)
                            ->where('dosen_id', Auth::user()->username)
                            ->get();

                    $namadosen = \DB::table('detail_kelas')
                            ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->join('users', 'jadwal_kelas.dosen_id', '=', 'users.username')
                            ->select('jadwal_kelas.*', 'users.name')
                            ->orderBy('users.name', 'asc')
                            ->where('semester', $currentsemesterParams)
                            ->where('id_praktikum', $currentMatakuliah)
                            ->where('dosen_id', Auth::user()->username)
                            ->where('kelas', $currentKelas)
                            ->first();
                }


                $sheet->mergeCells('F14:S14');
                $sheet->mergeCells('A14:A15');
                $sheet->mergeCells('B14:B15');
                $sheet->mergeCells('C14:C15');
                $sheet->mergeCells('D14:D15');
                $sheet->mergeCells('E14:E15');
                $sheet->mergeCells('T14:T15');
                $sheet->mergeCells('U14:U15');

                $sheet->row(9, array(
                    'REKAPITULASI ABSENSI MAHASISWA SEMESTER GENAP TAHUN AKADEMIK '.substr($currentsemesterParams, 0, 4).'/'.(substr($currentsemesterParams, 0, 4)+1).'    ', '', '', ''
                ));
                $sheet->row(10, array(
                    'Kode/sks', '', $currentMatakuliah
                ));
                $sheet->row(11, array(
                    'Nama Matakuliah', '', ' '.Praktikum::find($currentMatakuliah)->nama.' '
                ));
                $sheet->row(12, array(
                    'Kelas', '', $currentKelas
                ));
                $sheet->row(13, array(
                    'Nama Dosen', '', $namadosen->name
                ));
                $sheet->row(14, array(
                    'NO',' '.$nikOrNim.' ',' '.$roles.' ', 'SKS', 'KELAS', 'MINGGU KE -', '', '', '', '', '', '', '', '','', '', '', '', '', 'JML HADIR', 'PRESENTASE'
                ));
                $sheet->row(15, array(
                    '', '', '', '', '', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'
                ));

                $sheet->setWidth(array(
                    'A'     =>  4,
                    'B'     =>  15,
                    'C'     =>  35,
                    'D'     =>  4,
                    'E'     =>  6,
                    'F'     =>  4,
                    'G'     =>  4,
                    'H'     =>  4,
                    'I'     =>  4,
                    'J'     =>  4,
                    'K'     =>  4,
                    'L'     =>  4,
                    'M'     =>  4,
                    'N'     =>  4,
                    'O'     =>  4,
                    'P'     =>  4,
                    'Q'     =>  4,
                    'R'     =>  4,
                    'S'     =>  4,
                    'T'     =>  10,
                    'U'     =>  12,
                ));

                $no = 1;
                $noinc = 1;
                foreach ($studentSubjects as $key => $value) {
                    if($katakunci == 'detaildosen') {
                        $pertemuan1 = $this->pertemuanSemuaMahasiswa($value, '1');
                        $pertemuan2 = $this->pertemuanSemuaMahasiswa($value, '2');
                        $pertemuan3 = $this->pertemuanSemuaMahasiswa($value, '3');
                        $pertemuan4 = $this->pertemuanSemuaMahasiswa($value, '4');
                        $pertemuan5 = $this->pertemuanSemuaMahasiswa($value, '5');
                        $pertemuan6 = $this->pertemuanSemuaMahasiswa($value, '6');
                        $pertemuan7 = $this->pertemuanSemuaMahasiswa($value, '7');
                        $pertemuan8 = $this->pertemuanSemuaMahasiswa($value, '8');
                        $pertemuan9 = $this->pertemuanSemuaMahasiswa($value, '9');
                        $pertemuan10 = $this->pertemuanSemuaMahasiswa($value, '10');
                        $pertemuan11 = $this->pertemuanSemuaMahasiswa($value, '11');
                        $pertemuan12 = $this->pertemuanSemuaMahasiswa($value, '12');
                        $pertemuan13 = $this->pertemuanSemuaMahasiswa($value, '13');
                        $pertemuan14 = $this->pertemuanSemuaMahasiswa($value, '14');
                        $presentase = round(($this->jumlahHadirSemuaMahasiswa($value)/14 * 100), 2). '%';
                        $presentaseV = round(($this->jumlahHadirSemuaMahasiswa($value)/14 * 100), 2);
                        $jmlhadir = $this->jumlahHadirSemuaMahasiswa($value);
                    }

                    if ($katakunci == 'detaildosen') {
                        $nama = User::where('username', $value->nim)->first();
                        $induk = $value->nim;
                    }
                    $praktikum = Praktikum::findOrFail($value->id_praktikum);
                    $matakuliah = Matakuliah::findOrFail($praktikum->id_matakuliah);
                    $sheet->row($key+16, array(
                         $key+1,
                         $induk, 
                         $nama->name, 
                         $matakuliah->sks, 
                         $value->kelas, 
                         $pertemuan1, 
                         $pertemuan2, 
                         $pertemuan3,   
                         $pertemuan4,
                         $pertemuan5,
                         $pertemuan6,
                         $pertemuan7,
                         $pertemuan8,
                         $pertemuan9,
                         $pertemuan10,
                         $pertemuan11,
                         $pertemuan12,
                         $pertemuan13,
                         $pertemuan14,
                         $jmlhadir,
                         $presentase
                    ));

                    if ($induk1) {
                        $induk2 = $induk;
                        $noinc = $key+1;
                        if ($induk2 == $induk1) {
                            $sheet->mergeCells('A'.($key+15).':A'.($key+16));
                            $sheet->mergeCells('B'.($key+15).':B'.($key+16));
                            $sheet->mergeCells('C'.($key+15).':C'.($key+16));
                            $no = $key+1;
                        }
                    }
                    $induk1 = $induk;

                    $sheet->row(count($studentSubjects)+16, array(
                        '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',' Jakarta, '.date('d').' '.$this->monthfilter(date('m')).' '.date('Y').' '
                    ));
                    $sheet->row(count($studentSubjects)+17, array(
                        '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Petugas'
                    ));
                    $sheet->row(count($studentSubjects)+21, array(
                        '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Bekti Riyanto'
                    ));
                    $sheet->cells('C'.($key+16), function($cells) use ($presentaseV) {
                        if($presentaseV <= 70) {
                            $cells->setFontColor('#FF0000');
                        }
                    });
                }
                        
                $sheet->cells('A9', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(16);
                });

                $sheet->setBorder('A14:U'.(count($studentSubjects) + 15), 'thin');

                $sheet->cells('A14:U'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A15:A'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('top');
                });
                $sheet->cells('B15:B'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('top');
                });
                // NAMA DOSEN
                $sheet->cells('C15:C'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('left');
                    $cells->setValignment('top');
                    $cells->setAlignment('left');
                    $cells->setAlignment('top');
                });

        });
        })->export('xls');
    }

    /**
     * Excel format dosen detail untuk admin
     */
    public function excelformatDosenDetail($currentsemesterParams, $currentDosen, $currentMatakuliah, $currentKelas, $katakunci)
    {
        $semesterString = (substr($currentsemesterParams, -1) == 1 ? 'GANJIL' : 'GENAP') .' '. substr($currentsemesterParams, 0, 4);
        Excel::create('LAPORAN SEMESTER DOSEN LAB', function($excel) use ($semesterString, $currentsemesterParams, $currentDosen, $currentMatakuliah,$currentKelas, $katakunci) {
            $excel->sheet('LAPORAN SEMESTER DOSEN LAB', function($sheet) use($semesterString, $currentsemesterParams, $currentDosen, $currentMatakuliah, $currentKelas, $katakunci) {
                $induk1 = array();
                $induk2 = array();
                $objDrawing = new PHPExcel_Worksheet_Drawing;
                $objDrawing->setPath(public_path('assets/images/img.png')); //your image path
                $objDrawing->setCoordinates('A1');
                $objDrawing->setWorksheet($sheet);

                if ($katakunci == 'semuadetaildosen') {
                    $nikOrNim = 'NIM';
                    $roles = 'NAMA';
                    $studentSubjects = \DB::table('detail_kelas')
                            ->join('jadwal_kelas', 'detail_kelas.id_jadwal_kelas', '=', 'jadwal_kelas.id_kelas')
                            ->join('users', 'detail_kelas.nim', '=', 'users.username')
                            ->select('jadwal_kelas.*', 'detail_kelas.nim', 'users.name')
                            ->orderBy('users.name', 'asc')
                            ->where('semester', $currentsemesterParams)
                            ->where('id_praktikum', $currentMatakuliah)
                            ->where('kelas', $currentKelas)
                            ->where('dosen_id', $currentDosen)
                            ->get();

                    $namadosen = \DB::table('users')
                            ->select('users.name')
                            ->where('username', $currentDosen)
                            ->first();
                }

                $sheet->mergeCells('F14:S14');
                $sheet->mergeCells('A14:A15');
                $sheet->mergeCells('B14:B15');
                $sheet->mergeCells('C14:C15');
                $sheet->mergeCells('D14:D15');
                $sheet->mergeCells('E14:E15');
                $sheet->mergeCells('T14:T15');
                $sheet->mergeCells('U14:U15');

                $sheet->row(9, array(
                    'REKAPITULASI ABSENSI MAHASISWA SEMESTER GENAP TAHUN AKADEMIK '.substr($currentsemesterParams, 0, 4).'/'.(substr($currentsemesterParams, 0, 4)+1).'    ', '', '', ''
                ));
                $sheet->row(10, array(
                    'Kode/sks', '', $currentMatakuliah
                ));
                $sheet->row(11, array(
                    'Nama Matakuliah', '', ''.Praktikum::find($currentMatakuliah)->nama.''
                ));
                $sheet->row(12, array(
                    'Kelas', '', $currentKelas
                ));
                $sheet->row(13, array(
                    'Nama Dosen', '', $namadosen->name
                ));
                $sheet->row(14, array(
                    'NO',' '.$nikOrNim.' ',' '.$roles.' ', 'SKS', 'KELAS', 'MINGGU KE -', '', '', '', '', '', '', '', '','', '', '', '', '', 'JML HADIR', 'PRESENTASE'
                ));
                $sheet->row(15, array(
                    '', '', '', '', '', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'
                ));

                $sheet->setWidth(array(
                    'A'     =>  4,
                    'B'     =>  15,
                    'C'     =>  35,
                    'D'     =>  4,
                    'E'     =>  6,
                    'F'     =>  4,
                    'G'     =>  4,
                    'H'     =>  4,
                    'I'     =>  4,
                    'J'     =>  4,
                    'K'     =>  4,
                    'L'     =>  4,
                    'M'     =>  4,
                    'N'     =>  4,
                    'O'     =>  4,
                    'P'     =>  4,
                    'Q'     =>  4,
                    'R'     =>  4,
                    'S'     =>  4,
                    'T'     =>  10,
                    'U'     =>  12,
                ));

                $no = 1;
                $noinc = 1;
                foreach ($studentSubjects as $key => $value) {
                    if($katakunci == 'semuadetaildosen') {
                        $pertemuan1 = $this->pertemuanSemuaMahasiswa($value, '1');
                        $pertemuan2 = $this->pertemuanSemuaMahasiswa($value, '2');
                        $pertemuan3 = $this->pertemuanSemuaMahasiswa($value, '3');
                        $pertemuan4 = $this->pertemuanSemuaMahasiswa($value, '4');
                        $pertemuan5 = $this->pertemuanSemuaMahasiswa($value, '5');
                        $pertemuan6 = $this->pertemuanSemuaMahasiswa($value, '6');
                        $pertemuan7 = $this->pertemuanSemuaMahasiswa($value, '7');
                        $pertemuan8 = $this->pertemuanSemuaMahasiswa($value, '8');
                        $pertemuan9 = $this->pertemuanSemuaMahasiswa($value, '9');
                        $pertemuan10 = $this->pertemuanSemuaMahasiswa($value, '10');
                        $pertemuan11 = $this->pertemuanSemuaMahasiswa($value, '11');
                        $pertemuan12 = $this->pertemuanSemuaMahasiswa($value, '12');
                        $pertemuan13 = $this->pertemuanSemuaMahasiswa($value, '13');
                        $pertemuan14 = $this->pertemuanSemuaMahasiswa($value, '14');
                        $presentase = round(($this->jumlahHadirSemuaMahasiswa($value)/14 * 100), 2). '%';
                        $presentaseV = round(($this->jumlahHadirSemuaMahasiswa($value)/14 * 100), 2);
                        $jmlhadir = $this->jumlahHadirSemuaMahasiswa($value);
                    }

                    if ($katakunci == 'semuadetaildosen') {
                        $nama = User::where('username', $value->nim)->first();
                        $induk = $value->nim;
                    }
                    $praktikum = Praktikum::findOrFail($value->id_praktikum);
                    $matakuliah = Matakuliah::findOrFail($praktikum->id_matakuliah);
                    $sheet->row($key+16, array(
                         $key+1,
                         $induk, 
                         $nama->name, 
                         $matakuliah->sks, 
                         $value->kelas, 
                         $pertemuan1, 
                         $pertemuan2, 
                         $pertemuan3,   
                         $pertemuan4,
                         $pertemuan5,
                         $pertemuan6,
                         $pertemuan7,
                         $pertemuan8,
                         $pertemuan9,
                         $pertemuan10,
                         $pertemuan11,
                         $pertemuan12,
                         $pertemuan13,
                         $pertemuan14,
                         $jmlhadir,
                         $presentase
                    ));

                    if ($induk1) {
                        $induk2 = $induk;
                        $noinc = $key+1;
                        if ($induk2 == $induk1) {
                            $sheet->mergeCells('A'.($key+15).':A'.($key+16));
                            $sheet->mergeCells('B'.($key+15).':B'.($key+16));
                            $sheet->mergeCells('C'.($key+15).':C'.($key+16));
                            $no = $key+1;
                        }
                    }
                    $induk1 = $induk;

                    $sheet->row(count($studentSubjects)+16, array(
                        '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',' Jakarta, '.date('d').' '.$this->monthfilter(date('m')).' '.date('Y').' '
                    ));
                    $sheet->row(count($studentSubjects)+17, array(
                        '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Petugas'
                    ));
                    $sheet->row(count($studentSubjects)+21, array(
                        '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Bekti Riyanto'
                    ));
                    $sheet->cells('C'.($key+16), function($cells) use ($presentaseV) {
                        if($presentaseV <= 70) {
                            $cells->setFontColor('#FF0000');
                        }
                    });
                }
                        
                $sheet->cells('A9', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(16);
                });

                $sheet->setBorder('A14:U'.(count($studentSubjects) + 15), 'thin');

                $sheet->cells('A14:U'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A15:A'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('top');
                });
                $sheet->cells('B15:B'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('top');
                });
                // NAMA DOSEN
                $sheet->cells('C15:C'.(count($studentSubjects) + 15), function($cells) {
                    $cells->setValignment('left');
                    $cells->setValignment('top');
                    $cells->setAlignment('left');
                    $cells->setAlignment('top');
                });

        });
        })->export('xls');
    }






    public function jumlahHadirSemuaDosen($studentSubjects)
    {
        $classes = \DB::table('presensidosenlab')
            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('keterangan', '<', '4')
            ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
            ->where('nik', $studentSubjects->dosen_id)
            ->count('keterangan');  
        if (!$classes) {
            return '0';
        }
        else {
            return $classes;
        }
    }

    public function monthfilter($month)
    {
        Switch ($month){
            case 1 : $month="Januari";
                Break;
            case 2 : $month="Februari";
                Break;
            case 3 : $month="Maret";
                Break;
            case 4 : $month="April";
                Break;
            case 5 : $month="Mei";
                Break;
            case 6 : $month="Juni";
                Break;
            case 7 : $month="Juli";
                Break;
            case 8 : $month="Agustus";
                Break;
            case 9 : $month="September";
                Break;
            case 10 : $month="Oktober";
                Break;
            case 11 : $month="November";
                Break;
            case 12 : $month="Desember";
                Break;
            }
        return $month;
    }

    public function pertemuanSemuaDosen($studentSubjects, $pertemuan)
    {
        $classes = \DB::table('presensidosenlab')
                ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                ->select('keterangan')
                ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
        $classes = \DB::table('presensilab')
            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('keterangan', '<', '4')
            ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
            ->where('nim', $studentSubjects->nim)
            ->count('keterangan');
        if ( !$classes ) {
            return '0';
        }
        else {
            return $classes;
        }
    }

    public function pertemuanSemuaMahasiswa($studentSubjects, $pertemuan)
    {
        $classes = \DB::table('presensilab')
            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
            ->where('nim', $studentSubjects->nim)
            ->where('pertemuan', $pertemuan)
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
        $classes = \DB::table('presensidosenlab')
            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('keterangan', '<', '4')
            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
            ->where('nik', Auth::user()->username)
            ->count('keterangan');  
        if (!$classes) {
            return '0';
        }
        else {
            return $classes;
        }   
    }

    public function pertemuanDosen($lecturerSchedules, $pertemuan)
    {
        $classes = \DB::table('presensidosenlab')
            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
            ->where('nik', Auth::user()->username)
            ->where('pertemuan', $pertemuan)
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
        $classes = \DB::table('presensilab')
            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
            ->where('keterangan', '<', '4')
            ->where('nim', Auth::user()->username)
            ->count('keterangan');  
        if ( !$classes ) {
            return '0';
        }
        else {
            return $classes;
        }
    }

    public function pertemuanMahasiswa($studentSubjects, $pertemuan)
    {
        $classes = \DB::table('presensilab')
            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
            ->where('nim', Auth::user()->username)
            ->where('pertemuan', $pertemuan)
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }

    public function jumlahHadirAsdos($lecturerSchedules)
    {
        $classes = \DB::table('presensiasdos')
            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('keterangan', '<', '4')
            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
            ->where('nim', Auth::user()->username)
            ->count('keterangan');  
        if (!$classes) {
            return '0';
        }
        else {
            return $classes;
        }
    }

    public function pertemuanAsdos($lecturerSchedules, $pertemuan)
    {
        $classes = \DB::table('presensiasdos')
            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
            ->where('nim', Auth::user()->username)
            ->where('pertemuan', $pertemuan)
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }


    public function jumlahHadirSemuaAsdos($studentSubjects)
    {
        $classes = \DB::table('presensiasdos')
            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('keterangan', '<', '4')
            ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
            ->where('nim', $studentSubjects->nim)
            ->count('keterangan');  
        if ( !$classes ) {
            return '0';
        }
        else {
            return $classes;
        }
    }

    public function pertemuanSemuaAsdos($lecturerSchedules, $pertemuan)
    {
        $classes = \DB::table('presensiasdos')
            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
            ->select('keterangan')
            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
            ->where('nim', $lecturerSchedules->nim)
            ->where('pertemuan', $pertemuan)
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }

}
