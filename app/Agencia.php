<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
    protected $connection = "sqlsrv_pessoa";
    protected $table = "pessoa..TA_AGENCIA";


    protected $primaryKey = ['nr_banco', 'nr_agencia'];
    public $timestamps = false;
    protected $fillable = ['nr_banco', 'nr_agencia',  'nm_agencia','nr_dac' ];

}
