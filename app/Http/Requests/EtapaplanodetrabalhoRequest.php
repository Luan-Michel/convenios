<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EtapaplanodetrabalhoRequest extends Request
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
            'id_aplicacao' => 'required',
            'ds_titulo_etapa' => 'required|min:5|max:150',
            'ds_etapa_aplic' => 'required|min:15|max:500',
            'ds_unidade_medida' => 'max:30',
            'qt_unidade_etapa' => 'max:19',
            'idcontas_plano' => 'required',
            'cd_tabela' => 'required',
            'vl_total_etapa' => 'required|max:18',
            'vl_reservado' => 'max:18',
            'vl_empenhado' => 'max:18',
            'vl_saldo' => 'max:18',
            ];
    }
}
