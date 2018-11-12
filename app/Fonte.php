<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fonte extends Model
{
    protected $connection = "sqlsrv_compras";
    protected $table = "FONTE";


    protected $primaryKey = 'cd_fonte';
    public $timestamps = false;
    protected $fillable = ['CD_FONTE', 'NM_FONTE', 'cd_ativo'];

}
