<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ConvenioRequest;
use App\Http\Requests\InstituicaoRequest;
use App\Http\Requests\PessoaFisicaRequest;
use App\Http\Requests\PessoaConvenioRequest;
use App\Pessoa;
use App\PessoaFisica;
use App\PessoaJuridica;
use App\Participantes;
use App\Convenio;
use App\Anexo;
use Storage;
use File;
use DB;

class PessoaConvenioController extends Controller
{
    public function Index()
    {

        $pessoas = DB::TABLE('AC_PARTICIPANTES')
                  ->JOIN('PESSOA..PESSOA_JURIDICA', 'AC_PARTICIPANTES.id_pessoa_instituição', '=', 'PESSOA..PESSOA_JURIDICA.id_pessoa')
                  ->JOIN('PESSOA..PESSOA', 'AC_PARTICIPANTES.id_pessoa_participante', '=', 'PESSOA..PESSOA.id_pessoa')
                  ->JOIN('AC_CONVENIO', 'AC_PARTICIPANTES.id_convenio', '=', 'AC_CONVENIO.id_convenio')
                  ->SELECT('AC_PARTICIPANTES.*', 'AC_CONVENIO.ds_sigla_objeto', 'AC_CONVENIO.nr_convenio', 'PESSOA..PESSOA.nm_pessoa_abreviado', 'PESSOA..PESSOA_JURIDICA.nm_fantasia')
                  ->get();

        return view('pessoaconvenio.PessoaConvenio')->with('pessoas', $pessoas);
    }

    public
    function Visualizar($id_convenio, $id_pessoa)
    {
        $p = \App\Participantes::where('nr_convenio', $id_convenio)->where('id_pessoa_participante', $id_pessoa)->get();

        $pes = \App\Pessoa::where('id_pessoa', $p[0]['id_pessoa_participante'])->get();
        $ins = \App\PessoaJuridica::where('id_pessoa', $p[0]['id_pessoa_instituicao'])->get();
        $con = \App\Convenio::where('nr_convenio', $p[0]['nr_convenio'])->get();
        $fin = \App\Financiador::where('id_financiador', $con[0]['id_financiador'])->get();
//        dd($con);
        return view('pessoaconvenio.Visualizar')->with('pessoa', $pes)->with('instituicao', $ins)->with('convenio', $con)->with('financiador', $fin)->with('p', $p);
    }

    public
    function adicionar()
    {
        $p = DB::select(DB::raw('select * from pessoa..pessoa p inner join pessoa..pessoa_fisica f
            on p.id_pessoa = f.id_pessoa'));

        $c = DB::TABLE('AC_CONVENIO')->select('id_convenio', 'ds_sigla_objeto')->get();

        //dd($p);
        /*$pf = \App\PessoaFisica::all();
        $pj = \App\PessoaJuridica::orderBy('nm_fantasia', 'asc')->get();*/
        $f = \App\Financiador::all();
        return view('pessoaconvenio.Cadastrar')/*->with('pessoa', $p)->with('pessoafisica', $pf)->with('pessoajuridica', $pj)*/->with('financiador', $f)->with('convenio', $c);
    }

    public
    function store(PessoaConvenioRequest $request)
    {
        $input = $request->all();
        //dd($input);

        $id_instituicao = \App\PessoaJuridica::where('cnpj', $new_cnpj)->get();

        $vetor = array();

        $vetor['id_convenio'] = $input['id_convenio'];
        $vetor['id_pessoa_participante'] = $input['id_pessoa_participante'];
        $vetor['id_pessoa_instituição'] = $id_instituicao;
        $vetor['cd_coordenador'] = $input['cd_coordenador'];
        $vetor['cd_categoria'] = $input['cd_categoria'];

        $vetor['id_pessoa_instituicao'] = $id_instituicao[0]->id_pessoa;


        Participantes::create($vetor);

        return \Redirect::to('planodetrabalho');
    }

    public
    function Editar($id_convenio, $id_pessoa)
    {
        $p = \App\Participantes::where('nr_convenio', $id_convenio)->where('id_pessoa_participante', $id_pessoa)->get();

        $pes = \App\Pessoa::where('id_pessoa', $p[0]['id_pessoa_participante'])->get();
        $ins = \App\PessoaJuridica::where('id_pessoa', $p[0]['id_pessoa_instituicao'])->get();
        $con = \App\Convenio::where('nr_convenio', $p[0]['nr_convenio'])->get();
        $fin = \App\Financiador::where('id_financiador', $con[0]['id_financiador'])->get();

        $pj = \App\Pessoa::where('id_pessoa', $p[0]['id_pessoa_instituicao'])->get();

        /*$pessoas = \App\Pessoa::all();
        $pj = \App\PessoaJuridica::all();
        $con = \App\Convenio::all();*/

        // dd($fin);
        return view('pessoaconvenio.Editar')->with('id_convenio', $id_convenio)->with('id_pessoa', $id_pessoa)
            ->with('pessoa', $pes)->with('con', $con)->with('pj', $pj)/*->with('pessoas', $pessoas)*/
            ->with('pessoajuridica', $ins)->with('convenio', $con)->with('financiador', $fin)->with('p', $p);
    }

    public
    function atualizabanco(PessoaConvenioRequest $request)
    {
        //modificar de acordo com o que está na view
        $input = $request->all();
        $vetor = array();
        $vetor['id_pessoa_instituicao'] = $input['cnpj_instituicao'];
        $vetor['cd_coordenador'] = $input['cd_coordenador'];

        $f = Participantes::where('nr_convenio', $input['nr_convenio'])->where('id_pessoa_participante', $input['id_pessoa'])->update($vetor);
        return redirect()->route('pessoaconvenio');
    }

    public
    function Deletar($id_convenio, $id_pessoa)
    {
        DB::beginTransaction();
        try {
            $part = \App\Participantes::where('nr_convenio', $id_convenio)->where('id_pessoa_participante', $id_pessoa)->get();
            $part->delete();
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(array('msg' => 'O cadastro não pode ser excluído porque possui dependência.', 'status' => 'Error'));
        }
        catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(array('msg' => 'O cadastro não pode ser excluído porque possui dependência.', 'status' => 'Error'));
        }
        DB::commit();
        return response()->json(array('msg' => 'Cadastro excluído com sucesso.', 'status' => 'Success'));
    }

    public function ajaxInst(Request $request){
        $new_cnpj = str_replace(".","",$request->cnpj);
        $new_cnpj = str_replace("-","",$new_cnpj);
        $new_cnpj = str_replace("/","",$new_cnpj);

        $inst = DB::select(DB::raw("select nm_pessoa_completo from pessoa..pessoa p
                inner join pessoa..pessoa_juridica pj on p.id_pessoa = pj.id_pessoa
                where pj.cnpj = '$new_cnpj'"));

        return response()->json($inst[0]->nm_pessoa_completo);
    }


    public
    function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }


    public
    function MissingMethod($params = array())
    {
        return 'Nada encontrado';
    }

}
