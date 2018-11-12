<?php

namespace Uepg\SGIAuthorizer\Http\Controllers;

use Illuminate\Http\Request;
use Uepg\SGIAuthorizer\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Uepg\SGIUser\Models\Usuario;
use Uepg\SGIAuthorizer\RequestToServer;
use Uepg\SGIAuthorizer\Exceptions\SGIAuthorizerException;
use Uepg\SGIAuthorizer\Events\UsuarioAutenticado;
use Illuminate\Support\Facades\Event;

class LoginController extends Controller {

    /**
     * Server reponsável pela comunicação com o servidor SGI-Security-Server
     * @var [type]
     */
    protected $server;

    public function __construct(RequestToServer $server) {
        $this->server = new RequestToServer();
    }

    /**
     * Retorna view de login ou um 401 (caso request seja via ajax)
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getLogin(Request $request) {
        if($request->ajax()) {
            return response('Unauthorized', 401);
        } else {
            return view(Config::get('sgiauthorizer.view.loginView'));
        }
    }

    /**
     * Retira as credenciais necessarias do $request
     * @param  Request $request [description]
     * @return array           [array contendo as credenciais]
     */
    private function getCredentials(Request $request) {
        return $request->only(['username', 'password']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \App\Exceptions\SGIAuthorizerException
     */
    public function login(Request $request) {
        $credentials = $this->getCredentials($request);
        //Captura eventual exceção gerada no $server
        try {
            $data = $this->server->RequestFirstLogin($credentials, $request);
        } catch (SGIAuthorizerException $e) {
            return $this->sendResponse($e->options, $request);
        }

        //$data => array contendo (tokens => tokens, usuario => usuario)
        if($data){
            $this->saveTokens($data['tokens']);
            $usuarioLogado = $this->userLogin($data['usuario']);
            if($usuarioLogado) {
                return $this->completeAuthenticationFlow($usuarioLogado, $request);
            }
        }
    }

    /**
     * Desconecta o usuário logado, retorna para a rota de login com mensagem
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout() {
        $user = '';
        if (Auth::user() !== null) {
            $user = Auth::user()->username;
        }
        session()->forget('sgiauthorizer');
        Auth::logout();
        return redirect()->route('login')->with('mensagem', 'Usuário '. $user .' desconectado com sucesso!');
    }

    /**
     * Salva os tokens na sessão
     *
     * @param $tokens
     * @return bool
     */
    private function saveTokens($tokens) {
        session()->put('sgiauthorizer.access_token', $tokens['access_token']);
        session()->put('sgiauthorizer.refresh_token', $tokens['refresh_token']);
        return true;
    }

    /**
     * Faz o login do usuário pela facade Auth. Assim fica todas as funções do Auth ficam disponiveis para o
     * programador
     *
     * @param $userData
     * @return Usuario
     */
    private function userLogin($userData) {
        $model = Auth::getProvider()->getModel();
        $usuarioLogado = new $model((array) $userData);
        Auth::login($usuarioLogado);
        Event::fire(new UsuarioAutenticado($usuarioLogado));
        return $usuarioLogado;
    }

    /**
     * Retorna a aplicação. ajax => retorna um json com o objeto do usuario logado.
     * Laravel => retorna para a ultima url ou para a rotaPadrao da aplicação
     *
     * @param $usuarioLogado
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    private function completeAuthenticationFlow($usuarioLogado, Request $request) {
        if($request->ajax()) {
            return json_encode($usuarioLogado);
        }
        else {
            return redirect(session()->get('sgiauthorizer.lasturl', Config::get('sgiauthorizer.app.rotaPadrao')));
        }
    }

    /**
     * Manda os erros para a view de login (normal request).
     * Manda os erros em formato json para a aplicacao (ajax request).
     *
     * @param $error
     * @param $request
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function sendResponse($error, $request) {
        if($request->ajax()) {
            return response(json_encode($error), 401);
        } else {
            $erro_tipo = $error->error;
            $erro_descricao = $error->error_description;
            return view(Config::get('sgiauthorizer.view.loginView'))
                ->withErrors(['login_tipo' => $erro_tipo, 'login_descricao' => $erro_descricao]);
        }
    }

}
