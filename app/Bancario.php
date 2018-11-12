<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bancario extends Model
{
    protected $connection = "sqlsrv_pessoa";
    protected $table = "BANCARIO";


    protected $primaryKey = 'id_pessoa';
    public $timestamps = false;
    protected $fillable = ['id_pessoa','seq_bancario', 'nr_banco', 'nr_agencia', 'nr_conta', 'nr_dac', 'cd_tipo_conta'];

}
