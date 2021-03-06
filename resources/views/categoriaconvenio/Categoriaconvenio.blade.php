@extends('app')
@section('content')
    @if(Session::has('message'))
        <div align="center" class="alert alert-danger">
            <strong>{{Session::get('message')}}</strong>
        </div>
    @endif

    <div class='container'>
        <div class="col-md-6">
          <h1>Categoria de convênio</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#categoria" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>

        <div class="col-md-6">
          <br>
        </div>
        <div class="col-md-1" align="left">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('categoriaconvenio.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>
        <div>
          <br><br><br><br>
          <br><br><br>
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
                        <a onclick="remove('{{ route('categoriaconvenio.Deletar',['id'=>$categoria->id_categoria])}}')" class="btn-sm btn-danger">
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

    @include('sweet::alert')

@endsection

@section('content_js')
    <script type="text/javascript">

      $("table").dataTable({
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

        function remove(rota){

          swal({
            title: 'Você tem certeza que deseja excluir a categoria?',
            text: "Esta ação não poderá ser desfeita.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              window.location.href = rota;
            }
          });

        }
    </script>
@endsection
