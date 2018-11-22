<?php

namespace App\Http\Controllers;

use App\PrevioEmpenho;
use App\Pessoa;
use App\PessoaFisica;
use App\PessoaJuridica;
use App\Fonte;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrevioEmpenhoRequest;
use Illuminate\Support\Facades\DB;
use UxWeb\SweetAlert\SweetAlert;


class PrevioEmpenhoController extends Controller
{
    public function index()

    {
        $p = \App\PrevioEmpenho::all();
        foreach ($p as $key => $vetor) {
            $pessoa= \App\Pessoa::where('id_pessoa', $p[$key]['id_pessoa'])->get();
            $p[$key] = $this->array_push_assoc($p[$key], 'id_pessoa', $pessoa[0]['nm_pessoa_completo']);

        }
        return view('previoempenho.Previoempenho', ['previoempenho' =>$p]);

    }

    public function substitui_char_especial($texto)
    {
        //Troca o caracter traço longo, por hifen , para solucionar erro ao gravar
        $texto = str_replace(chr(150),chr(45),$texto);
        //Troca o caracter traço longo, por hifen , para solucionar erro ao gravar
        $texto = str_replace(chr(151),chr(45),$texto);
        //Troca o caracter ponto (marcador do word) , por hifen , para solucionar erro ao gravar
        $texto = str_replace(chr(149),chr(45),$texto);
        //Troca o caracter aspas de abertura (do word) , por aspas comum , para solucionar erro ao gravar
        $texto = str_replace(chr(147),chr(34),$texto);
        //Troca o caracter aspas de fechamento (do word) , por aspas comum , para solucionar erro ao gravar
        $texto = str_replace(chr(148),chr(34),$texto);
        //Troca o caracter plica de fechamento (do word) , por aspas comum , para solucionar erro ao gravar
        $texto = str_replace(chr(153),chr(39),$texto);
        //Troca o caracter plica de fechamento (do word) , por aspas comum , para solucionar erro ao gravar
        $texto = str_replace(chr(146),chr(96),$texto);
        //Troca o caracter plica de fechamento (do word) , por aspas comum , para solucionar erro ao gravar
        $texto = str_replace(chr(39),chr(239),$texto);

        return $texto;
    }

