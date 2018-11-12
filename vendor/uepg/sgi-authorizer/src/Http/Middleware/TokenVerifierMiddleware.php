<?php

namespace Uepg\SGIAuthorizer\Http\Middleware;

use Closure;
use Uepg\SGIAuthorizer\LoginValidator;
use Illuminate\Support\Facades\Config;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware responsável por verificar os AccessTokens e renovar os RefreshTokens
 *
 * @package SGIAuthorizer\Http\Middleware
 */
class TokenVerifierMiddleware
{
    protected $loginValidator;
    protected $url;
    protected $access_token;
    protected $refresh_token;

    public function __construct(LoginValidator $loginValidator, UrlGenerator $url){
        $this->loginValidator = $loginValidator;
        $this->url = $url;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->access_token = $request->session()->get('sgiauthorizer.access_token');
        while(!$this->loginValidator->validateAccessToken($this->access_token, $request)) {
                $this->refresh_token = $request->session()->get('sgiauthorizer.refresh_token');
                if (!$this->loginValidator->getNewAccessToken($this->refresh_token, $request)) {
                    session()->put('sgiauthorizer.lasturl', $this->url->current());
                    Auth::logout();
                    return $this->handleResponse($request);
                }else{
                    $this->access_token = $request->session()->get('sgiauthorizer.access_token');
                    $this->loginValidator->validateAccessToken($this->access_token, $request);
                }
            }
        return $next($request);
    }

    /**
     * Manda os erros para a view de login (normal request).
     * Manda os erros em formato json para a aplicacao (ajax request).
     *
     * @param $error
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function handleResponse($request) {
        $response = json_encode(['error' => 'session_error', 'error_description' => 'Sessão expirada, faça o login novamente.']);

        //Se for uma requisição ajax retorna 401
        if ($request->ajax()) {
            return response($response, 401);
        } else {

            return redirect(Config::get('sgiauthorizer.app.loginRoute'))->with('mensagem', 'Desculpe, sua sessão expirou. Faça o login novamente.');
        }
    }
}
