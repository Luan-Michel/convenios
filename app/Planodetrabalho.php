<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planodetrabalho extends Model
{
     protected $connection = "sqlsrv";
    protected $table = "AC_META_APLIC";

    protected $primaryKey = "id_aplicacao";

    public $timestamps = false;

    protected $fillable = ['id_convenio', 'seq_meta_aplic',
        'ds_titulo_meta_aplic', 'ds_meta_aplic', 'dt_inicio_meta', 'dt_termino_meta'];
}
