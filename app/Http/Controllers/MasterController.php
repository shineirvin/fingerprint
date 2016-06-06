<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

// Model
use App\User;
use App\Matakuliah;
use App\Jenisruang;
use App\Ruang;

// Request
use App\Http\Requests\MatakuliahRequest;
use App\Http\Requests\JenisruangRequest;
use App\Http\Requests\RuangRequest;

class MasterController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /* =========================================MATAKULIAH=======================================================*/

    public function index_matakuliah()
    {
        return view('master/matakuliah.index');
    }

    public function getDatamatakuliah()
    { 	
    	return Datatables::of(Matakuliah::select('*'))
        	->addColumn('action', function ($matakuliah) {
                return '<a href="matakuliahData/'.$matakuliah->kode_matakuliah.'/edit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a> <a id="swalalert" href="'.$matakuliah->kode_matakuliah.'" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a> ';
            })
            ->editColumn('recstatus', function ($matakuliah) {
            	return ($matakuliah->recstatus == '1' ? 'Active' : 'Non Active');
            })
            ->make(true);      
    }

    public function registermatakuliah()
    {
    	return view('master/matakuliah.create');
    }

    public function store_matakuliah(MatakuliahRequest $request)
    {
    	$matakuliah = new Matakuliah;
    	$matakuliah->kode_matakuliah = $request->input('kode_matakuliah');
    	$matakuliah->nama_matakuliah = $request->input('nama_matakuliah');
    	$matakuliah->sks = $request->input('sks');
    	$matakuliah->recstatus = $request->input('recstatus');
    	$matakuliah->save();
        flash()->success('Success!', 'Your data has been created!');
    	return redirect('matakuliahDataView');
    }

    public function edit_matakuliah($id)
    {
    	 $matakuliah = Matakuliah::findOrFail($id);
    	 return view('master/matakuliah.edit', compact('matakuliah'));
    }

    public function update_matakuliah($id, MatakuliahRequest $request)
    {
    	 $matakuliah = Matakuliah::findOrFail($id);
    	 $matakuliah->update($request->All());
         flash()->success('Success!', 'Your data has been updated!');
    	 return redirect('matakuliahDataView');
    }

    public function destroy_matakuliah($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->delete();
        flash()->success('Success!', 'Your data has been deleted!');
        return redirect('matakuliahDataView');
    }

    /* =========================================RUANG=======================================================*/
    public function index_ruang()
    {
        return view('master/ruang.index');
    }

    public function registerruang()
    {
        $jenisruang = Jenisruang::lists('jenis_ruang', 'id');
        $jenisruang->prepend('Pilih Jenis Ruang', '');
        return view('master/ruang.create', compact('jenisruang'));
    }

    public function store_ruang(RuangRequest $request)
    {
        $ruang = new Ruang;
        $ruang->nama_ruang = $request->input('nama_ruang');
        $ruang->kapasitas = $request->input('kapasitas');
        $ruang->jenisruang_id = $request->input('jenisruang_id');
        $ruang->recstatus = $request->input('recstatus');
        $ruang->save();
        flash()->success('Success!', 'Your data has been created!');
        return redirect('ruangDataView');
    }

    public function getDataruang()
    { 	
    	return Datatables::of(Ruang::select('*'))
        	->addColumn('action', function ($ruang) {
                return '<a href="ruangData/'.$ruang->id.'/edit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a> <a id="swalalert" href="'.$ruang->id.'" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a> ';
            })
            ->editColumn('jenisruang_id', function ($ruang) {
                return $jenisruang = Jenisruang::find($ruang->jenisruang_id)->jenis_ruang;
            })
            ->editColumn('recstatus', function ($ruang) {
            	return ($ruang->recstatus == '1' ? 'Active' : 'Non Active');
            })
            ->make(true);      
    }

    public function edit_ruang($id)
    {
        $ruang = Ruang::findOrFail($id);
        $jenisruang = Jenisruang::lists('jenis_ruang', 'id');
        return view('master/ruang.edit', compact('ruang', 'jenisruang'));
    }

    public function update_ruang($id, RuangRequest $request)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->update($request->All());
        flash()->success('Success!', 'Your data has been updated!');
        return redirect('ruangDataView');
    }

    public function destroy_ruang($id)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->delete();
        flash()->success('Success!', 'Your data has been deleted!');
        return redirect('ruangDataView');
    }


    /* =========================================JENISRUANG=======================================================*/

    public function index_jenisruang()
    {
        return view('master/jenisruang.index');
    }

    public function registerjenisruang()
    {
        return view('master/jenisruang.create');
    }

    public function store_jenisruang(JenisruangRequest $request)
    {
        $jenisruang = new Jenisruang;
        $jenisruang->jenis_ruang = $request->input('jenis_ruang');
        $jenisruang->recstatus = $request->input('recstatus');
        $jenisruang->save();
        flash()->success('Success!', 'Your data has been created!');
        return redirect('jenisruangDataView');
    }

    public function getDatajenisruang()
    {   
        return Datatables::of(jenisruang::select('*'))
            ->addColumn('action', function ($jenis_ruang) {
                return '<a href="jenisruangData/'.$jenis_ruang->id.'/edit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a> <a id="swalalert" href="'.$jenis_ruang->id.'" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a> ';
            })
            ->editColumn('recstatus', function ($jenis_ruang) {
                return ($jenis_ruang->recstatus == '1' ? 'Active' : 'Non Active');
            })
            ->make(true);      
    }

    public function edit_jenisruang($id)
    {
         $jenisruang = Jenisruang::findOrFail($id);
         return view('master/jenisruang.edit', compact('jenisruang'));
    }

    public function update_jenisruang($id, JenisruangRequest $request)
    {
         $jenisruang = Jenisruang::findOrFail($id);
         $jenisruang->update($request->All());
         flash()->success('Success!', 'Your data has been updated!');
         return redirect('jenisruangDataView');
    }

    public function destroy_jenisruang($id)
    {
        $jenisruang = Jenisruang::findOrFail($id);
        $jenisruang->delete();
        flash()->success('Success!', 'Your data has been deleted!');
        return redirect('jenisruangDataView');
    }

}
