<?php

namespace App\Http\Controllers;

use App\Hari;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\KelasPenggantiRequest;
use App\Jenisruang;
use App\Kelasmk;
use App\Kelaspengganti;
use App\Kelaspenggantilab;
use App\Jadwalkelas;
use App\Matakuliah;
use App\Ruang;
use App\Praktikum;
use App\User;
use Carbon\Carbon;
use PHPExcel_Worksheet_Drawing;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|regex:/^[(a-zA-Z\s)]+$/u',
            'roles' => 'required|min:1',
            'username' => 'required|max:255|unique:users|digits:9',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($request->roles == 'Dosen') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|regex:/^[(a-zA-Z\s)]+$/u',
                'roles' => 'required|min:1',
                'username' => 'required|max:255|unique:users|digits:8',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
            ]);          
        }

        if ($validator->fails()) {
            if ($request->roles == 'Admin') {
                return redirect('registeradmin')
                            ->withErrors($validator)
                            ->withInput();            
            }
            if ($request->roles == 'Dosen') {
                return redirect('registerdosen')
                            ->withErrors($validator)
                            ->withInput();            
            }
            if ($request->roles == 'Mahasiswa') {
                return redirect('registermahasiswa')
                            ->withErrors($validator)
                            ->withInput();            
            }
        }

        $user = new User;
        $user->name = $request->name;
        $user->roles = $request->roles;
        $user->username = $request->username;
        $user->status = '1';
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        flash()->success('Success!', 'Berhasil daftar '.strtolower($request->roles).' baru!');

        return redirect('register'.strtolower($request->roles));
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
        flash()->success('Success!', 'Berhasil daftar admin baru!');

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

    public function validateLab_index($currentsemesterParams)
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

        return view('admin.attLabindex', compact('semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
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
                return $hari->nama;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $nama = User::where('id', $lecturerSchedules->dosen_id)->first();
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

    public function getDataJadwalDosenLabAll($semester)
    {
        $lecturerSchedules = Jadwalkelas::select('*')->where('semester', $semester)->get();
        return Datatables::of($lecturerSchedules)
            ->editColumn('dosen_id', function ($lecturerSchedules) {
                $user = User::findOrFail($lecturerSchedules->user_id);
                return $user->username;
            })
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="../presensilab/'.$lecturerSchedules->id_kelas.'/0" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
            })
            ->editColumn('semester', function ($lecturerSchedules) {
                return strtoupper($lecturerSchedules->semester);
            })
            ->editColumn('hari_name', function ($lecturerSchedules) {
                $hari = Hari::findOrFail($lecturerSchedules->hari_id);
                return $hari->nama;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $nama = User::where('id', $lecturerSchedules->user_id)->first();
                return $nama->name;
            })
            ->editColumn('matakuliah_id', function ($lecturerSchedules) {
                $hari = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                return $hari->nama;
            })
            ->editColumn('ruang_id', function ($lecturerSchedules) {
                $ruang = Ruang::findOrFail($lecturerSchedules->id_ruang);
                return $ruang->nama;
            })
            ->editColumn('waktu', function ($lecturerSchedules) {
                return $lecturerSchedules->time_start;
            })
            ->make(true);   
    }


    public function kelaspengganti_index()
    {
        return view('admin.kelaspengganti.index');
    }

    public function kelaspenggantiLab_index()
    {
        return view('admin.kelaspenggantilab.index');
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
                return $hari->nama;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $kelasmk = Kelasmk::find($lecturerSchedules->kelasmk_id);
                $nama = User::where('id', $kelasmk->dosen_id)->first();
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

    public function getDataKelaspenggantiLab()
    {
        $lecturerSchedules = Kelaspenggantilab::select('*')->where('status', '1')->get();
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="kelaspenggantiLabData/'.$lecturerSchedules->jadwalkelas_id.'/edit" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit </a> <a href="kelaspenggantiDataDelete/'.$lecturerSchedules->id.'" class="btn btn-danger"><i class="fa fa-trash"></i> Delete </a>';
            })
            ->editColumn('status', function ($lecturerSchedules) {
                return ($lecturerSchedules->status == '1' ? 'Active' : 'Non Active');
            })
            ->editColumn('semester', function ($lecturerSchedules) {
                $kelasmk = Jadwalkelas::find($lecturerSchedules->jadwalkelas_id);
                return strtoupper($kelasmk->semester);
            })
            ->editColumn('hari_name', function ($lecturerSchedules) {
                $hari = Hari::findOrFail($lecturerSchedules->hari_id);
                return $hari->nama;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $kelasmk = Jadwalkelas::find($lecturerSchedules->jadwalkelas_id);
                $nama = User::where('id', $kelasmk->dosen_id)->first();
                return $nama->name;
            })
            ->editColumn('nim', function ($lecturerSchedules) {
                $kelasmk = Jadwalkelas::find($lecturerSchedules->jadwalkelas_id);
                return $kelasmk->dosen_id;
            })
            ->editColumn('matakuliah_id', function ($lecturerSchedules) {
                $kelasmk = Jadwalkelas::find($lecturerSchedules->jadwalkelas_id);
                $hari = Praktikum::findOrFail($kelasmk->id_praktikum);
                return $hari->nama;
            })
            ->editColumn('ruang_id', function ($lecturerSchedules) {
                $ruang = Ruang::findOrFail($lecturerSchedules->id_ruang);
                return $ruang->nama;
            })
            ->editColumn('kelas', function ($lecturerSchedules) {
                $kelasmk = Jadwalkelas::find($lecturerSchedules->jadwalkelas_id);
                return $kelasmk->kelas;
            })
            ->make(true);   
    }



    public function registerkelaspengganti($id)
    {
        $kelasmk = Kelasmk::find($id);

        return view('admin/kelaspengganti.create', compact('kelasmk'));
    }

    public function registerkelaspenggantilab($id)
    {
        $jadwalkelas = Jadwalkelas::find($id);
        return view('admin/kelaspenggantilab.create', compact('jadwalkelas'));
    }

    public function store_kelaspengganti(Request $request)
    {
        $kelasmk = Kelasmk::find($request->kelasmk_id);
        $Alljadwal = \DB::table('kelasmk')
                  ->join('matakuliah', 'kelasmk.matakuliah_id', '=', 'matakuliah.kode_matakuliah')
                  ->select('waktu', 'matakuliah.sks', 'matakuliah.nama_matakuliah')
                  ->where('semester', $kelasmk->semester)
                  ->where('hari_id', $request->hari_id)
                  ->get();
        foreach($Alljadwal as $jadwal) {
            if($request->waktu > $jadwal->waktu && $request->waktu < Carbon::parse($jadwal->waktu)->addHours($jadwal->sks)->toTimeString()) {
                return redirect()->back()
                    ->with('bentrok', 'Jadwal bentrok dengan matakuliah '.$jadwal->nama_matakuliah. ' ('.$jadwal->waktu.'-'. Carbon::parse($jadwal->waktu)->addHours($jadwal->sks)->toTimeString().')')
                    ->withInput();   
            }
        }

        $kelaspengganti = new Kelaspengganti;
        $kelaspengganti->kelasmk_id = $request->input('kelasmk_id');
        $kelaspengganti->waktu = $request->input('waktu');
        $kelaspengganti->hari_id = $request->input('hari_id');
        $kelaspengganti->ruang_id = $request->input('ruang_id');
        $kelaspengganti->status = $request->input('recstatus');
        $kelaspengganti->save();

        return redirect('kelaspenggantiDataView');
    }

    public function store_kelaspenggantilab(Request $request)
    {
        $kelaspengganti = new Kelaspenggantilab;
        $kelaspengganti->jadwalkelas_id = $request->input('kelasmk_id');
        $kelaspengganti->waktu = $request->input('waktu');
        $kelaspengganti->hari_id = $request->input('hari_id');
        $kelaspengganti->id_ruang = $request->input('id_ruang');
        $kelaspengganti->status = $request->input('status');
        $kelaspengganti->save();

        return redirect('kelaspenggantiLabDataView');
    }

    public function edit_kelaspengganti($id)
    {
        $kelasmk = Kelasmk::find($id);
        $kelaspengganti = Kelaspengganti::where('kelasmk_id', $id)->first();
        return view('admin/kelaspengganti.edit', compact('kelaspengganti', 'kelasmk'));
    }

    public function edit_kelaspenggantiLab($id)
    {
        $kelasmk = Jadwalkelas::find($id);
        $kelaspengganti = Kelaspenggantilab::where('jadwalkelas_id', $id_kelas)->first();
        return view('admin/kelaspenggantilab.edit', compact('kelaspengganti', 'kelasmk'));
    }

    public function update_kelaspengganti($id, KelasPenggantiRequest $request)
    {
        $kelaspengganti = Kelaspengganti::findOrFail($id);
        $kelaspengganti->update($request->All());
        flash()->success('Success!', 'Kelas pengganti berhasil diupdate!');
        return redirect('kelaspenggantiDataView');
    }

    public function update_kelaspenggantiLab($id, KelasPenggantiLabRequest $request)
    {
        $kelaspengganti = Kelaspenggantilab::findOrFail($id);
        $kelaspengganti->update($request->All());
        flash()->success('Success!', 'Kelas pengganti berhasil diupdate!');
        return redirect('kelaspenggantiLabDataView');
    }

    public function destroy_kelaspengganti($id)
    {
        $kelaspengganti = Kelaspengganti::findOrFail($id);
        $kelaspengganti->status = '0';
        $kelaspengganti->save();
        flash()->success('Success!', 'Kelas pengganti berhasil dihapus!');
        return redirect('kelaspenggantiDataView');
    }

    public function destroy_kelaspenggantiLab($id)
    {
        $kelaspengganti = KelaspenggantiLab::findOrFail($id);
        $kelaspengganti->status = '0';
        $kelaspengganti->save();
        flash()->success('Success!', 'Kelas pengganti berhasil dihapus!');
        return redirect('kelaspenggantiLabDataView');
    }

    public function listkelasmk()
    {
        return view('admin/kelaspengganti.listkelasmk');
    }

   public function listjadwalkelas()
    {
        return view('admin/kelaspenggantilab.listjadwalkelas');
    }


    public function getDataListKelasmk()
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');
        $kelaspengganti = Kelaspengganti::select('kelasmk_id')->where('status', 1)->get();

        $lecturerSchedules = \DB::table('kelasmk')
                                  ->select('*')
                                  ->whereNotIn('id', $kelaspengganti)
                                  ->where('semester', $currentsemesterDirty)
                                  ->where('recstatus', '1')
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
                return $hari->nama;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $nama = User::where('id', $lecturerSchedules->dosen_id)->first();
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

    public function getDataListJadwalkelas()
    {
        $datetime = Carbon::now();
        $currentsemesterDirty = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');

        $kelaspengganti = Kelaspenggantilab::select('jadwalkelas_id')->where('status', 1)->get();

        $lecturerSchedules = \DB::table('jadwal_kelas')
                                  ->select('*')
                                  ->whereNotIn('id_kelas', $kelaspengganti)
                                  ->where('semester', $currentsemesterDirty)
                                  ->where('status', '1')
                                  ->get();
        $lecturerSchedules = collect($lecturerSchedules);
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="kelaspenggantiLabData/'.$lecturerSchedules->id_kelas.'" class="btn btn-warning"><i class="fa fa-pencil"></i> Kelola KP </a>';
            })
            ->editColumn('recstatus', function ($lecturerSchedules) {
                return ($lecturerSchedules->status == '1' ? 'Active' : 'Non Active');
            })
            ->editColumn('semester', function ($lecturerSchedules) {
                return strtoupper($lecturerSchedules->semester);
            })
            ->editColumn('hari_name', function ($lecturerSchedules) {
                $hari = Hari::findOrFail($lecturerSchedules->hari_id);
                return $hari->nama;
            })
            ->editColumn('name', function ($lecturerSchedules) {
                $nama = User::where('id', $lecturerSchedules->user_id)->first();
                return $nama->name;
            })
            ->editColumn('nim', function ($lecturerSchedules) {
                $nim = User::where('id', $lecturerSchedules->user_id)->first();
                return $nim->username;
            })
            ->editColumn('matakuliah_id', function ($lecturerSchedules) {
                $matakuliah = Praktikum::findOrFail($lecturerSchedules->id_praktikum);
                return $matakuliah->nama;
            })
            ->editColumn('ruang_id', function ($lecturerSchedules) {
                $ruang = Ruang::findOrFail($lecturerSchedules->id_ruang);
                return $ruang->nama;
            })
            ->editColumn('waktu', function ($lecturerSchedules) {
                return $lecturerSchedules->time_start;
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
                $induk1 = array();
                $induk2 = array();
                $objDrawing = new PHPExcel_Worksheet_Drawing;
                $objDrawing->setPath(public_path('assets/images/img.png')); //your image path
                $objDrawing->setCoordinates('A1');
                $objDrawing->setWorksheet($sheet);

                $studentSubjects = \DB::table('kelasmk')
                                    ->join('users', 'kelasmk.dosen_id', '=', 'users.id')
                                    ->select('kelasmk.*')
                                    ->orderBy('name', 'asc')
                                    ->get();
                $semester = \DB::table('kelasmk')
                                    ->join('users', 'kelasmk.dosen_id', '=', 'users.id')
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
                    $presentase = round(($this->JmlHadirDosen($value->id, $value->dosen_id, $start, $end)/4 * 100), 0). '%';
                    $jmlhadir = $this->JmlHadirDosen($value->id, $value->dosen_id, $start, $end);
                    $induk = $value->dosen_id;
                    $matakuliah = Matakuliah::findOrFail($value->matakuliah_id);
                    $LecturerNames = User::select('name')->where('id', $value->dosen_id)->first();
                    if ($induk1) {
                        $induk2 = $induk;
                        if ($induk2 == $induk1) {
                            $sheet->mergeCells('A'.($key+15).':A'.($key+16));
                            $sheet->mergeCells('B'.($key+15).':B'.($key+16));
                            $sheet->mergeCells('C'.($key+15).':C'.($key+16));
                            //$no = $key+1;
                        }
                        else {
                            
                            $no = $no+1;
                        }
                    }
                    $induk1 = $induk;
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
                            ->join('users', 'kelasmk.dosen_id', '=', 'users.id')
                            ->select('kelasmk.*')
                            ->orderBy('name', 'asc')
                            ->get();
        $lecturerSchedules = collect($lecturerSchedules);

        return Datatables::of($lecturerSchedules)
            ->editColumn('nama_dosen', function ($lecturerSchedules) {
                $LecturerNames = User::select('name')->where('id', $lecturerSchedules->dosen_id)->first();
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
                $presentase = round(($this->jumlahHadirDosenBulanan($lecturerSchedules, $start, $end)/4 * 100), 0). '%';
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
            ->where('keterangan', '<', '4')
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
        $pertemuan2 = \DB::table('presensidosen')
                        ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
                        ->select('pertemuan')
                        ->where('presensidosen.waktu', '>=', $start)
                        ->where('presensidosen.waktu', '<=', $end)
                        ->where('kelasmk_id', $lecturerSchedules->id)
                        ->where('nik', $lecturerSchedules->dosen_id)
                        ->first();
        if (!$pertemuan2) {
            $pertemuanReal = '';
        }
        else {
            $pertemuanReal = $pertemuan2->pertemuan+$pertemuan-1;
        }
        $classes = \DB::table('presensidosen')
            ->join('kelasmk', 'presensidosen.kelasmk_id', '=', 'kelasmk.id')
            ->select('keterangan', 'presensidosen.pertemuan')
            ->where('presensidosen.waktu', '>=', $start)
            ->where('presensidosen.waktu', '<=', $end)
            ->where('kelasmk_id', $lecturerSchedules->id)
            ->where('nik', $lecturerSchedules->dosen_id)
            ->where('pertemuan', $pertemuanReal)
            ->first();
        if (!$classes) {
            return '';
        }
        else {
            return $classes->keterangan;
        }
    }
}
