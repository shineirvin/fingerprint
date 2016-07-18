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
use App\Presensikelas;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PresensiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($currentsemesterParams)
    {
    	$datas = Kelasmk::select('*')->where('dosen_id', Auth::user()->username)->get();
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

        return view('presensi.index', compact('datas', 'semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }


    public function indexJadwalDosen($currentsemesterParams)
    {
        $datas = Kelasmk::select('*')->where('dosen_id', Auth::user()->username)->get();
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

        return view('presensi.indexJadwalDosen', compact('datas', 'semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));
    }

    public function indexJadwalDosenCreate($id)
    {
        $kelasmk = Kelasmk::find($id);

        return view('presensi.indexJadwalDosenCreate', compact('kelasmk'));
    }

    public function registerbatashadir(Request $request)
    {
        $messages = [
            'required' => 'Field ini harus diisi!.',
            'numeric' => 'Field ini harus diisi dengan nilai numerik!.',
            'between' => 'Field ini hanya dapat diisi diantara 1 - 14!.',
        ];

        $validator = Validator::make($request->all(), [
            'batashadir' => 'required|numeric|between:1,14',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator);
        }
        else {
            $kelasmk = Kelasmk::find($request->kelasmk_id);
            $kelasmk->batashadir = $request->batashadir;
            $kelasmk->save();           
        }


        return redirect('listJadwalDosen/'.$request->kelasmk_id.'/create');
    }

    public function getDataJadwalDosen($semester)
    {
        $lecturerSchedules = Kelasmk::select('*')->where('semester', $semester)->where('dosen_id', Auth::user()->username)->get();
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="../presensi/'.$lecturerSchedules->id.'/0" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
            })
            ->addColumn('action1', function ($lecturerSchedules) {
                return '<a href="../listJadwalDosen/'.$lecturerSchedules->id.'/create" class="btn btn-success"><i class="fa fa-check"></i> Set Batas Pertemuan </a>';
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

    public function getDataPresensiMahasiswa($id, $encounter)
    {
        $presensikelas = Presensikelas::select('*')->where('kelasmk_id', $id)->where('pertemuan', $encounter)->get();

        return Datatables::of($presensikelas)
            ->addColumn('action', function ($presensikelas) {
                return '<a href="../presensi/'.$presensikelas->id.'" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
            })
            ->editColumn('name', function ($presensikelas) {
                $nama = User::where('username', $presensikelas->nim)->first();
                return $nama->name;
            })
            ->addColumn('keterangan', function ($presensikelas) {
                return '<input name="id[]" type="hidden" value="'. $presensikelas->id .'">
                    <input name="datetime[]" type="hidden" value="'. $presensikelas->waktu .'">
                        <span style="padding-right: 15%;"> 
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'. $presensikelas->id .'" type="radio" value="'.$presensikelas->id.'1" '. ($presensikelas->keterangan == '1' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>                                     
                        <span style="padding-right: 15%;">
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensikelas->id.'" type="radio" value="'.$presensikelas->id.'2"  '. ($presensikelas->keterangan == '2' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>
                        <span style="padding-right: 16%;">
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensikelas->id.'" type="radio" value="'.$presensikelas->id.'3" '. ($presensikelas->keterangan == '3' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensikelas->id.'" type="radio" value="'.$presensikelas->id.'4" '. ($presensikelas->keterangan == '4' ? 'checked' : '') .'>
                                <span></span>
                            </label>';
            })
            ->make(true);   
    }

    public function validasi($id, $encounter)
    {
        return view('presensi.validasi', compact('id', 'encounter'));
    }

    public function studentvalidate(Request $request)
    {
        $id = $request->input('idpage');
        foreach ($request['id'] as $id) {
            $attendances = Presensikelas::findOrFail($id);
            $attendances->keterangan = substr($request[$id], -1);
            $attendances->save();
        }
        return redirect()->back()->with('id');
    }

}
