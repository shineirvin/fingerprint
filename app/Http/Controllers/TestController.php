<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function testo()
    {
        return view('practice.index');
    }

    public function getIndex()
    {
        return view('practice.table');
    }

    public function anyData()
    {
        return Datatables::of(User::select('*'))->make(true);
    }
}
