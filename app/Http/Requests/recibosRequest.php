<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class recibosRequest extends FormRequest
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
            
            'anioConsulta' => 'required|numeric',
            'mesConsulta' => 'required|in:ENE,FEB,MAR,ABR,MAY,JUN,JUL,AGO,SEP,OCT,NOV,DIC',
            'anioConsulta' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            
             'anioConsulta.required' => 'El campo Año a consultar es requerido.',
             'anioConsulta.numeric' => 'El campo Año a consultar debe ser numerico.',
             'mesConsulta.required' => 'El campo Mes a consultar es requerido.',
             'mesConsulta.numeric' => 'El campo Mes a consultar debe ser numerico.',
             'mesConsulta.in' => 'El campo Mes a consultar no es correcto.',

        ];
    }
}
