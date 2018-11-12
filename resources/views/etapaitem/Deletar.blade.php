@extends('app')

@section('content')
    <div class="container">

           <h3>Previo Empenho deletado com sucesso</h3>
            <!--Bot�o voltar etapaplanodetrabalho-->
            <a href="<?php echo url('etapaplanodetrabalho'); ?>">
                        {!! Form::button('etapaplanodetrabalho', ['class'=>'btn btn-primary'])!!}
            </a>

            <!--Bot�o voltar principal-->
            <a href="<?php echo url('principal'); ?>">
                        {!! Form::button('Principal', ['class'=>'btn btn-primary'])!!}
            </a>
            <br><br><br><br><br>
    </div>
@endsection
