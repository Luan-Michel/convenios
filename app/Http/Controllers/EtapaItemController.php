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
use UxWeb\SweetAlert\SweetAlert;
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
        $etapaitem = \App\EtapaItem::where('id_etapa_item_aplic', $id)->first();

        $e = \App\EtapaPlanodetrabalho::all();
        $p = \App\Pais::all()->sortBy('nm_pais');
        $m = \App\Moeda::all()->sortBy('ds_moeda');
        $d = DB::TABLE('COMPRAS..DESPESA')->where('cd_desp', $etapaitem->cd_desp)->where('cd_tabela', $etapaitem->cd_tabela)->first();
        //tratamento dados
        $etapaitem->dt_aplicacao = date('d/m/Y', strtotime($etapaitem->dt_aplicacao));
        $etapaitem->vl_item = str_replace('.', ',', $etapaitem->vl_item);
        $etapaitem->vl_total_item = str_replace('.', ',', $etapaitem->vl_total_item);
        // fim tratamento

        return view('etapaitem.Editar')
              ->with('etapaitem', $etapaitem)
              ->with('etapas', $e)
              ->with('despesa', $d)
              ->with('moeda', $m)
              ->with('pais', $p);
    }

    public function Deletar($id)
    {
        $etapaitem = \App\EtapaItem::where('id_etapa_item_aplic', $id);
        try {
          $etapaitem->delete();
          SweetAlert::success("Item removido com sucesso.");
          return redirect()->route('etapaitem');
        } catch (\Illuminate\Database\QueryException $e) {
          SweetAlert::error("Item não pode ser removido devido a dependência.");
          return redirect()->back();
        }
    }

    public function atualizabanco(ItemRequest $request, $id)
    {
        $input = $request->all();

        $item = DB::TABLE('AC_ETAPA_ITEM_APLIC')->WHERE('id_etapa_item_aplic', $id)->first();

        if($item->cd_desp == $input['cd_desp']){
            $input['cd_tabela'] = $item->cd_tabela;
        }else{
            $de = DB::TABLE('COMPRAS..DESPESA')
                  ->WHERE('CD_DESP', intval($input['cd_desp']))
                  ->select('cd_tabela')
                  ->orderBy('cd_tabela', 'desc')
                  ->first();

            $input['cd_tabela'] = intval($de->cd_tabela);
        }

        $retorno_dt_aplicacao = explode('/', $input['dt_aplicacao']);
        $valoritem = str_replace(".", "", $input['vl_item']);
        $valoritem = str_replace(",", ".", $valoritem);
        $valortotalitem = str_replace(".", "", $input['vl_total_item']);
        $valortotalitem = str_replace(",", ".", $valortotalitem);
        $input = $this->array_push_assoc($input, 'dt_aplicacao', $retorno_dt_aplicacao[2] . "-" . $retorno_dt_aplicacao[1] . "-" . $retorno_dt_aplicacao[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'vl_item', $valoritem);
        $input = $this->array_push_assoc($input, 'vl_total_item', $valortotalitem);
        unset($input['_token']);
        unset($input['_method']);
        $f = EtapaItem::find($id)->update($input);
        SweetAlert::success("Item atualizado com sucesso");
        return redirect()->route('etapaitem');
    }


    public function store(ItemRequest $request)
    {
        $input = $request->all();

        $de = DB::TABLE('COMPRAS..DESPESA')
              ->WHERE('CD_DESP', intval($input['cd_desp']))
              ->select('cd_tabela')
              ->orderBy('cd_tabela', 'desc')
              ->first();

        $input['cd_tabela'] = intval($de->cd_tabela);
        //tratamentodados
        $retorno_dt_aplicacao = explode('/', $input['dt_aplicacao']);
        $valoritem = str_replace(".", "", $input['vl_item']);
        $valoritem = str_replace(",", ".", $valoritem);
        $valortotalitem = str_replace(".", "", $input['vl_total_item']);
        $valortotalitem = str_replace(",", ".", $valortotalitem);
        $input = $this->array_push_assoc($input, 'dt_aplicacao', $retorno_dt_aplicacao[2] . "-" . $retorno_dt_aplicacao[1] . "-" . $retorno_dt_aplicacao[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'vl_item', $valoritem);
        $input = $this->array_push_assoc($input, 'vl_total_item', $valortotalitem);
        //endtratamentodados
        SweetAlert::success("Item cadastrado com sucesso");
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
              ->select('NM_DESP as text', 'CD_DESP as id')
              ->first();

        return response()->json($de);
    }

    public function getNameDesp($nm_desp)
    {
        //$cd_tab = intval($cd_tab);
        //return response()->json($nm_desp);
        $tab = DB::TABLE('COMPRAS..DESPESA')
                    ->MAX('CD_TABELA');

        $nm_desp = "%".$nm_desp."%";
        $d = DB::TABLE('COMPRAS..DESPESA')
              ->WHERE('NM_DESP', 'LIKE', $nm_desp)
              ->WHERE('CD_TABELA', $tab)
              ->LIMIT(50)
              ->select('CD_DESP as id', 'NM_DESP as text')
              ->get();
        return response()->json($d);
    }

    public function getNameDespEdit($id, $nm_desp)
    {
        //$cd_tab = intval($cd_tab);
        //return response()->json($nm_desp);
        $tab = DB::TABLE('COMPRAS..DESPESA')
                    ->MAX('CD_TABELA');

        $nm_desp = "%".$nm_desp."%";
        $d = DB::TABLE('COMPRAS..DESPESA')
              ->WHERE('NM_DESP', 'LIKE', $nm_desp)
              ->WHERE('CD_TABELA', $tab)
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
