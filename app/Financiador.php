<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financiador extends Model
{
     protected $connection = "sqlsrv";
    protected $table = "AC_FINANCIADOR";

    protected $primaryKey = "id_financiador";

    public $timestamps = false;

    protected $fillable = ['id_financiador', 'nm_financiador', 'ds_sigla_financiador', 'tp_esfera'];

    public function convenio(){
      return $this->hasMany('App\Convenio', 'id_financiador');
    }
}
