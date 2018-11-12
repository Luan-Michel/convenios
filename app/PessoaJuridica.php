<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaJuridica extends Model
{
     protected $connection = "sqlsrv_pessoa";
    protected $table = "PESSOA_JURIDICA";


    protected $primaryKey = 'id_pessoa';
    public $timestamps = false;
    protected $fillable = ['id_pessoa', 'nm_fantasia','cnpj','inscricao_estadual','cd_siaf'];

}
