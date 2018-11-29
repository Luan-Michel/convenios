<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PlanodetrabalhoRequest;
use App\Planodetrabalho;
use UxWeb\SweetAlert\SweetAlert;
use DB;

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
        $convenio = \App\Convenio::where('ano_convenio', $ano_conv)->where('nr_convenio', $nr_conv)->where('id_financiador', $f)->first();
        $seq = intval(DB::TABLE('AC_META_APLIC')->MAX('seq_meta_aplic'))+1;

        return view('planodetrabalho.Cadastrarplano')
            ->with('seq', $seq)
            ->with('convenio', $convenio);
    }


    public function Editar($id)
    {
        $planodetrabalho = \App\Planodetrabalho::find($id);
        $convenio = DB::TABLE('AC_CONVENIO')->WHERE('id_convenio', $planodetrabalho->id_convenio)->first();

        $old_dt_inicio = $planodetrabalho->dt_inicio_meta;
        $old_dt_termino = $planodetrabalho->dt_termino_meta;
        $new_dt_inicio = date('d/m/Y', strtotime($old_dt_inicio));
        $new_dt_termino = date('d/m/Y', strtotime($old_dt_termino));
        $planodetrabalho = $this->array_push_assoc($planodetrabalho, 'dt_inicio_meta', $new_dt_inicio);
        $planodetrabalho = $this->array_push_assoc($planodetrabalho, 'dt_termino_meta', $new_dt_termino);


        return view('planodetrabalho.Editar', compact('planodetrabalho', 'convenio'))->with('planodetrabalho', $planodetrabalho, 'convenio', $convenio);
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

    public function atualizabanco(Request $request, $id)
    {
        $input = $request->all();
        //faz-se a divisão das datas
        $retorno_dt_inicio = explode('/', $request->dt_inicio_meta);
        $retorno_dt_termino = explode('/', $request->dt_termino_meta);
        //atribui ao objeto os valores de dt_inicio e dt_termino
        $input = $this->array_push_assoc($input, 'dt_inicio_meta', $retorno_dt_inicio[2] . "-" . $retorno_dt_inicio[1] . "-" . $retorno_dt_inicio[0]);
        $input = $this->array_push_assoc($input, 'dt_termino_meta', $retorno_dt_termino[2] . "-" . $retorno_dt_termino[1] . "-" . $retorno_dt_termino[0]);
        //***fim tratamento dados***
        //dd($input);
        //***fim tratamento dados***
        $f = Planodetrabalho::find($id)->update($input);
        $f = Planodetrabalho::find($id);
        $convenio = DB::TABLE('AC_CONVENIO')->WHERE('id_convenio', $f->id_convenio)->first();
        return redirect()->route('planodetrabalho',[$convenio->ano_convenio,$convenio->nr_convenio,$convenio->id_financiador]);
    }

    public function Deletar($id)
    {
        $planodetrabalho = \App\Planodetrabalho::findOrFail($id);
        // Session::flash('flash_message', 'Financiador deletado com sucesso');
        try {
          $planodetrabalho->delete($id);
          return redirect()->route('planodetrabalho');
          SweetAlert::success("Plano removido com sucesso");
        } catch (\Illuminate\Database\QueryException $e) {
          SweetAlert::error("Plano não pode ser removido devido a dependência.");
          return redirect()->back();
        }

    }

    public function store(Request $request)
    {
        $input = $request->all();
        //faz-se a divisão das datas

        $retorno_dt_inicio = explode('/', $request->dt_inicio_meta);
        $retorno_dt_termino = explode('/', $request->dt_termino_meta);
        $retorno = explode('/', $input['nr_convenio']);

        $c = DB::TABLE('AC_CONVENIO')->where('nr_convenio', intval($retorno[0]))->where('ano_convenio', intval($retorno[1]))->first();
        $input['id_convenio'] = $c->id_convenio;
        //atribui ao objeto os valores de dt_inicio e dt_termino
        $input = $this->array_push_assoc($input, 'dt_inicio_meta', $retorno_dt_inicio[2] . "-" . $retorno_dt_inicio[1] . "-" . $retorno_dt_inicio[0]);
        $input = $this->array_push_assoc($input, 'dt_termino_meta', $retorno_dt_termino[2] . "-" . $retorno_dt_termino[1] . "-" . $retorno_dt_termino[0]);
        //***fim tratamento dados***
        //dd($input);
        $i['id_convenio'] = intval($input['id_convenio']);
        $i['seq_meta_aplic'] = intval(DB::TABLE('AC_META_APLIC')->MAX('seq_meta_aplic'))+1;
        $i['ds_titulo_meta_aplic'] = $input['ds_titulo_meta_aplic'];
        $i['ds_meta_aplic'] = $input['ds_meta_aplic'];
        $i['dt_inicio_meta'] = $input['dt_inicio_meta'];
        $i['dt_termino_meta'] = $input['dt_termino_meta'];

        try {
          DB::TABLE('AC_META_APLIC')->insert($i);

          return redirect()->route('etapaplanodetrabalho');
        } catch (\Exception $e) {

        }

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
