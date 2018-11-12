<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlanodetrabalhoRequest extends Request
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

//          'ano_convenio' => 'required',
            'id_convenio' => 'required',
            'id_financiador' => 'required',
            'seq_meta_aplic' => 'required',
            'ds_titulo_meta_aplic' => 'required|min:5|max:150',
            'ds_meta_aplic' => 'required|min:15|max:500',

        ];
    }
}
