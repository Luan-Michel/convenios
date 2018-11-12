<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CategoriaconvenioRequest;
use App\Categoriaconvenio;
use Illuminate\Support\Facades\DB;


class CategoriaconvenioController extends Controller
{
  public function Index(){
       $f = \App\Categoriaconvenio::all();
      return view('categoriaconvenio.Categoriaconvenio', ['categoria'=> $f]);
  }

  public function Adicionar(){
      return view('categoriaconvenio.Cadastrar');
  }

  public function Editar($id){
      $categoria = \App\Categoriaconvenio::find($id);
      $possuiconv= DB::select(DB::raw("Select count(*) from AC_CONVENIO WHERE ID_CATEGORIA = $id having count(*)>0"));
      if($possuiconv == null){
          $possuiconv=0;
          return view('categoriaconvenio.Editar')->with('categoria',$categoria)->with('possuiconv',$possuiconv);

      } else{
          $possuiconv=1;
          \Session::flash('message_editar', 'Categoria não pode ser editada por possuir convênio cadastrado.');
          return view('categoriaconvenio.Editar')->with('categoria',$categoria)->with('possuiconv',$possuiconv);

      }
  }

  public function Visualizar($id){
      $categoria = \App\Categoriaconvenio::find($id);
      return view('categoriaconvenio.Visualizar', compact('categoria'));
  }

  public function atualizabanco(CategoriaconvenioRequest $request, $id){
      $f = Categoriaconvenio::find($id)->update($request->all());
      return redirect()->route('categoriaconvenio');
  }
    // Não funciona, procurar erro, pro financiador roda, aqui da pau.
     public function Deletar($id) {
         try {
             $categoria = \App\Categoriaconvenio::findOrFail($id);
             $categoria->delete($id);
             return redirect()->route('categoriaconvenio');
         } catch (QueryException $e){}
            return redirect()->route('categoriaconvenio')->with('message', 'Categoria não pode ser excluída por possuir convênio cadastrado.');
        }

    public function store(CategoriaconvenioRequest $request){
      $input = $request->all();
      Categoriaconvenio::create($input);
      return redirect()->route('categoriaconvenio');
  }

  public function MissingMethod($params = array()){
      return 'Nada encontrado';
  }
}
