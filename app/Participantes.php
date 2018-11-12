<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participantes extends Model
{
   protected $connection = "sqlsrv";
  protected $table = "AC_PARTICIPANTES";

  protected $primaryKey = "id_pessoa_participante";

  public $timestamps = false;

  protected $fillable = ['id_financiador', 'ano_convenio', 'nr_convenio', 'id_pessoa_participante', 'id_pessoa_instituicao', 'cd_coordenador'];

}
