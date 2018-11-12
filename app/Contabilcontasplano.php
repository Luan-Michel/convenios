<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contabilcontasplano extends Model
{
     protected $connection = "sqlsrv_contabil";
    protected $table = "contas_plano";
    protected $primaryKey = ['idcontas_plano'];
    public $timestamps = false;
    protected $fillable = ['cdred'];
}
