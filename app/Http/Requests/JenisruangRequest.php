<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class JenisruangRequest extends Request
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
                    'jenis_ruang' => 'required',
                    'recstatus' =>'required'
                ];
            }
            case 'POST':
            {
                return [
                    'jenis_ruang' => 'required|unique:jenisruang,jenis_ruang',
                    'recstatus' =>'required'
                ];                
            }
            default:break;
        }
    }
}
