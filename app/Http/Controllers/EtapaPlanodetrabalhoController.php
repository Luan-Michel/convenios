<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\EtapaplanodetrabalhoRequest;
use App\Planodetrabalho;
use App\EtapaPlanodetrabalho;
use App\Contabilcontasplano;
use App\Despesas;
use UxWeb\SweetAlert\SweetAlert;
use DB;

class EtapaPlanodetrabalhoController extends Controller
{
    public function Index()
    {
        $ept = DB::TABLE('AC_ETAPA_APLIC')
                  ->JOIN('AC_META_APLIC', 'AC_ETAPA_APLIC.id_aplicacao', '=', 'AC_META_APLIC.id_aplicacao')
                  ->SELECT('AC_ETAPA_APLIC.*', 'AC_META_APLIC.ds_titulo_meta_aplic')
                  ->get();
        foreach ($ept as $e) {
            $e->dt_termino_etapa = date('d/m/Y', strtotime($e->dt_termino_etapa));
        }
        return view('etapaplanodetrabalho.EtapaPlanodetrabalho', ['etapaplanodetrabalho' => $ept]);
    }

    public function Adicionar()
    {
        $pt = \App\Planodetrabalho::all();
        $c = \App\Contabilcontasplano::all();
        $d = \App\Despesas::all();
        return view('etapaplanodetrabalho.Cadastrar')->with('planodetrabalho', $pt)->with('contabil', $c)->with('despesas', $d);
    }

    public function Editar($id)
    {
        try {
            $ept = \App\EtapaPlanodetrabalho::where('id_etapa_aplic', '=', $id)->get();

            $vl_total_etapa = str_replace('.', ',', $ept[0]['vl_total_etapa']);
            $vl_reservado = str_replace('.', ',', $ept[0]['vl_reservado']);
            $vl_empenhado = str_replace('.', ',', $ept[0]['vl_empenhado']);
            $vl_saldo = str_replace('.', ',', $ept[0]['vl_saldo']);
            $dt_inicio_etapa = date('d/m/Y', strtotime($ept[0]['dt_inicio_etapa']));
            $dt_termino_etapa = date('d/m/Y', strtotime($ept[0]['dt_termino_etapa']));

            $ept[0] = $this->array_push_assoc($ept[0], 'vl_total_etapa', $vl_total_etapa);
            $ept[0] = $this->array_push_assoc($ept[0], 'vl_reservado', $vl_reservado);
            $ept[0] = $this->array_push_assoc($ept[0], 'vl_empenhado', $vl_empenhado);
            $ept[0] = $this->array_push_assoc($ept[0], 'vl_saldo', $vl_saldo);
            $ept[0] = $this->array_push_assoc($ept[0], 'dt_inicio_etapa', $dt_inicio_etapa);
            $ept[0] = $this->array_push_assoc($ept[0], 'dt_termino_etapa', $dt_termino_etapa);

            $ptt = \App\Planodetrabalho::where('id_aplicacao', $ept[0]['id_aplicacao'])->get();
            $icp = \App\Contabilcontasplano::where('idcontas_plano', '=', $ept[0]['idcontas_plano'])->get();
            $cdd = \App\Despesas::where('cd_desp', '=', $ept[0]['cd_desp'])
                ->where('CD_TABELA', '=', $ept[0]['cd_tabela'])
                ->get();

            $pt = \App\Planodetrabalho::all();
            $c  = \App\Contabilcontasplano::all();
            $d  = \App\Despesas::all();

        } catch (Exception $e) {
            dd($e);
        }
        return view('etapaplanodetrabalho.Editar')->with('pt', $pt)->with('c', $c)->with('d', $d)->with('etapaplanodetrabalho', $ept)->with('planodetrabalho', $ptt)->with('contabil', $icp)->with('despesas', $cdd);
    }

