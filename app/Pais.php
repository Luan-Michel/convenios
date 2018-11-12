<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
     protected $connection = "sqlsrv";
    protected $table = "UEPG..TA_PAIS";

    protected $primaryKey = "id_pais";

    public $timestamps = false;

    protected $fillable = ['nm_pais', 'sigla_pais'];

}
