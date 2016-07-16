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
use App\Dami;
use App\Hari;
use App\Presensikelas;
use App\Jadwalkelas;
use App\Praktikum;
use App\Presensilab;
use App\Presensiasdos;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PresensiLabController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($currentsemesterParams)
    {
        $datas = Jadwalkelas::select('*')->where('user_id', Auth::user()->id)->get();
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
        return view('presensi.indexLab', compact('datas', 'semester', 'currentsemester', 'currentsemesterDirty', 'currentsemesterParams', 'currentsemesterParamsFilter'));

    }

    public function validasi($id, $encounter)
    {
        return view('presensi.validasilab', compact('id', 'encounter'));
    }

    public function validasiasdos($id, $encounter)
    {
        return view('presensi.validasilabasdos', compact('id', 'encounter'));
    }


    public function studentvalidateLab(Request $request)
    {
        $id = $request->input('idpage');
        foreach ($request['id'] as $id) {
            $attendances = Presensilab::findOrFail($id);
            $attendances->keterangan = substr($request[$id], -1);
            $attendances->save();
        }
        return redirect()->back()->with('id');
    }

    public function studentvalidateLabasdos(Request $request)
    {
        $id = $request->input('idpage');
        foreach ($request['id'] as $id) {
            $attendances = Presensiasdos::findOrFail($id);
            $attendances->keterangan = substr($request[$id], -1);
            $attendances->save();
        }
        return redirect()->back()->with('id');
    }

    public function getDataJadwalDosen($semester)
    {
        $lecturerSchedules = Jadwalkelas::select('*')->where('semester', $semester)->where('user_id', Auth::user()->id)->get();
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
                return $hari->namahari;
            })
            ->editColumn('matakuliah_id', function ($lecturerSchedules) {
                $praktikum = Praktikum::find($lecturerSchedules->id_praktikum);
                return $praktikum->nama;
            })
            ->editColumn('ruang_id', function ($lecturerSchedules) {
                $ruang = Ruang::findOrFail($lecturerSchedules->ruang_id);
                return $ruang->nama_ruang;
            })
            ->editColumn('waktu', function ($lecturerSchedules) {
                return $lecturerSchedules->time_start.' - '.$lecturerSchedules->time_end;
            })
            ->make(true);   
    }

    public function getDataPresensiMahasiswa($id, $encounter)
    {
        $presensilab = Presensilab::select('*')->where('jadwal_kelas_id', $id)->where('pertemuan', $encounter)->get();
        return Datatables::of($presensilab)
            ->editColumn('nim', function ($studentSubjects) {
                $user = User::findOrFail($studentSubjects->nim);
                return $user->username;
            })
            ->addColumn('action', function ($presensilab) {
                return '<a href="../presensilab/'.$presensilab->id.'" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
            })
            ->editColumn('name', function ($presensilab) {
                $nama = User::where('id', $presensilab->nim)->first();
                return $nama->name;
            })
            ->addColumn('keterangan', function ($presensilab) {
                return '<input name="id[]" type="hidden" value="'. $presensilab->id .'">
                    <input name="datetime[]" type="hidden" value="'. $presensilab->waktu .'">
                        <span style="padding-right: 15%;"> 
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'. $presensilab->id .'" type="radio" value="'.$presensilab->id.'1" '. ($presensilab->keterangan == '1' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>                                     
                        <span style="padding-right: 15%;">
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensilab->id.'" type="radio" value="'.$presensilab->id.'2"  '. ($presensilab->keterangan == '2' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>
                        <span style="padding-right: 16%;">
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensilab->id.'" type="radio" value="'.$presensilab->id.'3" '. ($presensilab->keterangan == '3' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensilab->id.'" type="radio" value="'.$presensilab->id.'4" '. ($presensilab->keterangan == '4' ? 'checked' : '') .'>
                                <span></span>
                            </label>';
            })
            ->make(true);   
    }

    public function getDataPresensiMahasiswaasdos($id, $encounter)
    {
        $presensilab = Presensiasdos::select('*')->where('jadwal_kelas_id', $id)->where('pertemuan', $encounter)->get();
        return Datatables::of($presensilab)
            ->editColumn('nim', function ($studentSubjects) {
                $user = User::findOrFail($studentSubjects->nim);
                return $user->username;
            })
            ->addColumn('action', function ($presensilab) {
                return '<a href="../presensilab/'.$presensilab->id.'" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
            })
            ->editColumn('name', function ($presensilab) {
                $nama = User::where('id', $presensilab->nim)->first();
                return $nama->name;
            })
            ->addColumn('keterangan', function ($presensilab) {
                return '<input name="id[]" type="hidden" value="'. $presensilab->id .'">
                    <input name="datetime[]" type="hidden" value="'. $presensilab->waktu .'">
                        <span style="padding-right: 15%;"> 
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'. $presensilab->id .'" type="radio" value="'.$presensilab->id.'1" '. ($presensilab->keterangan == '1' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>                                     
                        <span style="padding-right: 15%;">
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensilab->id.'" type="radio" value="'.$presensilab->id.'2"  '. ($presensilab->keterangan == '2' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>
                        <span style="padding-right: 16%;">
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensilab->id.'" type="radio" value="'.$presensilab->id.'3" '. ($presensilab->keterangan == '3' ? 'checked' : '') .'>
                                <span></span>
                            </label>
                        </span>
                            <label class="radio-inline radio-styled radio-success">
                                <input name="'.$presensilab->id.'" type="radio" value="'.$presensilab->id.'4" '. ($presensilab->keterangan == '4' ? 'checked' : '') .'>
                                <span></span>
                            </label>';
            })
            ->make(true);   
    }



}
