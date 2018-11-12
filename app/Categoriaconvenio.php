<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoriaconvenio extends Model
{
     protected $connection = "sqlsrv";
    protected $table = "AC_CATEGORIA_CONV";

    protected $primaryKey = "id_categoria";

    public $timestamps = false;

    protected $fillable = ['id_categoria', 'ds_categoria'];
}
