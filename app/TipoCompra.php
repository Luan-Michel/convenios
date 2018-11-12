<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCompra extends Model
{
    protected $connection = "sqlsrv_compras";
    protected $table = "tipo_compra";


    protected $primaryKey = "cd_tpcompra";
    public $timestamps = false;
    protected $fillable = ['CD_TPCOMPRA', 'DS_TPCOMPRA'];

}
