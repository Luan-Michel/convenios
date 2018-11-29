@extends('app')

@section('content')
    <div class='container'>
        <div class="col-md-6">
          <h1>Etapa Plano de trabalho</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#etapa_plano_de_trabalho" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
        <div style="padding-bottom: 20px" class="col-md-12">
          <div class="col-md-1" align="left">
            <a href="<?php echo url('principal'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
          </div>
          <div class="col-md-offset-10 col-md-1" align="left">
              <a href="{{ route('etapaplanodetrabalho.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
          </div>
        </div>
        <br><br><br>
        <table class="table table-striped table-hover table-bordered" id="table">
            <thead>
            <tr>
                <th>Título</th>
                <th>Plano de Trabalho</th>
                <th>Data termino</th>
                <th>Alterar</th>
                <th>Excluir</th>
            </thead>
            <tbody>
            @foreach($etapaplanodetrabalho as $etapaplanodetrabalho)
                <tr>
                    <td>{{$etapaplanodetrabalho->ds_titulo_etapa}}</td>
                    <td>{{$etapaplanodetrabalho->ds_titulo_meta_aplic}}</td>
                    <td>{{$etapaplanodetrabalho->dt_termino_etapa}}</td>
                    <td align="center" >
                        <a href="{{ route('etapaplanodetrabalho.Editar',['id'=>$etapaplanodetrabalho->id_etapa_aplic])}}"
                           class="btn-sm btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a></td>
                    <td align="center">
                        <a onclick="remove('{{ route('etapaplanodetrabalho.Deletar',['id'=>$etapaplanodetrabalho->id_etapa_aplic])}}')"
                           class="btn-sm btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br><br>
        <div class="col-md-1" align="left">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('etapaplanodetrabalho.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>

    </div>

    @include('sweet::alert')

@endsection

@section('content_js')
    <script type="text/javascript">
    function remove(rota){
      swal({
        title: 'Você tem certeza que deseja excluir a etapa?',
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
    </script>
@endsection
