<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despesas extends Model
{
     protected $connection = "sqlsrv_compras";
    protected $table = "DESPESA";

    protected $primaryKey = "cd_desp";

    public $timestamps = false;

    protected $fillable = [ 'cd_desp','nm_desp', 'nm_despcompl'];

}
