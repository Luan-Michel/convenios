<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
     protected $connection = "sqlsrv";
    protected $table = "AC_ANEXOS";


    protected $primaryKey = ['id_anexo'];
    public $timestamps = false;
    protected $fillable = ['id_convenio', 'ds_titulo_anexo'];

}
