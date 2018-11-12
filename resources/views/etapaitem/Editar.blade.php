@extends('app')


@section('content')
<div class='container'>
    <h1>Etapa Item</h1>

    @if($errors->any())
    <ul class="alert alert-warning">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach

    </ul>
    @endif
    {!! Form::open(['route'=>['etapaitem.atualizabanco', $etapaitem[0]['id_etapa_item_aplic']], 'method'=>'put'])!!}

    <div class="col-md-4">
        {!! Form::label('id_etapa_aplic','Etapa Plano de Trabalho')!!}
        <select required name="id_etapa_aplic" class="form-control margin-bottom-10" id="id_etapa_aplic">
            <option value="{{$etapaplanodetrabalho[0]['id_etapa_aplic']}}">{{$etapaplanodetrabalho[0]['ds_titulo_etapa']}}</option>
            @foreach($ept as $ept)
                <option value="{{$ept->id_etapa_aplic}}">{{$ept->ds_titulo_etapa}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-8">
        {!! Form::label('cd_tabela','Despesa')!!}
        <select required name="cd_tabela" class="form-control margin-bottom-10" id="cd_tabela">
            <option value="{{$despesa[0]['CD_TABELA']}}|{{$despesa[0]['CD_DESP']}}">{{$despesa[0]['NM_DESP']}}</option>
            @foreach($d as $d)
                <option value="{{$d->CD_TABELA}}|{{$d->CD_DESP}}">{{$d->NM_DESP}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        {!! Form::label('id_pais','País')!!}
        <select required name="id_pais" class="form-control margin-bottom-10" id="id_pais">
            <option value="{{$pais[0]['id_pais']}}">{{$pais[0]['nm_pais']}} ({{$pais[0]['sigla_pais']}})</option>
            @foreach($p as $p)
                <option value="{{$p->id_pais}}">{{$p->nm_pais}} ({{$p->sigla_pais}})</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        {!! Form::label('id_moeda','Moeda')!!}
        <select required name="id_moeda" class="form-control margin-bottom-10" id="id_moeda">
            <option value="{{$moeda[0]['id_moeda']}}">{{$moeda[0]['ds_moeda']}} ({{$moeda[0]['sigla_moeda']}})</option>
            @foreach($m as $m)
                <option value="{{$m->id_moeda}}">{{$m->ds_moeda}} ({{$m->sigla_moeda}})</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 margin-bottom-5" id="dp2">
        {!! Form::label('dt_aplicacao','Data Aplicação')!!}
        <br><input id="dt_aplicacao" required class="date" name="dt_aplicacao" value="{{$etapaitem[0]['dt_aplicacao']}}" type="text"/><br>
    </div>
    <div class="col-md-3">
        {!! Form::label('vl_item','Valor unitário Item')!!}
        <input required id="vl_item" data-mask="#.##0,00" data-mask-reverse="true" name="vl_item" type="text" value="{{$etapaitem[0]['vl_item']}}" class="form-control margin-bottom-10">
    </div>
    <div class="col-md-3">
        {!! Form::label('qt_item','Quantidade Item')!!}
        <input required id="qt_item" name="qt_item" type="text" value="{{$etapaitem[0]['qt_item']}}" class="form-control margin-bottom-10">
    </div>
    <div class="col-md-3">
        {!! Form::label('vl_total_item','Valor Total Item')!!}
        <input required id="vl_total_item" data-mask="#.##0,00" data-mask-reverse="true" name="vl_total_item" value="{{$etapaitem[0]['vl_total_item']}}" type="text" class="form-control margin-bottom-10">
    </div>
    <div class="col-md-12">
        {!! Form::label('ds_item','Descrição Item')!!}
        {!! Form::textarea('ds_item', $etapaitem[0]['ds_item'], ['class'=>'form-control'])!!}
    </div>

    <div class="col-md-3">
        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
        <div class="form-group">
            {!! Form::submit('Salvar Etapa Item', ['class'=>'btn btn-primary'])!!}
        </div>
    </div>
{!! Form::close()!!}
<!--Bot�o voltar-->
    <div class="col-md-1">
        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
        <a href="<?php echo url('etapaitem'); ?>">
            {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
        </a>
    </div>

<br><br><br><br><br><br>
</div>
@endsection

@section('content_js')
    <script type="text/javascript">

        //datepicker
        $('#dp1 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});
        $('#dp2 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});

        $('#id_etapa_aplic').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
        $('#id_pais').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
        $('#id_moeda').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
    </script>
@endsection