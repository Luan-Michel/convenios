<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtapaItem extends Model
{
     protected $connection = "sqlsrv";
    protected $table = "AC_ETAPA_ITEM_APLIC";

    protected $primaryKey = "id_etapa_item_aplic";

    public $timestamps = false;

    protected $fillable = ['id_etapa_aplic', 'ds_item', 'cd_tabela', 'cd_desp', 'dt_aplicacao', 'vl_item', 'qt_item', 'vl_total_item', 'id_pais', 'id_moeda'];
}
