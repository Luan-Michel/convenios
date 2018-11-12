<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrevioEmpenho extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "AC_PREVIO_EMPENHO";
    protected $primaryKey = 'id_rpe';
    public $timestamps = false;
    protected $fillable = ['id_rpe','ano_rpe', 'nr_rpe', 'cd_tpcompra','cd_fonte', 'id_etapa_aplic', 'tp_beneficiario', 'id_pessoa',
    'seq_bancario', 'ds_objetivo', 'vl_previo_empenho', 'id_moeda', 'tp_rpe', 'dt_rpe'];
}
