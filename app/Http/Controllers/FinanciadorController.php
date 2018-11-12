<?php

namespace App\Http\Controllers;
use App\Convenio;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FinanciadorRequest;
use App\Financiador;
use Illuminate\Support\Facades\DB;


class FinanciadorController extends Controller
{
    public function Index(){



        $f = \App\Financiador::all();

        foreach($f as $key => $item){
//            dd($item['tp_esfera']);
            if($item['tp_esfera'] == 'e'){
                $f[$key] = $this->array_push_assoc($f[$key], 'tp_esfera', 'Estadual');
            }
            if($item['tp_esfera'] == 'f'){
                $f[$key] = $this->array_push_assoc($f[$key], 'tp_esfera', 'Federal');
            }
            if($item['tp_esfera'] == 'i'){
                $f[$key] = $this->array_push_assoc($f[$key], 'tp_esfera', 'Internacional');
            }
        }
//       dd($f);

        return view('financiador.Financiador', ['financiador'=> $f]);
    }

    public function Adicionar(){
        return view('financiador.Cadastrar');
    }

    public function Editar($id){
        $financiador = \App\Financiador::find($id);
        $possuiconv= DB::select(DB::raw("Select count(*) from AC_CONVENIO WHERE ID_FINANCIADOR = $id having count(*)>0"));
        if($possuiconv == null){
            $possuiconv=0;
            return view('financiador.Editar')
                ->with('financiador',$financiador)
                ->with('possuiconv',$possuiconv);
        } else{
            $possuiconv = 1;
            \Session::flash('message_editar', 'O Financiador não pode ser alterado por possuir convênio cadastrado.');
            return view('financiador.Editar')
                ->with('financiador',$financiador)
                ->with('possuiconv',$possuiconv);
        }
    }

    /* public function Visualizar($id){
         $financiador = \App\Financiador::find($id);
         return view('financiador.Visualizar', compact('financiador'));
     }*/

    public function atualizabanco(FinanciadorRequest $request, $id){
        $f = Financiador::find($id)->update($request->all());
        dd($f);
        return redirect()->route('financiador');
    }

    public function Deletar($id){
        try{
            $financiador = \App\Financiador::findOrFail($id);
            $financiador->delete($id);
            return redirect()->route('financiador');
        }catch (QueryException $e){
            return redirect()->route('financiador')
                ->with('message', 'O Financiador não pode ser excluído por possuir convênio cadastrado.');
        }

        //Session::flash('flash_message', 'Financiador deletado com sucesso');

    }

    public function store(FinanciadorRequest $request){
        $input = $request->all();
        //  Financiador::setEchoFormat('e(utf8_encode(%s))');
        // dd($input);
        // var_dump($input);
        //  die();
        Financiador::create($input);
        return redirect()->route('financiador');
    }

    public function MissingMethod($params = array()){
        return 'Nada encontrado';
    }

    public
    function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public function financiadorConvenio(){
        $retorno = \App\Financiador::all()->financiador;
        dd($retorno);
    }
}
