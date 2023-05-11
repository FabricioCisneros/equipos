<?php

namespace App\Http\Requests\Dashboard\Directorio;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'empleado_id'=>['required'],
            'ticket_id'=>['required']
        ];
    }

    public function messages()
    {
        return[
            'empleado_id.required'=>__('No se selecciono ningun :attribute ',['attribute'=>__('empleado')]),
            'ticket_id.is.required'=>__('No se selecciono ningun :attribute',['attribute'=>__('equipo')])
        ];
    }
}
