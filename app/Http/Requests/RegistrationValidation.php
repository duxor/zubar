<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegistrationValidation extends Request
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
           'ime'=>'required',
           'prezime'=>'required',
           'password'=>'required',
           'email'=>'required',
           'telefon'=>'required|numeric',
       ];
    }
    public function messages()
    {
        return [
            'ime.required'=>'Unesite ime!',
            'prezime.required'=>'Unesite Prezime!',
            'password.required'=>'Unesite lozinku!',
            'email.required'=>'Unesite email!',
            'telefon.required'=>'Unesite broj telefona!',
            'telefon.numeric'=>'Telefon mora biti broj!',
        ];

    }
}
