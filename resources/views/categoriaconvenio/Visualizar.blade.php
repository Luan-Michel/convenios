@extends('app')


@section('content')
<div class='container'>
    <h1>Visualizar Categoria de convênio: {{$categoria->ds_categoria}}</h1>

    @if($errors->any())
    <ul class="alert alert-warning">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach

    </ul>
    @endif

    {!!Form::open(['route'=>['categoriaconvenio.atualizabanco', $categoria->id_categoria], 'method'=>'put'])!!}

    <!--Nome Form input-->
    <div class="form-group">
        {!!Form::label('ds_categoria','Nome:')!!}
        {!!Form::text('ds_categoria', $categoria->ds_categoria,['class'=>'form-control', 'disabled'])!!}
    </div>

     {!!Form::close()!!}

    <a href="<?php echo url('categoriaconvenio'); ?>">
        {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
    </a>
<br><br><br><br><br><br>
</div>
@endsection
