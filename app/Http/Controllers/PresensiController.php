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

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PresensiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    	$datas = Kelasmk::select('*')->where('dosen_id', Auth::user()->username)->get();
    	return view('presensi.index', compact('datas'));
    }

    public function getDataJadwalDosen()
    {
        $lecturerSchedules = Kelasmk::select('*')->where('dosen_id', Auth::user()->username)->get();
        return Datatables::of($lecturerSchedules)
            ->addColumn('action', function ($lecturerSchedules) {
                return '<a href="presensi/'.$lecturerSchedules->id.'" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
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

    public function getDataPresensiMahasiswa($id)
    {
        $presensikelas = Presensikelas::select('*')->where('NIM', '!=', '')->where('kelasmk_id', $id)->get();

        return Datatables::of($presensikelas)
            ->addColumn('action', function ($presensikelas) {
                return '<a href="presensi/'.$presensikelas->id.'" class="btn btn-success"><i class="fa fa-check"></i> Validasi </a>';
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

    public function validasi($id)
    {
        return view('presensi.validasi', compact('id'));
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
