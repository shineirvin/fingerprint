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
use PHPExcel_Worksheet_Drawing;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function indexDosen($currentsemesterParams)
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

        return view('report.indexDosen', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function indexMahasiswa($currentsemesterParams)
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

        return view('report.indexMahasiswa', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
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

    public function reportMahasiswaData($semester)
    {
        $studentSubjects =  \DB::table('dpmk')
                    ->join('kelasmk', 'dpmk.kelasmk_id', '=', 'kelasmk.id')
                    ->select('kelasmk.*', 'dpmk.nim')
                    ->where('nim', Auth::user()->username)
                    ->where('semester', $semester)
                    ->get();
        $studentSubjects = collect($studentSubjects);
        return Datatables::of($studentSubjects)
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


    public function reportDosenData($semester)
    {
        $lecturerSchedules = Kelasmk::select('*')->where('dosen_id', Auth::user()->username)->where('semester', $semester)->get();
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





    /**
     * Report Excel Semua Dosen ( Admin )
     */
    public function reportAllDosenExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "SemuaDosen");
    }

    public function reportAllMahasiswaExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "SemuaMahasiswa");
    }

    public function reportDosenExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "dosen");
    }

    public function reportMahasiswaExcel($currentsemesterParams)
    {
        return $this->excelformat($currentsemesterParams, $katakunci = "mahasiswa");
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
                    $studentSubjects = \DB::table('kelasmk')
                                        ->join('users', 'kelasmk.dosen_id', '=', 'users.username')
                                        ->select('kelasmk.*')
                                        ->where('semester', $currentsemesterParams)
                                        ->orderBy('name', 'asc')
                                        ->get();
                }
                elseif ($katakunci == 'dosen') {
                    $nikOrNim = 'NIK';
                    $roles = 'NAMA DOSEN';
                    $studentSubjects = \DB::table('kelasmk')
                                        ->join('users', 'kelasmk.dosen_id', '=', 'users.username')
                                        ->select('kelasmk.*')
                                        ->where('dosen_id', Auth::user()->username)
                                        ->where('semester', $currentsemesterParams)
                                        ->orderBy('name', 'asc')
                                        ->get();
                }
                elseif ($katakunci == 'SemuaMahasiswa') {
                    $nikOrNim = 'NIM';
                    $roles = 'NAMA MAHASISWA';
                    $studentSubjects = \DB::table('dpmk')
                            ->join('kelasmk', 'dpmk.kelasmk_id', '=', 'kelasmk.id')
                            ->join('users', 'dpmk.nim', '=', 'users.username')
                            ->select('kelasmk.*', 'dpmk.nim', 'users.name')
                            ->orderBy('users.name', 'asc')
                            ->where('semester', $currentsemesterParams)
                            ->get();
                }
                elseif ($katakunci == 'mahasiswa') {
                    $nikOrNim = 'NIM';
                    $roles = 'NAMA MAHASISWA';
                    $studentSubjects = \DB::table('dpmk')
                            ->join('kelasmk', 'dpmk.kelasmk_id', '=', 'kelasmk.id')
                            ->join('users', 'dpmk.nim', '=', 'users.username')
                            ->select('kelasmk.*', 'dpmk.nim', 'users.name')
                            ->where('nim', Auth::user()->username)
                            ->orderBy('users.name', 'asc')
                            ->where('semester', $currentsemesterParams)
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
                    'NO',' '.$nikOrNim.' ',' '.$roles.' ', 'KODE MK', 'NAMA MATAKULIAH', 'SKS', 'KELAS', 'MINGGU KE -', '', '', '', '', '', '', '', '', '', '', '', '', '', 'JML HADIR'
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
                    }

                    if ($katakunci == 'SemuaDosen' || $katakunci == 'dosen') {
                        $nama = User::where('username', $value->dosen_id)->first();
                        $induk = $value->dosen_id;
                    }
                    elseif ($katakunci == 'SemuaMahasiswa' || $katakunci == 'mahasiswa') {
                        $nama = User::where('username', $value->nim)->first();
                        $induk = $value->nim;
                    }
                    $matakuliah = Matakuliah::findOrFail($value->matakuliah_id);
                    $sheet->row($key+16, array(
                         $no,
                         $induk, 
                         $nama->name, 
                         $value->matakuliah_id, 
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
                         $jmlhadir
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
                }
                        
                $sheet->cells('D8', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(16);
                });

                $sheet->cells('A10:A13', function($cells) {
                    $cells->setFontWeight('bold');
                });


                $sheet->setBorder('A14:V'.(count($studentSubjects) + 15), 'thin');

                $sheet->cells('A14:V'.(count($studentSubjects) + 15), function($cells) {
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


    public function jumlahHadirSemuaDosen($studentSubjects)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('keterangan', '1')
            ->where('kelasmk_id', $studentSubjects->id)
            ->where('nik', $studentSubjects->dosen_id)
            ->count('keterangan');  
        if (!$classes) {
            return '0';
        } else {
            if ($classes >= 14) {
                return '14';
            }
            return $classes;
        }
    }










    public function pertemuanMahasiswa($studentSubjects, $pertemuan)
    {
        $classes = \DB::table('presensikelas')
                    ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
                    ->select('keterangan')
                    ->where('kelasmk_id', $studentSubjects->id)
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
        $classes = \DB::table('presensikelas')
            ->join('kelasmk', 'presensikelas.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('keterangan', '1')
            ->where('kelasmk_id', $studentSubjects->id)
            ->where('nim', Auth::user()->username)
            ->count('keterangan');  
        if ( !$classes ) {
            return '0';
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
            return '0';
        }
        else {
            return $classes;
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
            return '0';
        }
        else {
            return $classes;
        }
    }

    public function pertemuanSemuaMahasiswa($studentSubjects, $pertemuan)
    {
        $classes = \DB::table('presensikelas')
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
