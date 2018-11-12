<?php

namespace Uepg\SGIAuthorizer\Http\Controllers;

use Illuminate\Http\Request;
use Uepg\SGIAuthorizer\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Uepg\SGIAuthorizer\RequestToServer;
use Uepg\SGIAuthorizer\Exceptions\SGIAuthorizerException;

class UsuarioExternoController extends Controller {
	 /**
     * Server reponsável pela comunicação com o servidor SGI-Security-Server
     * @var [type]
     */
    protected $server;

    public function __construct(RequestToServer $server) {
        $this->server = new RequestToServer();
    }

	public function getCadastro() {
		return view(Config::get('sgiauthorizer.view.cadastroExternoView'));
	}

	public function postCadastro(Request $request) {
		try {
			$mensagem = $this->server->RequestCadastroExterno($request);
		} catch (SGIAuthorizerException $e) {
			return $this->sendResponse($e->options, $request);
		}
	    return $this->completeUserRecordFlow($mensagem, $request);
	}

	    /**
     * Retorna a aplicação. ajax => retorna um json com a mensagem de usuário cadastrado.
     * Laravel => retorna para a view de cadastro om a mensagem de usuário cadastrado.
     *
     * @param $mensagem
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function completeUserRecordFlow($mensagem, Request $request) {
        if($request->ajax()) {
            return json_encode(['mensagem' => $mensagem]);
        }
        else {
            return view(Config::get('sgiauthorizer.view.cadastroExternoView'))->with('mensagem', $mensagem);
        }
    }

	/**
	 * Manda os erros para a view de cadastro de usuário externo (normal request).
	 * Manda os erros em formato json para a aplicacao (ajax request).
	 *
	 * @param $error
	 * @param $request
	 * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function sendResponse($error, $request) {
		if($request->ajax()) {
			return response(json_encode($error), 401);
		} else {
			$erro_tipo = $error->error;
			$erro_descricao = $error->error_description;
			$request->flashExcept(['password', 'email_opt_in']);
            return view(Config::get('sgiauthorizer.view.cadastroExternoView'))
				->withErrors(['externo_tipo' => $erro_tipo, 'externo_descricao' => $erro_descricao]);
        }
	}


}