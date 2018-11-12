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
            $nr_convenio = DB::select(DB::raw("select nr_convenio FROM AC_CONVENIO A noholdlock GROUP BY nr_convenio ORDER BY 1 DESC"));
            $cd_tpcompra = DB::select(DB::raw("select * from compras..tipo_compra  noholdlock"));
            $cd_fonte = DB::select(DB::raw("select cd_fonte, nm_fonte from compras..fonte f noholdlock where cd_ativo='S'"));
            //dd($cd_fonte);
            $ano_convenio = DB::select(DB::raw("SELECT ano_convenio FROM AC_CONVENIO A noholdlock GROUP BY ano_convenio ORDER BY 1 DESC"));
            $financiador = DB::select(DB::raw("SELECT id_financiador,nm_financiador FROM AC_FINANCIADOR F noholdlock GROUP BY nm_financiador ORDER BY nm_financiador"));
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
            ->with('financiador', $financiador)
            ->with('ano_convenio',$ano_convenio)
            ->with('nr_convenio', $nr_convenio);
    }

    public function ajaxEtapaAplic(Request $request){
        if(isset($request->id_financiador) && isset($request->nr_convenio) && isset($request->ano_convenio)) {
            $data = DB::select(DB::raw("select id_etapa_aplic, ds_titulo_etapa from AC_ETAPA_APLIC E noholdlock
                        inner join AC_META_APLIC M noholdlock on m.id_aplicacao=e.id_aplicacao
                              and m.id_financiador=$request->id_financiador and m.nr_convenio=$request->nr_convenio
                              and m.ano_convenio=$request->ano_convenio"));
        }
        return response()->json( $data);

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
        //dd($input);
        //tratamentodados
        if (DB::table('ac_previo_empenho')->where('nr_rpe', $input['nr_rpe'])->count() <> 0){
            $input['nr_rpe'] = DB::table('ac_previo_empenho')->max('nr_rpe')+1;
        }
        $input['ano_rpe'] = date('Y');
        $retorno_dt_rpe = explode('/', $input['dt_rpe']);
        $valorprevio = str_replace(".", "", $input['vl_previo_empenho']);
        $valorprevio = str_replace(",", ".", $valorprevio);
        $input = $this->array_push_assoc($input, 'dt_rpe', $retorno_dt_rpe[2] . "-" . $retorno_dt_rpe[1] . "-" . $retorno_dt_rpe[0]);
        $input = $this->array_push_assoc($input, 'vl_previo_empenho', $valorprevio);

        if($input['tp_beneficiario']=='Servidor'){
            $input['tp_beneficiario'] = 'S';
        }
        if($input['tp_beneficiario']=='Acadêmico'){
            $input['tp_beneficiario'] = 'A';
        }
        if($input['tp_beneficiario']=='Convidado'){
            $input['tp_beneficiario'] = 'C';
        }
        //endtratamentodados
        /*        dd($input);*/
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

            $p = \App\PrevioEmpenho::where('nr_rpe', $id)->get();

            $valorprevio = explode(".",  $p[0]->vl_previo_empenho);

            $valorprevio = $valorprevio[0];

            $p[0]->vl_previo_empenho = $valorprevio;

            $cd_tpcompra = \App\TipoCompra::all();
            $financiadores = \App\Financiador::all();
            $fonte = \App\Fonte::all();
            $convenios = \App\Convenio::all();
            $moeda = \App\Moeda::all();
            $tp_beneficiario = $p[0]->tp_beneficiario;
            if($tp_beneficiario == 'S') {
                $tp_beneficiario = 'Servidor';
            }
            if($tp_beneficiario == 'A') {
                $tp_beneficiario = 'Acadêmico';
            }
            if($tp_beneficiario == 'C') {
                $tp_beneficiario = 'Convidado';
            }

            $tp_rpe=$p[0]->tp_rpe;
            if($tp_rpe == 'D'){
                $tp_rpe="Diaria";
            }
            if($tp_rpe == 'A'){
                $tp_rpe= "Auxílio Financeiro";
            }

            //foreing key de convenio
            $cd = \App\TipoCompra::where('cd_tpcompra', $p[0]->cd_tpcompra)->get();
            $aux=$p[0]->id_etapa_aplic;
            $f = DB::select(DB::raw("select * from ac_financiador F inner join ac_meta_aplic M
            on F.id_financiador=M.id_financiador inner join ac_etapa_aplic E on M.id_aplicacao=E.id_aplicacao
            inner join ac_previo_empenho P on E.id_etapa_aplic=$aux"));
            $id_financiador=$f[0]->id_financiador;
            $ano_convenio=$f[0]->ano_convenio;
            $nr_convenio=$f[0]->nr_convenio;

            $cd_fonte = \App\Fonte::where('cd_fonte', $p[0]->cd_fonte)->get();

            $aplic = \App\EtapaAplicacao::where('id_etapa_aplic', $p[0]->id_etapa_aplic)->get();
            $aplicgeral=DB::select(DB::raw("select id_etapa_aplic, ds_titulo_etapa from AC_ETAPA_APLIC E noholdlock
                        inner join AC_META_APLIC M noholdlock on m.id_aplicacao=e.id_aplicacao
                              and m.id_financiador=$id_financiador and m.nr_convenio=$nr_convenio
                              and m.ano_convenio=$ano_convenio"));
            $moeda = \App\Moeda::all();
            $pessoa= \App\Pessoa::where('id_pessoa', $p[0]->id_pessoa)->get();
            $moedap=\App\Moeda::where('id_moeda', $p[0]->id_moeda)->get();
            $aux2=$p[0]->id_pessoa;
            $aux3=$p[0]->seq_bancario;

            $cc= DB::select(DB::raw("select seq_bancario, nr_banco, nr_agencia, nr_conta, nr_dac
                      from pessoa..bancario b noholdlock 
                         where id_pessoa = $aux2 and seq_bancario = $aux3"));

            $ccgeral= DB::select(DB::raw("select seq_bancario, nr_banco, nr_agencia, nr_conta, nr_dac
                      from pessoa..bancario b noholdlock 
                         where id_pessoa = $aux2 ORDER by seq_bancario"));
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }

        $old_dt_rpe = $p[0]['dt_rpe'];
        $new_dt_rpe = date('d/m/Y', strtotime($old_dt_rpe));
        $p[0]['dt_rpe'] = $new_dt_rpe;

        return view('previoempenho.Editar')->with('previoempenho', $p)
            ->with('cd_tpcompra', $cd_tpcompra)
            ->with('fonte', $fonte)
            ->with('convenios', $convenios)
            ->with('financiadores', $financiadores)
            ->with('financiador', $f)
            ->with('moeda', $moeda)
            ->with('cd', $cd)
            ->with('cd_fonte', $cd_fonte)
            ->with('aplic', $aplic)
            ->with('pessoa', $pessoa)
            ->with('tp_beneficiario', $tp_beneficiario)
            ->with('moedap', $moedap)
            ->with('tp_rpe', $tp_rpe)
            ->with('cc', $cc)
            ->with('ccgeral', $ccgeral)
            ->with('aplicgeral', $aplicgeral);
    }

    public function atualizabanco(PrevioEmpenhoRequest $request, $id){
        $input = $request->all();
//        dd($input);
        //tratamentodados
        $texto=$input['ds_objetivo'];
        $this->substitui_char_especial($texto);

        $str = mb_convert_encoding($texto, "ISO-8859-1");
        //dd($str);
        $retorno_dt_rpe = explode('/', $request->dt_rpe);
        $valorprevio = str_replace(".", "", $request->vl_previo_empenho);
        $valorprevio = str_replace(",", ".", $valorprevio);
        $input = $this->array_push_assoc($input, 'dt_rpe', $retorno_dt_rpe[2] . "-" . $retorno_dt_rpe[1] . "-" . $retorno_dt_rpe[0]);
        $input = $this->array_push_assoc($input, 'vl_previo_empenho', $valorprevio);

        if($request->tp_beneficiario=='Servidor'){
            $input['tp_beneficiario'] = 'S';
        }
        if($request->tp_beneficiario=='Acadêmico'){
            $input['tp_beneficiario'] = 'A';
        }
        if($request->tp_beneficiario=='Convidado'){
            $input['tp_beneficiario'] = 'C';
        }

        if($request->tp_rpe=='Auxílio Financeiro'){
            $input['tp_rpe'] = 'A';
        }
        if($request->tp_rpe=='Diaria'){
            $input['tp_rpe'] = 'D';
        }
        //dd($input);
        //endtratamentodados

        //dd($input);

        /*         $p= \App\PrevioEmpenho::where('nr_rpe', $id)->update($input);*/

        $p= \App\PrevioEmpenho::where('nr_rpe', $id)->update([
            'cd_tpcompra' => $input['cd_tpcompra'],
            'cd_fonte' =>$input['cd_fonte'],
            'id_etapa_aplic' =>$input['id_etapa_aplic'],
            'tp_beneficiario' =>$input['tp_beneficiario'],
            'id_pessoa'=>$input['id_pessoa'],
            'seq_bancario'=>$input['seq_bancario'],
//            'ds_objetivo'=>$input['ds_objetivo'],
            'ds_objetivo'=>$str,
            'vl_previo_empenho'=>$input['vl_previo_empenho'],
            'id_moeda'=>$input['id_moeda'],
            'tp_rpe'=>$input['tp_rpe'],
            'dt_rpe'=>$input['dt_rpe'],
        ]);

        //$p = PrevioEmpenho::find($input['nr_rpe'],$input['nr_rpe'])->update($input);
        //dd($p);

        return redirect()->route('previoempenho');
    }

    //função deletar original
    /* public function Deletar($id){
         try{
             $previoempenho = \App\PrevioEmpenho::where('nr_rpe', $id);
             $previoempenho->delete($id);

             return redirect()->route('previoempenho');
         }catch (QueryException $e){
             return redirect()->route('previoempenho')->with('message', 'Previo Empenho não pode ser excluido por dependencia.');
         }
     }*/

    public function ajaxDelete(Request $request) {
        $data = \App\PrevioEmpenho::where('nr_rpe', $request->nr_rpe);
        $data->delete($request->nr_rpe);
        return response()->json($data);
    }
}
