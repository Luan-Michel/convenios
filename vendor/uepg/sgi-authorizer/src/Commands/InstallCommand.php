<?php

namespace Uepg\SGIAuthorizer\Commands;

use Uepg\SGIAuthorizer\Commands\BaseCommand;

class InstallCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgi-authorizer:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adiciona as rotas necessárias para o SGIAuthorizer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {      
        $this->displayLogo();  

        $this->info('Arquivo de rotas atualizado com sucesso.');

        file_put_contents(
            app_path('Http/routes.php'),
            file_get_contents(__DIR__.'/routes'),
            FILE_APPEND
        );
    } 
}
