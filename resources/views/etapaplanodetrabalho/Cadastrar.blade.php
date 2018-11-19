@extends('app')

@section('content')

    <div class="container">
        <h1>Etapa do Plano de trabalho</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
        @endif

        {!! Form::open(['route'=>'etapaplanodetrabalho.store'])!!}

        <div class="col-md-4">
            {!! Form::label('id_aplicacao','Plano de Trabalho')!!}
            <select required name="id_aplicacao" class="form-control margin-bottom-10" id="id_aplicacao">
                <option value=""></option>
                @foreach($planodetrabalho as $planodetrabalho)
                    <option value="{{$planodetrabalho->id_aplicacao}}">{{$planodetrabalho->ds_titulo_meta_aplic}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-8">
            {!! Form::label('cd_tabela','Despesas')!!}
            <select  required name="cd_tabela" class="form-control margin-bottom-10" id="cd_tabela">
                <option value=""></option>
                @foreach($despesas as $despesas)
                    <option value="{{$despesas->CD_DESP}}|{{$despesas->CD_TABELA}}">{{$despesas->CD_DESP}} - {{$despesas->NM_DESP}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            {!! Form::label('idcontas_plano','CDRED')!!}
            <select required name="idcontas_plano" class="form-control margin-bottom-10" id="idcontas_plano">
                <option value=""></option>
                @foreach($contabil as $contabil)
                    <option value="{{$contabil->idcontas_plano}}">{{$contabil->cdred}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-10">
            {!! Form::label('ds_titulo_etapa','Titulo da Etapa')!!}
            {!! Form::text('ds_titulo_etapa', null, ['class'=>'form-control'])!!}
        </div>
        <div class="col-md-12">
            {!! Form::label('ds_etapa_aplic','Etapa')!!}
            {!! Form::textarea('ds_etapa_aplic', null, ['class'=>'form-control'])!!}
        </div>
        <div class="col-md-3" id="dp1">
            {!! Form::label('dt_inicio_etapa','Data de Início')!!}
            <br><input id="dt_inicio_etapa" required class="date" name="dt_inicio_etapa" type="text"
                       onchange="restringefim()"/><br>
        </div>
        <div class="col-md-3" id="dp2">
            {!! Form::label('dt_termino_etapa','Data de Término')!!}
            <br><input id="dt_termino_etapa" required class="date" name="dt_termino_etapa" type="text"/><br>
        </div>
        <div class="col-md-3">
            {!! Form::label('ds_unidade_medida','Unidade Medida')!!}
            {!! Form::text('ds_unidade_medida', null, ['class'=>'form-control'])!!}
        </div>
        <div class="col-md-3">
            {!! Form::label('qt_unidade_etapa','Quantidade Unidade')!!}
            {!! Form::number('qt_unidade_etapa', null, ['class'=>'form-control'])!!}
        </div>

        <div class="col-md-3">
            {!! Form::label('vl_total_etapa','Valor Total')!!}
            <input required type="text" data-mask="#.##0,00" data-mask-reverse="true" value="" id="vl_total_etapa"
                   name="vl_total_etapa" class="form-control"/>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_reservado','Valor Reservado')!!}
            <input required type="text" data-mask="#.##0,00" data-mask-reverse="true" value="" id="vl_reservado"
                   name="vl_reservado" class="form-control"/>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_empenhado','Valor Empenhorado')!!}
            <input required type="text" data-mask="#.##0,00" data-mask-reverse="true" value="" id="vl_empenhado"
                   name="vl_empenhado" class="form-control"/>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_saldo','Valor Saldo')!!}
            <input required type="text" data-mask="#.##0,00" data-mask-reverse="true" value="" id="vl_saldo"
                   name="vl_saldo" class="form-control"/>
        </div>

        <br>
        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <div class="form-group">
                {{--redirecionamento para etapa participantes feito direto no controller--}}
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </div>
        </div>
        {!! Form::close()!!}
                <!--Bot�o voltar-->
        <div class="col-md-1">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <a href="<?php echo url('etapaplanodetrabalho'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>
        <br><br><br><br><br><br><br><br><br><br>
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
