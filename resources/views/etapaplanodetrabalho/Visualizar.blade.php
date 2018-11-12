@extends('app')
@section('content')
    <div class='container'>
        <h1>Visualizar Etapa Plano de Trabalho</h1>

        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>
        @endif
        <div class="col-md-4">
            {!! Form::label('id_aplicacao','Plano de Trabalho')!!}
            <input name="id_aplicacao" class="form-control margin-bottom-10" id="id_aplicacao"
                   value="{{$planodetrabalho[0]['ds_titulo_meta_aplic']}}" disabled>
        </div>

        <div class="col-md-8">
            {!! Form::label('cd_tabela','Despesas')!!}
            <input name="cd_tabela" class="form-control margin-bottom-10"
                   value="{{$despesas[0]['CD_DESP']}} - {{$despesas[0]['NM_DESP']}}" id="cd_tabela" disabled>
        </div>
        <div class="col-md-2">
            {!! Form::label('idcontas_plano','CDRED')!!}
            <input required name="idcontas_plano" class="form-control margin-bottom-10"
                   value="{{$contabil[0]['cdred']}}" id="idcontas_plano" disabled>
        </div>
        <div class="col-md-10">
            {!! Form::label('ds_titulo_etapa','Titulo da Etapa')!!}
            <input class="form-control margin-bottom-10" value="{{$etapaplanodetrabalho[0]['ds_titulo_etapa']}}"
                   disabled>
        </div>
        <div class="col-md-12">
            {!! Form::label('ds_etapa_aplic','Etapa')!!}
            <input type="textarea" class="form-control margin-bottom-10"
                   value="{{$etapaplanodetrabalho[0]['ds_etapa_aplic']}}" disabled>
        </div>
        <div class="col-md-3">
            {!! Form::label('dt_inicio_etapa','Data de Início')!!}
            <br><input class="date" value="{{$etapaplanodetrabalho[0]['dt_inicio_etapa']}}"
                       disabled>
            <br>
        </div>
        <div class="col-md-3">
            {!! Form::label('dt_termino_etapa','Data de Término')!!}
            <br><input class="date" value="{{$etapaplanodetrabalho[0]['dt_termino_etapa']}}"
                       disabled><br>
        </div>
        <div class="col-md-3">
            {!! Form::label('ds_unidade_medida','Unidade Medida')!!}
            <input class="form-control margin-bottom-10" value="{{$etapaplanodetrabalho[0]['ds_unidade_medida']}}"
                   disabled>
        </div>
        <div class="col-md-3">
            {!! Form::label('qt_unidade_etapa','Quantidade Unidade')!!}
            <input class="form-control margin-bottom-10" value="{{$etapaplanodetrabalho[0]['qt_unidade_etapa']}}"
                   disabled>
        </div>

        <div class="col-md-3">
            {!! Form::label('vl_total_etapa','Valor Total')!!}
            <input class="form-control margin-bottom-10" value="R$ {{$etapaplanodetrabalho[0]['vl_total_etapa']}}"
                   disabled>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_reservado','Valor Reservado')!!}
            <input class="form-control margin-bottom-10" value="R$ {{$etapaplanodetrabalho[0]['vl_reservado']}}"
                   disabled>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_empenhado','Valor Empenhorado')!!}
            <input class="form-control margin-bottom-10" value="R$ {{$etapaplanodetrabalho[0]['vl_empenhado']}}"
                   disabled>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_saldo','Valor Saldo')!!}
            <input class="form-control margin-bottom-10" value="R$ {{$etapaplanodetrabalho[0]['vl_saldo']}}" disabled>
        </div>

        <br>
        <!--Bot�o voltar-->
        <div class="col-md-12">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <a href="<?php echo url('etapaplanodetrabalho'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
            </a>
        </div>
    </div>
@endsection
