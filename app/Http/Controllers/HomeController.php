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
        /*$pdf = \PDF::loadView('index');
        return $pdf->download('invoice.pdf');*/
        Excel::create('Filename', function($excel) { 
            $excel->sheet('First sheet', function($sheet) {
                $studentSubjects = Kelasmk::select('*')->get();

                $sheet->mergeCells('H1:K1');
                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $sheet->mergeCells('D1:D2');
                $sheet->mergeCells('E1:E2');
                $sheet->mergeCells('F1:F2');
                $sheet->mergeCells('G1:G2');
                $sheet->mergeCells('L1:L2');
  
                $sheet->row(1, array(
                    'NO','NIK','NAMA DOSEN', 'KODE MK', 'NAMA MATAKULIAH', 'SKS', 'KELAS', 'MINGGU KE -', '', '', '', 'JML HADIR'
                ));
                $sheet->row(2, array(
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

                ));

                foreach ($studentSubjects as $key => $value) {
                    $matakuliah = Matakuliah::findOrFail($value->matakuliah_id);
                    $LecturerNames = User::select('name')->where('username', $value->dosen_id)->first();
                    $sks = Matakuliah::findOrFail($value->matakuliah_id);
                    $sheet->row($key+3, array(
                         $key+1,
                         $value->dosen_id, 
                         $LecturerNames->name, 
                         $value->matakuliah_id, 
                         $matakuliah->nama_matakuliah, 
                         $sks->sks, 
                         $value->kelas, 
                         '1', 
                         '1', 
                         '2', 
                         '1', 
                         '3'
                    ));
                }
                        
                $sheet->setBorder('A1:L'.(count($studentSubjects) + 2), 'thin');
                
                $sheet->cells('A1:L'.(count($studentSubjects) + 2), function($cells) {
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });

                $sheet->cells('C3:C'.(count($studentSubjects) + 2), function($cells) {
                    $cells->setValignment('left');
                    $cells->setAlignment('left');
                });
                $sheet->cells('D3:D'.(count($studentSubjects) + 2), function($cells) {
                    $cells->setValignment('left');
                    $cells->setAlignment('left');
                });
                $sheet->cells('E3:E'.(count($studentSubjects) + 2), function($cells) {
                    $cells->setValignment('left');
                    $cells->setAlignment('left');
                });


        });


        })->export('xls');





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
