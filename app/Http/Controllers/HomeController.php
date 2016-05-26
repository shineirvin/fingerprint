<?php

namespace App\Http\Controllers;

use App\Dpmk;
use App\Http\Requests;
use App\Http\Requests\ChangePasswordRequest;
use App\Kelasmk;
use App\Matakuliah;
use App\Presensikelas;
use App\User;
use Auth;
use PHPExcel_Worksheet_Drawing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::User();
        return view('profile', compact('user'));
    }

    /**
     * Upload or replace users profile picture
     */
    public function profilepicture(Request $request)
    {
        if (!$request->file('file')) {
            flash()->error('Failed', 'Please select some photo before upload');
            return redirect ('profile');
        }
        $user = Auth::User();
        $destinationPath = 'uploads/'; // upload path
        $extension = $request->file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
        $upload_success = $request->file('file')->move($destinationPath, $fileName); // uploading file to given path
        $user->fhoto = $destinationPath . $fileName;
        $user->save();

        flash()->success('Success!', 'New photo has been uploaded');

        return redirect('profile');
    }

    /**
     * Change User Password
     */
    public function changepassword(ChangePasswordRequest $request)
    {
        $data = Auth::User();
        if ( Hash::check($request->oldpassword, $data->password) ) {
            $data->password = Hash::make($request->newpassword);
            $data->save();
            flash()->success('Success!', 'Your password has been changed Successfuly');

            return redirect('profile');
        } else {
            return redirect()->back()->withInput()->withErrors(['oldpassword' => 'Password yang anda masukan salah.']);
        }
    }

}
