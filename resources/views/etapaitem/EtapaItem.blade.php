@extends('app')

@section('content')
    <div class="container">
      <div class="col-md-12" id="cabecalho">
        <div class="col-md-6">
          <h1>Itens da Etapa</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#item_etapa" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
      </div>
        {{-- <a class="btn btn-default" href="{{ route('etapaplanodetrabalho')}}" class="btn btn-primary">Visualizar Previo Empenho</a> --}}

        <div class="col-md-1" align="right">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('etapaitem.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>

        <br><br><br>
        <table class="table table-striped table-hover table-bordered" id="table">
          <thead>
              <tr>
                  <th>Item</th>
                  <th>Valor Total</th>
                  <th>Alterar</th>
                  <th>Excluir</th>
              </tr>
          </thead>
          <tbody>
              @foreach($etapaitem as $etapaitem)
              <tr>
                  <td>{{$etapaitem->ds_item}}</td>
                  <td>{{$etapaitem->vl_total_item}}</td>
                  <td align="center">
                    <a href="{{ route('etapaitem.Editar',['id'=>$etapaitem->id_etapa_item_aplic])}}" class="btn-sm btn-default">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>

                    </a>
                      </td>
                  <td align="center">
                    <a href="{{ route('etapaitem.Deletar',['id'=>$etapaitem->id_etapa_item_aplic])}}" class="btn-sm btn-danger">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>

                    </a>
                      {{--<a href="/etapaitem/{{$etapaitem->id_etapa_item_aplic}}/visualizar" class="btn-sm btn-primary">Visualizar</a>--}}
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>

        <br><br>
        <div class="col-md-1" align="right">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('etapaitem.Cadastrar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
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
@endsection
