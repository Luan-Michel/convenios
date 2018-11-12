@extends('app')

@section('content')
    <div class="container">

           <h3>Categoria de convênio deletada com sucesso</h3>
            <!--Bot�o voltar categoriaconvenio-->
            <a href="<?php echo url('categoriaconvenio'); ?>">
                        {!! Form::button('Categoriaconvenio', ['class'=>'btn btn-primary'])!!}
            </a>

            <!--Bot�o voltar principal-->
            <a href="<?php echo url('principal'); ?>">
                        {!! Form::button('Principal', ['class'=>'btn btn-primary'])!!}
            </a>
            <br><br><br><br><br>
    </div>
@endsection
