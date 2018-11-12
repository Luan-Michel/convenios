<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AjudaRequest;
use App\Ajuda;

class AjudaController extends Controller
{
   public function Index(){    
       return view('ajuda.Ajuda');   
   }
   
   public function MissingMethod($params = array()){
       return 'Nada encontrado';
   }
}

