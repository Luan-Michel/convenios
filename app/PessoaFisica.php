<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaFisica extends Model
{
    protected $connection = "sqlsrv_pessoa";
    protected $table = "PESSOA_FISICA";


    protected $primaryKey = 'id_pessoa';
    public $timestamps = false;
    protected $fillable = ['id_pessoa', 'cpf'];

}
