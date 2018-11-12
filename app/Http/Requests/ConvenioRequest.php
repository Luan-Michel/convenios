<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConvenioRequest extends Request
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
    {/*dd(((int)\Request::get( 'ano_processo')-1));*/
        return [

            /*dd(\Request::get('ano_convenio'), \Request::get('ano_processo')),*/
            'id_financiador' => 'required',
            'nr_convenio' => 'required',
            'nr_protocolo' => 'max:8',
            'ano_processo' => 'min:4|max:4',
            'ano_convenio' => 'required',
            'nr_processo' => 'max:8',
            'ds_objeto' => 'required|max:250',
            'ds_sigla_objeto' => 'max:30',
            'nr_sit_tce' => 'required|max:8',
            'vl_convenio' => 'required|max:18',
            'dt_inicio' => 'required',
            'dt_limite_execucao' => 'required',
            'dt_prest_contas' => 'required',
            'idcontas_plano_contabil' => 'required',
            
            ];
    }
}
