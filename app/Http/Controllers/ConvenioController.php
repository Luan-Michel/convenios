<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use UxWeb\SweetAlert\SweetAlert;
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
use PhpParser\Node\Stmt\Throw_;
use Validator;
use Storage;
use File;
use DB;


class ConvenioController extends Controller
{
    public function Index()
    {
        /* $c = \App\Convenio::all();
         foreach ($c as $key => $vetor) {
             $f = \App\Financiador::where('id_financiador', $c[$key]['id_financiador'])->get();
             $c[$key] = $this->array_push_assoc($c[$key], 'id_financiador', $f[0]['nm_financiador']);
         }*/
        $c = DB::select(DB::raw("select * from ac_convenio c inner join ac_financiador f on c.id_financiador = f.id_financiador
                order By ano_convenio desc, nr_convenio desc "));

        return view('convenio.Convenio')->with('convenio',$c);
    }

    public function convenioAnexo($id)
    {
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

    public function convenioFinanciador($id)
    {
        $retorno = \App\Convenio::where('id_financiador', $id)->get();
//        var_dump($retorno);
        return $retorno;
    }

    public function Pessoa()
    {
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
        return view('convenio.PessoaConvenio')->with('pessoa', $vetorpessoa)
            ->with('instituicao', $vetorinstituicao)
            ->with('convenio', $vetorconvenio)->with('p', $p);
    }
    //endmain

    //visualizar
//    public function Visualizar($id)
//    {
//        try {
//            $c = \App\Convenio::where('nr_convenio', $id)->get();
//            $a = \App\Anexo::where('nr_convenio', $id)->get();
//            //foreing key de convenio
//            $f = \App\Financiador::where('id_financiador', $c[0]->id_financiador)->get();
//            $cat = \App\Categoriaconvenio::where('id_categoria', $c[0]->id_categoria)->get();
//            $cc = \App\Contabilcontasplano::where('idcontas_plano', $c[0]->idcontas_plano_contabil)->get();
//            $cb = \App\Contabilcontasplano::where('idcontas_plano', $c[0]->idcontas_plano_banco)->get();
//            //participantes
//            $p = \App\Participantes::where('nr_convenio', $c[0]->nr_convenio)->get();
//            //foreing key de Participantes
//        } catch (\Illuminate\Database\QueryException $ex) {
//            dd($ex->getMessage());
//        }
//        //tratamentodatas
//        $old_dt_inicio = $c[0]['dt_inicio'];
//        $new_dt_inicio = date('d/m/Y', strtotime($old_dt_inicio));
//        $c[0]['dt_inicio'] = $new_dt_inicio;
//        $old_dt_limite_execucao = $c[0]['dt_limite_execucao'];
//        $new_dt_limite_execucao = date('d/m/Y', strtotime($old_dt_limite_execucao));
//        $c[0]['dt_limite_execucao'] = $new_dt_limite_execucao;
//        $old_dt_prest_contas = $c[0]['dt_prest_contas'];
//        $new_dt_prest_contas = date('d/m/Y', strtotime($old_dt_prest_contas));
//        $c[0]['dt_prest_contas'] = $new_dt_prest_contas;
//        $old_dt_limite_vigencia = $c[0]['dt_limite_vigencia'];
//        $new_dt_limite_vigencia = date('d/m/Y', strtotime($old_dt_limite_vigencia));
//        $c[0]['dt_limite_vigencia'] = $new_dt_limite_vigencia;
//        //endtradamentodatas
//        //retornar view
//        return view('convenio.Visualizar')->with('financiador', $f)->with('cb', $cb)->with('cc', $cc)->with('anexo', $a)->with('convenio', $c)->with('categoria', $cat)->with('participantes', $p);
//    }

    public static function converteData($data){
        return (preg_match('/\//',$data)) ? implode('-', array_reverse(explode('/', $data))) : implode('/', array_reverse(explode('-', $data)));
    }

    public
    function VisualizarPessoaConvenio($id_convenio, $id_pessoa)
    {
        $p = \App\Participantes::where('id_convenio', $id_convenio)->where('id_pessoa_participante', $id_pessoa)->get();

        $pes = \App\Pessoa::where('id_pessoa', $p[0]['id_pessoa_participante'])->get();
        $ins = \App\PessoaJuridica::where('id_pessoa', $p[0]['id_pessoa_instituicao'])->get();
        $con = \App\Convenio::where('id_convenio', $p[0]['nr_convenio'])->get();
        $fin = \App\Financiador::where('id_financiador', $con[0]['id_financiador'])->get();
//        dd($con);
        return view('convenio.VisualizarPessoaConvenio')->with('pessoa', $pes)->with('instituicao', $ins)->with('convenio', $con)->with('financiador', $fin)->with('p', $p);
    }

    //endvisualizar
    //add
    public
    function Adicionar()
    {
        try {
            $f = \App\Financiador::all();
            $c = \App\Contabilcontasplano::all();
            $cat = \App\Categoriaconvenio::all();
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
        return view('convenio.Cadastrar')->with('financiador', $f)->with('contabil', $c)
            ->with('categoria', $cat)->with('con', $c);
    }

    public
    function adicionarpessoaconvenio($nr_convenio)
    {
        $convenio = \App\Convenio::where('nr_convenio', $nr_convenio)->get();
        //dd($convenio);
        // return view('convenio.CadastrarConvenio')->with('financiador', $f);
    }

    public
    function adicionarpessoa()
    {
        $p = \App\Pessoa::
        leftJoin('PESSOA..PESSOA_FISICA', 'PESSOA..PESSOA.id_pessoa', '=', 'PESSOA..PESSOA_FISICA.id_pessoa')->get();

        //dd($p);
        $pf = \App\PessoaFisica::all();
        $pj = \App\PessoaJuridica::orderBy('nm_fantasia', 'asc')->get();
        $f = \App\Financiador::all();
        return view('convenio.CadastrarPessoaConvenio')->with('pessoa', $p)->with('pessoafisica', $pf)->with('pessoajuridica', $pj)->with('financiador', $f);
    }

    public
    function adicionarpessoafisica()
    {
        return view('convenio.CadastrarPessoaFisica');
    }


    public
    function adicionarinstituicao()
    {
        return view('convenio.CadastrarInstituicao');
    }

    //endadd
    //store
    public function store(ConvenioRequest $request)
    {

      //
      $rules = [
      'ano_convenio' => 'required|min:4|max:4',
      'nr_convenio' => 'required|max:9',
      'ano_processo' => 'required|min:4|max:4',
      'nr_processo' => 'required|max:8',
      'nr_protocolo' => 'required|max:8',
      'nr_sit_tce' => 'required|max:8',
      'vl_convenio' => 'required',
      'dt_inicio' => 'required|min:10|max:10',
      'dt_limite_execucao' => 'required|min:10|max:10',
      'dt_prest_contas' => 'required',
      'idcontas_plano_contabil' => 'required',
      'idcontas_plano_banco' => 'required',
      'ds_sigla_objeto' => 'required',
      'ds_objeto' => 'required',
      ];

      if(array_key_exists ( 'id_financiador' , $request->all() )){
        $rules['id_financiador'] = 'required';
      }else{
        $rules['sigla_fin'] = 'required';
        $rules['tp_esfera'] = 'required';
      }

      if(array_key_exists ( 'id_categoria' , $request->all() )){
        $rules['id_categoria'] = 'required';
      }else{
        $rules['sigla_cat'] = 'required';
      }

      $customMessages = [
          'required' => 'O :attribute é obrigatório.',
      ];

      $input = $request->all();
      //$this->validate($request, $rules, $customMessages);
      $v = Validator::make($input, $rules, $customMessages);
      if($v->fails()) return redirect()->back()->withInput($input)->withErrors($v);
      // $this->validate($request, [
      //   'id_convenio' => 'required',
      //   'ano_convenio' => 'required|max:4|min:4'
      // ]);

      $i['ano_convenio'] = intval($input['ano_convenio']);
      $i['nr_convenio'] = intval($input['nr_convenio']);
      $i['ano_processo'] = intval($input['ano_processo']);
      $i['nr_processo'] = intval($input['nr_processo']);
      $i['nr_protocolo'] = intval($input['nr_protocolo']);
      $i['vl_convenio'] = floatval(str_replace(",", ".",str_replace(".","",$input['vl_convenio'])));
      $i['dt_inicio'] = ConvenioController::converteData($input['dt_inicio']);
      $i['dt_limite_execucao'] = ConvenioController::converteData($input['dt_limite_execucao']);
      $i['dt_limite_vigencia'] =  ConvenioController::converteData($input['dt_limite_vigencia']);
      $i['dt_prest_contas'] =  ConvenioController::converteData($input['dt_prest_contas']);
      $i['idcontas_plano_contabil'] = intval($input['idcontas_plano_contabil']);
      $i['idcontas_plano_banco'] = intval($input['idcontas_plano_banco']);
      $i['nr_sit_tce'] = intval($input['nr_sit_tce']);
      $i['id_categoria'] = intval($input['id_categoria']);
      $i['id_financiador'] = intval($input['id_financiador']);
      $i['ds_sigla_objeto'] = $input['ds_sigla_objeto'];
      $i['ds_objeto'] = $input['ds_objeto'];
      $i['ds_resumo_plano'] = $input['ds_resumo_plano'];
      $i['fl_aviso_exec_30'] = 0;
      $i['fl_aviso_exec_60'] = 0;
      $i['fl_aviso_exec_fim'] = 0;

      if(strtotime($i['dt_inicio']) < strtotime('1969-01-01') ||
         strtotime($i['dt_limite_execucao']) < strtotime($i['dt_inicio']) ||
         strtotime($i['dt_limite_vigencia']) < strtotime($i['dt_limite_execucao']) ||
         strtotime($i['dt_prest_contas']) > strtotime($i['dt_limite_vigencia']) ||
         $i['ano_convenio'] < 1969 || $i['ano_processo'] < $i['ano_convenio']){
           return redirect()->back()->withInput($input)->withErrors(["Há datas que não conferem, por favor revise-as."]);
         }

         if(!(DB::TABLE('contabil..contas_plano')->where('idcontas_plano', $i['idcontas_plano_banco'])->count()) ||
            !(DB::TABLE('contabil..contas_plano')->where('idcontas_plano', $i['idcontas_plano_contabil'])->get()) ){
              return redirect()->back()->withInput($input)->withErrors(["Há códigos de contas que não conferem, por favor revise-as."]);
            }

      if(DB::table('AC_CONVENIO')
          ->WHERE('id_financiador', $i['id_financiador'])
          ->WHERE('ano_convenio', $i['ano_convenio'])
          ->WHERE('nr_convenio', $i['nr_convenio'])
          ->where('nr_protocolo', $i['nr_protocolo'])
          ->count()){
            return redirect()->back()->withInput($input)->withErrors(["Há erros de valores duplicados, por favor revise as entradas."]);
          }

      try {
          DB::TABLE('AC_CONVENIO')->insert($i);
      } catch (\PDOException  $e) {
        SweetAlert::error("Ocorreu um erro, entre em contato com o NTI.");
        return redirect('convenios');
      }

      SweetAlert::success("Convênio cadastrado com sucesso");

      $conv = DB::TABLE('AC_CONVENIO')
              ->WHERE('ano_convenio', $i['ano_convenio'])
              ->WHERE('nr_convenio', $i['nr_convenio'])
              ->WHERE('id_financiador', $i['id_financiador'])
              ->FIRST();

      //***fim salvando convenio***

      //***inicio loop anexos***
          $anexo = $request->anexo;
          if ($anexo[0] != null) {
              $ac_anexo = array();
              $vetor[] = array();
              foreach ($anexo as $key => $value) {

                    $name = $value->getClientOriginalName();

                    $partes = explode(".", $name);
                    // somente o nome do arquivo
                    $nome	= preg_replace('/\.[^.]*$/', '', $name);
                    // removendo simbolos, acentos etc
                    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýýþÿŔŕ?';
                    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuuyybyRr-';
                    $nome = strtr($nome, utf8_decode($a), $b);
                    $nome = str_replace(".","-",$nome);
                    $nome = preg_replace( "/[^0-9a-zA-Z\.]+/",'-',$nome);

                    //--

                    // Define um aleatório para o arquivo baseado no timestamps atual
                    $name = uniqid($nome);

                    // Recupera a extensão do arquivo
                    $extension = $value->getClientOriginalExtension();

                    // Define finalmente o nome
                    $nameFile = "{$name}.{$extension}";

                    // Faz o upload:
                    $upload = $value->move('app/storage/uploads', $nameFile);
                    // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao

                    // Verifica se NÃO deu certo o upload (Redireciona de volta)
                    if ( !$upload ){
                        return redirect()
                                    ->back()
                                    ->with('error', 'Falha ao fazer upload')
                                    ->withInput();
                                  }

                    DB::TABLE("AC_ANEXOS")->INSERT(['id_convenio' => $conv->id_convenio, 'ds_titulo_anexo' => $nameFile]);
                }
            }



        SweetAlert::success("Convênio cadastrado com sucesso.");
        return redirect('convenio');
        // $conv_financiador = \App\Financiador::where('id_financiador', $input['id_financiador'])->get();
        // $financiador_plano=\App\Financiador::all();
        // return Redirect::route('planodetrabalho/'.$input['ano_convenio'].'/'.$input['nr_convenio'].'/'.$conv_financiador)
        //     ->with('conv_financiador',$conv_financiador)
        //     ->with('ano_convenio',$input['ano_convenio'])
        //     ->with('nr_convenio',$input['nr_convenio'])
        //     ->with('financiador',$financiador_plano);

    }

    public
    function storeinstituicao(InstituicaoRequest $request)
    {
        $input = $request->all();
        // dd($input);
        PessoaJuridica::create($input);
    }

    public
    function storepessoafisica(PessoaFisicaRequest $request)
    {
        $input = $request->all();
        // dd($input);
        PessoaFisica::create($input);
    }

    public
    function storepessoaconvenio(PessoaConvenioRequest $request)
    {
        $input = $request->all();
        if ($request->cd_coordenador != null) {
            $input = $this->array_push_assoc($input, 'cd_coordenador', "S");
        } else {
            $input = $this->array_push_assoc($input, 'cd_coordenador', "N");
        }
        $retorno = explode('|', $request->nr_convenio);
        $input = $this->array_push_assoc($input, 'ano_convenio', $retorno[1]);
        $input = $this->array_push_assoc($input, 'nr_convenio', $retorno[0]);

//        var_dump($input);
        Participantes::create($input);
//        dd(Participantes::create($input));
        return \Redirect::to('convenio/pessoa');
    }

    //endstore
    //editar
    public
    function Editar($ano, $nr, $id_financiador)
    {

        try {
            $financiadores = \App\Financiador::all();
            $contabils = \App\Contabilcontasplano::all();
            $categorias = \App\Categoriaconvenio::all();
            $c = \App\Convenio::where('ano_convenio', $ano)->where('nr_convenio', $nr)->where('id_financiador', $id_financiador)->first();
            //dd($c->id_financiador);
            $a = \App\Anexo::where('id_convenio', $c->id_convenio)->get();
            //foreing key de convenio
            $f = \App\Financiador::where('id_financiador', $c->id_financiador)->get();
            $cat = \App\Categoriaconvenio::where('id_categoria', $c->id_categoria)->get();
            //dd($cat);
            $cb = \App\Contabilcontasplano::where('idcontas_plano', $c->idcontas_plano_banco)->get();
            $cc = \App\Contabilcontasplano::where('idcontas_plano', $c->idcontas_plano_contabil)->get();
            $p = \App\Participantes::where('id_convenio', $c->id_convenio)->get();
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
        //tratamento datas
        $old_dt_inicio = $c->dt_inicio;
        $new_dt_inicio = date('d/m/Y', strtotime($old_dt_inicio));
        $c->dt_inicio = $new_dt_inicio;

        $old_dt_limite_execucao = $c->dt_limite_execucao;
        $new_dt_limite_execucao = date('d/m/Y', strtotime($old_dt_limite_execucao));
        $c->dt_limite_execucao = $new_dt_limite_execucao;

        $old_dt_prest_contas = $c->dt_prest_contas;
        $new_dt_prest_contas = date('d/m/Y', strtotime($old_dt_prest_contas));
        $c->dt_prest_contas = $new_dt_prest_contas;

        $old_dt_limite_vigencia = $c->dt_limite_vigencia;
        $new_dt_limite_vigencia = date('d/m/Y', strtotime($old_dt_limite_vigencia));
        $c->dt_limite_vigencia = $new_dt_limite_vigencia;

        //view

        return view('convenio.Editar')->with('financiador', $f)->with('cb', $cb)->with('cc', $cc)->with('anexo', $a)->with('convenio', $c)->with('categoria', $cat)->with('participantes', $p)->with('financiadores', $financiadores)->with('categorias', $categorias)->with('contabils', $contabils)->with('cons', $contabils);
    }

    public
    function EditarPessoaConvenio($id_convenio, $id_pessoa)
    {
        $p = \App\Participantes::where('nr_convenio', $id_convenio)->where('id_pessoa_participante', $id_pessoa)->get();

        $pes = \App\Pessoa::where('id_pessoa', $p[0]['id_pessoa_participante'])->get();
        $ins = \App\PessoaJuridica::where('id_pessoa', $p[0]['id_pessoa_instituicao'])->get();
        $con = \App\Convenio::where('nr_convenio', $p[0]['nr_convenio'])->get();
        $fin = \App\Financiador::where('id_financiador', $con[0]['id_financiador'])->get();

        $pessoas = \App\Pessoa::all();
        $pj = \App\PessoaJuridica::all();
        $con = \App\Convenio::all();

        return view('convenio.EditarPessoaConvenio')->with('id_convenio', $id_convenio)->with('id_pessoa', $id_pessoa)->with('pessoa', $pes)->with('con', $con)->with('pj', $pj)->with('pessoas', $pessoas)->with('pessoajuridica', $ins)->with('convenio', $con)->with('financiador', $fin)->with('p', $p);
    }

    public
    function atualizabancoPessoaConvenio(PessoaConvenioRequest $request)
    {
        $input = $request->all();
        $vetor = array();
        $vetor['id_pessoa_instituicao'] = $input['id_pessoa_instituicao'];
        if ($request->cd_coordenador != null) {
            $vetor['cd_coordenador'] = "S";
        } else {
            $vetor['cd_coordenador'] = "N";
        }
        $f = Participantes::where('nr_convenio', $input['nr_convenio'])->where('id_pessoa_participante', $input['id_pessoa'])->update($vetor);
        return redirect()->route('convenio.PessoaConvenio');
    }

    public
    function atualizabanco(ConvenioRequest $request, $ano, $nr, $id_financiador)
    {

        $input = $request->all();
        $vareavel = $request->anexo;
        //***inicio tratamento dados***
        $retorno_dt_inicio = explode('/', $request->dt_inicio);
        $retorno_dt_limite = explode('/', $request->dt_limite_execucao);
        $retorno_dt_prest_contas = explode('/', $request->dt_prest_contas);
        $retorno_dt_limite_vigencia = explode('/', $request->dt_limite_vigencia);
        $valor = str_replace(".", "", $request->vl_convenio);
        $valor = str_replace(",", ".", $valor);
        $input = $this->array_push_assoc($input, 'vl_convenio', $valor);
        $input = $this->array_push_assoc($input, 'dt_inicio', $retorno_dt_inicio[2] . "-" . $retorno_dt_inicio[1] . "-" . $retorno_dt_inicio[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'dt_limite_execucao', $retorno_dt_limite[2] . "-" . $retorno_dt_limite[1] . "-" . $retorno_dt_limite[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'dt_prest_contas', $retorno_dt_prest_contas[2] . "-" . $retorno_dt_prest_contas[1] . "-" . $retorno_dt_prest_contas[0] . " 00:00:00");
        $input = $this->array_push_assoc($input, 'dt_limite_vigencia', $retorno_dt_limite_vigencia[2] . "-" . $retorno_dt_limite_vigencia[1] . "-" . $retorno_dt_limite_vigencia[0] . " 00:00:00");
        //***fim tratamento dados***
        //dd($input);
        //***salvando convenio***
        $f = \App\Convenio::where('nr_convenio', $nr)->where('ano_convenio', $ano)
            ->where('id_financiador', $id_financiador)->update([
                'nr_protocolo' => $input['nr_protocolo'],
                'ano_processo' => $input['ano_processo'],
                'nr_processo' => $input['nr_processo'],
                'ds_objeto' => $input['ds_objeto'],
                'ds_sigla_objeto' => $input['ds_sigla_objeto'],
                'nr_sit_tce' => $input['nr_sit_tce'],
                'vl_convenio' => $input['vl_convenio'],
                'dt_inicio' => $input['dt_inicio'],
                'dt_limite_execucao' => $input['dt_limite_execucao'],
                'dt_prest_contas' => $input['dt_prest_contas'],
                'dt_limite_vigencia' => $input['dt_limite_vigencia'],
                'idcontas_plano_contabil' => $input['idcontas_plano_contabil'],
                'idcontas_plano_banco' => $input['idcontas_plano_banco'],
                'id_categoria' => $input['id_categoria'],
                'ds_resumo_plano' =>$input['ds_resumo_plano'] ,
            ]);

        //$f = Convenio::find($id)->update($input);
        //***fim salvando convenio***
        //dd($f);

        //***inicio loop anexos***
        $anexo = $request->anexo;
        if ($anexo != null) {
            $token = $request->_token;
            $financiador = $request->id_financiador;
            $anoconvenio = $request->ano_convenio;
            $nrconvenio = $request->id_convenio;
            $ac_anexo = array();
            $vetor[] = array();
            foreach ($anexo as $key => $value) {
                $ac_anexo = $this->array_push_assoc($ac_anexo, '_token', $token);
                $ac_anexo = $this->array_push_assoc($ac_anexo, 'id_convenio', $nrconvenio);
                $file_name = pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);
                $ds_titulo_anexo = md5($key . time());
                $ds_titulo_anexo = $file_name . "_" . $ds_titulo_anexo . ".pdf";
                $ac_anexo = $this->array_push_assoc($ac_anexo, 'ds_titulo_anexo', $ds_titulo_anexo);
                $vetor[$key] = $ac_anexo;
                Anexo::create($ac_anexo);
            }
            $files = $vareavel;
            $file_count = count($files);
            $uploadcount = 0;
            foreach ($files as $key => $file) {
                $destinationPath = '../storage/uploads';
                $filename = $vetor[$key]["ds_titulo_anexo"];
                $file->move($destinationPath, $filename);
                $uploadcount++;
            }
            if ($uploadcount == $file_count) {
                \Session::flash('success', 'Upload successfully');
                return \Redirect::to('convenio');
            } else {
                var_dump("problema na submissão .pdf");
                die();
            }
        }
        //***fim loop anexos***


        return redirect()->route('convenio');
    }

    //endeditar
    //deletar
    public function Deletar($id_convenio) {
      $id_convenio = intval($id_convenio);
        try{
            $anexo = DB::TABLE('AC_ANEXOS')->where('id_convenio', $id_convenio)->delete();
            $convenio = DB::TABLE('AC_CONVENIO')->where('id_convenio', $id_convenio)->delete();
            SweetAlert::success('Convênio excluido com sucesso!');
        } catch (\Illuminate\Database\QueryException $ex) {
            \Session::flash('message_delete', 'Convênio não pode ser excluído por dependência.');
        }
        return redirect()->route('convenio');
    }

    public
    function DeletarPessoaConvenio($id_convenio, $id_pessoa)
    {
        $part = \App\Participantes::where('nr_convenio', $id_convenio)->where('id_pessoa_participante', $id_pessoa);
        $part->delete();
        \Session::flash('flash_message', 'Participante deletado com sucesso');
        return redirect()->route('convenio.PessoaConvenio');
    }

    //enddeletar

    public
    function multiple_upload($files, $caminho)
    {
        $file_count = count($files);
        $uploadcount = 0;
        foreach ($files as $file) {
            $destinationPath = '../storage/uploads';
            $filename = $caminho;
            $upload_success = $file->move($destinationPath, $filename);
            $uploadcount++;
        }
        if ($uploadcount == $file_count) {
            Session::flash('success', 'Upload successfully');
            return true;
        } else {
//            return $validator;
        }
    }

    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public
    function MissingMethod($params = array())
    {
        return 'Nada encontrado';
    }

    public function ajaxVerificaConv(Request $request){
        $data = DB::select(DB::raw("select count(*) from ac_convenio where ano_convenio = $request->ano_convenio
                and nr_convenio=$request->nr_convenio and id_financiador = $request->id_financiador"));
        return response()->json($data[0]->computed0);
    }

}
