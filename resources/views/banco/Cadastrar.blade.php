@extends('app')
@section('content')
    @if(Session::has('message'))
        <div class="alert alert-danger">
            <strong>{{ Session::get('message') }}</strong>
        </div>
    @endif
    <div class="container">
        <h1>Banco</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        @endif
        <br>
        {!! Form::open(['route'=>'banco.store', 'files' =>true])!!}

        <div class="col-md-2">
            {!! Form::label('nr_banco','Número do Banco')!!}
            <input required type="text" max="3"  id="nr_banco" placeholder="" name="nr_banco" class="form-control"/>
        </div>
        <div class="col-md-6">
            {!! Form::label('nm_banco', 'Nome do Banco') !!}
            <input required type="text" max="50" id="nm_banco" placeholder="" name="nm_banco" class="form-control"/>

        </div>

        <div class="col-md-12"></div>
    {{--{!! Form::close() !!}--}}

    <!--Bot�o voltar-->

        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('/previoempenho'); ?>">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </a>
        </div>
    </div>
@endsection
