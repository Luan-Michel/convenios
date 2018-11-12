<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PrincipalRequest;
use App\Principal;

class PrincipalController extends Controller
{
   public function Index(){
       return view('principal.Principal');
   }

   public function js(){
       return view('errors.js');   
   }

   public function MissingMethod($params = array()){
       return 'Nada encontrado';
   }
}
