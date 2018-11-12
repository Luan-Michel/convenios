<?php
/**
 * Created by IntelliJ IDEA.
 * User: joaoh
 * Date: 11/13/15
 * Time: 9:45 AM
 */

return array(

    /*
    |-------------------------------------------
    | Client Array
    |-------------------------------------------
    |
    | id: ID do client,
    | secret: Senha do client
    |
    */

    'client' => [
        'id' => env('APP_CLIENT_ID', 1),
        'secret' => env('APP_CLIENT_SECRET', 'secret')
    ],

    /*
    |-------------------------------------------
    | Server Array
    |-------------------------------------------
    |
    | host: Ip do servidor da aplicação,
    | path: Caminho base da aplicação
    |
    */

    'server' => [
        'host' => 'http://dev01.redes.uepg.br/',
        'path' => 'sgi-security-server/server/public/'
    ],

    /*
   |-------------------------------------------
   | App Array
   |-------------------------------------------
   |
   | loginRoute: Rota de login da aplicação.
   |
   | userInfoRoute: Rota para exibir informações do usuario logado.
   |
   | rotaPadrao: Rota padrão para sua aplicação. Caso seja o primeiro login,
   | usuario será redirecionado para essa rota. Caso contrario será redirecionado
   | para a ultima rota visitada.
   |
   */

    'app' => [
        'loginRoute' => '/login',
        'userInfoRoute' => '/user/profile',
        'rotaPadrao' => 'principal'
    ],

    /*
   |-------------------------------------------
   | View Array
   |-------------------------------------------
   |
   | layout: Nome da visão utilizada como layout na aplicação, será extendida pela
   |             visão do formulário disponibilizado com este pacote.
   |
   | loginView: Nome da View (formato Blade) de login da aplicação. O padrão utiliza a view disponibilizada
   |                por este pacote, ela pode ser alterada por uma view especifica de sua aplicação.
   |
   | userInfoView: Nome da View (formato Blade) para mostrar as informações do usuário logado. Como o loginView, fique a
   |                vontade para colocar sua propria view.
   |
   | loggedUserView: Nome da View (formato Blade) para inserir na topbar (ou onde desejar) o username do usuário logado,
   |                  caso o usuario não esteja logado, aparecerá um botão login. Deve utilizar essa view com o comando
   |                  de blade '@include(Config::get('sgiauthorizer.view.loggedUserView'))' onde desejar que seja
   |                  exibido.
   |
   | loginSection: Nome da seção no layout principal onde deve ser inserido o formulário
   |                de login.
   |
   | userInfoSection: Nome da seção no layout principal onde deve ser inserido os dados do usuario logado.
   |
   */

    'view' => [
        'layout' => 'app',

        'loginView' => 'sgiauthorizer::auth.login',
        'userInfoView' => 'sgiauthorizer::auth.showUserInfo',
        'loggedUserView' => 'sgiauthorizer::auth.loggedUser',

        'loginSection' => 'content',
        'userInfoSection' => 'userinfo'
    ]

);
