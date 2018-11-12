@extends('app')


@section('content')
    <div class="container">
        <h1>Visualizar Pessoa Jurídica</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
            @endif
            <br>

            <div class="col-md-5">
                {!! Form::label('nm_pessoa_completo','Nome Fantasia')!!}
                <input disabled type="text" id="nm_fantasia" value="{{ $pessoa[0]['nm_pessoa_completo'] }}"
                       name="nm_fantasia" class="form-control"/>
            </div>
            <div class="col-md-2">
                {!! Form::label('cnpj','CNPJ')!!}
                <input disabled type="text" id="cnpj" value="{{ $pessoajuridica[0]['cnpj'] }}" class="form-control"/>
            </div>
            <div class="col-md-2">
                {!! Form::label('inscricao_estadual','Inscrição estadual')!!}
                <input disabled type="text" id="inscricao_estadual"
                       value="{{ $pessoajuridica[0]['inscricao_estadual'] }}" class="form-control"/>
            </div>
            <div class="col-md-2">
                {!! Form::label('cd_siaf','cd Siaf')!!}
                <input disabled type="text" id="cd_siaf" value="{{ $pessoajuridica[0]['cd_siaf'] }}"
                       class="form-control"/>
            </div>
            @foreach($email as $email)
                <div class="col-md-12">
                    {!! Form::label('nm_pessoa_completo','Email')!!}
                    <input disabled type="text" id="nm_pessoa_completo" value="{{ $email['ds_email'] }}"
                           name="nm_pessoa_completo"
                           class="form-control"/>
                </div>
            @endforeach

            <!--Bot�o voltar-->
            <div class="col-md-2">
                <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                <br>
                <a href="<?php echo url('/pessoa'); ?>">
                    {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
                </a>
            </div>
    </div>
@endsection
