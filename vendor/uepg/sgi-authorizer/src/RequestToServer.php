<?php

namespace Uepg\SGIAuthorizer;

use Uepg\SGIAuthorizer\Exceptions\SGIAuthorizerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Uepg\SGIAuthorizer\Events\UsuarioExternoFoiCadastrado;
use Illuminate\Support\Facades\Event;

class RequestToServer {
    //Guzzle client para conexão com servidor.
    protected $client;

    public function __construct() {
        $this->client = new Client(['base_uri' => Config::get('sgiauthorizer.server.host') . config::get('sgiauthorizer.server.path')]);
    }

    /**
     * Cria request para o primeiro login server
     * @param $credentials
     * @param Request $request
     * @return mixed
     * @throws SGIAuthorizerException
     */
    public function RequestFirstLogin($credentials) {
        try {
            $requestLogin = $this->client->post('access_token', [
                'json' => [
                    'username' => $credentials['username'],
                    'password' => $credentials['password'],
                    'client_id' => Config::get('sgiauthorizer.client.id'),
                    'client_secret' => Config::get('sgiauthorizer.client.secret'),
                    'grant_type' => 'password'
                ]
            ]);
        } catch (ClientException $e) {
            \Log::debug($e);
            //Ocorreu um erro ao fazer a autenticação no ldap
            $error = json_decode(explode('response:', $e->getMessage())[1]);
            throw new SGIAuthorizerException($error);
        } catch (RequestException $e) {
            //Ocorreu um erro com a comunicação do servidor (connection timeout, DNS error, etc..)
            $error = (object)['error' => 'erro_conexao', 'error_description' => 'Ocorreu um erro de conexao com o servidor'];
            throw new SGIAuthorizerException($error);
        }

        $usuario = $requestLogin->getBody()->getContents();
        return unserialize($usuario);
    }

    public function RequestAccessTokenValidation($access_token, Request $request) {
        $headers = ['Authorization' => 'Bearer ' . $access_token];
        try {
            $requestValidation = $this->client->get('access_token', ['headers' => $headers]);
        } catch (ClientException $e) {
            return false;
        }

        $response = $requestValidation->getBody()->getContents();
        $array_response = json_decode($response);
        return $array_response->valideAccessToken;
    }

    public function RequestNewAccessToken($refresh_token, Request $request) {
        try {
            $requestNewToken = $this->client->post('access_token', [
                'json' => [
                    'client_id' => Config::get('sgiauthorizer.client.id'),
                    'client_secret' => Config::get('sgiauthorizer.client.secret'),
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refresh_token
                ]
            ]);
        } catch (ClientException $e) {
            return false;
        }

        $response = $requestNewToken->getBody()->getContents();
        $tokens = json_decode($response);

        session(['sgiauthorizer.access_token' => $tokens->access_token]);
        session(['sgiauthorizer.refresh_token' => $tokens->refresh_token]);

        return true;
    }

    /**
     * Chama servidor para registrar um usuário externo
     * @param $dados
     * @return \Illuminate\Http\RedirectResponse
     * @throws SGIAuthorizerException
     */
    public function RequestCadastroExterno($request) {
        try {
            $requestExterno = $this->client->post('cadastrar_externo', [
                'json' => [
                    'client_id' => Config::get('sgiauthorizer.client.id'),
                    'client_secret' => Config::get('sgiauthorizer.client.secret'),
                    'email' => $request->email,
                    'password' => $request->password,
                    'password_confirmation' => $request->password_confirmation,
                    'descricao' => 'Usuário Externo',
                    'nome' => $request->nome,
                    'email_opt_in' => $request->email_opt_in ? true : false,
                    'cpf' => $request->cpf,
                    'rg' => $request->rg,
                ]
            ]);
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents());
            throw new SGIAuthorizerException($error);
        }
        //retira os dados não necessários do $request
        $dados = $request->except(['password', 'password_confirmation', '_token', 'submit']);
        //Dispara evento com os dados do usuário criado
        Event::fire(new UsuarioExternoFoiCadastrado($dados));
        //Retorna mensagem de sucesso para o controlador
        return json_decode($requestExterno->getBody()->getContents())->mensagem;
    }
}