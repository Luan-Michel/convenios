<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ItemRequest;
use App\Planodetrabalho;
use App\EtapaPlanodetrabalho;
use App\Contabilcontasplano;
use App\Despesas;
use App\EtapaItem;
use DB;

class EtapaItemController extends Controller
{
    public function Index()
    {
        $ei = \App\EtapaItem::all();
        foreach ($ei as $key => $item) {
            $valor = str_replace(".", ",", $item['vl_total_item']);
            $ei[$key] = $this->array_push_assoc($ei[$key], 'vl_total_item', $valor);
        }
        return view('etapaitem.EtapaItem', ['etapaitem' => $ei]);
    }

    public function Adicionar()
    {
        $ept = \App\EtapaPlanodetrabalho::all();
        $p = \App\Pais::all()->sortBy('nm_pais');
        $m = \App\Moeda::all()->sortBy('ds_moeda');
        $d = \App\Despesas::all();
        return view('etapaitem.Cadastrar')->with('etapaplanodetrabalho', $ept)->with('pais', $p)->with('moeda', $m)->with('despesas', $d);
    }

    public function Editar($id)
    {
        $etapaitem = \App\EtapaItem::where('id_etapa_item_aplic', $id)->get();
        //tratamento dados
        $dt = date('d/m/Y', strtotime($etapaitem[0]['dt_aplicacao']));
        $etapaitem[0] = $this->array_push_assoc($etapaitem[0], 'dt_aplicacao', $dt);
        $vl = str_replace('.', ',', $etapaitem[0]['vl_item']);
        $etapaitem[0] = $this->array_push_assoc($etapaitem[0], 'vl_item', $vl);
        $vlt = str_replace('.', ',', $etapaitem[0]['vl_total_item']);
        $etapaitem[0] = $this->array_push_assoc($etapaitem[0], 'vl_total_item', $vlt);
        // fim tratamento
        $ep = \App\EtapaPlanodetrabalho::where('id_etapa_aplic', '=', $etapaitem[0]['id_etapa_aplic'])->get();
        $pais = \App\Pais::where('id_pais', '=', $etapaitem[0]['id_pais'])->get();
        $moeda = \App\Moeda::where('id_moeda', '=', $etapaitem[0]['id_moeda'])->get();
        $cdd = \App\Despesas::where('cd_desp', '=', $etapaitem[0]['cd_desp'])
            ->where('cd_tabela', '=', $etapaitem[0]['cd_tabela'])
            ->get();
        $e = \App\EtapaPlanodetrabalho::all();
        $p = \App\Pais::all()->sortBy('nm_pais');
        $m = \App\Moeda::all()->sortBy('ds_moeda');
        $d = \App\Despesas::all();

        return view('etapaitem.Editar')->with('d', $d)->with('m', $m)->with('p', $p)->with('ept', $e)->with('despesa', $cdd)->with('moeda', $moeda)->with('pais', $pais)->with('etapaplanodetrabalho', $ep)->with('etapaitem', $etapaitem);
    }

    public function Deletar($id)
    {
        $ept = \App\EtapaPlanodetrabalho::all();
        $p = \App\Pais::all()->sortBy('nm_pais');
        $m = \App\Moeda::all()->sortBy('ds_moeda');
        $d = \App\Despesas::all();
        $etapaitem = \App\EtapaItem::where('id_etapa_item_aplic', $id);
        $etapaitem->delete();
        \Session::flash('flash_message', 'Etapa Item deletada com sucesso');
        return redirect()->route('etapaitem');
    }

