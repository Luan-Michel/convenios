<?php

namespace App\Http\Controllers;

use App\Anexo;
use App\Email;
use App\Http\Requests\InstituicaoRequest;
use App\Http\Requests\PessoaFisicaRequest;
use App\Http\Requests\PessoaJuridicaRequest;
use App\Pessoa;
use App\PessoaFisica;
use App\PessoaJuridica;
use DB;
use File;
use Illuminate\Http\Request;
use Storage;

//use Illuminate\Support\Facades\DB;

class PessoaController extends Controller
{
    public function Index()    {

        //dd($pessoaj);


        $p = null;
        return view('pessoa.Pessoa');

    }

    public function ajaxDelete(Request $request)     {
        $servidor = DB::select(DB::raw("SELECT count(*) FROM drh..matricula_serv m noholdlock
                     WHERE m.id_pessoa = $request->id_pessoa AND convert(CHAR,m.dt_adm,112) <= convert(CHAR,getdate(),112)
                     AND (m.dt_demis=NULL OR convert(CHAR,m.dt_demis,112) > convert(CHAR,getdate(),112))
                     AND m.cd_classe NOT IN (18,23)"));

        if ($servidor[0]->computed0 <> 0) {
            return response()->json(array('msg' => 'O cadastro não pode ser excluído porque é um Servidor.', 'status' => 'Error'));
        } else {
            //realizar transactions
            DB::beginTransaction();

            //TROCAR TABELAS PARA PESSOA.. APÓS CONCLUÍDO
            try {
                //Pessoa Física

                DB::table('pess_te..pessoa_fisica')->where('id_pessoa', $request->id_pessoa)->delete();
                DB::table('pess_te..e_mail')->where('id_pessoa', $request->id_pessoa)->delete();

                //Pessoa Jurídica
                DB::table('pess_te..pessoa_juridica')->where('id_pessoa', $request->id_pessoa)->delete();

                //Pessoa
                DB::table('pess_te..pessoa')->where('id_pessoa', $request->id_pessoa)->delete();

            }
            catch (\Exception $e) {
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
    }

    public function ajaxPesquisaPessoa(Request $request) {
        $p=DB::select(DB::raw("select P.id_pessoa, nm_pessoa_completo, cnpj, cpf from pess_te..pessoa P 
                               left join pess_te..pessoa_fisica F on P.id_pessoa = F.id_pessoa
                               left join pess_te..pessoa_juridica J on P.id_pessoa = J.id_pessoa
                               where nm_pessoa_completo like '%$request->search%' order by nm_pessoa_completo"));
        return response()->json($p);
    }

    public function convenioAnexo($id) {
        $anexo = Anexo::where('id_anexo', $id)->get();
        $filename = $anexo[0]['ds_titulo_anexo'];
        $path = storage_path() . '/uploads/' . $filename;

        if (!File::exists($path)) abort(404);
        $file = File::get($path);
        $type = File::mimeType($path);
        File::delete($path);
        $ane = \App\Anexo::where('id_anexo', $id);
        $ane->delete();
        return $id;
    }

    public function convenioFinanciador($id) {
        $retorno = \App\Convenio::where('id_financiador', $id)->get();
//        var_dump($retorno);
        return $retorno;
    }

    public function Pessoa() {
        $p = \App\Participantes::all();
        $vetorpessoa[] = array();
        $vetorinstituicao[] = array();
        $vetorconvenio[] = array();
        foreach ($p as $key => $value) {
            $pes = \App\Pessoa::where('id_pessoa', $p[$key]['id_pessoa_participante'])->get();
            $ins = \App\PessoaJuridica::where('id_pessoa', $p[$key]['id_pessoa_instituicao'])->get();
            $con = \App\Convenio::where('nr_convenio', $p[$key]['nr_convenio'])->get();
            $vetorpessoa[$key] = $pes[0]['nm_pessoa_completo'];
            $vetorinstituicao[$key] = $ins[0]['nm_fantasia'];
            $vetorconvenio[$key] = $con[0]['ds_sigla_objeto'];
        }
        return view('pessoa.PessoaConvenio')->with('pessoa', $vetorpessoa)->with('instituicao', $vetorinstituicao)->with('convenio', $vetorconvenio)->with('p', $p);
    }

//endmain
//visualizar

    public function VisualizarPessoaConvenio($id_convenio, $id_pessoa) {
        $p = \App\Participantes::where('nr_convenio', $id_convenio)
            ->where('id_pessoa_participante', $id_pessoa)->get();
        $pes = \App\Pessoa::where('id_pessoa', $p[0]['id_pessoa_participante'])->get();
        $ins = \App\PessoaJuridica::where('id_pessoa', $p[0]['id_pessoa_instituicao'])->get();
        $con = \App\Convenio::where('nr_convenio', $p[0]['nr_convenio'])->get();
        $fin = \App\Financiador::where('id_financiador', $con[0]['id_financiador'])->get();
//        dd($con);
        return view('pessoa.VisualizarPessoaConvenio')->with('pessoa', $pes)->with('instituicao', $ins)->with('convenio', $con)->with('financiador', $fin)->with('p', $p);
    }

    public function adicionarpessoafisica() {
        return view('pessoa.CadastrarPessoaFisica');
    }

    public function adicionarinstituicao() {
        return view('pessoa.CadastrarInstituicao');
    }

    public function Email($id, $seq) {
        DB::beginTransaction();
        try {
            $email = Email::where('id_pessoa', $id)->where('seq_email', $seq);
            $email->delete();
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(array('msg' => 'O E-mail não pode ser excluído.', 'status' => 'Error'));
        }
        catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(array('msg' => 'O E-mail não pode ser excluído.', 'status' => 'Error'));
        }

        DB::commit();
        return response()->json(array('msg' => 'E-mail excluído com sucesso.', 'status' => 'Success'));

//        return $id;

    }

    public function storeinstituicao(InstituicaoRequest $request) {
        $input = $request->all();
        $new_cnpj = str_replace(".","",$input['cnpj']);
        $new_cnpj = str_replace("-","",$new_cnpj);
        $new_cnpj = str_replace("/","",$new_cnpj);
        $new_cd_siaf = str_replace(".","",$input['cd_siaf']);
        $nome = $input['nm_fantasia'];
        $nm_abreviado = DB::select(DB::raw("SELECT pessoa.dbo.gera_nome_abreviado('$nome', 40)"));

        $input = $this->array_push_assoc($input, 'nm_pessoa_completo', $input['nm_fantasia']);
        $input = $this->array_push_assoc($input, 'nm_pessoa_abreviado', $nm_abreviado[0]->computed0);
        $input = $this->array_push_assoc($input, 'cnpj', $new_cnpj);
        $input = $this->array_push_assoc($input, 'cd_siaf', $new_cd_siaf);

        $pessoa = Pessoa::create($input);
        $idpessoa = $pessoa->id_pessoa;
        $input = $this->array_push_assoc($input, 'id_pessoa', $idpessoa);
        $pessoajuridica = PessoaJuridica::create($input);

        $vetor = array();
        foreach ($input['email'] as $key => $email) {
            $vetor[$key]['ds_email'] =  $email;
            $vetor[$key]['seq_email'] =  $key+1;
            $vetor[$key]['id_pessoa'] =  $idpessoa;
            Email::create($vetor[$key]);
        }
        return redirect()->route('pessoa');
    }

    public function storepessoafisica(PessoaFisicaRequest $request) {
        $input = $request->all();
        $new_cpf = str_replace(".","",$input['cpf']);
        $new_cpf = str_replace("-","",$new_cpf);
        $input = $this->array_push_assoc($input, 'cpf', $new_cpf);
        dd($input);
        $pessoa = Pessoa::create($input);
        $idpessoa = $pessoa->id_pessoa;
        $input = $this->array_push_assoc($input, 'id_pessoa', $idpessoa);
        $pessoafisica = PessoaFisica::create($input);

        $vetor = array();
        foreach ($input['email'] as $key => $email) {
            $vetor[$key]['ds_email'] =  $email;
            $vetor[$key]['seq_email'] =  $key+1;
            $vetor[$key]['id_pessoa'] =  $idpessoa;
            Email::create($vetor[$key]);
        }
        return redirect()->route('pessoa');
    }
//endstore
//editar

    public function Editar($id) {
        $p = Pessoa::where('id_pessoa', $id)->get();
        $pf = PessoaFisica::where('id_pessoa', $id)->get();
        $pj = PessoaJuridica::where('id_pessoa', $id)->get();
        $e = Email::where('id_pessoa', $id)->get();

        $servidor = DB::select(DB::raw("SELECT count(*) FROM drh..matricula_serv m noholdlock
                     WHERE m.id_pessoa = $id AND convert(CHAR,m.dt_adm,112) <= convert(CHAR,getdate(),112)
                     AND (m.dt_demis=NULL OR convert(CHAR,m.dt_demis,112) > convert(CHAR,getdate(),112))
                     AND m.cd_classe NOT IN (18,23)"));
        $valida_serv = '0';
        if ($servidor[0]->computed0 <> 0) {
            $valida_serv = '1';
            \Session::flash('message_serv', 'Cadastro não pode ser alterado porque é um servidor.');
        }

        if(isset($pf[0])){
            return view('pessoa.EditarPessoaFisica')->with('pessoa', $p)->with('pessoafisica', $pf)->with('email', $e)->with('valida_serv',$valida_serv);
        }
        if(isset($pj[0])){
            return view('pessoa.EditarInstituicao')->with('pessoa', $p)->with('pessoajuridica', $pj)->with('email', $e);
        }
    }

    public function Visualizar($id) {
        $p = Pessoa::where('id_pessoa', $id)->get();
        $pf = PessoaFisica::where('id_pessoa', $id)->get();
        $pj = PessoaJuridica::where('id_pessoa', $id)->get();
        $e = Email::where('id_pessoa', $id)->get();

        if(isset($pj[0])){
            return view('pessoa.VisualizarInstituicao')->with('pessoa', $p)->with('pessoajuridica', $pj)->with('email', $e);
        }
        if(isset($pf[0])){
            return view('pessoa.VisualizarPessoaFisica')->with('pessoa', $p)->with('pessoafisica', $pf)->with('email', $e);
        }
    }

    public function atualizabancopessoafisica(PessoaFisicaRequest $request, $id) {

        $input = $request->all();
        $new_cpf = str_replace(".","",$input['cpf']);
        $new_cpf = str_replace("-","",$new_cpf);
        $input = $this->array_push_assoc($input, 'cpf', $new_cpf);

        $pf = \App\PessoaFisica::where('id_pessoa', $id)->update([
            'cpf' => $input['cpf'],
        ]);

        // email_usr é o email que usuário já tem cadastrado
        $max_seq = DB::table('pess_te..e_mail')->where('id_pessoa', $id)->max('seq_email');
//        dd($max_seq);

        for($i = 1; $i <= $max_seq; $i++)
            $e = \App\Email::where('id_pessoa',$id)->where('seq_email',$i)->update([
                'ds_email' =>  $input[$i],
            ]);
//        };

        if($input['email'][0] != "") {
            $vetor = array();
            foreach ($input['email'] as $key => $email) {
                $vetor[$key]['ds_email'] = $email;
                $vetor[$key]['seq_email'] = $max_seq + 1;
                $vetor[$key]['id_pessoa'] = $id;
                Email::create($vetor[$key]);
            };
        }

        $p = \App\Pessoa::where('id_pessoa', $id)->update([
            'nm_pessoa_completo' => $input['nm_pessoa_completo'],
            'nm_pessoa_abreviado' => $input['nm_pessoa_abreviado'],
        ]);
//        dd($input);

        return redirect()->route('pessoa');
    }

    public function atualizabancopessoajuridica(PessoaJuridicaRequest $request, $id) {
        $input = $request->all();

        $new_cnpj = str_replace(".","",$input['cnpj']);
        $new_cnpj = str_replace("-","",$new_cnpj);
        $new_cnpj = str_replace("/","",$new_cnpj);
        $new_cd_siaf = str_replace(".","",$input['cd_siaf']);
        $input = $this->array_push_assoc($input, 'cnpj', $new_cnpj);
        $input = $this->array_push_assoc($input, 'cd_siaf', $new_cd_siaf);

        $pf = \App\PessoaJuridica::where('id_pessoa', $id)->update([
            'cnpj' => $input['cnpj'],
        ]);

        // email_usr é o email que usuário já tem cadastrado
        $max_seq = DB::table('pess_te..e_mail')->where('id_pessoa', $id)->max('seq_email');

        for($i = 1; $i <= $max_seq; $i++)
            $e = \App\Email::where('id_pessoa',$id)->where('seq_email',$i)->update([
                'ds_email' =>  $input[$i],
            ]);

//    dd($input);

        if($input['email'][0] != "") {
            $vetor = array();
            foreach ($input['email'] as $key => $email) {
                $vetor[$key]['ds_email'] = $email;
                $vetor[$key]['seq_email'] = $max_seq + 1;
                $vetor[$key]['id_pessoa'] = $id;
                Email::create($vetor[$key]);
            };
        }

            $aux = $input['nm_fantasia'];
            $nm_abreviado = DB::select(DB::raw("SELECT pessoa.dbo.gera_nome_abreviado( '$aux', 40)"));

        $p = \App\Pessoa::where('id_pessoa', $id)->update([
            'nm_pessoa_completo' => $input['nm_fantasia'],
            'nm_pessoa_abreviado' => $nm_abreviado[0]->computed0,

        ]);

        dd($input);

        return redirect()->route('pessoa');
    }

//deletar
    public function Deletar($id) {
        return redirect()->route('pessoa');
    }

    public function array_push_assoc($array, $key, $value) {
        $array[$key] = $value;
        return $array;
    }

    public function MissingMethod($params = array()) {
        return 'Nada encontrado';
    }

    public function valida_cpf(Request $request){
        $new_cpf = str_replace(".","",$request->cpf);
        $new_cpf = str_replace("-","",$new_cpf);

        $cpf = DB::table('pessoa..pessoa_fisica')->where('cpf',$new_cpf)->get();

        if( $cpf[0]->id_pessoa <> null ){

            return response()->json($cpf[0]->id_pessoa);
        }
    }

    public function valida_cnpj(Request $request){
        $new_cnpj = str_replace(".","",$request->cnpj);
        $new_cnpj = str_replace("-","",$new_cnpj);
        $new_cnpj = str_replace("/","",$new_cnpj);

        $cnpj = DB::table('pessoa..pessoa_juridica')->where('cnpj',$new_cnpj)->get();

        if( $cnpj[0]->id_pessoa <> null ){
            return response()->json($cnpj[0]->id_pessoa);
        }
    }

    public function gera_nome_abreviado(Request $request){

            $nm_abreviado = DB::select(DB::raw("SELECT pessoa.dbo.gera_nome_abreviado('$request->nome', 40)"));
            return response()->json($nm_abreviado[0]->computed0);

    }

}