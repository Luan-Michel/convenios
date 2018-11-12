<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moeda extends Model
{
     protected $connection = "sqlsrv";
    protected $table = "AC_MOEDA";

    protected $primaryKey = "id_moeda";

    public $timestamps = false;

    protected $fillable = [ 'ds_moeda', 'sigla_moeda', 'id_pais', 'dt_extincao'];

}
