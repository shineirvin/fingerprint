<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RuangRequest extends Request
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
    public function rules()
    {
        switch($this->method())
        {
             case 'PATCH':
            {
                return [
                    'nama_ruang' => 'required',
                    'kapasitas' =>'required',
                    'jenisruang_id' =>'required',
                    'recstatus' =>'required'
                ];
            }
            case 'POST':
            {
                return [
                    'nama_ruang' => 'required|unique:ruang,nama_ruang',
                    'kapasitas' =>'required',
                    'jenisruang_id' =>'required',
                    'recstatus' =>'required'
                ];                
            }
            default:break;
        }
    }
}
