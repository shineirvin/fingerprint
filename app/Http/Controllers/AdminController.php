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

    	return redirect('changepassdosen');
    }

    public function newpassmahasiswa(Request $request)
    {
    	$user = User::find($request->id);
    	$user->password = Hash::make($request->password);
    	$user->save();

    	return redirect('changepassmahasiswa');
    }

    public function newpassAdmin(Request $request)
    {
    	$user = User::find($request->id);
    	$user->password = Hash::make($request->password);
    	$user->save();

    	return redirect('changepassAdmin');
    }



    public function validate_index()
    {
        return view('admin.attindex');
    }

    public function getDataJadwalDosenAll()
    {
        $lecturerSchedules = Kelasmk::select('*')->get();
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="presensi/'.$lecturerSchedules->id.'/0" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
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
        flash()->success('Success!', 'Kelas pengganti berhasil dibuat!');
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


}
