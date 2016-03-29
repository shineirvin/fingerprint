<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MatakuliahRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(\Illuminate\Http\Request $request)
    {
        switch($this->method())
        {
             case 'PATCH':
            {
                return [
                    'kode_matakuliah' => 'required',
                    'nama_matakuliah' => 'required',
                    'sks' => 'required',
                    'recstatus' =>'required'
                ];
            }
            case 'POST':
            {
                return [
                    'kode_matakuliah' => 'required|unique:matakuliah,kode_matakuliah',
                    'nama_matakuliah' => 'required',
                    'sks' => 'required',
                    'recstatus' =>'required'
                ];                
            }
            default:break;
        }

    }
}
