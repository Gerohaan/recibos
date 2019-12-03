<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class datosIngreRequest extends FormRequest
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
            
            'Cedula' => 'required|numeric|digits_between:6,8',
            'Mes' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
            'Anno' => 'required|numeric',
           // 'MesConsulta' => 'required',
           // 'AnnoConsulta' => 'required|numeric',

        ];
    }

    public function messages()
    {
        return [
            
            'Cedula.required' => 'El campo Cedula es requerido.',
            'Cedula.digits_between' => 'El campo Cedula debe poseer un minimo de 6 digitos.',
            'Cedula.digits_between' => 'El campo Cedula debe poseer un maximo de 8 digitos.',
            'Cedula.numeric' => 'El campo Cedula debe ser numerico.',
            'Mes.required' => 'El campo Mes es requerido.',
            'Mes.in' => 'El campo Mes no es correcto.',
            'Anno.required' => 'El campo año de ingreso es requerido.',
            'Anno.numeric' => 'El campo año de ingreso debe ser numerico.',
            //'MesConsulta.required' => 'El campo Mes a consultar es requerido.',
           // 'AnnoConsulta.required' => 'El campo Año a consultar es requerido.',
           // 'AnnoConsulta.numeric' => 'El campo Año a consultar debe ser numerico.',

        ];
    }
}
