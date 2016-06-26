<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ChangePasswordRequest extends Request
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
        return [
            'oldpassword' => 'required',
            'newpassword' => 'min:6|required',
            'cpassword' => 'min:6|same:newpassword|required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Field ini harus di isi.',
            'same' => 'Konfirmasi password harus sama.',
            'min' => 'Panjang Password minimal 6 karakter.'
        ];
    }

}
