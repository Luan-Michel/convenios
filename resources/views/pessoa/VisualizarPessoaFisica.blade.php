@extends('app')


@section('content')
    <div class="container">
        <h1>Visualizar Pessoa Física</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
            @endif
            <br>

            <div class="col-md-5">
                {!! Form::label('nm_pessoa_completo','Nome Completo')!!}
                <input disabled type="text" id="nm_pessoa_completo" value="{{ $pessoa[0]['nm_pessoa_completo'] }}"
                       name="nm_pessoa_completo" class="form-control"/>
            </div>
            <div class="col-md-5">
                {!! Form::label('nm_pessoa_abreviado','Nome Abreviado')!!}
                <input disabled type="text" id="nm_pessoa_abreviado" value="{{ $pessoa[0]['nm_pessoa_abreviado'] }}"
                       name="nm_pessoa_abreviado" class="form-control"/>
            </div>
            <div class="col-md-2">
                {!! Form::label('cpf','CPF')!!}
                <input disabled type="text" id="cpf" value="{{ $pessoafisica[0]['cpf'] }}" class="form-control"/>
            </div>
            @foreach($email as $email)
                <div class="col-md-12">
                    {!! Form::label('nm_pessoa_completo','Email')!!}
                    <input disabled type="text" id="nm_pessoa_completo" value="{{ $email['ds_email'] }}" name="nm_pessoa_completo"
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
