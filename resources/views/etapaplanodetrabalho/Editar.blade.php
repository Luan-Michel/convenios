@extends('app')

@section('content')
<div class='container'>
    <div class="col-md-12" id="cabecalho">
      <div class="col-md-6">
        <h1>Editar Etapa Plano de Trabalho</h1>
      </div>
      <div style="padding-top: 20px" class="col-md-6">
         <a href="{{route('ajuda')}}#etapa_plano_de_trabalho" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
      </div>
    </div>

    @if($errors->any())
    <ul class="alert alert-warning">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach

    </ul>
    @endif
    {!! Form::open(['route'=>['etapaplanodetrabalho.atualizabanco', $etapaplanodetrabalho[0]['id_etapa_aplic']], 'method'=>'put'])!!}
    <div class="col-md-4">
        {!! Form::label('id_aplicacao','Plano de Trabalho')!!}
        <select required name="id_aplicacao" class="form-control margin-bottom-10" id="id_aplicacao">
            <option value="{{$planodetrabalho[0]['id_aplicacao']}}">{{$planodetrabalho[0]['ds_titulo_meta_aplic']}}</option>
            @foreach($pt as $pt)
                <option value="{{$pt->id_aplicacao}}">{{$pt->ds_titulo_meta_aplic}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-8">
        {!! Form::label('cd_tabela','Despesas')!!}
        <select  required name="cd_tabela" class="form-control margin-bottom-10" id="cd_tabela">
            <option value="{{$despesas[0]['CD_DESP']}}|{{$despesas[0]['CD_TABELA']}}">{{$despesas[0]['CD_DESP']}} - {{$despesas[0]['NM_DESP']}}</option>
            @foreach($d as $d)
                <option value="{{$d->CD_DESP}}|{{$d->CD_TABELA}}">{{$d->CD_DESP}} - {{$d->NM_DESP}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        {!! Form::label('idcontas_plano','CDRED')!!}
        <select required name="idcontas_plano" class="form-control margin-bottom-10" id="idcontas_plano">
            <option value="{{$contabil[0]['idcontas_plano']}}">{{$contabil[0]['cdred']}}</option>
            @foreach($c as $c)
                <option value="{{$c->idcontas_plano}}">{{$c->cdred}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-10">
        {!! Form::label('ds_titulo_etapa','Titulo da Etapa')!!}
        <input id="ds_titulo_etapa" name="ds_titulo_etapa" class="form-control margin-bottom-10" value="{{$etapaplanodetrabalho[0]['ds_titulo_etapa']}}"
               >
    </div>
    <div class="col-md-12">
        {!! Form::label('ds_etapa_aplic','Etapa')!!}
        <input id="ds_etapa_aplic" name="ds_etapa_aplic" type="textarea" class="form-control margin-bottom-10"
               value="{{$etapaplanodetrabalho[0]['ds_etapa_aplic']}}" >
    </div>
    <div class="col-md-3" id="dp1">
        {!! Form::label('dt_inicio_etapa','Data de Início')!!}
        <br><input id="dt_inicio_etapa" required class="date" name="dt_inicio_etapa" type="text"
                   onchange="restringefim()" value="{{$etapaplanodetrabalho[0]['dt_inicio_etapa']}}"
                   >
        <br>
    </div>
    <div class="col-md-3" id="dp2">
        {!! Form::label('dt_termino_etapa','Data de Término')!!}
        <br><input id="dt_termino_etapa" required class="date" name="dt_termino_etapa" type="text" value="{{$etapaplanodetrabalho[0]['dt_termino_etapa']}}"
                   ><br>
    </div>
    <div class="col-md-3">
        {!! Form::label('ds_unidade_medida','Unidade Medida')!!}
        <input id="ds_unidade_medida" name="ds_unidade_medida" class="form-control margin-bottom-10" value="{{$etapaplanodetrabalho[0]['ds_unidade_medida']}}"
               >
    </div>
    <div class="col-md-3">
        {!! Form::label('qt_unidade_etapa','Quantidade Unidade')!!}
        <input class="form-control margin-bottom-10" value="{{$etapaplanodetrabalho[0]['qt_unidade_etapa']}}"
               >
    </div>
    <br>
    <div class="col-md-3">
        {!! Form::label('vl_total_etapa','Valor Total')!!}
        <input required class="form-control margin-bottom-10" data-mask="#.##0,00" data-mask-reverse="true" id="vl_total_etapa" name="vl_total_etapa" value="{{$etapaplanodetrabalho[0]['vl_total_etapa']}}"
               >
    </div>
    <div class="col-md-3">
        {!! Form::label('vl_reservado','Valor Reservado')!!}
        <input required class="form-control margin-bottom-10" data-mask="#.##0,00" data-mask-reverse="true" id="vl_reservado" name="vl_reservado" value="{{$etapaplanodetrabalho[0]['vl_reservado']}}"
               >
    </div>
    <div class="col-md-3">
        {!! Form::label('vl_empenhado','Valor Empenhorado')!!}
        <input required class="form-control margin-bottom-10" data-mask="#.##0,00" data-mask-reverse="true" id="vl_empenhado" name="vl_empenhado" value="{{$etapaplanodetrabalho[0]['vl_empenhado']}}"
               >
    </div>
    <div class="col-md-3">
        {!! Form::label('vl_saldo','Valor Saldo')!!}
        <input required class="form-control margin-bottom-10" data-mask="#.##0,00" data-mask-reverse="true" id="vl_saldo" name="vl_saldo" value="{{$etapaplanodetrabalho[0]['vl_saldo']}}" >


    </div>
    <div class="col-md-12" >
        <br><br>
        <a href="{{ route('etapaparticipantes.Cadastrar')}}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo Participante</a>
        &nbsp         &nbsp         &nbsp


        <a href="{{ route('etapaitem.Cadastrar')}}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo Item</a>

    </div>
    <br>

    <div class="col-md-4">
        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
        </div>
    </div>
{!! Form::close()!!}
    <!--Bot�o voltar-->
    <div class="col-md-8">
        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label><br>
        <a href="<?php echo url('etapaplanodetrabalho'); ?>">
            {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
        </a>
    </div>

<br><br><br><br><br><br>
</div>
@endsection

@section('content_js')
    <script type="text/javascript">

        $('#idcontas_plano').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });

        $('#id_aplicacao').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });

        //datepicker
        $('#dp1 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});
        $('#dp2 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});

        function restringefim() {
            var valorselecionado = $("#dt_inicio_etapa").val();
            $('#dp2 .date').datepicker('setStartDate', valorselecionado);
            $('#dp2 .date').datepicker('update', valorselecionado);
        }
    </script>
@endsection
