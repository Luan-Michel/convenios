<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bancario;
use App\Banco;
use App\Pessoa;
use App\Agencia;
use App\Http\Requests;
use App\Http\Requests\BancarioRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class ContaCorrenteController extends Controller
{
    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public function banco(){
        $nm_banco = DB::select(DB::raw("Select nr_banco, nm_banco from pessoa..TA_BANCO noholdlock
                    order by nm_banco"));
        return $nm_banco;
    }

    public function Adicionar($id){
        $this->banco();
        $id_pessoa = \App\Pessoa::where('id_pessoa', $id)->get();
        return view('contacorrente.Cadastrar')
            ->with('id_pessoa', $id_pessoa)
            ->with('nm_banco', $this->banco());
    }

    public function ajaxAgencia(Request $request){
        if(isset($request->nm_banco)) {
            $data = DB::select(DB::raw("Select nr_agencia, nm_agencia from pessoa..ta_agencia noholdlock
                   where nr_banco = '$request->nm_banco' order by 1"));
            return response()->json($data);
        }
    }

    public function ajaxTipoConta (Request $request){
        if (isset($request->nm_banco) && ($request->nm_banco == 104)){
            $data = DB::select(DB::raw("select cd_tipo_conta, ds_tipo_conta from pessoa..TA_TIPO_CONTA noholdlock
                    where nr_banco = '104' order by 1"));
            return response()->json($data);
        }
    }

    public function index($id)
    {
        $cc = \App\Bancario::where('id_pessoa', $id)->get();
        $id_pessoa = \App\Pessoa::where('id_pessoa', $id)->get();

        if(count ($cc)==0){

            $seq_bancario =1;
            $this->banco();
            return view('contacorrente.Cadastrar')
                ->with('id_pessoa', $id_pessoa)
                ->with('seq_bancario',$seq_bancario)
                ->with('nm_banco', $this->banco());
        } else{
            foreach ($cc as $key => $vetor) {
                $nm_banco= \App\Banco::where('nr_banco', $cc[$key]['nr_banco'])->get();
                $cc[$key] = $this->array_push_assoc($cc[$key], 'nr_banco', $nm_banco[0]['nm_banco']);
            }
            return view('contacorrente.ContaCorrente')
                ->with('cc', $cc)
                ->with('id_pessoa', $id_pessoa);
        }
    }

    public function Editar ($id, $seq_bancario){
        try{
            $cc = \App\Bancario::where('id_pessoa', $id)->where('seq_bancario', $seq_bancario)->get();
            $id_pessoa = \App\Pessoa::where('id_pessoa', $cc[0]->id_pessoa)->get();
            $nm_banco = $this->banco();
            $cd_tipo_conta= null;
            foreach ($cc as $key => $vetor) {
                $banco= \App\Banco::where('nr_banco', $cc[$key]['nr_banco'])->get();
                $agencia= \App\Agencia::where('nr_agencia', $cc[$key]['nr_agencia'])->get();
                if($cc[0]->nr_banco == 104) {
                    $cd_tipo_conta= \App\TipoConta::where('cd_tipo_conta', $cc[$key]['cd_tipo_conta'])->get();
                    //$cc[$key] = $this->array_push_assoc($cc[$key], 'cd_tipo_conta', $cd_tipo_conta[0]['ds_tipo_conta']);
                }
            }
            // dd($cc);
        }catch(\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
        return view('contacorrente.Editar')
            ->with('id_pessoa', $id_pessoa)
            ->with('nm_banco', $nm_banco)
            ->with('banco', $banco)
            ->with('agencia', $agencia)
            ->with('cd_tipo_conta', $cd_tipo_conta)
            ->with('cc', $cc);
    }

    public function store(BancarioRequest $request)
    {
        $input = $request->all();

        //tratamento dos dados
        $id_pessoa=$input['id_pessoa'];
        $seq_bancario = DB::select(DB::raw("select max(seq_bancario)+1 from pessoa..bancario where id_pessoa= $id_pessoa"));
        $input['seq_bancario']=$seq_bancario[0]->computed0;
        if($input['nr_banco'] == 104) {
            $input['nr_conta'] = str_pad($input['nr_conta'], 8, "0", STR_PAD_LEFT);
        }
        if (preg_match('/^[a-zA-Z0-9]+/', $input['nr_dac'])){}
        else {
            return redirect()->route('contacorrente.Cadastrar', $id_pessoa)->with('message', 'DAC não pode conter caracteres especiais!');
        }
        Bancario::create($input);
        return redirect()->route('contacorrente', $id_pessoa);
    }

    public function Deletar($id, $seq_bancario)
    {
        try{
            $conta = \App\Bancario::where('id_pessoa', $id)->where('seq_bancario', $seq_bancario);
            $conta->delete($seq_bancario);
            return redirect()->route('contacorrente', $id);
        }catch (QueryException $e){
            return redirect()->route('contacorrente', $id)->with('message', 'Conta Corrente não pode ser excluida por dependencia.');
        }
    }


    public function atualizabanco(BancarioRequest $request, $id, $seq_bancario)
    {
        $input = $request->all();
        //dd($input);
        $conta= \App\Bancario::where('id_pessoa', $id)->where('seq_bancario', $seq_bancario)->get();

        if($input['nr_banco'] == 104) {
            $input['nr_conta'] = str_pad($input['nr_conta'], 8, "0", STR_PAD_LEFT);
            if (preg_match('/^[a-zA-Z0-9]+/', $input['nr_dac'])){}
            else {
                return redirect()->route('contacorrente.Cadastrar', $id)->with('message', 'DAC não pode conter caracteres especiais!');
            }

            $cc = \App\Bancario::where('id_pessoa', $id)->where('seq_bancario', $seq_bancario)->update([
                'id_pessoa' => $id,
                'seq_bancario' => $seq_bancario,
                'nr_banco' => $input['nr_banco'],
                'nr_agencia' => $input['nr_agencia'],
                'nr_conta' => $input['nr_conta'],
                'nr_dac' => $input['nr_dac'],
                'cd_tipo_conta' => $input['cd_tipo_conta'],
            ]);
        }
        else {
            //dd($input);
            if (preg_match('/^[a-zA-Z0-9]+/', $input['nr_dac'])){
            }
            else {
                return redirect()->route('contacorrente.Cadastrar', $id)->with('message', 'DAC não pode conter caracteres especiais!');
            }
            $cc = \App\Bancario::where('id_pessoa', $id)->where('seq_bancario', $seq_bancario)->update([
                'id_pessoa' => $id,
                'seq_bancario' => $seq_bancario,
                'nr_banco' => $input['nr_banco'],
                'nr_agencia' => $input['nr_agencia'],
                'nr_conta' => $input['nr_conta'],
                'nr_dac' => $input['nr_dac'],
            ]);
        }
        return redirect()->route('contacorrente', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
