@extends('app')
@section('content')
    @if(Session::has('message'))
        <div align="center" class="alert alert-danger">
            <strong>{{Session::get('message')}}</strong>
        </div>
    @endif

    <div class='container'>
        <h1>Categoria de convênio</h1>
        <div class="col-md-1" align="left">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('categoriaconvenio.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>
        <table class="table table-striped table-hover table-bordered" id="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Alterar</th>
                <th>Excluir</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categoria as $categoria)
                <tr>
                    <td>{{$categoria->ds_categoria}}</td>
                    <td align="center">
                        <a href="{{ route('categoriaconvenio.Editar',['id'=>$categoria->id_categoria])}}" class="btn-sm btn-default">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td align="center">
                        <a href="{{ route('categoriaconvenio.Deletar',['id'=>$categoria->id_categoria])}}" class="btn-sm btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br> <br>
        <div class="col-md-1" align="left">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('categoriaconvenio.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>

    </div>

@endsection

@section('content_js')
    <script> $("table").dataTable({
            "language": {
                "url": "/Portuguese.json",
                "search":"Pesquisar",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "info" : '',
                "paginate": {
                    "previous": "Anterior",
                    "next": "Próximo"
                },
                "sEmptyTable":"Nenhum registro encontrado."
        }});
    </script>
@endsection
