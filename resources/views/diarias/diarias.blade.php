@extends('app')

@section('content')
    @if(Session::has('message_delete'))
        <div align="center" class="alert alert-danger">
            <strong>{{Session::get('message_delete')}}</strong>
        </div>
    @endif
    <div class='container'>
      <div class="col-md-12" id="cabecalho">
        <div class="col-md-6">
          <h1>Diárias</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#diaria" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
      </div>
      <br>
          <div class="col-md-1" align="right">
            <a href="<?php echo url('principal'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
          </div>
          <div class="col-md-offset-10 col-md-1" align="left">
              <a href="{{ route('diarias.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
          </div>


        <br><br><br>
        <br><br><br>
        <div class="col-md-12">
            <table class="table tale-striped table-bordered table-hover" id="table">
                <thead>
                <tr>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Data de Saída</th>
                    <th>Alterar</th>
                    <th>Excluir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($diarias as $d)
                    <tr>
                        <td>{{$d->origem}}</td>
                        <td>{{$d->destino}}</td>
                        <td>{{$d->dt_saida}}</td>
                        <td align="center">
                            <a type="button"  href="{{ route('diarias.Editar',[$d->id_rpe])}}" class="btn-sm btn-default">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                        </td>
                        <td align="center">
                            <a onclick="remove('{{ route('diarias.Deletar',[$d->id_rpe])}}')" class="btn-sm btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                            {{-- <a href="/convenio/{{$convenio->nr_convenio}}/visualizar" class="btn-sm btn-primary">Visualizar</a> --}}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        <div class="col-md-1" align="left">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('diarias.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>

    </div>

    @include('sweet::alert')

@endsection

@section('content_js')
    <script type="text/javascript">
        $("table").dataTable({
            "language": {
                "url": "/Portuguese.json",
                "search": "Pesquisar",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "info": '',
                "paginate": {
                    "previous": "Anterior",
                    "next": "Próximo"
                },
                "sEmptyTable":"Nenhum registro encontrado."
            }
        });

        function remove(rota){

          swal({
            title: 'Você tem certeza que deseja excluir a diária?',
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
