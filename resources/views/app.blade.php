<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DIPROC</title>

    <link href="{{ asset('/css/bootstrap.sandstone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/pace.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/selectize.default.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sticky-footer.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-datepicker.css') }}" rel="stylesheet" rel="stylesheet"/>
    <link href="{{ asset('/css/site.css') }}" rel="stylesheet" rel="stylesheet"/>
    <link rel="shortcut icon" href="http://portal.uepg.br/favicon.ico"/>
    {{--Nova versão do jquery--}}
    <script src="{{ asset('/js/jquery3.2.1.js') }}"></script>
    {{--<script src="{{ asset('/js/jquery.js') }}"></script>--}}
    {{--JQuery validator--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />--}}

    <script src="{{ asset('/validation/dist/jquery.validate.js') }}"></script>
    {{--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>--}}


    {{--SweetAlert--}}
    <link href="{{asset('/sweetalert/dist/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('/sweetalert/dist/sweetalert.min.js' )}}"></script>

    {{--CKEditor--}}
    <script src="{{ asset('/ckeditor/ckeditor.js')}}"></script>

</head>
<body id="corpo">
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-top">
    <div class="container-fluid" style="background-color: #0085c3 !important">
        <div class="navbar-header">
            <br>
            <a href="http://uepg.br/">
                <img src="{{asset('images/UEPG.png')}}" alt="UEPG - Universidade Estadual de Ponta Grossa"
                     class="img-responsive" style="margin-top: -4px;">
            </a>
            <br>

            </div>

        <div class="navbar-header navbar-right" style="padding: 0 15px; float: right; margin-top: 35px;">
          <ul class="nav navbar-nav navbar-right" >
              <!-- Authentication Links -->
              @if (Auth::guest())
                  <li><a href="{{ url('/login') }}">Login</a></li>
                  <li><a href="{{ url('/register') }}">Registre-se</a></li>
              @else
                  <li class="dropdown">
                      <div class="navbar-header navbar-right" style="padding: 15px 15px;">
                          <p class="navbar-text pull-left">
                              @include(Config::get('sgiauthorizer.view.loggedUserView'))
                          </p>
                      </div>
                  </li>
              @endif
          </ul>
        </div>
        @include('sweet::alert')
        <div align="center" style="padding: 0 30px; ">
            <br>
            <a href="{{ url('principal') }}">
                <h1><font color="#2A166F"><b>CONTROLE DE CONVÊNIOS</b></font></h1>
            </a>
            <br>
        </div>

        @yield('menu')


    </div>
</nav>

<div class="container-fluid">
    <noscript>
        <meta http-equiv="refresh" content="1;" url="{{ url('errors/js') }}">
    </noscript>
    @yield('content')
</div>

<br><br><br><br>

<footer class="_footer">
    <div class="container-fluid">
        <p class="navbar-text">© 2015 - <a href="http://pitangui.uepg.br/nti" target="_blank">Núcleo de Tecnologia de
                Informação - UEPG</a>
            <br>Problemas na visualização? <a href="mailto:internet@uepg.br" target="_top">internet@uepg.br</a></p>
        <div class="navbar-header navbar-right hidden-xs">
            <a class="navbar-brand" href="http://pitangui.uepg.br/nti" target="_blank">
                <img src="https://sistemas.uepg.br/producao/abertura/imagens/NTI-48x48.png"
                     alt="NTI - Núcleo de Tecnologia de Informação" class="img-responsive" style="margin-top: -50%;">
            </a>
        </div>
    </div>
</footer>
</body>


<script src="{{ asset('/js/angular.min.js') }}"></script>

<script src="{{ asset('/js/pace.min.js') }}"></script>
{{--<script src="{{ asset('/js/jquery.min.js') }}"></script>--}}
{{--<script src="{{ asset('/js/index.js') }}"></script>--}}
<script src="{{ asset('/js/selectize.js') }}"></script>
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script src="{{ asset('/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datepicker.js') }}"></script>

@yield('content_js')
</html>
