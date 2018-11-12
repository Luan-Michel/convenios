<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtapaAplicacao extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "AC_ETAPA_APLIC";

    protected $primaryKey = "id_etapa_aplic";

    public $timestamps = false;

    protected $fillable = ['id_etapa_aplic', 'id_aplicacao', 'ds_titulo_etapa', 'ds_etapa_aplic', 'dt_inicio_etapa',
        'dt_termino_etapa', 'ds_unidade_medida', 'qt_unidade_etapa', 'idcontas_plano', 'cd_tabela', 'cd_desp', 'vl_total_etapa',
        'vl_reservado', 'vl_empenhado', 'vl_saldo'];
}
