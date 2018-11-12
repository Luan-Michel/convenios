@extends('app')

@section('content')
<div class='container'>
  <h1>Participante</h1>
    
    @if($errors->any())
    <ul class="alert alert-warning">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        
    </ul>    
    @endif
    <br><br><br><br><br><br><br>
    <div class="col-md-12" name="div_pessoa" id="div_pessoa">
        {!! Form::label('id_pessoa_participante','Nome')!!}
        <input disabled value="{{$pessoa[0]['nm_pessoa_completo']}}" type="text" class="form-control"/>
    </div>
    <div class="col-md-6">
        {!! Form::label('id_pessoa_instituicao','Instituição')!!}
        <input disabled value="{{$instituicao[0]['nm_fantasia']}}" type="text" class="form-control"/>
    </div>

    <div class="col-md-6">
        {!! Form::label('cd_coordenador','Coordenador')!!}
        @if ($p[0]['cd_coordenador'] == "S")
            <input disabled value="SIM" type="text" class="form-control"/>
        @endif
        @if ($p[0]['cd_coordenador'] == "N")
            <input disabled value="NÃO" type="text" class="form-control"/>
        @endif
    </div>

    <div class="col-md-6">
        {!! Form::label('id_financiador', 'Financiador')!!}
        <input disabled value="{{$financiador[0]['nm_financiador']}}" type="text" class="form-control"/>
    </div>
    <!--Convênio-->
    <div class="col-md-6">
        {!! Form::label('nr_convenio', 'Convênio')!!}
        <input disabled value="{{ $convenio[0]['nr_convenio']}} - {{ $convenio[0]['ds_objeto'] }}" type="text" class="form-control"/>
    </div>
    <div class="col-md-2">
        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
        <br>
        <a href="<?php echo url('convenio/pessoa'); ?>">
            {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
        </a>
    </div>
</div>
    
@endsection
