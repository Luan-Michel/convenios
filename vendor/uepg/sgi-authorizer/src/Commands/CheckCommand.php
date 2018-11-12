<?php

namespace Uepg\SGIAuthorizer\Commands;

use Uepg\SGIAuthorizer\Commands\BaseCommand;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class CheckCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sgi-authorizer:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica se as credenciais da aplicação estão corretas';

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

        $client = new Client(['base_uri' => Config::get('sgiauthorizer.server.host') . config::get('sgiauthorizer.server.path')]);

        try {
            $valida = $client->post('validar_aplicacao', [
                'json' => [
                    'client_id' => Config::get('sgiauthorizer.client.id'),
                    'client_secret' => Config::get('sgiauthorizer.client.secret')
                ]
            ]);
        } catch (RequestException $e) {
            $this->error('Por favor, verifique as credenciais da sua aplicação.');
            exit();
        }
        $mensagem = json_decode($valida->getBody()->getContents());

        $this->info($mensagem->mensagem);

    }
}