    public function Adicionar(){
        try {

            $ano_rpe = date('Y');
            $nr_rpe= DB::table('ac_previo_empenho')->max('nr_rpe');
            if( $nr_rpe == null){
                $nr_rpe = 1;
            }else{
                $nr_rpe = max(array($nr_rpe))+1;
            }
            //dd($nr_rpe);
            $cd_tpcompra = DB::select(DB::raw("select * from compras..tipo_compra  noholdlock"));
            $cd_fonte = DB::select(DB::raw("select cd_fonte, nm_fonte from compras..fonte f noholdlock where cd_ativo='S'"));
            //dd($cd_fonte);
            $convenio = DB::TABLE('AC_CONVENIO')->get();
            $id_moeda = DB::select(DB::raw("select id_moeda, ds_moeda from AC_MOEDA where dt_extincao = null"));
            $num_etapa= DB::select(DB::raw("select count (id_etapa_aplic) from AC_ETAPA_APLIC"));

           // dd($nr_convenio);

        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        return view('previoempenho.Cadastrar')
            ->with('num_etapa', $num_etapa)
            ->with('cd_fonte', $cd_fonte)
            ->with('ano_rpe', $ano_rpe)
            ->with('nr_rpe', $nr_rpe)
            ->with('cd_tpcompra', $cd_tpcompra)
            ->with('id_moeda', $id_moeda)
            ->with('convenio', $convenio);
    }

    public function ajaxEtapaAplic(Request $request){


       // return response()->json([$request->id_convenio]);

        if(isset($request->id_convenio)) {
            // $data = DB::TABLE('AC_META_APLIC')
            //         ->JOIN('AC_ETAPA_APLIC', 'AC_META_APLIC.id_aplicacao', '=', 'AC_ETAPA_APLIC.id_aplicacao')
            //         ->WHERE('id_convenio', intval($request->$id_convenio))
            //         ->SELECT('AC_ETAPA_APLIC.id_etapa_aplic', 'AC_ETAPA_APLIC.ds_titulo_etapa')
            //         ->get();

            $data = DB::select(DB::raw("select id_etapa_aplic, ds_titulo_etapa from AC_ETAPA_APLIC E noholdlock
                        inner join AC_META_APLIC M noholdlock on m.id_aplicacao=e.id_aplicacao
                              and m.id_convenio=$request->id_convenio"));
        }
        return response()->json($data);

    }



    public function ajaxBeneficiario(Request $request){
        if(isset($request->id_etapa_aplic)) {
            $data = DB::select(DB::raw("select id_pessoa, nm_pessoa_completo from ac_etapa_participantes
                            inner join pessoa..pessoa p on p.id_pessoa=id_pessoa_participante
                            where id_etapa_aplic=$request->id_etapa_aplic"));
        }
        return response()->json( $data);
    }

    public function ajaxPessoa(Request $request){
        if(isset($request->id_pessoa)){
            $data=$request->id_pessoa ;
        }
        return response()->json($data);
    }

    public function ajaxConta (Request $request){
        if(isset($request->id_pessoa)){
            $data = DB::select(DB::raw("select seq_bancario, nr_banco, nr_agencia, nr_conta, nr_dac
                      from pessoa..bancario b noholdlock
                         where id_pessoa = $request->id_pessoa order BY  seq_bancario"));
        }return response()->json($data);
    }

    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public function store(PrevioEmpenhoRequest $request)
    {
        $input = $request->all();
        //tratamentodados
        $input['ano_rpe'] = date('Y');
        $retorno_dt_rpe = explode('/', $input['dt_rpe']);
        $valorprevio = str_replace(".", "", $input['vl_previo_empenho']);
        $valorprevio = str_replace(",", ".", $valorprevio);
        $input = $this->array_push_assoc($input, 'dt_rpe', $retorno_dt_rpe[2] . "-" . $retorno_dt_rpe[1] . "-" . $retorno_dt_rpe[0]);
        $input = $this->array_push_assoc($input, 'vl_previo_empenho', $valorprevio);
        //endtratamentodados
        /*        dd($input);*/
        unset($input['id_convenio']);
        $input['nr_rpe'] = DB::table('ac_previo_empenho')->max('nr_rpe')+1;
        SweetAlert::success('Prévio Empenho cadastrado com sucesso!');
        PrevioEmpenho::create($input);
        return redirect()->route('previoempenho');
    }

    public function show($id)
    {
        //
    }

    public function Editar($id)
    {
        try {

            $p = DB::TABLE('AC_PREVIO_EMPENHO')
                    ->where('id_rpe', $id)
                    ->JOIN('AC_ETAPA_APLIC', 'AC_ETAPA_APLIC.id_etapa_aplic', '=', 'AC_PREVIO_EMPENHO.id_etapa_aplic')
                    ->JOIN('AC_META_APLIC', 'AC_ETAPA_APLIC.id_aplicacao', '=', 'AC_META_APLIC.id_aplicacao')
                    ->SELECT('AC_PREVIO_EMPENHO.*', 'AC_META_APLIC.id_aplicacao', 'AC_META_APLIC.id_convenio')
                    ->first();

            $p->vl_previo_empenho = str_replace(".", ",",  $p->vl_previo_empenho);

            $cd_tpcompra = \App\TipoCompra::all();
            $fontes = \App\Fonte::all();
            $convenios = \App\Convenio::all();
            $moeda = \App\Moeda::all();

            $etapas = DB::select(DB::raw("select id_etapa_aplic, ds_titulo_etapa from AC_ETAPA_APLIC E noholdlock
                        inner join AC_META_APLIC M noholdlock on m.id_aplicacao=e.id_aplicacao
                              and m.id_convenio=$p->id_convenio"));

            $pessoas = DB::TABLE('AC_ETAPA_PARTICIPANTES')
                        ->join('PESSOA..PESSOA', 'PESSOA..PESSOA.id_pessoa', '=', 'AC_ETAPA_PARTICIPANTES.id_pessoa_participante')
                        ->where('id_etapa_aplic', $p->id_etapa_aplic)
                        ->SELECT('AC_ETAPA_PARTICIPANTES.*', 'PESSOA..PESSOA.nm_pessoa_completo')
                        ->get();

            $ccgeral= DB::select(DB::raw("select seq_bancario, nr_banco, nr_agencia, nr_conta, nr_dac
                      from pessoa..bancario b noholdlock
                         where id_pessoa = $p->id_pessoa ORDER by seq_bancario"));

        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->route('previoempenho')->with('message', 'Houve um erro desconhecido, por favor contate o NTI.');
        }

        $old_dt_rpe = $p->dt_rpe;
        $new_dt_rpe = date('d/m/Y', strtotime($old_dt_rpe));
        $p->dt_rpe = $new_dt_rpe;

        return view('previoempenho.Editar')
            ->with('previoempenho', $p)
            ->with('cd_tpcompra', $cd_tpcompra)
            ->with('fontes', $fontes)
            ->with('convenios', $convenios)
            ->with('moeda', $moeda)
            ->with('etapas', $etapas)
            ->with('pessoas', $pessoas)
            ->with('ccgeral', $ccgeral);
    }

    public function atualizabanco(PrevioEmpenhoRequest $request, $id){
        $input = $request->all();
        //tratamentodados
        $retorno_dt_rpe = explode('/', $input['dt_rpe']);
        $valorprevio = str_replace(".", "", $input['vl_previo_empenho']);
        $valorprevio = str_replace(",", ".", $valorprevio);
        $input = $this->array_push_assoc($input, 'dt_rpe', $retorno_dt_rpe[2] . "-" . $retorno_dt_rpe[1] . "-" . $retorno_dt_rpe[0]);
        $input = $this->array_push_assoc($input, 'vl_previo_empenho', $valorprevio);
        //endtratamentodados
        /* dd($input);*/
        unset($input['id_convenio']);
        unset($input['nr_rpe']);
        unset($input['ano_rpe']);

        try {
          $p= \App\PrevioEmpenho::where('id_rpe', $id)->update([
            'cd_tpcompra' => $input['cd_tpcompra'],
            'cd_fonte' =>$input['cd_fonte'],
            'id_etapa_aplic' =>$input['id_etapa_aplic'],
            'id_pessoa'=>$input['id_pessoa'],
            'seq_bancario'=>$input['seq_bancario'],
            'ds_objetivo'=>$input['ds_objetivo'],
            'vl_previo_empenho'=>$input['vl_previo_empenho'],
            'id_moeda'=>$input['id_moeda'],
            'tp_rpe'=>$input['tp_rpe'],
            'dt_rpe'=>$input['dt_rpe'],
          ]);
          SweetAlert::success('Prévio Empenho atualizado com sucesso!');
          return redirect()->route('previoempenho');
        } catch (Exception $e) {
          return redirect()->route('previoempenho')->with('message', 'Previo Empenho não pôde ser atualizado.');
        }



    }

    //função deletar original
     public function Deletar($id_rpe){
         try{
             $previoempenho = \App\PrevioEmpenho::where('id_rpe', $id_rpe);
             $previoempenho->delete();

             SweetAlert::success('Prévio Empenho removido com sucesso!');
             return redirect()->route('previoempenho');
         }catch (QueryException $e){
             return redirect()->route('previoempenho')->with('message', 'Previo Empenho não pode ser excluido por dependencia.');
         }
     }

    // public function ajaxDelete(Request $request) {
    //     $data = \App\PrevioEmpenho::where('nr_rpe', $request->nr_rpe);
    //     $data->delete($request->nr_rpe);
    //     return response()->json($data);
    // }
}
