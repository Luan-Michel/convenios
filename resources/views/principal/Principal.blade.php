@extends('app')
        <!doctype html>
<html lang="pt_br">
  <meta charset="UTF-8">
  <head>
      <style>
          .menu-h li {
              display: inline;
              padding-right: 20px;
          }
      </style>
  </head>
  <body>
    @section('content')
    {{--<h1>DIPROC - Controle de Convênios </h1>--}}
    <br>
    <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation"><a class="btn btn-primary" href="{{ url('financiador') }}"><font
                            color="#ffffff"> Financiador</font></a></li>
            <li role="presentation"><a class="btn btn-primary" href="{{ url('categoriaconvenio') }}"><font
                            color="#ffffff"> Categoria de Convênio</font></a></li>
            <li role="presentation"><a class="btn btn-primary" href="{{ url('convenio') }}"><font
                            color="#ffffff"> Convênio</font></a></li>
            <li role="presentation"><a class="btn btn-primary" href="{{ url('previoempenho') }}"><font
                            color="#ffffff"> Prévio Empenho</font></a></li>
            <li role="presentation"><a class="btn btn-primary" href="{{ route('pessoa')}}"><font
                            color="#ffffff"> Pessoa</font></a></li>
            <li role="presentation"><a class="btn btn-primary" href="{{ route('pessoaconvenio')}}"><font
                            color="#ffffff">Participante</font></a></li>
        </ul>
    </div>
    <div class="col-md-2">
          <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a class="btn btn-primary" href="{{ url('planodetrabalho') }}"><font
                              color="#ffffff"> Plano de trabalho</font></a></li>
              <li role="presentation"><a class="btn btn-primary" href="{{ url('etapaplanodetrabalho') }}"><font
                              color="#ffffff"> Etapa do plano de trabalho</font></a></li>
              <li role="presentation"><a class="btn btn-primary" href="{{ url('etapaparticipantes') }}"><font
                              color="#ffffff"> Etapa participantes</font></a></li>
              <li role="presentation"><a class="btn btn-primary" href="{{ url('etapaitem') }}"><font
                              color="#ffffff"> Etapa Item</font></a></li>
              <li role="presentation"><a class="btn btn-primary" href="{{ url('diarias') }}"><font
                              color="#ffffff"> Diárias</font></a></li>
              <li role="presentation"><a class="btn btn-primary" href="{{ url('ajuda') }}"><font
                              color="#ffffff"> Ajuda</font></a></li>
          </ul>
    </div>
    <div class="col-md-8">
    </div>
  </body>
</html>
@endsection
