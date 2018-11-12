@extends('app')

@section('content')
    <div class='container'>
        <h1>Visualizar Convênio</h1>
        <br/>
        <br/>


        <div class="col-md-6">
            {!! Form::label('id_financiador','Financiador')!!}
            <input disabled type="text" id="id_financiador" name="id_financiador"
                   value="{{$financiador[0]['nm_financiador']}}" class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('ano_convenio','Ano do convênio')!!}
            <input disabled type="text" id="ano_convenio" name="ano_convenio" value="{{$convenio[0]['ano_convenio']}}"
                   class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('nr_convenio','Número do Convênio')!!}
            <input disabled type="text" id="nr_convenio" name="nr_convenio" value="{{$convenio[0]['nr_convenio']}}"
                   class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('nr_protocolo','Número do protocolo')!!}
            <input disabled type="text" id="nr_protocolo" name="nr_protocolo" value="{{$convenio[0]['nr_protocolo']}}"
                   class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('ano_processo','Ano do processo')!!}
            <input disabled type="text" id="ano_processo" name="ano_processo" value="{{$convenio[0]['ano_processo']}}"
                   class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('nr_processo','Número do processo')!!}
            <input disabled type="text" id="nr_processo" name="nr_processo" value="{{$convenio[0]['nr_processo']}}"
                   class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('id_categoria','Categoria')!!}
            <input disabled type="text" id="id_categoria" name="id_categoria" value="{{$categoria[0]['ds_categoria']}}"
                   class="form-control"/>
        </div>
        <div class="col-md-6">
            {!! Form::label('ds_objeto','Objeto')!!}
            <input disabled type="text" id="ds_objeto" name="ds_objeto" value="{{$convenio[0]['ds_objeto']}}"
                   class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('ds_sigla_objeto','Sigla do objeto')!!}
            <input disabled type="text" id="ds_sigla_objeto" name="ds_sigla_objeto"
                   value="{{$convenio[0]['ds_sigla_objeto']}}" class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('nr_sit_tce','Sit')!!}
            <input disabled type="text" id="nr_sit_tce" name="nr_sit_tce" value="{{$convenio[0]['nr_sit_tce']}}"
                   class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('vl_convenio','Valor do convênio')!!}
            <input disabled type="text" data-mask="#.##0,00" data-mask-reverse="true" id="vl_convenio"
                   name="vl_convenio" value="{{$convenio[0]['vl_convenio']}}" class="form-control"/>
        </div>
        <div class="col-md-3">
            {!! Form::label('idcontas_plano','CDRED Conta contabil')!!}
            <br><input disabled type="text" id="idcontas_plano" name="idcontas_plano" value="{{$cc[0]['cdred']}}"
                       class="form-control"/><br>
        </div>
        <div class="col-md-3">
            {!! Form::label('idcontas_plano','CDRED Conta banco')!!}
            <br><input disabled type="text" id="idcontas_plano" name="idcontas_plano" value="{{$cb[0]['cdred']}}"
                       class="form-control"/><br>
        </div>
        <div class="col-md-3 margin-bottom-5" id="dp1">
            {!! Form::label('dt_inicio','Data de início')!!}
            <br><input disabled type="text" id="dt_inicio" name="dt_inicio" value="{{$convenio[0]['dt_inicio']}}"
                       class="form-control"/><br>
        </div>
        <div class="col-md-3 margin-bottom-5" id="dp2">
            {!! Form::label('dt_limite_execucao','Data limite de execução')!!}
            <br><input disabled type="text" id="dt_limite_execucao" name="dt_limite_execucao"
                       value="{{$convenio[0]['dt_limite_execucao']}}" class="form-control"/><br>
        </div>
        <div class="col-md-3 margin-bottom-5" id="dp3">
            {!! Form::label('dt_prest_contas','Data prestação de contas')!!}
            <br><input disabled type="text" id="dt_prest_contas" name="dt_prest_contas"
                       value="{{$convenio[0]['dt_prest_contas']}}" class="form-control"/><br>
        </div>
        <div class="col-md-3 margin-bottom-5" id="dp4">
            {!! Form::label('dt_limite_vigencia','Data limite de vigência')!!}
            <br><input disabled type="text" id="dt_limite_vigencia" name="dt_limite_vigencia"
                       value="{{$convenio[0]['dt_limite_vigencia']}}" class="form-control"/><br>
        </div>
        <div class="col-md-12">
            {!! Form::label('ds_resumo_plano','Resumo do Plano de trabalho')!!}
            {!! Form::textarea('ds_resumo_plano', $convenio[0]['ds_resumo_plano'], ['class'=>'form-control', 'disabled'])!!}
        </div>
        <div class="col-md-12 margin-bottom-5">
            @if (!empty($anexo[0]))
                {!! Form::label('id_anexo','Anexos:')!!}
                @foreach($anexo as $anexo)
                    <div class="col-md-12">
                        <div class="col-md-10">
                            <br><input disabled type="text" id="id_anexo" name="id_anexo"
                                       value="{{$anexo['ds_titulo_anexo']}}"
                                       class="form-control"/><br>
                        </div>
                        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label><br>
                        <div class="col-md-2">
                            <a class="btn btn-primary" href="#" onclick="window.open('/pdfs/{{$anexo['ds_titulo_anexo']}}', '_blank', 'fullscreen=yes'); return false;"> Ver
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <br> <br><br> <br>
        <a href="<?php echo url('convenio'); ?>">
            {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
        </a>

    </div>

@endsection
