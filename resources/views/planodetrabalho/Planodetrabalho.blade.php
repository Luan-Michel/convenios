@extends('app')
@section('content')
    @if(Session::get('message'))

        <div align="center" class="alert alert-success">
            <strong>{{Session::get('message')}}</strong>
        </div>
    @endif
    <div class="container">
        <div class="col-md-6">
          <h1>Plano de trabalho</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#plano_de_trabalho" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
        <div class="col-md-12">
          <h3>@if(isset($conv)) Convênio: {{$conv->ds_sigla_objeto}} @else Geral @endif</h3>
        </div>
        <?php
        if(isset($conv)){
          $ano = $conv->ano_convenio;
          $nr = $conv->nr_convenio;
          $f = $conv->id_financiador;
        }
        ?>
        <br>
        <div class="col-md-1">
            <a class="btn btn-warning " href="<?php echo url('principal'); ?>">Voltar</a>
        </div>
        @if(isset($conv))
        <div class="col-md-offset-10 col-md-1">
          <a class="btn btn-success" href="{{ route('planodetrabalho.Cadastrar', [$ano,$nr,$f])}}" ><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>
        @endif
        <br><br><br>
        <div class="container">
            <br><br>
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead>
                <tr>
                    <th style="width: 80px">Sequência</th>
                    <th>Título</th>
                    <th style="width: 80px">Alterar</th>
                    <th style="width: 80px">Excluir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($planodetrabalho as $planodetrabalho)
                    <tr>
                        <td>{{$planodetrabalho->seq_meta_aplic}}</td>
                        <td>{{$planodetrabalho->ds_titulo_meta_aplic}}</td>
                        <td align="center">
                            <a href="{{ route('planodetrabalho.Editar',['id'=>$planodetrabalho->id_aplicacao])}}" class="btn-sm btn-default ">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a></td>
                        <td align="center">
                            <a href="{{ route('planodetrabalho.Deletar',['id'=>$planodetrabalho->id_aplicacao])}}" class="btn-sm btn-danger ">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>

                            </a>
                        {{--<a href="planodetrabalho/{{$planodetrabalho->id_aplicacao}}/visualizar" class="btn-sm btn-primary">Visualizar</a>--}}
                        <!-- <a href="{{ route('planodetrabalho.Visualizar',['id'=>$planodetrabalho->id_aplicacao])}}" class="btn-sm btn-primary">Visualizar</a> -->
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--Adicionar ao clicar ou ao passar o mouse por cima as opções de pessoa física e pessoa jurídica.--}}
        </div>
        <br>
        <br>
        <div class="col-md-1">
            <a class="btn btn-warning " href="<?php echo url('principal'); ?>">Voltar</a>
        </div>
        @if(isset($conv))
          <div class="col-md-offset-10 col-md-1">
            <a class="btn btn-success" href="{{ route('planodetrabalho.Cadastrar', [$ano,$nr,$f])}}" ><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
          </div>
        @endif
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
                "sEmptyTable":"Nenhum plano de trabalho foi cadastrado para esse convênio."
            }});
    </script>
@endsection