    public function atualizabanco(EtapaplanodetrabalhoRequest $request, $id)
    {
        $input = $request->all();
        $meta = DB::TABLE('AC_META_APLIC')->where('id_aplicacao', $input['id_aplicacao'])->first();
        //***inicio tratamento dados***
        $retorno = explode('|', $request->cd_tabela);
        $input = $this->array_push_assoc($input, 'cd_tabela', $retorno[1]);
        $input = $this->array_push_assoc($input, 'cd_desp', $retorno[0]);
        //faz-se a divisão das datas
        $retorno_dt_inicio = explode('/', $request->dt_inicio_etapa);
        $retorno_dt_termino = explode('/', $request->dt_termino_etapa);
        //atribui ao objeto os valores de dt_inicio e dt_termino
        $input = $this->array_push_assoc($input, 'dt_inicio_etapa', $retorno_dt_inicio[2] . "-0" . $retorno_dt_inicio[1] . "-" . $retorno_dt_inicio[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'dt_termino_etapa', $retorno_dt_termino[2] . "-0" . $retorno_dt_termino[1] . "-" . $retorno_dt_termino[0] . " 00:00:00");
        unset($input['_token']);
        unset($input['_method']);
        //***fim tratamento dados***
//        dd($input);

        if((strtotime($input['dt_inicio_etapa']) < strtotime($meta->dt_inicio_meta)) ||
           (strtotime($input['$dt_termino_etapa']) > strtotime($meta->dt_termino_meta)) ||
           (strtotime($input['$dt_termino_etapa']) < strtotime($input['dt_inicio_etapa']))){
             SweetAlert::error("Há erros de datas, por favor revise-as.");
             return redirect()->back();
           }

        $f = EtapaPlanodetrabalho::find($id)->update($input);
        return redirect()->route('etapaplanodetrabalho');
    }

    public function store(EtapaplanodetrabalhoRequest $request)
    {
        $input = $request->all();
        $meta = DB::TABLE('AC_META_APLIC')->where('id_aplicacao', $input['id_aplicacao'])->first();
        //***inicio tratamento dados***
        $retorno = explode('|', $request->cd_tabela);
        $input = $this->array_push_assoc($input, 'cd_tabela', $retorno[1]);
        $input = $this->array_push_assoc($input, 'cd_desp', $retorno[0]);
        //faz-se a divisão das datas
        $retorno_dt_inicio = explode('/', $request->dt_inicio_etapa);
        $retorno_dt_termino = explode('/', $request->dt_termino_etapa);
        //atribui ao objeto os valores de dt_inicio e dt_termino
        $input = $this->array_push_assoc($input, 'dt_inicio_etapa', $retorno_dt_inicio[2] . "-0" . $retorno_dt_inicio[1] . "-" . $retorno_dt_inicio[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'dt_termino_etapa', $retorno_dt_termino[2] . "-0" . $retorno_dt_termino[1] . "-" . $retorno_dt_termino[0] . " 00:00:00");
        //***fim tratamento dados***

        if((strtotime($input['dt_inicio_etapa']) < strtotime($meta->dt_inicio_meta)) ||
           (strtotime($input['dt_termino_etapa']) > strtotime($meta->dt_termino_meta)) ||
           (strtotime($input['dt_termino_etapa']) < strtotime($input['dt_inicio_etapa']))){
             SweetAlert::error("Há erros de datas, por favor revise-as.");
             return redirect()->back();
           }

        EtapaPlanodetrabalho::create($input);
        return redirect()->route('etapaparticipantes');
    }

    public function Visualizar($id)
    {
        try {
            $ept = \App\EtapaPlanodetrabalho::where('id_etapa_aplic', '=', $id)->get();

            $vl_total_etapa = str_replace('.', ',', $ept[0]['vl_total_etapa']);
            $vl_reservado = str_replace('.', ',', $ept[0]['vl_reservado']);
            $vl_empenhado = str_replace('.', ',', $ept[0]['vl_empenhado']);
            $vl_saldo = str_replace('.', ',', $ept[0]['vl_saldo']);
            $dt_inicio_etapa = date('d/m/Y', strtotime($ept[0]['dt_inicio_etapa']));
            $dt_termino_etapa = date('d/m/Y', strtotime($ept[0]['dt_termino_etapa']));

            $ept[0] = $this->array_push_assoc($ept[0], 'vl_total_etapa', $vl_total_etapa);
            $ept[0] = $this->array_push_assoc($ept[0], 'vl_reservado', $vl_reservado);
            $ept[0] = $this->array_push_assoc($ept[0], 'vl_empenhado', $vl_empenhado);
            $ept[0] = $this->array_push_assoc($ept[0], 'vl_saldo', $vl_saldo);
            $ept[0] = $this->array_push_assoc($ept[0], 'dt_inicio_etapa', $dt_inicio_etapa);
            $ept[0] = $this->array_push_assoc($ept[0], 'dt_termino_etapa', $dt_termino_etapa);

            $ptt = \App\Planodetrabalho::where('id_aplicacao', $ept[0]['id_aplicacao'])->get();
            $icp = \App\Contabilcontasplano::where('idcontas_plano', '=', $ept[0]['idcontas_plano'])->get();
            $cdd = \App\Despesas::where('cd_desp', '=', $ept[0]['cd_desp'])
                ->where('CD_TABELA', '=', $ept[0]['cd_tabela'])
                ->get();
        } catch (Exception $e) {
            dd($e);
        }
        return view('etapaplanodetrabalho.Visualizar')->with('etapaplanodetrabalho', $ept)->with('planodetrabalho', $ptt)->with('contabil', $icp)->with('despesas', $cdd);
    }

    public function Deletar($id)
    {
        $ept = \App\EtapaPlanodetrabalho::where('id_etapa_aplic', $id);
        try {
          $ept->delete();
          return redirect()->route('etapaplanodetrabalho');
          SweetAlert::success("Etapa do Plano de Trabalho removida com sucesso");
        } catch (\Illuminate\Database\QueryException $e) {
          SweetAlert::error("Etapa não pode ser removida devido a dependência.");
          return redirect()->back();
        }
    }

    public function MissingMethod($params = array())
    {
        return 'Nada encontrado';
    }


    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

}
