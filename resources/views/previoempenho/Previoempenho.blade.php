@extends('app')

@section('content')
    <div class='container'>
      <div class="col-md-12" id="cabecalho">
        <div class="col-md-6">
          <h1>Prévio Empenho</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#previoempenho" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
      </div>
        <div class="col-md-1" align="right">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('previoempenho.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>
        <div class="col-md-6" align="right">
          <br>
        </div>
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover" id="table">
                <thead>
                <tr>
                    <th>Ano Prévio Empenho</th>
                    <th>Número Prévio Empenho</th>
                    <th>Beneficiário</th>
                    <th>Alterar</th>
                    <th>Excluir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($previoempenho as $previoempenho)
                    <tr>
                        <td>{{$previoempenho->ano_rpe}}</td>
                        <td>{{$previoempenho->nr_rpe}}</td>
                        <td>{{$previoempenho->id_pessoa}}</td>
                        <td align="center">
                            <a href="{{ route('previoempenho.Editar',['id_rpe'=>$previoempenho->id_rpe])}}" class="btn-sm btn-default"> <span class="glyphicon glyphicon-pencil"/></a>
                        </td>
                        <td align="center">
                                <a onclick="remove('{{ route('previoempenho.Deletar',['id_rpe'=>$previoempenho->id_rpe])}}')" class="btn-sm btn-danger">
                                  <span class="glyphicon glyphicon-trash"></span>
                                </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-1" align="right">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('previoempenho.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>
    </div>
    @include('sweet::alert')
@endsection
@section('content_js')
    <script>
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
            }
        });

        </script>

        <script type="text/javascript">

        function remove(rota){

          swal({
            title: 'Você tem certeza que deseja excluir o Prévio Empenho?',
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
