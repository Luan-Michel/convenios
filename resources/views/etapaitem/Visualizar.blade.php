@extends('app')


@section('content')
    <div class='container'>
        <h1>Visualizar Etapa Item</h1>

        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>
        @endif

        <div class="col-md-4">
            {!! Form::label('id_etapa_aplic','Etapa Plano de Trabalho')!!}
            <input disabled class="form-control margin-bottom-10"
                   value="{{$etapaplanodetrabalho[0]['ds_titulo_etapa']}}">
        </div>
        <div class="col-md-8">
            {!! Form::label('cd_tabela','Despesa')!!}
            <input disabled class="form-control margin-bottom-10"
                   value="{{$despesas[0]['NM_DESP']}}">
        </div>
        <div class="col-md-6">
            {!! Form::label('id_pais','País')!!}
            <input disabled class="form-control margin-bottom-10" value="{{$pais[0]['nm_pais']}}({{$pais[0]['sigla_pais']}})">
        </div>
        <div class="col-md-6">
            {!! Form::label('id_moeda','Moeda')!!}
            <input disabled class="form-control margin-bottom-10" value="{{$moeda[0]['ds_moeda']}}({{$moeda[0]['sigla_moeda']}})">
        </div>
        <div class="col-md-3 margin-bottom-5" id="dp2">
            {!! Form::label('dt_aplicacao','Data Aplicação')!!}
            <br><input id="dt_aplicacao" disabled class="date" name="dt_aplicacao" value="{{$etapaitem[0]['dt_aplicacao']}}" type="text"/><br>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_item','Valor unitário Item')!!}
            <input disabled id="vl_item" name="vl_item" type="text" value="{{$etapaitem[0]['vl_item']}}" class="form-control margin-bottom-10">
        </div>
        <div class="col-md-3">
            {!! Form::label('qt_item','Quantidade Item')!!}
            <input disabled id="qt_item" name="qt_item" type="text" value="{{$etapaitem[0]['qt_item']}}" class="form-control margin-bottom-10">
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_total_item','Valor Total Item')!!}
            <input disabled id="vl_total_item" name="vl_total_item" value="{{$etapaitem[0]['vl_total_item']}}" type="text" class="form-control margin-bottom-10">
        </div>
        <div class="col-md-12">
            {!! Form::label('ds_item','Descrição Item')!!}
            {!! Form::textarea('ds_item', $etapaitem[0]['ds_item'], ['class'=>'form-control', 'disabled'])!!}
        </div>
        <br>
        <a href="<?php echo url('etapaitem'); ?>">
            {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
        </a>
        <br><br><br><br><br><br>
    </div>
@endsection
