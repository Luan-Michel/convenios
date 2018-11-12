@extends('app')

@section('content')
    <div class="container">

           <h3>Categoria de convênio deletada com sucesso</h3>

            <a href="<?php echo url('planodetrabalho'); ?>">
                        {!! Form::button('planodetrabalho', ['class'=>'btn btn-primary'])!!}
            </a>


            <a href="<?php echo url('principal'); ?>">
                        {!! Form::button('Principal', ['class'=>'btn btn-primary'])!!}
            </a>
            <br><br><br><br><br>
    </div>
@endsection
