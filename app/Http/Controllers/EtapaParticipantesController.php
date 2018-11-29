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
use UxWeb\SweetAlert\SweetAlert;

use DB;

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

    public function getEtapa($id)
    {
        $etapa = DB::TABLE('AC_ETAPA_APLIC')->where('id_etapa_aplic', $id)->first();

        $meta = DB::TABLE('AC_META_APLIC')->WHERE('id_aplicacao', $etapa->id_aplicacao)->first();

        $participantes = DB::TABLE('AC_PARTICIPANTES')
                          ->JOIN('PESSOA..PESSOA', 'PESSOA..PESSOA.id_pessoa', '=', 'AC_PARTICIPANTES.id_pessoa_participante')
                          ->WHERE('id_convenio', $meta->id_convenio)
                          ->select('PESSOA..PESSOA.nm_pessoa_completo as text', 'AC_PARTICIPANTES.id_pessoa_participante as id')
                          ->get();

        return response()->json($participantes);
    }

    public function getEtapaEdit($id, $id_etapa)
    {
        $etapa = DB::TABLE('AC_ETAPA_APLIC')->where('id_etapa_aplic', $id_etapa)->first();

        $meta = DB::TABLE('AC_META_APLIC')->WHERE('id_aplicacao', $etapa->id_aplicacao)->first();

        $participantes = DB::TABLE('AC_PARTICIPANTES')
                          ->JOIN('PESSOA..PESSOA', 'PESSOA..PESSOA.id_pessoa', '=', 'AC_PARTICIPANTES.id_pessoa_participante')
                          ->WHERE('id_convenio', $meta->id_convenio)
                          ->select('PESSOA..PESSOA.nm_pessoa_completo as text', 'AC_PARTICIPANTES.id_pessoa_participante as id')
                          ->get();

        return response()->json($participantes);
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

        return view('etapaparticipantes.Cadastrar')->with('planodetrabalho', $ept);
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

      $participante = DB::TABLE('AC_ETAPA_PARTICIPANTES')->WHERE('id_etapa_participante', $id)->first();

      $etapa = DB::TABLE('AC_ETAPA_APLIC')->where('id_etapa_aplic', $participante->id_etapa_aplic)->first();

      $meta = DB::TABLE('AC_META_APLIC')->WHERE('id_aplicacao', $etapa->id_aplicacao)->first();

      $participantes = DB::TABLE('AC_PARTICIPANTES')
                        ->JOIN('PESSOA..PESSOA', 'PESSOA..PESSOA.id_pessoa', '=', 'AC_PARTICIPANTES.id_pessoa_participante')
                        ->WHERE('id_convenio', $meta->id_convenio)
                        ->select('PESSOA..PESSOA.nm_pessoa_completo', 'AC_PARTICIPANTES.id_pessoa_participante')
                        ->get();

      return view('etapaparticipantes.Editar')
                ->with('planodetrabalho', $ept)
                ->with('participante', $participante)
                ->with('participantes', $participantes);
    }

    public function atualizabanco(EtapaParticipantesRequest $request, $id)
    {
      $input = $request->all();
      unset($input['_token']);

      try {
        DB::TABLE('AC_ETAPA_PARTICIPANTES')
        ->WHERE('id_etapa_participante', $id)
        ->UPDATE(['id_pessoa_participante' => $input['id_pessoa_participante']]);
        SweetAlert::success("Participante atualizado com sucesso na etapa.");
        return redirect()->route('etapaitem');
      } catch (\Exception $e) {
        return redirect()->back()->withInput($input)->withErrors(["Houve um erro, tente novamente ou contate o NTI."]);
      }
    }


    public function store(EtapaParticipantesRequest $request)
    {
        $input = $request->all();
        $etapa = DB::TABLE('AC_ETAPA_APLIC')->where('id_etapa_aplic', $input['id_etapa_aplic'])->first();
        $meta = DB::TABLE('AC_META_APLIC')->WHERE('id_aplicacao', $etapa->id_aplicacao)->first();

        $input['id_convenio'] = $meta->id_convenio;
        unset($input['_token']);

        try {
          DB::TABLE('AC_ETAPA_PARTICIPANTES')->INSERT($input);
          SweetAlert::success("Participante cadastrada com sucesso na etapa.");
          return redirect()->route('etapaitem');
        } catch (\Exception $e) {
          return redirect()->back()->withInput($input)->withErrors(["Houve um erro, tente novamente ou contate o NTI."]);
        }

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
        SweetAlert::success("Participante removido com sucesso da etapa.");
        return redirect()->route('etapaparticipantes');
    }

    public function MissingMethod($params = array())
    {
        return 'Nada encontrado';
    }
}
