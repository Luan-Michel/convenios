<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $connection = "sqlsrv_pessoa";
    protected $table = "pessoa";

    protected $primaryKey = "id_pessoa";

    public $timestamps = false;

    protected $fillable = ['id_pessoa', 'nm_pessoa_completo','nm_pessoa_abreviado'];
}

