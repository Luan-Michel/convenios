<?php

namespace Uepg\SGIAuthorizer\Providers\Auth;

use Uepg\SGIUser\Models\Usuario;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class SGIUserProvider implements UserProvider {

    /**
     * Model de Usuario a ser usado (auth.config)
     *
     * @var
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Retorna qual o model para Usuario
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Retorna o usuário logado quando chamado
     * @param $identifier
     * @return mixed
     */
    public function retrieveById($identifier)
    {
        return $identifier;
    }

    /* As demais funções não precisamos implementar. A unica coisa que precisamos é o retrieveById
     * que é chamada sempre que o Auth:: é usado.
     */
    public function retrieveByCredentials(array $credentials) {}

    public function updateRememberToken(Authenticatable $user, $token) {}

    public function retrieveByToken($identifier, $token) {}

    public function validateCredentials(Authenticatable $user, array $credentials) {}
}