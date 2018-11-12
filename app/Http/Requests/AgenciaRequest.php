<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Agencia;

class AgenciaRequest extends Request
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

            //REGRAS
            'nr_banco' => 'required',
            'nr_agencia' => 'required',
            'nm_agencia' =>  'required',
            'nr_dac' => 'required',
        ];
    }
}
