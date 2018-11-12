<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ItemRequest extends Request
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
            'id_etapa_aplic' => 'required',
            'dt_aplicacao' => 'required',
            'vl_item' => 'required|max:18',
            'qt_item' => 'max:18',
            'vl_total_item' => 'max:18',
        ];
    }
}
