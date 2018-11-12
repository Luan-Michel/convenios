<?php

namespace App\Http\Controllers;

use App\Agencia;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Banco;
use App\Http\Requests\AgenciaRequest;
use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\DB;

class AgenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function banco(){
        $nm_banco = DB::select(DB::raw("Select nr_banco, nm_banco from pessoa..TA_BANCO noholdlock
                    order by nm_banco"));
        return $nm_banco;
        /*$nm_banco =\App\Banco::all();
         return $nm_banco;*/
    }

    public function index()
    {
        $this->banco();
        return view('agencia.Cadastrar')
            ->with('nm_banco', $this->banco());
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgenciaRequest $request)
    {
//        $input=$request->all();
//        $nr_banco= $input['nr_banco'];
//        $nr_agencia=$input['nr_agencia'];
        //dd($input);
        $valida= \App\Agencia::where('nr_banco', $request->nr_banco)->where('nr_agencia', $request->nr_agencia)->first();

//        dd($valida);

        if(empty($valida)){

            DB::table('pessoa..Ta_Agencia')
                ->insert([
                    'nr_banco' => $request->nr_banco,
                    'nr_agencia' => $request->nr_agencia,
                    'nr_dac' => $request->nr_dac,
                    'nm_agencia' => $request->nm_agencia
                ]);
            return redirect()->route('agencia')->with('message', 'Agência cadastrada com sucesso!');
        }else {

            return redirect()->route('agencia')->with('message', 'Agência já cadastrada!');
        }
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