    public function atualizabanco(ItemRequest $request, $id)
    {
        $input = $request->all();
        $retorno_cd_tabela_desp = explode('|', $input['cd_tabela']);
        $retorno_dt_aplicacao = explode('/', $input['dt_aplicacao']);
        $valoritem = str_replace(".", "", $input['vl_item']);
        $valoritem = str_replace(",", ".", $valoritem);
        $valortotalitem = str_replace(".", "", $input['vl_total_item']);
        $valortotalitem = str_replace(",", ".", $valortotalitem);
        $input = $this->array_push_assoc($input, 'cd_tabela', $retorno_cd_tabela_desp[0]);
        $input = $this->array_push_assoc($input, 'cd_desp', $retorno_cd_tabela_desp[1]);
        $input = $this->array_push_assoc($input, 'dt_aplicacao', $retorno_dt_aplicacao[2] . "-" . $retorno_dt_aplicacao[1] . "-" . $retorno_dt_aplicacao[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'vl_item', $valoritem);
        $input = $this->array_push_assoc($input, 'vl_total_item', $valortotalitem);
        unset($input['_token']);
        unset($input['_method']);
        $f = EtapaItem::find($id)->update($input);
        return redirect()->route('etapaitem');
    }


    public function store(ItemRequest $request)
    {
        $input = $request->all();

        //tratamentodados
        $retorno_cd_tabela_desp = explode('|', $input['cd_tabela']);
        $retorno_dt_aplicacao = explode('/', $input['dt_aplicacao']);
        $valoritem = str_replace(".", "", $input['vl_item']);
        $valoritem = str_replace(",", ".", $valoritem);
        $valortotalitem = str_replace(".", "", $input['vl_total_item']);
        $valortotalitem = str_replace(",", ".", $valortotalitem);
        $input = $this->array_push_assoc($input, 'cd_tabela', $retorno_cd_tabela_desp[0]);
        $input = $this->array_push_assoc($input, 'cd_desp', $retorno_cd_tabela_desp[1]);
        $input = $this->array_push_assoc($input, 'dt_aplicacao', $retorno_dt_aplicacao[2] . "-" . $retorno_dt_aplicacao[1] . "-" . $retorno_dt_aplicacao[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'vl_item', $valoritem);
        $input = $this->array_push_assoc($input, 'vl_total_item', $valortotalitem);
        //endtratamentodados
        EtapaItem::create($input);
        return redirect()->route('etapaitem');
    }

    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public function getDespesas($desp)
    {

        $de = DB::TABLE('COMPRAS..DESPESA')
              ->WHERE('CD_DESP', $desp)
              ->select('NM_DESP as text', 'CD_DESP as id', 'CD_TABELA')
              ->get();

        foreach ($de as $d) {
          // code...
          $d->text = $d->text."/".$d->CD_TABELA;
          $d->id = $d->id."/".$d->CD_TABELA;
          unset ($d->CD_TABELA);
        }
        return response()->json($de);
    }

    public function getNameDesp($nm_desp)
    {
        //$cd_tab = intval($cd_tab);
        //return response()->json($nm_desp);
        $nm_desp = "%".$nm_desp."%";
        $d = DB::TABLE('COMPRAS..DESPESA')
              ->WHERE('NM_DESP', 'LIKE', $nm_desp)
              ->ORWHERE('CD_DESP', 'LIKE', $nm_desp)
              ->LIMIT(50)
              ->select('CD_DESP as id', 'NM_DESP as text')
              ->get();
        return response()->json($d);
    }

    public function Visualizar($id)
    {
        $etapaitem = \App\EtapaItem::where('id_etapa_item_aplic', '=', $id)->get();
        $dt = date('d/m/Y', strtotime($etapaitem[0]['dt_aplicacao']));
        $etapaitem[0] = $this->array_push_assoc($etapaitem[0], 'dt_aplicacao', $dt);
        $vl = str_replace('.', ',', $etapaitem[0]['vl_item']);
        $etapaitem[0] = $this->array_push_assoc($etapaitem[0], 'vl_item', $vl);
        $vlt = str_replace('.', ',', $etapaitem[0]['vl_total_item']);
        $etapaitem[0] = $this->array_push_assoc($etapaitem[0], 'vl_total_item', $vlt);
        $ep = \App\EtapaPlanodetrabalho::where('id_etapa_aplic', '=', $etapaitem[0]['id_etapa_aplic'])->get();
        $pais = \App\Pais::where('id_pais', '=', $etapaitem[0]['id_pais'])->get();
        $moeda = \App\Moeda::where('id_moeda', '=', $etapaitem[0]['id_moeda'])->get();
        $cdd = \App\Despesas::where('cd_desp', '=', $etapaitem[0]['cd_desp'])
            ->where('cd_tabela', '=', $etapaitem[0]['cd_tabela'])
            ->get();
        return view('etapaitem.Visualizar')->with('etapaitem', $etapaitem)->with('etapaplanodetrabalho', $ep)->with('pais', $pais)->with('moeda', $moeda)->with('despesas', $cdd);
    }

    public function MissingMethod($params = array())
    {
        return 'Nada encontrado';
    }
}
