<?php

namespace App\Http\Controllers;

use App\Hari;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\KelasPenggantiRequest;
use App\Jenisruang;
use App\Kelasmk;
use App\Kelaspengganti;
use App\Matakuliah;
use App\Ruang;
use App\User;
use Carbon\Carbon;
use PHPExcel_Worksheet_Drawing;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function changepassdosen_index()
    {
    	return view('admin.cpdosen');
    }

    public function changepassmahasiswa_index()
    {
    	return view('admin.cpmahasiswa');
    }

    public function changepassadmin_index()
    {
        return view('admin.cpadmin');
    }

    public function registeradmin()
    {
        return view('admin.registeradmin');
    }

    public function registerdosen()
    {
        return view('admin.registerdosen');
    }

    public function registermahasiswa()
    {
        return view('admin.registermahasiswa');
    }

    public function changepassdosenData()
    {
    	$dosen = User::select('*')->where('roles', 'Dosen')->get();
        return Datatables::of($dosen)
        	->addColumn('action', function ($dosen) {
                return '<button class="btn btn-warning open-modal" data-toggle="modal" value="'.$dosen->id.'" aria-hidden="true"><i class="fa fa-edit"></i> Edit</button>';
            })
            ->make(true);   
    }

    public function changepassmahasiswaData()
    {
    	$mahasiswa = User::select('*')->where('roles', 'Mahasiswa')->get();
    	return Datatables::of($mahasiswa)
        	->addColumn('action', function ($mahasiswa) {
                return '<button class="btn btn-warning open-modal" data-toggle="modal" value="'.$mahasiswa->id.'" aria-hidden="true"><i class="fa fa-edit"></i> Edit</button>';
            })
            ->make(true);   
    }

    public function changepassadminData()
    {
        $admin = User::select('*')->where('roles', 'Admin')->get();
        return Datatables::of($admin)
            ->addColumn('action', function ($admin) {
                return '<button class="btn btn-warning open-modal" data-toggle="modal" value="'.$admin->id.'" aria-hidden="true"><i class="fa fa-edit"></i> Edit</button>';
            })
            ->make(true);   
    }


    public function getDosenData($dosen_id)
    {
    	return response()->json(User::select('*')->where('roles', 'Dosen')->where('id', $dosen_id)->first());
    }

    public function getMahasiswaData($mahasiswa_id)
    {
    	return response()->json(User::select('*')->where('roles', 'Mahasiswa')->where('id', $mahasiswa_id)->first());
    }

    public function getAdminData($admin_id)
    {
        return response()->json(User::select('*')->where('roles', 'Admin')->where('id', $admin_id)->first());
    }

    public function newpassdosen(Request $request)
    {
    	$user = User::find($request->id);
    	$user->password = Hash::make($request->password);
    	$user->save();
        flash()->success('Success!', 'Berhasil daftar dosen baru!');

    	return redirect('changepassdosen');
    }

    public function newpassmahasiswa(Request $request)
    {
    	$user = User::find($request->id);
    	$user->password = Hash::make($request->password);
    	$user->save();
        flash()->success('Success!', 'Berhasil daftar mahasiswa baru!');

    	return redirect('changepassmahasiswa');
    }

    public function newpassAdmin(Request $request)
    {
    	$user = User::find($request->id);
    	$user->password = Hash::make($request->password);
    	$user->save();
        flash()->success('Success!', 'Berhasil daftar dosen baru!');

    	return redirect('changepassadmin');
    }

    public function validate_index($currentsemesterParams)
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

        return view('admin.attindex', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function getDataJadwalDosenAll($semester)
    {
        $lecturerSchedules = Kelasmk::select('*')->where('semester', $semester)->get();
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="../presensi/'.$lecturerSchedules->id.'/0" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
            })
            ->editColumn('semester', function ($lecturerSchedules) {
                return strtoupper($lecturerSchedules->semester);
            })
            ->editColumn('hari_name', function ($lecturerSchedules) {
                $hari = Hari::findOrFail($lecturerSchedules->hari_id);
                return $hari->namahari;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $nama = User::where('username', $lecturerSchedules->dosen_id)->first();
                return $nama->name;
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


    public function kelaspengganti_index()
    {
        return view('admin.kelaspengganti.index');
    }

    public function getDataKelaspengganti()
    {
        $lecturerSchedules = Kelaspengganti::select('*')->where('status', '1')->get();
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="kelaspenggantiData/'.$lecturerSchedules->kelasmk_id.'/edit" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit </a> <a href="kelaspenggantiDataDelete/'.$lecturerSchedules->id.'" class="btn btn-danger"><i class="fa fa-trash"></i> Delete </a>';
            })
            ->editColumn('status', function ($lecturerSchedules) {
                return ($lecturerSchedules->status == '1' ? 'Active' : 'Non Active');
            })
            ->editColumn('semester', function ($lecturerSchedules) {
                $kelasmk = Kelasmk::find($lecturerSchedules->kelasmk_id);
                return strtoupper($kelasmk->semester);
            })
            ->editColumn('hari_name', function ($lecturerSchedules) {
                $hari = Hari::findOrFail($lecturerSchedules->hari_id);
                return $hari->namahari;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $kelasmk = Kelasmk::find($lecturerSchedules->kelasmk_id);
                $nama = User::where('username', $kelasmk->dosen_id)->first();
                return $nama->name;
            })
            ->editColumn('nim', function ($lecturerSchedules) {
                $kelasmk = Kelasmk::find($lecturerSchedules->kelasmk_id);
                return $kelasmk->dosen_id;
            })
            ->editColumn('matakuliah_id', function ($lecturerSchedules) {
                $kelasmk = Kelasmk::find($lecturerSchedules->kelasmk_id);
                $hari = Matakuliah::findOrFail($kelasmk->matakuliah_id);
                return $hari->nama_matakuliah;
            })
            ->editColumn('ruang_id', function ($lecturerSchedules) {
                $ruang = Ruang::findOrFail($lecturerSchedules->ruang_id);
                return $ruang->nama_ruang;
            })
            ->editColumn('kelas', function ($lecturerSchedules) {
                $kelasmk = Kelasmk::find($lecturerSchedules->kelasmk_id);
                return $kelasmk->kelas;
            })
            ->make(true);   
    }


    public function registerkelaspengganti($id)
    {
        $kelasmk = Kelasmk::find($id);
        return view('admin/kelaspengganti.create', compact('kelasmk'));
    }

    public function store_kelaspengganti(Request $request)
    {
        $kelaspengganti = new Kelaspengganti;
        $kelaspengganti->kelasmk_id = $request->input('kelasmk_id');
        $kelaspengganti->waktu = $request->input('waktu');
        $kelaspengganti->hari_id = $request->input('hari_id');
        $kelaspengganti->ruang_id = $request->input('ruang_id');
        $kelaspengganti->status = $request->input('recstatus');
        $kelaspengganti->save();

        return redirect('kelaspenggantiDataView');
    }

    public function edit_kelaspengganti($id)
    {
        $kelasmk = Kelasmk::find($id);
        $kelaspengganti = Kelaspengganti::where('kelasmk_id', $id)->first();
        return view('admin/kelaspengganti.edit', compact('kelaspengganti', 'kelasmk'));
    }

    public function update_kelaspengganti($id, KelasPenggantiRequest $request)
    {
        $kelaspengganti = Kelaspengganti::findOrFail($id);
        $kelaspengganti->update($request->All());
        flash()->success('Success!', 'Kelas pengganti berhasil diupdate!');
        return redirect('kelaspenggantiDataView');
    }

    public function destroy_kelaspengganti($id)
    {
        $kelaspengganti = Kelaspengganti::findOrFail($id);
        $kelaspengganti->status = '0';
        $kelaspengganti->save();
        flash()->success('Success!', 'Kelas pengganti berhasil dihapus!');
        return redirect('kelaspenggantiDataView');
    }

    public function listkelasmk()
    {
        return view('admin/kelaspengganti.listkelasmk');
    }

    public function getDataListKelasmk()
    {
        $kelaspengganti = Kelaspengganti::select('kelasmk_id')->get();

        $lecturerSchedules = \DB::table('kelasmk')
                                  ->select('*')
                                  ->whereNotIn('id', $kelaspengganti)
                                  ->get();
        $lecturerSchedules = collect($lecturerSchedules);
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="kelaspenggantiData/'.$lecturerSchedules->id.'" class="btn btn-warning"><i class="fa fa-pencil"></i> Kelola KP </a>';
            })
            ->editColumn('recstatus', function ($lecturerSchedules) {
                return ($lecturerSchedules->recstatus == '1' ? 'Active' : 'Non Active');
            })
            ->editColumn('semester', function ($lecturerSchedules) {
                return strtoupper($lecturerSchedules->semester);
            })
            ->editColumn('hari_name', function ($lecturerSchedules) {
                $hari = Hari::findOrFail($lecturerSchedules->hari_id);
                return $hari->namahari;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $nama = User::where('username', $lecturerSchedules->dosen_id)->first();
                return $nama->name;
            })
            ->editColumn('nim', function ($lecturerSchedules) {
                return $lecturerSchedules->dosen_id;
            })
            ->editColumn('matakuliah_id', function ($lecturerSchedules) {
                $matakuliah = Matakuliah::findOrFail($lecturerSchedules->matakuliah_id);
                return $matakuliah->nama_matakuliah;
            })
            ->editColumn('ruang_id', function ($lecturerSchedules) {
                $ruang = Ruang::findOrFail($lecturerSchedules->ruang_id);
                return $ruang->nama_ruang;
            })
            ->editColumn('kelas', function ($lecturerSchedules) {
                return $lecturerSchedules->kelas;
            })
            ->make(true);   
    }


    public function reportBulananDetail_index($datestart, $dateend)
    {       
        $startday = substr($datestart, 0, 2);
        $startmonth = substr($datestart, 2, 2);
        $startyear = substr($datestart, 4);
        $start = $startday . '-' . $startmonth . '-' . $startyear;
        $endday = substr($dateend, 0, 2);
        $endmonth = substr($dateend, 2, 2);
        $endyear = substr($dateend, 4);
        $end = $endday . '-' . $endmonth . '-' . $endyear;
        return view('admin.reportbulanan.indexdetail', compact('datestart', 'dateend', 'start', 'end'));
    }

    public function monthlyreportexcel($datestart, $dateend)
    {
        $startday = substr($datestart, 0, 2);
        $startmonth = substr($datestart, 2, 2);
        $startyear = substr($datestart, 4);
        $start = $startyear . '-' . $startmonth . '-' . $startday;
        $startFormat = $startday . '-' . $this->monthfilter($startmonth) . '-' . $startyear;
        if ($startmonth < 6) {
            $semesterString = 'GANJIL';
        }
        else {
            $semesterString = 'GENAP';
        }

        $endday = substr($dateend, 0, 2);
        $endmonth = substr($dateend, 2, 2);
        $endyear = substr($dateend, 4);
        $end = $endyear . '-' . $endmonth . '-' . $endday;
        $endFormat = $endday . '-' . $this->monthfilter($endmonth) . '-' . $endyear;
        $endmin1 = Carbon::create($endyear, $endmonth, $endday, 0);

        Excel::create('LAPORAN BULANAN', function($excel) use ($start, $end, $startFormat, $endFormat, $semesterString) { 
            $excel->sheet('LAPORAN BULANAN', function($sheet) use($start, $end, $startFormat, $endFormat, $semesterString) {
                $dosen_id = array();
                $dosen_id2 = array();
                $objDrawing = new PHPExcel_Worksheet_Drawing;
                $objDrawing->setPath(public_path('assets/images/img.png')); //your image path
                $objDrawing->setCoordinates('A1');
                $objDrawing->setWorksheet($sheet);

                $studentSubjects = \DB::table('kelasmk')
                                    ->join('users', 'kelasmk.dosen_id', '=', 'users.username')
                                    ->select('kelasmk.*')
                                    ->orderBy('name', 'asc')
                                    ->get();
                $semester = \DB::table('kelasmk')
                                    ->join('users', 'kelasmk.dosen_id', '=', 'users.username')
                                    ->select('kelasmk.*')
                                    ->orderBy('name', 'asc')
                                    ->first();

                $sheet->mergeCells('H14:K14');
                $sheet->mergeCells('A14:A15');
                $sheet->mergeCells('B14:B15');
                $sheet->mergeCells('C14:C15');
                $sheet->mergeCells('D14:D15');
                $sheet->mergeCells('E14:E15');
                $sheet->mergeCells('F14:F15');
                $sheet->mergeCells('G14:G15');
                $sheet->mergeCells('L14:L15');
                $sheet->mergeCells('M14:M15');

                $sheet->row(8, array(
                    '', '', '', 'LAPORAN BULANAN'
                ));
                $sheet->row(10, array(
                    'PROGRAM STUDI TEKNIK INFORMATIKA'
                ));
                $sheet->row(11, array(
                    'DAFTAR KEHADIRAN DOSEN SEMESTER '.$semesterString.' TAHUN AKADEMIK '.substr($semester->semester, 0, 4).' / '.(substr($semester->semester, 0, 4) + 1).' '
                ));
                $sheet->row(12, array(
                    'FAKULTAS TEKNOLOGI INFORMASI UNIVERSITAS TARUMANAGARA'
                ));
                $sheet->row(13, array(
                    '(Tanggal '. $startFormat .' - '. $endFormat .')'
                ));

                $sheet->row(14, array(
                    'NO','NIK','NAMA DOSEN', 'KODE MK', 'NAMA MATAKULIAH', 'SKS', 'KELAS', 'MINGGU KE -', '', '', '', 'JML HADIR', 'PRESENTASE'
                ));
                $sheet->row(15, array(
                    '', '', '', '', '', '', '', '1', '2', '3', '4',
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
                    'L'     =>  10,
                    'M'     =>  12,

                ));

                $no = 1;
                foreach ($studentSubjects as $key => $value) {

                    $pertemuan1 = $this->pertemuan($value->id, '1', $start, $end);
                    $pertemuan2 = $this->pertemuan($value->id, '2', $start, $end);
                    $pertemuan3 = $this->pertemuan($value->id, '3', $start, $end);
                    $pertemuan4 = $this->pertemuan($value->id, '4', $start, $end);
                    $presentase = round(($this->JmlHadirDosen($value->id, $value->dosen_id, $start, $end)/14 * 100), 2). '%';
                    $jmlhadir = $this->JmlHadirDosen($value->id, $value->dosen_id, $start, $end);

                    $matakuliah = Matakuliah::findOrFail($value->matakuliah_id);
                    $LecturerNames = User::select('name')->where('username', $value->dosen_id)->first();
                    $sheet->row($key+16, array(
                         $no,
                         $value->dosen_id, 
                         $LecturerNames->name, 
                         $value->matakuliah_id, 
                         $matakuliah->nama_matakuliah, 
                         $matakuliah->sks, 
                         $value->kelas, 
                         $pertemuan1, 
                         $pertemuan2, 
                         $pertemuan3,   
                         $pertemuan4, 
                         $jmlhadir,
                         $presentase
                    ));

                    if ($dosen_id) {
                        $dosen_id2 = $value->dosen_id;
                        if ($dosen_id2 == $dosen_id) {
                            $sheet->mergeCells('A'.($key+15).':A'.($key+16));
                            $sheet->mergeCells('B'.($key+15).':B'.($key+16));
                            $sheet->mergeCells('C'.($key+15).':C'.($key+16));
                            $no = $key+1;
                        }
                    }
                    $dosen_id = $value->dosen_id;

                    $sheet->row(count($studentSubjects)+16, array(
                        ' Jakarta, '.date('d').' '.$this->monthfilter(date('m')).' '.date('Y').' '
                    ));
                    $sheet->row(count($studentSubjects)+17, array(
                        'Mengetahui', '', '', '', '', '', 'Petugas'
                    ));
                    $sheet->row(count($studentSubjects)+18, array(
                        'Kasubag Akademik & Perkuliahan'
                    ));
                    $sheet->row(count($studentSubjects)+21, array(
                        'Dra. Dindin SR', '', '', '', '', '', 'Bekti R'
                    ));
                }
                        
                $sheet->cells('D8', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(16);
                });

                $sheet->cells('A10:A13', function($cells) {
                    $cells->setFontWeight('bold');
                });


                $sheet->setBorder('A14:M'.(count($studentSubjects) + 15), 'thin');
                // NO
                $sheet->cells('A14:M'.(count($studentSubjects) + 15), function($cells) {
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

    public function pertemuan($kelasmk_id, $pertemuan, $start, $end)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('presensidosen.waktu', '>=', $start)
            ->where('presensidosen.waktu', '<=', $end)
            ->where('kelasmk_id', $kelasmk_id)
            ->where('pertemuan', $pertemuan)
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }

    public function JmlHadirDosen($kelasmk_id, $dosen_id, $start, $end)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('presensidosen.waktu', '>=', $start)
            ->where('presensidosen.waktu', '<=', $end)
            ->where('keterangan', '1')
            ->where('kelasmk_id', $kelasmk_id)
            ->where('NIK', $dosen_id)
            ->count('keterangan');  
        if (!$classes) {
            return '0';
        }
        else {
            if ($classes >= 4) {
                return '4';
            }
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


    /**
     * Monthly Report for Lecturer
     */
    public function reportBulanan_index()
    {
        return view('admin/reportbulanan.index');
    }

    public function getDataReportBulanan($datestart, $dateend)
    {
        $startday = substr($datestart, 0, 2);
        $startmonth = substr($datestart, 2, 2);
        $startyear = substr($datestart, 4);
        $start = $startyear . '-' . $startmonth . '-' . $startday;

        $endday = substr($dateend, 0, 2);
        $endmonth = substr($dateend, 2, 2);
        $endyear = substr($dateend, 4);
        $end = $endyear . '-' . $endmonth . '-' . $endday;
        $endmin1 = Carbon::create($endyear, $endmonth, $endday, 0);

        $lecturerSchedules = \DB::table('kelasmk')
                            ->join('users', 'kelasmk.dosen_id', '=', 'users.username')
                            ->select('kelasmk.*')
                            ->orderBy('name', 'asc')
                            ->get();
        $lecturerSchedules = collect($lecturerSchedules);

        return Datatables::of($lecturerSchedules)
            ->editColumn('nama_dosen', function ($lecturerSchedules) {
                $LecturerNames = User::select('name')->where('username', $lecturerSchedules->dosen_id)->first();
                return $LecturerNames->name;
            })
            ->editColumn('nama_matakuliah', function ($lecturerSchedules) {
                $Matakuliah = Matakuliah::findOrFail($lecturerSchedules->matakuliah_id);
                return $Matakuliah->nama_matakuliah;
            })
            ->editColumn('matakuliah_id', function ($lecturerSchedules) {
                return $lecturerSchedules->matakuliah_id;
            })
            ->editColumn('kelas', function ($lecturerSchedules) {
                return $lecturerSchedules->kelas;
            })
            ->editColumn('sks', function ($lecturerSchedules) {
                $sks = Matakuliah::findOrFail($lecturerSchedules->matakuliah_id);
                return $sks->sks;
            })
            ->editColumn('jml_hadir', function ($lecturerSchedules) use($start, $end) {
                return $this->jumlahHadirDosenBulanan($lecturerSchedules, $start, $end);
            })
            ->editColumn('1', function ($lecturerSchedules) use($start, $end) {
                return $this->pertemuanDosenBulanan($lecturerSchedules, $start, $end, '1');
            })
            ->editColumn('2', function ($lecturerSchedules) use($start, $end) {
                return $this->pertemuanDosenBulanan($lecturerSchedules, $start, $end, '2');
            })
            ->editColumn('3', function ($lecturerSchedules) use($start, $end) {
                return $this->pertemuanDosenBulanan($lecturerSchedules, $start, $end, '3');
            })
            ->editColumn('4', function ($lecturerSchedules) use($start, $end) {
                return $this->pertemuanDosenBulanan($lecturerSchedules, $start, $end, '4');
            })
            ->editColumn('presentase', function ($lecturerSchedules) use($start, $end) {
                $presentase = round(($this->jumlahHadirDosenBulanan($lecturerSchedules, $start, $end)/14 * 100), 2). '%';
                return $presentase;
            })
            ->make(true);     
    }


    public function jumlahHadirDosenBulanan($lecturerSchedules, $start, $end)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('presensidosen.waktu', '>=', $start)
            ->where('presensidosen.waktu', '<=', $end)
            ->where('keterangan', '1')
            ->where('kelasmk_id', $lecturerSchedules->id)
            ->where('nik', $lecturerSchedules->dosen_id)
            ->count('pertemuan');  
        if (!$classes) {
            return '0';
        }
        else {
            if ($classes >= 4) {
                return '4';
            }
            return $classes;
        }
    }

    public function pertemuanDosenBulanan($lecturerSchedules, $start, $end, $pertemuan)
    {
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan')
            ->where('presensidosen.waktu', '>=', $start)
            ->where('presensidosen.waktu', '<=', $end)
            ->where('kelasmk_id', $lecturerSchedules->id)
            ->where('nik', $lecturerSchedules->dosen_id)
            ->where('pertemuan', '1')
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }
}
