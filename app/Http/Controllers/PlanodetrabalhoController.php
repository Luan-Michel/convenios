<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PlanodetrabalhoRequest;
use App\Planodetrabalho;

class PlanodetrabalhoController extends Controller
{
    public function Index($ano_conv, $nr_conv, $f)
    {
        $c = \App\Convenio::where('ano_convenio', $ano_conv)
            ->where('nr_convenio', $nr_conv)
            ->where('id_financiador', $f)
            ->first();
        $plan = \App\Planodetrabalho::where('id_convenio', $c->id_convenio)->get();
        //dd($plan);
        return view('planodetrabalho.Planodetrabalho', ['planodetrabalho' => $plan, 'conv' => $c]);
    }

    public function Indexall()
    {
        $plan = \App\Planodetrabalho::get();
        //dd($plan);
        return view('planodetrabalho.Planodetrabalho', ['planodetrabalho' => $plan]);
    }



    public function Adicionar($ano_conv, $nr_conv, $f)
    {
        $financiador = \App\Financiador::all(['nm_financiador', 'id_financiador']);
        $convenio = \App\Convenio::all(['nr_convenio', 'ano_convenio']);

        //usado quando cria um convenio e é direcionado direto para o plano de trabalho
        $conv_financiador=null;
        $financiador_plano=null;
        $ano_convenio=null;
        $nr_convenio=null;
        $fin = \App\Financiador::where('id_financiador', $f)->get();
        return view('planodetrabalho.Cadastrarplano')
            ->with('fin', $fin)
            ->with('conv', $nr_conv)
            ->with('ano', $ano_conv)
            ->with('financiador', $financiador)
            ->with('convenio', $convenio)
            ->with('conv_financiador',$conv_financiador)
            ->with('ano_convenio',$ano_convenio)
            ->with('nr_convenio',$nr_convenio);
    }


    public function Editar($id)
    {
        $financiador = \App\Financiador::all();
        $planodetrabalho = \App\Planodetrabalho::find($id);
        //dd($planodetrabalho);
        //busca no banco de Convenio.ds_sigla_objeto e Financiador.nm_financiador
        $fin = \App\Financiador::find($planodetrabalho->id_financiador);
        $conv = \App\Convenio::where('id_convenio', $planodetrabalho->id_convenio)->first();
        //tratamento formato da data
        $old_dt_inicio = $planodetrabalho->dt_inicio_meta;
        $old_dt_termino = $planodetrabalho->dt_termino_meta;
        $new_dt_inicio = date('d/m/Y', strtotime($old_dt_inicio));
        $new_dt_termino = date('d/m/Y', strtotime($old_dt_termino));
        $planodetrabalho = $this->array_push_assoc($planodetrabalho, 'dt_inicio_meta', $new_dt_inicio);
        $planodetrabalho = $this->array_push_assoc($planodetrabalho, 'dt_termino_meta', $new_dt_termino);

        return view('planodetrabalho.Editar', compact('financiador', 'planodetrabalho', 'fin', 'conv'))->with('financiador', $financiador, 'planodetrabalho', $planodetrabalho, 'fin', $fin, 'conv', $conv);
    }

    public function Visualizar($id)
    {
        $financiador = \App\Financiador::all();
        $planodetrabalho = \App\Planodetrabalho::find($id);
        $fin = \App\Financiador::find($planodetrabalho->id_financiador);
        $conv = \App\Convenio::where('nr_convenio', $planodetrabalho->nr_convenio)->first();
        $old_dt_inicio = $planodetrabalho->dt_inicio_meta;
        $old_dt_termino = $planodetrabalho->dt_termino_meta;
        $new_dt_inicio = date('d/m/Y', strtotime($old_dt_inicio));
        $new_dt_termino = date('d/m/Y', strtotime($old_dt_termino));
        $planodetrabalho = $this->array_push_assoc($planodetrabalho, 'dt_inicio_meta', $new_dt_inicio);
        $planodetrabalho = $this->array_push_assoc($planodetrabalho, 'dt_termino_meta', $new_dt_termino);
        return view('planodetrabalho.Visualizar', compact('financiador', 'planodetrabalho', 'fin', 'conv'))->with('financiador', $financiador, 'planodetrabalho', $planodetrabalho, 'fin', $fin, 'conv', $conv);
    }

    public function atualizabanco(PlanodetrabalhoRequest $request, $id)
    {

        $input = $request->all();
        //faz-se a divisão das datas
        $retorno_dt_inicio = explode('/', $request->dt_inicio_meta);
        $retorno_dt_termino = explode('/', $request->dt_termino_meta);
        $input = $this->array_push_assoc($input, 'id_convenio', $retorno[0]);
        //atribui ao objeto os valores de dt_inicio e dt_termino
        $input = $this->array_push_assoc($input, 'dt_inicio_meta', $retorno_dt_inicio[2] . "-" . $retorno_dt_inicio[1] . "-" . $retorno_dt_inicio[0]);
        $input = $this->array_push_assoc($input, 'dt_termino_meta', $retorno_dt_termino[2] . "-" . $retorno_dt_termino[1] . "-" . $retorno_dt_termino[0]);
        //***fim tratamento dados***
        //dd($input);
        //***fim tratamento dados***
        $f = Planodetrabalho::find($id)->update($input);
        return redirect()->route('planodetrabalho',[$input['ano_convenio'],$input['nr_convenio'],$input['id_financiador']]);
    }

    public function Deletar($id)
    {
        $planodetrabalho = \App\Planodetrabalho::findOrFail($id);
        $planodetrabalho->delete($id);
        // Session::flash('flash_message', 'Financiador deletado com sucesso');
        return redirect()->route('planodetrabalho');
    }

    public function store(PlanodetrabalhoRequest $request)
    {
        $input = $request->all();
        //faz-se a divisão das datas
        $retorno_dt_inicio = explode('/', $request->dt_inicio_meta);
        $retorno_dt_termino = explode('/', $request->dt_termino_meta);
        $input = $this->array_push_assoc($input, 'id_convenio', $retorno[0]);
        //atribui ao objeto os valores de dt_inicio e dt_termino
        $input = $this->array_push_assoc($input, 'dt_inicio_meta', $retorno_dt_inicio[2] . "-" . $retorno_dt_inicio[1] . "-" . $retorno_dt_inicio[0]);
        $input = $this->array_push_assoc($input, 'dt_termino_meta', $retorno_dt_termino[2] . "-" . $retorno_dt_termino[1] . "-" . $retorno_dt_termino[0]);
        //***fim tratamento dados***
        //dd($input);
        Planodetrabalho::create($input);
        return redirect()->route('etapaplanodetrabalho');
    }

    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public function MissingMethod($params = array())
    {
        return 'Nada encontrado';
    }
}
