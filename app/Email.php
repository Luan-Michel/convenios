<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
     protected $connection = "sqlsrv_pessoa";
    protected $table = "E_MAIL";

//    protected $primaryKey = "";

    public $timestamps = false;

    protected $fillable = [ 'id_pessoa', 'seq_email', 'ds_email'];

}
