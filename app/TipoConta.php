<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoConta extends Model
{
    protected $connection = "sqlsrv_pessoa";
    protected $table = "TA_TIPO_CONTA";


    protected $primaryKey = ['cd_tipo_conta', 'nr_banco'];
    public $timestamps = false;
    protected $fillable = ['cd_tipo_conta', 'nr_banco', 'ds_tipo_conta'];

}
