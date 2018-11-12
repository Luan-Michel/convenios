<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EtapaParticipantesRequest;

use App\EtapaParticipante;
use App\EtapaPlanodetrabalho;
use App\Planodetrabalho;
use App\Contabilcontasplano;
use App\Despesas;
use App\Participantes;
use App\Pessoa;

class EtapaParticipantesController extends Controller
{
    public function Index()
    {
        $ep = \App\EtapaParticipante::all();
        foreach ($ep as $key => $ept) {
            $id_etapa_aplic = \App\EtapaPlanodetrabalho::find($ept['id_etapa_aplic']);
            $id_pessoa_participante = \App\Pessoa::where('id_pessoa', '=', $ept['id_pessoa_participante'])->get();
            $this->array_push_assoc($ep[$key], 'nm_pessoa_completo', $id_pessoa_participante[0]['nm_pessoa_completo']);
            $this->array_push_assoc($ep[$key], 'ds_titulo_etapa', $id_etapa_aplic->ds_titulo_etapa);
        }
        return view('etapaparticipantes.EtapaParticipante', ['etapaparticipantes' => $ep]);
    }

    public function Adicionar()
    {
        $pt = \App\EtapaPlanodetrabalho::all();
        $p = \App\Participantes::all();

        $ept = array();
        foreach ($pt as $key => $pt) {
            $ds_titulo_meta_aplic = \App\Planodetrabalho::find($pt['id_aplicacao']);
            $this->array_push_assoc($pt, 'ds_titulo_meta_aplic', $ds_titulo_meta_aplic->ds_titulo_meta_aplic);
            $ept[$key] = $pt;
        }

        $part = array();
        foreach ($p as $key => $p) {
            $nm_pessoa_completa = \App\Pessoa::where('id_pessoa', '=', $p['id_pessoa_participante'])->get();
            $this->array_push_assoc($p, 'nm_pessoa_completa', $nm_pessoa_completa[0]['nm_pessoa_completo']);
            $part[$key] = $p;
        }
        return view('etapaparticipantes.Cadastrar')->with('planodetrabalho', $ept)->with('participantes', $part);
    }

    public function Editar($id)
    {
        $pt = \App\EtapaPlanodetrabalho::all();
        $p = \App\Participantes::all();

        $ept = array();
        foreach ($pt as $key => $pt) {
            $ds_titulo_meta_aplic = \App\Planodetrabalho::find($pt['id_aplicacao']);
            $this->array_push_assoc($pt, 'ds_titulo_meta_aplic', $ds_titulo_meta_aplic->ds_titulo_meta_aplic);
            $ept[$key] = $pt;
        }

        $part = array();
        foreach ($p as $key => $p) {
            $nm_pessoa_completa = \App\Pessoa::where('id_pessoa', '=', $p['id_pessoa_participante'])->get();
            $this->array_push_assoc($p, 'nm_pessoa_completa', $nm_pessoa_completa[0]['nm_pessoa_completo']);
            $part[$key] = $p;
        }

        $ep = \App\EtapaParticipante::where('id_etapa_participante', '=', $id)->get();
        $id_etapa_aplic = \App\EtapaPlanodetrabalho::where('id_etapa_aplic', '=', $ep[0]['id_etapa_aplic'])->get();
        $id_aplicacao = \App\Planodetrabalho::where('id_aplicacao', '=',$id_etapa_aplic[0]['id_aplicacao'])->get();
        $id_pessoa_participante = \App\Pessoa::where('id_pessoa', '=', $ep[0]['id_pessoa_participante'])->get();
        $this->array_push_assoc($ep[0], 'ds_titulo_meta_aplic', $id_aplicacao[0]['ds_titulo_meta_aplic']);
        $this->array_push_assoc($ep[0], 'ds_titulo_etapa', $id_etapa_aplic[0]['ds_titulo_etapa']);
        $this->array_push_assoc($ep[0], 'nm_pessoa_completo', $id_pessoa_participante[0]['nm_pessoa_completo']);

        return view('etapaparticipantes.Editar')->with('participantes',$part)->with('planodetrabalho',$ept)->with('etapaparticipante',$ep);
    }

    public function atualizabanco(EtapaParticipantesRequest $request, $id)
    {
        $input = $request->all();
        $retorno_pessoa_participante = explode('|', $input['id_etapa_participante']);
        $input = $this->array_push_assoc($input, 'id_pessoa_participante', $retorno_pessoa_participante[0]);
        $input = $this->array_push_assoc($input, 'id_financiador', $retorno_pessoa_participante[1]);
        $input = $this->array_push_assoc($input, 'ano_convenio', $retorno_pessoa_participante[2]);
        $input = $this->array_push_assoc($input, 'nr_convenio', $retorno_pessoa_participante[3]);
        unset($input['_token']);
        unset($input['_method']);
        unset($input['id_etapa_participante']);
//        dd($input);
        EtapaParticipante::where('id_etapa_participante', '=', $id)->update($input);
        return redirect()->route('etapaparticipantes');
    }


    public function store(EtapaParticipantesRequest $request)
    {
        $input = $request->all();
        $retorno_pessoa_participante = explode('|', $input['id_pessoa_participante']);
        $input = $this->array_push_assoc($input, 'id_pessoa_participante', $retorno_pessoa_participante[0]);
        $input = $this->array_push_assoc($input, 'id_financiador', $retorno_pessoa_participante[1]);
        $input = $this->array_push_assoc($input, 'ano_convenio', $retorno_pessoa_participante[2]);
        $input = $this->array_push_assoc($input, 'nr_convenio', $retorno_pessoa_participante[3]);
        EtapaParticipante::create($input);
        return redirect()->route('etapaitem');
    }

    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public function Deletar($id)
    {
//        dd($id);
        $ep = \App\EtapaParticipante::where('id_etapa_participante', $id);
        $ep->delete();
        \Session::flash('flash_message', 'Etapa participante deletado com sucesso');
        return redirect()->route('etapaparticipantes');
    }

    public function MissingMethod($params = array())
    {
        return 'Nada encontrado';
    }
}
