@extends('app')
@section('content')
<div class='container'>
    <h1>Visualizar Plano de Trabalho: {{$planodetrabalho->ds_titulo_meta_aplic}}</h1>

    @if($errors->any())
    <ul class="alert alert-warning">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach

    </ul>
    @endif

    {!!Form::open(['route'=>['planodetrabalho.atualizabanco', $planodetrabalho->id_aplicacao], 'method'=>'put'])!!}

    <!--Nome Form input-->
    <div class="col-md-12">


    <div class="col-md-6">
        {!! Form::label('id_financiador', 'Financiador')!!}
        <select required name="id_financiador" class="form-control margin-bottom-10" id="id_financiador" disabled>
          <option value="{{$fin->id_financiador}}">{{$fin->nm_financiador}}</option>
        </select>

    </div>
    <!--Convênio-->
    <div class="col-md-6">
        {!! Form::label('nr_convenio', 'Convênio')!!}
        <select required name="nr_convenio" class="form-control margin-bottom-10" id="nr_convenio" disabled="">
        <option value="{{$conv->nr_convenio}}" >{{$conv->ds_sigla_objeto}}</option>
        <option value=""></option>
        </select>
    </div>
     <!--Sequencia meta aplicativo Form input-->
     <div class="col-md-6">
        {!! Form::label('seq_meta_aplic','Sequência meta aplicação')!!}
        {!! Form::number('seq_meta_aplic', $planodetrabalho->seq_meta_aplic, ['class'=>'form-control', 'min'=>'0' , 'disabled'])!!}
    </div>
    <!--Titulo convenio Form input-->
     <div class="col-md-6">
         {!! Form::label('ds_titulo_meta_aplic','Título meta aplicação')!!}
        {!! Form::text('ds_titulo_meta_aplic', $planodetrabalho->ds_titulo_meta_aplic, ['class'=>'form-control' , 'disabled'])!!}
    </div>
    <!--Datas inicio e fim-->
    <div id="datepairExample">
          <div class="col-md-3 margin-bottom-5">
            <label for="firstName" class="control-label">Início da meta</label>
            <br><input id="dt_inicio_meta" value="{{$planodetrabalho->dt_inicio_meta}}" disabled onkeypress="return false"  name="dt_inicio_meta"   type="text" class="form-control" /><br>
          </div>
          <div class="col-md-3 margin-bottom-5">
            <label for="lastName" class="control-label">Término da meta</label>
            <br><input id="dt_termino_meta" value="{{$planodetrabalho->dt_termino_meta}}" disabled onkeypress="return false"  name="dt_termino_meta" type="text" class="form-control" /><br>
          </div>
    </div>
    <br>
    <!--Meta Form input-->
       <div class="col-md-12">
          {!! Form::label('ds_meta_aplic','Meta aplicação')!!}
          {!! Form::textarea('ds_meta_aplic', $planodetrabalho->ds_meta_aplic, ['class'=>'form-control' , 'disabled'])!!}
       </div>
    <div class="col-md-12">
       {!!Form::close()!!}
       <div class="col-md-3">
          <br><label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
          <a href="<?php echo url('planodetrabalho'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
          </a>
     </div>
    </div>
<br><br><br><br><br><br>
</div>
@endsection
