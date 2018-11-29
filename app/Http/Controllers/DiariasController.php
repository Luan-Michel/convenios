<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use UxWeb\SweetAlert\SweetAlert;

class DiariasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $diarias = DB::TABLE('AC_RPE_DIARIA')
                    ->JOIN('UEPG..TA_CIDADE as ORIG', 'ORIG.id_cidade', '=', 'AC_RPE_DIARIA.id_cidade_origem')
                    ->JOIN('UEPG..TA_CIDADE as DEST', 'DEST.id_cidade', '=', 'AC_RPE_DIARIA.id_cidade_destino')
                    ->SELECT('AC_RPE_DIARIA.*', 'ORIG.nm_cidade as origem', 'DEST.nm_cidade as destino')
                    ->get();

        foreach ($diarias as $d) {
          $d->dt_saida = date('d/m/Y', strtotime($d->dt_saida));
        }

        return view('diarias.diarias', ['diarias' => $diarias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $previoempenho = DB::TABLE('AC_PREVIO_EMPENHO')->GET();
        $centrocusto = DB::TABLE('ASSEPLAN..CENTRO_CUSTO')->GET();
        $estados = DB::TABLE('UEPG..TA_UF')->GET();
        $transporte = DB::TABLE('ac_tipo_transporte')->GET();


        return view('diarias.cadastrar',['previoempenho' => $previoempenho, 'centrocusto' => $centrocusto, 'estados' => $estados, 'cidades' => [], 'transporte' => $transporte]);
    }


    public function getDestino($id)
    {
        $cidades = DB::TABLE('UEPG..TA_CIDADE')->WHERE('id_uf', $id)->select('nm_cidade as text', 'id_cidade as id')->get();

        return response()->json($cidades);

    }

    public function getDestinoEditar($id, $id_cidade)
    {
        $cidades = DB::TABLE('UEPG..TA_CIDADE')->WHERE('id_uf', $id_cidade)->select('nm_cidade as text', 'id_cidade as id')->get();

        return response()->json($cidades);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();

        unset($input['_token']);

        $data = explode('/', $input['dt_saida']);
        $input['dt_saida'] = $data[2].'-'.$data[1].'-'.$data[0];
        $data = explode('/', $input['dt_retorno']);
        $input['dt_retorno'] = $data[2].'-'.$data[1].'-'.$data[0];
        $data = explode('/', $input['dt_conversao_moeda']);
        $input['dt_conversao_moeda'] = $data[2].'-'.$data[1].'-'.$data[0];

        $input['vl_aux_financeiro'] = str_replace(',', '.', str_replace('.', '', $input['vl_aux_financeiro']));
        $input['vl_diaria_alim'] = str_replace(',', '.', str_replace('.', '', $input['vl_diaria_alim']));
        $input['vl_diaria_hosp'] = str_replace(',', '.', str_replace('.', '', $input['vl_diaria_hosp']));
        $input['vl_conversao_moeda'] = str_replace(',', '.', str_replace('.', '', $input['vl_conversao_moeda']));
        $input['vl_adic_desl'] = str_replace(',', '.', str_replace('.', '', $input['vl_adic_desl']));

        try {
          DB::TABLE('AC_RPE_DIARIA')->INSERT($input);
          SweetAlert::success("Diária cadastrada com sucesso");
          return redirect('diarias');
        } catch (\Exception $e) {
          return redirect()->back()->withInput($input)->withErrors(["Houve um erro, tente novamente ou contate o NTI."]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $diaria = DB::TABLE('AC_RPE_DIARIA')
                    ->JOIN('UEPG..TA_CIDADE as ORIG', 'ORIG.id_cidade', '=', 'AC_RPE_DIARIA.id_cidade_origem')
                    ->JOIN('UEPG..TA_CIDADE as DEST', 'DEST.id_cidade', '=', 'AC_RPE_DIARIA.id_cidade_destino')
                    ->WHERE('id_rpe', $id)
                    ->SELECT('AC_RPE_DIARIA.*', 'ORIG.nm_cidade as origem', 'DEST.nm_cidade as destino')
                    ->first();

        $previoempenho = DB::TABLE('AC_PREVIO_EMPENHO')->GET();
        $centrocusto = DB::TABLE('ASSEPLAN..CENTRO_CUSTO')->GET();
        $estados = DB::TABLE('UEPG..TA_UF')->GET();
        $transporte = DB::TABLE('ac_tipo_transporte')->GET();

        $origem = DB::TABLE('UEPG..TA_CIDADE')
                  ->WHERE('id_cidade', $diaria->id_cidade_origem)
                  ->first();

        $destino = DB::TABLE('UEPG..TA_CIDADE')
                  ->WHERE('id_cidade', $diaria->id_cidade_destino)
                  ->first();

        $cidades_origem = DB::TABLE('UEPG..TA_CIDADE')->WHERE('id_uf', $origem->id_uf)->get();
        $cidades_destino = DB::TABLE('UEPG..TA_CIDADE')->WHERE('id_uf', $destino->id_uf)->get();

        $diaria->dt_saida = date('d/m/Y', strtotime($diaria->dt_saida));
        $diaria->dt_retorno = date('d/m/Y', strtotime($diaria->dt_retorno));
        $diaria->dt_conversao_moeda = date('d/m/Y', strtotime($diaria->dt_conversao_moeda));

        $diaria->vl_aux_financeiro = str_replace('.', ',', $diaria->vl_aux_financeiro);
        $diaria->vl_diaria_alim = str_replace('.', ',', $diaria->vl_diaria_alim);
        $diaria->vl_diaria_hosp = str_replace('.', ',', $diaria->vl_diaria_hosp);
        $diaria->vl_adic_desl = str_replace('.', ',', $diaria->vl_adic_desl);
        $diaria->vl_conversao_moeda = str_replace('.', ',', $diaria->vl_conversao_moeda);


        return view('diarias.editar',['diaria' => $diaria,
                                      'origem' => $origem,
                                      'destino' => $destino,
                                      'previoempenho' => $previoempenho,
                                      'centrocusto' => $centrocusto,
                                      'estados' => $estados,
                                      'cidades_origem' => $cidades_origem,
                                      'cidades_destino' => $cidades_destino,
                                      'transporte' => $transporte]);


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
        $input = $request->all();

        unset($input['_token']);
        $id_rpe = $input['id_rpe'];
        unset($input['id_rpe']);

        $data = explode('/', $input['dt_saida']);
        $input['dt_saida'] = $data[2].'-'.$data[1].'-'.$data[0];
        $data = explode('/', $input['dt_retorno']);
        $input['dt_retorno'] = $data[2].'-'.$data[1].'-'.$data[0];
        $data = explode('/', $input['dt_conversao_moeda']);
        $input['dt_conversao_moeda'] = $data[2].'-'.$data[1].'-'.$data[0];

        $input['vl_aux_financeiro'] = str_replace(',', '.', str_replace('.', '', $input['vl_aux_financeiro']));
        $input['vl_diaria_alim'] = str_replace(',', '.', str_replace('.', '', $input['vl_diaria_alim']));
        $input['vl_diaria_hosp'] = str_replace(',', '.', str_replace('.', '', $input['vl_diaria_hosp']));
        $input['vl_conversao_moeda'] = str_replace(',', '.', str_replace('.', '', $input['vl_conversao_moeda']));
        $input['vl_adic_desl'] = str_replace(',', '.', str_replace('.', '', $input['vl_adic_desl']));

        try {
          DB::TABLE('AC_RPE_DIARIA')
          ->WHERE('id_rpe', $id_rpe)
          ->UPDATE($input);
          SweetAlert::success("Diária atualizada com sucesso");
          return redirect('diarias');
        } catch (\Exception $e) {
          return redirect()->back()->withInput($input)->withErrors(["Houve um erro, tente novamente ou contate o NTI."]);
        }

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
        try {
          DB::TABLE('AC_RPE_DIARIA')->WHERE('id_rpe', $id)->delete();
          SweetAlert::success("Diária excluida com sucesso");
          return redirect('diarias');
        } catch (\Illuminate\Database\QueryException $e) {
          SweetAlert::error("Diária não pode ser removido devido a dependência.");
          return redirect()->back();
        }
    }
}
