<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtapaParticipante extends Model
{
    protected $connection = "sqlsrv";

    protected $table = "AC_ETAPA_PARTICIPANTES";

    protected $primaryKey = "id_etapa_participante";

    public $timestamps = false;

    protected $fillable = ['id_etapa_aplic', 'id_financiador', 'ano_convenio', 'nr_convenio', 'id_pessoa_participante'];
}
