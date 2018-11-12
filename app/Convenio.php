<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $connection = "sqlsrv";
    protected $table = "AC_CONVENIO";
    protected $primaryKey = 'id_convenio';
    public $timestamps = false;
    protected $fillable = ['id_financiador', 'ano_convenio','nr_convenio', 'nr_protocolo', 'ano_processo','nr_processo', 'ds_objeto',
        'ds_sigla_objeto', 'nr_sit_tce', 'vl_convenio', 'dt_inicio', 'dt_limite_execucao', 'dt_prest_contas', 'dt_limite_vigencia',
      'idcontas_plano_contabil', 'idcontas_plano_banco', 'id_categoria', 'ds_resumo_plano', 'fl_aviso_exec_30', 'fl_aviso_exec_60',
      'fl_aviso_exec_fim'];


    public function financiador(){
      return $this->belongTo('App\Financiador');
    }
}
