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

use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportLabController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function indexDosen()
    {
    	return view('reportlab.indexDosen');
    }

    public function indexMahasiswa()
    {
        return view('reportlab.indexMahasiswa');
    }

    public function indexAsdos()
    {
        return view('reportlab.indexAsdos');
    }

    public function indexAdmin()
    {
        return view('reportlab.indexAdmin');
    }

    public function indexAdminLab($currentsemesterParams)
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

        return view('report.indexAdminLab', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function indexMhsLabAdmin($currentsemesterParams)
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
            ->editColumn('0', function ($studentSubjects) {
                return '';
            })
            ->editColumn('jml_hadir', function ($studentSubjects) {
                $classes = \DB::table('presensidosenlab')
                    ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                    ->select('keterangan')
                    ->where('keterangan', '1')
                    ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
                    ->where('nik', $studentSubjects->dosen_id)
                    ->count('pertemuan');  
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes;
                }
            })
            ->editColumn('1', function ($studentSubjects) {
                $classes = \DB::table('presensidosenlab')
                        ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                        ->select('keterangan')
                        ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensidosenlab')
                        ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                        ->select('keterangan')
                        ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensidosenlab')
                        ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                        ->select('keterangan')
                        ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensidosenlab')
                        ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                        ->select('keterangan')
                        ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensidosenlab')
                        ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                        ->select('keterangan')
                        ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensidosenlab')
                        ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                        ->select('keterangan')
                        ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensidosenlab')
                        ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                        ->select('keterangan')
                        ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensidosenlab')
                        ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                        ->select('keterangan')
                        ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $studentSubjects = User::select('name')->where('username', $studentSubjects->nim)->first();
                return $studentSubjects->name;
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
            ->editColumn('0', function ($studentSubjects) {
                return '';
            })
            ->editColumn('jml_hadir', function ($studentSubjects) {
                $classes = \DB::table('presensilab')
                    ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                    ->select('keterangan')
                    ->where('keterangan', '1')
                    ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
                    ->where('nim', $studentSubjects->nim)
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
                $classes = \DB::table('presensilab')
                    ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                    ->select('keterangan')
                    ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensilab')
                    ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                    ->select('keterangan')
                    ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensilab')
                    ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                    ->select('keterangan')
                    ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensilab')
                    ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                    ->select('keterangan')
                    ->where('jadwal_kelas_id', $studentSubjects->id_kelas)
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
                $classes = \DB::table('presensilab')
                    ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                    ->select('keterangan')
                    ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
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
                $classes = \DB::table('presensilab')
                    ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
                    ->select('keterangan')
                    ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
                    ->where('pertemuan', '6')
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
        $lecturerSchedules = Jadwalkelas::select('*')->where('dosen_id', Auth::user()->username)->get();
        return Datatables::of($lecturerSchedules)
            ->editColumn('id_matakuliah', function ($lecturerSchedules) {
                $Matakuliah = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                return $Matakuliah->id_matakuliah;
            })
            ->editColumn('nama_matakuliah', function ($lecturerSchedules) {
                $Matakuliah = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                return $Matakuliah->nama;
            })
            ->editColumn('sks', function ($lecturerSchedules) {
            	$Matakuliah = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                $sks = Matakuliah::findOrFail($Matakuliah->id_matakuliah);
                return $sks->sks;
            })
            ->editColumn('0', function ($studentSubjects) {
                return '';
            })
            ->editColumn('jml_hadir', function ($lecturerSchedules) {
            	$classes = \DB::table('presensidosenlab')
		            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('keterangan', '1')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
		            ->where('nik', Auth::user()->username)
		            ->count('keterangan'); 	
		        if (!$classes) {
		        	return '';
		        }
		        else {
                	return $classes;
		        }
            })
            ->editColumn('1', function ($lecturerSchedules) {
            	$classes = \DB::table('presensidosenlab')
		            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
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
            	$classes = \DB::table('presensidosenlab')
		            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
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
            	$classes = \DB::table('presensidosenlab')
		            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
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
            	$classes = \DB::table('presensidosenlab')
		            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
                    ->where('pertemuan', '4')
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

    public function reportMahasiswaData()
    {
    	$studentSubjects = Detailkelas::select('*')->where('nim', Auth::user()->username)->get();
        return Datatables::of($studentSubjects)
            ->editColumn('nama_matakuliah', function ($studentSubjects) {
            	$jadwalkelas = Jadwalkelas::find($studentSubjects->id_jadwal_kelas);
                $matakuliah = Praktikum::findOrFail($jadwalkelas->id_praktikum);
                return $matakuliah->nama;
            })
            ->editColumn('matakuliah_id', function ($studentSubjects) {
            	$jadwalkelas = Jadwalkelas::find($studentSubjects->id_jadwal_kelas);
                $matakuliah = Praktikum::findOrFail($jadwalkelas->id_praktikum);
                return $matakuliah->id_matakuliah;
            })
            ->editColumn('kelas', function ($studentSubjects) {
            	$jadwalkelas = Jadwalkelas::find($studentSubjects->id_jadwal_kelas);
                return $jadwalkelas->kelas;
            })
            ->editColumn('sks', function ($studentSubjects) {
            	$jadwalkelas = Jadwalkelas::find($studentSubjects->id_jadwal_kelas);
                $praktikum = Praktikum::findOrFail($jadwalkelas->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
                return $sks->sks;
            })
            ->editColumn('jml_hadir', function ($studentSubjects) {
            	$classes = \DB::table('presensilab')
		            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
		            ->where('keterangan', '1')
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
            	$classes = \DB::table('presensilab')
		            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
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
            	$classes = \DB::table('presensilab')
		            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
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
            	$classes = \DB::table('presensilab')
		            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
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
            	$classes = \DB::table('presensilab')
		            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
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
            	$classes = \DB::table('presensilab')
		            ->join('jadwal_kelas', 'presensilab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $studentSubjects->id_jadwal_kelas)
		            ->where('pertemuan', '5')
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
            	$classes = \DB::table('presensidosenlab')
		            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('keterangan', '1')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id)
                    ->where('nik', $studentSubjects->dosen_id)
                    ->count('keterangan');  
                if (!$classes) {
                    return '';
                }
                else {
                    return $classes;
                }
            })
            ->editColumn('1', function ($studentSubjects) {
            	$classes = \DB::table('presensidosenlab')
		            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id)
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
            	$classes = \DB::table('presensidosenlab')
		            ->join('jadwal_kelas', 'presensidosenlab.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id)
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

    public function reportAsdosData() {
    	$lecturerSchedules = Asistenkelas::select('*')->where('nim', Auth::user()->username)->get();
        return Datatables::of($lecturerSchedules)
            ->editColumn('id_matakuliah', function ($lecturerSchedules) {
            	$Matakuliah = Jadwalkelas::find($lecturerSchedules->id_kelas);
                $praktikum = Praktikum::find($Matakuliah->id_praktikum);
                return $praktikum->id_matakuliah;
            })
            ->editColumn('nama_matakuliah', function ($lecturerSchedules) {
            	$Matakuliah = Jadwalkelas::find($lecturerSchedules->id_kelas);
                $praktikum = Praktikum::findOrFail($Matakuliah->id_praktikum);
                return $praktikum->nama;
            })
            ->editColumn('sks', function ($lecturerSchedules) {
            	$Matakuliah = Jadwalkelas::find($lecturerSchedules->id_kelas);
            	$praktikum = Praktikum::findOrFail($Matakuliah->id_praktikum);
                $sks = Matakuliah::findOrFail($praktikum->id_matakuliah);
                return $sks->sks;
            })
            ->editColumn('kelas', function ($lecturerSchedules) {
            	$kelas = Jadwalkelas::find($lecturerSchedules->id_kelas);
                return $kelas->kelas;
            })
            ->editColumn('0', function ($studentSubjects) {
                return '';
            })
            ->editColumn('jml_hadir', function ($lecturerSchedules) {
            	$classes = \DB::table('presensiasdos')
		            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('keterangan', '1')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
		            ->where('nim', Auth::user()->username)
		            ->count('keterangan'); 	
		        if (!$classes) {
		        	return '';
		        }
		        else {
                	return $classes;
		        }
            })
            ->editColumn('1', function ($lecturerSchedules) {
            	$classes = \DB::table('presensiasdos')
		            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
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
            	$classes = \DB::table('presensiasdos')
		            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
		            ->where('nim', Auth::user()->username)
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
            	$classes = \DB::table('presensiasdos')
		            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
		            ->where('nim', Auth::user()->username)
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
            	$classes = \DB::table('presensiasdos')
		            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
		            ->where('nim', Auth::user()->username)
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
            	$classes = \DB::table('presensiasdos')
		            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
		            ->where('nim', Auth::user()->username)
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
            	$classes = \DB::table('presensiasdos')
		            ->join('jadwal_kelas', 'presensiasdos.jadwal_kelas_id', '=', 'jadwal_kelas.id_kelas')
		            ->select('keterangan')
		            ->where('jadwal_kelas_id', $lecturerSchedules->id_kelas)
		            ->where('nim', Auth::user()->username)
                    ->where('pertemuan', '6')
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
