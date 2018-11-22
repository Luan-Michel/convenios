@extends('app')
@section('content')
    @if(Session::has('message'))

        <div align="center" class="alert alert-danger">
            <strong>{{Session::get('message')}}</strong>
        </div>
    @endif

    <div class='container'>
        <div class="col-md-6">
          <h1>Financiador</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#financiador" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
        <div class="col-md-6">
          <br>
        </div>
        <div style="padding-bottom: 50px">
          <div class="col-md-1" align="left">
            <a href="<?php echo url('principal'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
          </div>
          <div class="col-md-offset-10 col-md-1" align="left">
              <a href="{{ route('financiador.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
          </div>
        </div>

        <div>
          <br><br><br><br>
        </div>

        <table class="table table-striped table-hover table-bordered" id="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Sigla</th>
                <th>Esfera</th>
                <th>Alterar</th>
                <th>Excluir</th>
            </thead>
            <tbody>

            @foreach($financiador as $financiador)

                <tr>
                    <td>{{$financiador->nm_financiador}}</td>
                    <td align="center">{{$financiador->ds_sigla_financiador}}</td>
                    @if ($financiador->tp_esfera == 'F' || $financiador->tp_esfera == 'f' )
                        <td align="center">Federal</td>
                    @elseif ($financiador->tp_esfera == 'E' || $financiador->tp_esfera == 'e')
                        <td align="center">Estadual</td>
                    @else
                        <td align="center">Internacional</td>
                    @endif
                    <td align="center">
                        <a href="{{ route('financiador.Editar',['id'=>$financiador->id_financiador])}}" class="btn-sm btn-default">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a></td>
                    <td align="center">
                        <a onclick="remove('{{ route('financiador.Deletar',['id'=>$financiador->id_financiador])}}')"  class="btn-sm btn-danger">
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
            <a href="{{ route('financiador.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
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
            title: 'Você tem certeza que deseja excluir o financiador?',
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
