<?php

/*
 * Rotas padrões do pacote SGIAuthorizer para login e exibição dos usuários logados.
 */
//Rota para login
Route::get(Config::get('sgiauthorizer.app.loginRoute'), ['as' => 'login', 'uses' => '\Uepg\SGIAuthorizer\Http\Controllers\LoginController@getLogin']);
Route::post(Config::get('sgiauthorizer.app.loginRoute'), '\Uepg\SGIAuthorizer\Http\Controllers\LoginController@login');

//Rota para logout
Route::get('/logout', ['as' => 'logout', 'uses' => '\Uepg\SGIAuthorizer\Http\Controllers\LoginController@logout']);

//
Route::group(['middleware' => 'sgiauth'], function() {
  	//Rota para exibir informações do usuario logado
  	Route::any(Config::get('sgiauthorizer.app.userInfoRoute'), ['uses' => '\Uepg\SGIAuthorizer\Http\Controllers\DisplayUserInfoController@userInfo']);


    Route::get('/', 'PrincipalController@Index');
    Route::get('convenio', ['as'=>'/', 'uses'=>'PrincipalController@Index']);
    Route::get('principal', 'PrincipalController@Index');
    Route::get('errors/js', 'PrincipalController@js');

    Route::get('pdfs/{filename}', function ($filename)
    {
        $path = storage_path() . '/uploads/' . $filename;
        if(!File::exists($path)) abort(404);
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    });


    Route::group(['prefix'=>'financiador', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'financiador', 'uses'=>'FinanciadorController@Index']);
        Route::get('adicionar', ['as'=>'financiador.Cadastrar', 'uses'=>'FinanciadorController@Adicionar']);
        Route::post('store', ['as'=>'financiador.store', 'uses'=>'FinanciadorController@store']);
        Route::get('{id}/visualizar', ['as'=>'financiador.Visualizar', 'uses'=>'FinanciadorController@Visualizar']);
        Route::get('{id}/deletar', ['as'=>'financiador.Deletar' ,'uses'=>'FinanciadorController@Deletar']);
        Route::get('{id}/editar', ['as'=>'financiador.Editar', 'uses'=>'FinanciadorController@Editar']);
        Route::put('{id}/atualizabanco',['as'=>'financiador.atualizabanco', 'uses'=>'FinanciadorController@atualizabanco']);
    });


    Route::group(['prefix'=>'categoriaconvenio', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'categoriaconvenio', 'uses'=>'CategoriaconvenioController@Index']);
        Route::get('adicionar', ['as'=>'categoriaconvenio.Cadastrar', 'uses'=>'CategoriaconvenioController@Adicionar']);
        Route::post('store', ['as'=>'categoriaconvenio.store', 'uses'=>'CategoriaconvenioController@store']);
        Route::get('{id}/visualizar', ['as'=>'categoriaconvenio.Visualizar', 'uses'=>'CategoriaconvenioController@Visualizar']);
        Route::get('{id}/deletar', ['as'=>'categoriaconvenio.Deletar' ,'uses'=>'CategoriaconvenioController@Deletar']);
        Route::get('{id}/editar', ['as'=>'categoriaconvenio.Editar', 'uses'=>'CategoriaconvenioController@Editar']);
        Route::put('{id}/atualizabanco',['as'=>'categoriaconvenio.atualizabanco', 'uses'=>'CategoriaconvenioController@atualizabanco']);

    });

    Route::group(['prefix'=>'convenio', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'convenio', 'uses'=>'ConvenioController@Index']);
        Route::get('adicionar', ['as'=>'convenio.Cadastrar', 'uses'=>'ConvenioController@Adicionar']);
        Route::post('store', ['as'=>'convenio.store', 'uses'=>'ConvenioController@store']);
        Route::get('{id_convenio}/deletar', ['as'=>'convenio.Deletar' ,'uses'=>'ConvenioController@Deletar']);
        Route::post('ajaxVerificaConv', 'ConvenioController@ajaxVerificaConv');
        Route::get('{ano}/{nr}/{id_financiador}/editar', ['as'=>'convenio.Editar', 'uses'=>'ConvenioController@Editar']);
        Route::get('{id}/visualizar', ['as'=>'convenio.VisualizarConvenio', 'uses'=>'ConvenioController@Visualizar']);
        Route::put('{ano}/{nr}/{id_financiador}/atualizabanco',['as'=>'convenio.atualizabanco', 'uses'=>'ConvenioController@atualizabanco']);
        Route::get('visualizarCnumero', ['as'=>'convenio.VisualizarCnumero', 'uses'=>'ConvenioController@VisualizarCnumero']);
        Route::get('{id}/visualizarCfinanciador', ['as'=>'convenio.VisualizarCfinanciador', 'uses'=>'ConvenioController@VisualizarCfinanciador']);
        Route::get('/financiador/{id}', 'ConvenioController@convenioFinanciador');
        Route::get('/anexo/{id}', 'ConvenioController@convenioAnexo');
    });



    Route::group(['prefix'=>'planodetrabalho', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'planodetrabalho', 'uses'=>'PlanodetrabalhoController@Indexall']);
        Route::get('{ano}/{nr}/{financiador}', ['as'=>'planodetrabalho', 'uses'=>'PlanodetrabalhoController@Index']);
        Route::get('{ano}/{nr}/{financiador}/adicionar', ['as'=>'planodetrabalho.Cadastrar', 'uses'=>'PlanodetrabalhoController@Adicionar']);
        Route::post('store', ['as'=>'planodetrabalho.store', 'uses'=>'PlanodetrabalhoController@store']);
        Route::get('{id}/visualizar', ['as'=>'planodetrabalho.Visualizar', 'uses'=>'PlanodetrabalhoController@Visualizar']);
        Route::get('{id}/deletar', ['as'=>'planodetrabalho.Deletar' ,'uses'=>'PlanodetrabalhoController@Deletar']);
        Route::get('{id}/editar', ['as'=>'planodetrabalho.Editar', 'uses'=>'PlanodetrabalhoController@Editar']);
        Route::put('{id}/atualizabanco',['as'=>'planodetrabalho.atualizabanco', 'uses'=>'PlanodetrabalhoController@Atualizabanco']);
        Route::get('visualizar', ['as'=>'planodetrabalho.Visualizar', 'uses'=>'PlanodetrabalhoController@Visualizar']);
    });


    Route::group(['prefix'=>'etapaplanodetrabalho', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'etapaplanodetrabalho', 'uses'=>'EtapaPlanodetrabalhoController@Index']);
        Route::get('adicionar', ['as'=>'etapaplanodetrabalho.Cadastrar', 'uses'=>'EtapaPlanodetrabalhoController@Adicionar']);
        Route::post('store', ['as'=>'etapaplanodetrabalho.store', 'uses'=>'EtapaPlanodetrabalhoController@store']);
        Route::get('{id}/visualizar', ['as'=>'etapaplanodetrabalho.Visualizar' ,'uses'=>'EtapaPlanodetrabalhoController@Visualizar']);
        Route::get('{id}/deletar', ['as'=>'etapaplanodetrabalho.Deletar' ,'uses'=>'EtapaPlanodetrabalhoController@Deletar']);
        Route::get('{id}/editar', ['as'=>'etapaplanodetrabalho.Editar', 'uses'=>'EtapaPlanodetrabalhoController@Editar']);
        Route::put('{id}/atualizabanco',['as'=>'etapaplanodetrabalho.atualizabanco', 'uses'=>'EtapaPlanodetrabalhoController@atualizabanco']);
        Route::get('visualizar', ['as'=>'etapaplanodetrabalho.Visualizar', 'uses'=>'EtapaPlanodetrabalhoController@Index']);
    });

    Route::group(['prefix'=>'etapaparticipantes', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'etapaparticipantes', 'uses'=>'EtapaParticipantesController@Index']);
        Route::get('adicionar', ['as'=>'etapaparticipantes.Cadastrar', 'uses'=>'EtapaParticipantesController@Adicionar']);
        Route::post('store', ['as'=>'etapaparticipantes.store', 'uses'=>'EtapaParticipantesController@store']);
        Route::get('{id}/deletar', ['as'=>'etapaparticipantes.Deletar' ,'uses'=>'EtapaParticipantesController@Deletar']);
        Route::get('{id}/editar', ['as'=>'etapaparticipantes.Editar', 'uses'=>'EtapaParticipantesController@Editar']);
        Route::get('{id}/visualizar', ['as'=>'etapaparticipantes.visualizar', 'uses'=>'EtapaParticipantesController@Index']);
        Route::post('{id}/atualizabanco',['as'=>'etapaparticipantes.atualizabanco', 'uses'=>'EtapaParticipantesController@atualizabanco']);
        Route::get('visualizar', ['as'=>'etapaparticipantes.Visualizar', 'uses'=>'EtapaParticipantesController@Index']);
        Route::get('adicionar/getetapa/{id}', ['as'=>'etapaparticipantes.getEtapa', 'uses'=>'EtapaParticipantesController@getEtapa']);
        Route::get('{id}/editar/getetapa/{id_etapa}', ['as'=>'etapaparticipantes.getEtapaEdit', 'uses'=>'EtapaParticipantesController@getEtapaEdit']);
    });

    Route::group(['prefix'=>'pessoa', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'pessoa', 'uses'=>'PessoaController@Index']);
        Route::get('ajaxPesquisaPessoa', 'PessoaController@ajaxPesquisaPessoa');
        Route::get('adicionar', ['as'=>'pessoa.Cadastrar', 'uses'=>'Controller@Adicionar']);
        Route::get('adicionarpessoa', ['as'=>'pessoa.adicionarpessoa' ,'uses'=>'PessoaController@adicionarpessoa']);
        Route::get('adicionarpessoafisica', ['as'=>'pessoa.adicionarpessoafisica' ,'uses'=>'PessoaController@adicionarpessoafisica']);
        Route::get('adicionarinstituicao', ['as'=>'pessoa.adicionarinstituicao' ,'uses'=>'PessoaController@adicionarinstituicao']);
        Route::post('storeinstituicao', ['as'=>'pessoa.storeinstituicao', 'uses'=>'PessoaController@storeinstituicao']);
        Route::post('storepessoafisica', ['as'=>'pessoa.storepessoafisica', 'uses'=>'PessoaController@storepessoafisica']);
        Route::get('{id}/deletar', ['as'=>'pessoa.Deletar' ,'uses'=>'PessoaController@Deletar']);
        Route::get('{id}/editar', ['as'=>'pessoa.Editar' ,'uses'=>'PessoaController@Editar']);
        Route::put('{id}/atualizabancopessoafisica',['as'=>'pessoa.atualizabancopessoafisica', 'uses'=>'PessoaController@atualizabancopessoafisica']);
        Route::put('{id}/atualizabancopessoajuridica',['as'=>'pessoa.atualizabancopessoajuridica', 'uses'=>'PessoaController@atualizabancopessoajuridica']);
        Route::get('{id}/visualizar', ['as'=>'pessoa.Visualizar' ,'uses'=>'PessoaController@Visualizar']);
        Route::get('/email/{id}/{seq}', 'PessoaController@Email');
        Route::post('{id}/ajaxDelete', ['as'=>'pessoa.ajaxDelete', 'uses'=>'PessoaController@ajaxDelete']);
        Route::post('valida_cpf', ['as'=>'pessoa.ajaxDelete', 'uses'=>'PessoaController@valida_cpf']);
        Route::post('valida_cnpj', ['as'=>'pessoa.ajaxDelete', 'uses'=>'PessoaController@valida_cnpj']);
        Route::post('gera_nome_abreviado', ['as'=>'pessoa.gera_nome_abreviado', 'uses'=>'PessoaController@gera_nome_abreviado']);

    });

    Route::group(['prefix'=>'pessoaconvenio', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'pessoaconvenio', 'uses'=>'PessoaConvenioController@Index']);
        Route::get('adicionar', ['as'=>'pessoaconvenio.adicionar', 'uses'=>'PessoaConvenioController@Adicionar']);
        Route::post('store', ['as'=>'pessoaconvenio.store', 'uses'=>'PessoaConvenioController@store']);
        Route::post('{id_convenio}/{id_pessoa}/deletar', ['as'=>'pessoaconvenio.Deletar' ,'uses'=>'PessoaConvenioController@Deletar']);
        Route::get('{id_convenio}/{id_pessoa}/editar', ['as'=>'pessoaconvenio.Editar', 'uses'=>'PessoaConvenioController@Editar']);
        Route::get('{id_convenio}/{id_pessoa}/visualizar', ['as'=>'pessoaconvenio.VisualizarConvenio', 'uses'=>'PessoaConvenioController@Visualizar']);
        Route::get('/ajaxInst', 'PessoaConvenioController@ajaxInst');
        Route::put('atualizabanco',['as'=>'pessoaconvenio.atualizabanco', 'uses'=>'PessoaConvenioController@atualizabanco']);
    });

    Route::group(['prefix'=>'etapaitem', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'etapaitem', 'uses'=>'EtapaItemController@Index']);
        Route::get('adicionar', ['as'=>'etapaitem.Cadastrar', 'uses'=>'EtapaItemController@Adicionar']);
        Route::post('store', ['as'=>'etapaitem.store', 'uses'=>'EtapaItemController@store']);
        Route::get('{id}/deletar', ['as'=>'etapaitem.Deletar' ,'uses'=>'EtapaItemController@Deletar']);
        Route::get('{id}/editar', ['as'=>'etapaitem.Editar' ,'uses'=>'EtapaItemController@Editar']);
        Route::get('{id}/editar/nm_desp/search/{nm_desp}', 'EtapaItemController@getNameDespEdit');
        Route::put('{id}/atualizabanco',['as'=>'etapaitem.atualizabanco', 'uses'=>'EtapaItemController@atualizabanco']);
        Route::get('{id}/visualizar', ['as'=>'etapaitem.Visualizar' ,'uses'=>'EtapaItemController@Visualizar']);
        Route::get('adicionar/cd_desp/{desp}', 'EtapaItemController@getDespesas');
        Route::get('adicionar/nm_desp/search/{nm_desp}','EtapaItemController@getNameDesp');
    });
    //Prévio Empenho
    Route::group(['prefix'=>'previoempenho', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'previoempenho', 'uses'=>'PrevioEmpenhoController@Index']);
        Route::get('adicionar', ['as'=>'previoempenho.Cadastrar', 'uses'=>'PrevioEmpenhoController@Adicionar']);
        Route::post('store', ['as'=>'previoempenho.store', 'uses'=>'PrevioEmpenhoController@store']);
        Route::get('{id}/deletar', ['as'=>'previoempenho.Deletar' ,'uses'=>'PrevioEmpenhoController@Deletar']);
        Route::get('{id}/editar', ['as'=>'previoempenho.Editar', 'uses'=>'PrevioEmpenhoController@Editar']);
        Route::get('{id}/visualizar', ['as'=>'previoempenho.Visualizar', 'uses'=>'PrevioEmpenhoController@Visualizar']);
        Route::put('{id}/atualizabanco',['as'=>'previoempenho.atualizabanco', 'uses'=>'PrevioEmpenhoController@atualizabanco']);
        Route::post('ajaxBeneficiario', 'PrevioEmpenhoController@ajaxBeneficiario');
        Route::post('ajaxPessoa', 'PrevioEmpenhoController@ajaxPessoa');
        Route::post('ajaxEtapaAplic', 'PrevioEmpenhoController@ajaxEtapaAplic');
        Route::post('ajaxConta', 'PrevioEmpenhoController@ajaxConta');
        Route::post('{id}/ajaxDelete', ['as'=>'previoempenho.ajaxDelete', 'uses'=>'PrevioEmpenhoController@ajaxDelete']);
    });


    //Conta Corrente
    Route::group(['prefix'=>'contacorrente', 'where'=>['id'=>'[0-9]+']], function(){
    /*    Route::get('', ['as'=>'contacorrente', 'uses'=>'ContaCorrenteController@Index']);*/
        Route::get('{id_pessoa}', ['as'=>'contacorrente', 'uses'=>'ContaCorrenteController@Index']);
        Route::get('{id_pessoa}/adicionar', ['as'=>'contacorrente.Cadastrar', 'uses'=>'ContaCorrenteController@Adicionar']);
        Route::post('store', ['as'=>'contacorrente.store', 'uses'=>'ContaCorrenteController@store']);
        Route::get('{id_pessoa}/{seq_bancario}/deletar', ['as'=>'contacorrente.Deletar' ,'uses'=>'ContaCorrenteController@Deletar']);
        Route::get('{id_pessoa}/{seq_bancario}/editar', ['as'=>'contacorrente.Editar' ,'uses'=>'ContaCorrenteController@Editar']);
        Route::put('{id_pessoa}/{seq_bancario}/atualizabanco',['as'=>'contacorrente.atualizabanco', 'uses'=>'ContaCorrenteController@atualizabanco']);
        Route::post('ajaxAgencia','ContaCorrenteController@ajaxAgencia');
        Route::post('ajaxTipoConta','ContaCorrenteController@ajaxTipoConta');


    });
    Route::group(['prefix'=>'banco', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'banco', 'uses'=>'BancoController@Index']);
        Route::get('adicionar', ['as'=>'banco.Cadastrar', 'uses'=>'BancoController@Adicionar']);
        Route::post('store', ['as'=>'banco.store', 'uses'=>'BancoController@store']);
        Route::get('{id}/visualizar', ['as'=>'banco.Visualizar' ,'uses'=>'BancoController@Visualizar']);
        Route::get('{id}/deletar', ['as'=>'banco.Deletar' ,'uses'=>'BancoController@Deletar']);
        Route::get('{id}/editar', ['as'=>'banco.Editar', 'uses'=>'BancoController@Editar']);
        Route::put('{id}/atualizabanco',['as'=>'banco.atualizabanco', 'uses'=>'BancoController@atualizabanco']);
        Route::get('visualizar', ['as'=>'banco.Visualizar', 'uses'=>'BancoController@Index']);
    });

    Route::group(['prefix'=>'agencia', 'where'=>['id'=>'[0-9]+']], function() {
        Route::get('', ['as' => 'agencia', 'uses' => 'AgenciaController@Index']);
        Route::get('adicionar', ['as' => 'agencia.Cadastrar', 'uses' => 'AgenciaController@Adicionar']);
        Route::post('store', ['as' => 'agencia.store', 'uses' => 'AgenciaController@store']);
        Route::get('{id}/visualizar', ['as' => 'agencia.Visualizar', 'uses' => 'AgenciaController@Visualizar']);
        Route::get('{id}/deletar', ['as' => 'agencia.Deletar', 'uses' => 'AgenciaController@Deletar']);
        Route::get('{id}/editar', ['as' => 'agencia.Editar', 'uses' => 'AgenciaController@Editar']);
        Route::put('{id}/atualizabanco', ['as' => 'agencia.atualizabanco', 'uses' => 'AgenciaController@atualizabanco']);
        Route::get('visualizar', ['as' => 'agencia.Visualizar', 'uses' => 'AgenciaController@Index']);
    });

    Route::group(['prefix'=>'diarias', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'diarias', 'uses'=>'DiariasController@Index']);
        Route::get('adicionar', ['as'=>'diarias.Cadastrar', 'uses'=>'DiariasController@create']);
        Route::get('adicionar/id_cidade_destino/{id}', ['as'=>'diarias.getDestino', 'uses'=>'DiariasController@getDestino']);
        Route::get('{id}/editar/id_cidade_destino/{id_cidade}', ['as'=>'diarias.getDestinoEditar', 'uses'=>'DiariasController@getDestinoEditar']);
        Route::get('{id}/deletar', ['as'=>'diarias.Deletar', 'uses'=>'DiariasController@destroy']);
        Route::post('store', ['as'=>'diarias.store', 'uses'=>'DiariasController@store']);
        Route::post('{id}/update', ['as'=>'diarias.update', 'uses'=>'DiariasController@update']);
        Route::get('{id}/editar', ['as'=>'diarias.Editar', 'uses'=>'DiariasController@edit']);
    });

    Route::group(['prefix'=>'ajuda', 'where'=>['id'=>'[0-9]+']], function(){
        Route::get('', ['as'=>'ajuda', 'uses'=>'AjudaController@Index']);
    });

    Route::group(['prefix'=>'ajax', 'where'=>['id'=>'[0-9]+']], function(){
        Route::post('buscarconvenio', ['as'=>'ajax.buscarconvenio', 'uses'=>'AjaxController@buscarconvenio']);

    });

    Route::get('/', function () {
        return view('login');
    });


});
