@extends('app')


@section('content')
<div class='container'>
    <h1>Visualizar Financiador: {{$financiador->nm_financiador}}</h1>

    @if($errors->any())
    <ul class="alert alert-warning">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach

    </ul>
    @endif

    {!!Form::open(['route'=>['financiador.atualizabanco', $financiador->id_financiador], 'method'=>'put'])!!}

    <!--Nome Form input-->
    <div class="form-group">
        {!!Form::label('nm_financiador','Nome:')!!}
        {!!Form::text('nm_financiador', $financiador->nm_financiador,['class'=>'form-control' , 'disabled' ])!!}

    </div>

    <!--Sigla Form input-->
    <div class="form-group">
        {!!Form::label('ds_sigla_financiador','Sigla:')!!}
        {!!Form::text('ds_sigla_financiador', $financiador->ds_sigla_financiador,['class'=>'form-control' , 'disabled' ])!!}

    </div>

     <!--Esfera Form input-->
    <div class="form-group">
        {!!Form::label('tp_esfera','Esfera:')!!}
        {!!Form::text('tp_esfera', $financiador->tp_esfera,['class'=>'form-control' , 'disabled' ])!!}

    </div>

     {!!Form::close()!!}

     <div class="col-md-1">
        <a href="<?php echo url('financiador'); ?>">
            {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
        </a>
     </div>
</div>
@endsection
