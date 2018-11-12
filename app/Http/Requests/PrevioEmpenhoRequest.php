<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PrevioEmpenhoRequest extends Request
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
            'ano_rpe' => 'required',
            'nr_rpe' => 'required',
            'cd_tpcompra' => 'required',
            'cd_fonte' => 'required',
            'ano_convenio' => 'required',
            'id_financiador' => 'required',
            'nr_convenio' => 'required',
            'id_etapa_aplic' =>  'required',
            'tp_beneficiario' => 'required',
            'id_pessoa' => 'required',
            'dt_rpe' =>  'required',
            'seq_bancario' => 'required',
            'ds_objetivo' =>  'required',
            'vl_previo_empenho' => 'required|min:0',
            'id_moeda' => 'required',
            'tp_rpe' => 'required',

        ];
    }
}
