<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $connection = "sqlsrv_pessoa";
    protected $table = "TA_BANCO";


    protected $primaryKey = 'nr_banco';
    public $timestamps = false;
    protected $fillable = ['nr_banco', 'nm_banco'];

}
