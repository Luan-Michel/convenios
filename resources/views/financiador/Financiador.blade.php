@extends('app')
@section('content')
    @if(Session::has('message'))

        <div align="center" class="alert alert-danger">
            <strong>{{Session::get('message')}}</strong>
        </div>
    @endif

    <div class='container'>
        <h1>Financiador</h1>
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
                        <a href="{{ route('financiador.Deletar',['id'=>$financiador->id_financiador])}}"  class="btn-sm btn-danger">
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
