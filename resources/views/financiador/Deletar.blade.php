@extends('app')

@section('content')
    <div class="container">
           
        
           <h3>Financiador deletado com sucesso</h3>
            
            <!--Botão voltar financiador-->
            <a href="<?php echo url('financiador'); ?>">
                        {!! Form::button('Financiador', ['class'=>'btn btn-primary'])!!}
            </a>
            
            <!--Botão voltar principal-->
            <a href="<?php echo url('principal'); ?>">
                        {!! Form::button('Principal', ['class'=>'btn btn-primary'])!!}
            </a>
    </div>
@endsection