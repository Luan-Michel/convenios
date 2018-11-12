@extends('app')

@section('content')
    <div class='container'>
        <h1>Prévio Empenho</h1>
        <div class="col-md-1" align="right">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('previoempenho.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>
        <div class="col-md-6" align="right">

        </div>
        <br><br><br>
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
                            <a href="{{ route('previoempenho.Editar',['nr'=>$previoempenho->nr_rpe])}}"
                               class="btn-sm btn-default glyphicon glyphicon-pencil"></a>
                        </td>
                        <td align="center">
                            {!! Form::open(['method'=>'get', 'route'=>['pessoaconvenio.ajaxDelete', $previoempenho->nr_rpe]]) !!}
                            <div class="btn-group">

                                <button type="button" class="delete btn-sm btn-danger glyphicon glyphicon-trash"
                                        data-toggle="modal"
                                        data-previo_token="{{ csrf_token() }}"
                                        data-previo_nr_rpe="{{$previoempenho->nr_rpe}}"
                                        data-previo_route="{{route('previoempenho.ajaxDelete', $previoempenho->nr_rpe)}}">
                                </button>
                                {!! Form::close() !!}

                            </div>
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
            }
        });
    </script>

    <script>
        $('button.delete').click(function()        {
            var rota = $(this).attr("data-previo_route");
            var nr_rpe = $(this).attr("data-previo_nr_rpe");
            var Token = $(this).attr("data-previo_token");

            swal({
                title:"Tem certeza?",
                text: "Você não será capaz de recuperar esse cadastro.",
                imageUrl: "{{asset('images/question.jpg')}}",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#DD6B55",
                confirmButtonColor: "#5cb85c",
                confirmButtonText: "Confirmar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (!isConfirm) return;
                $.ajax({
                    type: "post",
                    url: rota,
                    data: {'X-CSRF-TOKEN': Token, nr_rpe:nr_rpe}
                }).done(function (data) {
                    console.log(data);
                    swal("Previo empenho número ", nr_rpe + " deletado com sucesso.", "success");
                    location.reload();
                }).error(function (data) {
                    console.log(data);
                    swal("Oops", "O previo empenho "+ nr_rpe +" não pode ser deletado", "error");
                });

            });
        });
    </script>
@endsection
