@extends('app')
@section('content')
    @if(Session::has('message'))
        <div class="alert alert-danger">
            <strong>{{ Session::get('message') }}</strong>
        </div>
    @endif
    <div class="container">
        <h1>Agência</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        @endif
        <br>
        {!! Form::open(['route'=>'agencia.store', 'files' =>true])!!}

        <div class="col-md-4">
            {!! Form::label('nr_banco','Banco')!!}
            <select required name="nr_banco" class="form-control margin-bottom-10 change-event" id="nr_banco">
                <option value=""></option>
                 @foreach($nm_banco as $nm_banco)
                     <option value="{{$nm_banco->nr_banco}}">{{$nm_banco->nm_banco}}</option>
                 @endforeach
            </select>
        </div>
        <div class="col-md-2">
            {!! Form::label('nr_agencia', 'Número da Agência') !!}
            <input required type="number" max="4" id="nr_agencia" placeholder="" name="nr_agencia" class="form-control"/>

        </div>

        <div class="col-md-4">
            {!! Form::label('nm_agencia', 'Nome da Agência') !!}
            <input required type="text" max="50"  id="nm_agencia" placeholder="" name="nm_agencia" class="form-control"/>

        </div>
        <div class="col-md-1">
            {!! Form::label('nr_dac', 'DAC') !!}
            <input required type="text" max="1" id="nr_dac" placeholder="" name="nr_dac" class="form-control"/>
        </div>

        <div class="col-md-12"></div>
    {{--{!! Form::close() !!}--}}

    <!--Bot�o voltar-->
        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('/banco'); ?>">
                {!! Form::button ('Cadastrar Banco', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>

        <div class="col-md-2">
            <label for="firstName" id="id_save" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('/previoempenho'); ?>">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </a>
        </div>
    </div>
@endsection
@section('content_js')

@endsection
