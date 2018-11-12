<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class BancarioRequest extends Request
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
            'nr_conta' => 'required',
            'nr_dac' => 'required',
            'cd_tipo_conta'=>'required_if:nm_banco,104',

        ];
    }
}
