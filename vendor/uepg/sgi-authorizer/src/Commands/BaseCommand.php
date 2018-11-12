<?php
namespace Uepg\SGIAuthorizer\Commands;

use Illuminate\Console\Command;

abstract class BaseCommand extends Command {

    abstract public function handle();

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Imprime o logo do sgi-authorizer
     * @return [type] [description]
     */
    protected function displayLogo() {
        // LOGO
        $this->comment('           _                   _   _                _               ');
        $this->comment(' ___  __ _(_)       __ _ _   _| |_| |__   ___  _ __(_)_______ _ __  ');
        $this->comment("/ __|/ _` | |_____ / _` | | | | __| '_ \ / _ \| '__| |_  / _ \ '__| ");
        $this->comment('\__ \ (_| | |_____| (_| | |_| | |_| | | | (_) | |  | |/ /  __/ |    ');
        $this->comment('|___/\__, |_|      \__,_|\__,_|\__|_| |_|\___/|_|  |_/___\___|_|    ');
        $this->comment('     |___/                                                          ');

        $this->comment('Versão ' . $this->version() . ' - Criado com ♥ pela equipe SGI.');
        $this->line('');
    }

    /**
     * Retorna a versão do Authorizer
     * @return [type] [description]
     */
    protected function version() {
        return exec('cd vendor/uepg/sgi-authorizer/; git describe --tags --abbrev=0;');
    }
}
