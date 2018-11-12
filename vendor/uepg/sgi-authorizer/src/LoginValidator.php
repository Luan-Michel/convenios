<?php
namespace Uepg\SGIAuthorizer;

use Uepg\SGIAuthorizer\RequestToServer;

class LoginValidator {
    /**
     * Server reponsável pela comunicação com o servidor SGI-Security-Server
     * @var [type]
     */
    protected $server;

    public function __construct(RequestToServer $server) {
        $this->server = new RequestToServer();
    }

    /**
     * Valida o Access Token
     * @param $access_token
     * @return bool
     */
    public function validateAccessToken($access_token, $request) {
        return $this->server->RequestAccessTokenValidation($access_token, $request);
    }

    /**
     * Renova tokens a partir de um Refresh Token
     * @param $refresh_token
     * @return bool
     */
    public function getNewAccessToken($refresh_token, $request) {
        return $this->server->RequestNewAccessToken($refresh_token, $request);
    }
}
