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

    {{--select2 --}}
    <link href="{{asset('select2-4.0.6-rc.1/dist/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('select2-4.0.6-rc.1/dist/js/select2.min.js')}}"></script>

    <style>
    /* Dropdown Button */
.dropbtn {
background-color: #3498DB;
color: white;
padding: 16px;
font-size: 16px;
border: none;
cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
background-color: #2980B9;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
position: relative;
display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
display: none;
position: absolute;
background-color: #f1f1f1;
min-width: 160px;
box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
color: black;
padding: 12px 16px;
text-decoration: none;
display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}

</style>


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

        <div class="navbar-header" style="padding: 0 25px;" >
            <br>
            <div class="dropdown">
              <button onclick="myFunction()" class="dropbtn">Menu</button>
              <div id="myDropdown" class="dropdown-content">
                <a href="{{ url('principal') }}">Início</a>
                <a href="{{ url('financiador') }}">Financiador</a>
                <a href="{{ url('categoriaconvenio') }}"> Categoria de Convênio</a>
                <a href="{{ url('convenio') }}">Convênio</a>
                <a href="{{ url('previoempenho') }}"> Prévio Empenho</a>
                <a href="{{ route('pessoa')}}"> Pessoa</a>
                <a href="{{ route('pessoaconvenio')}}"> Participante</a>
                <a href="{{ url('planodetrabalho') }}"> Plano de Trabalho</a>
                <a href="{{ url('etapaplanodetrabalho') }}"> Etapa da Meta</a>
                <a href="{{ url('etapaparticipantes') }}"> Participante da Etapa</a>
                <a href="{{ url('etapaitem') }}"> Item da Etapa</a>
                <a href="{{ url('diarias') }}"> Diária</a>
                <a href="{{ url('ajuda') }}"> Ajuda</a>
              </div>
            </div>
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
                <h1><font color="#2A166F"><b>SISCONV</b></font></h1>
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
        <p class="navbar-text">© 2018 - <a href="http://pitangui.uepg.br/nti" target="_blank">Núcleo de Tecnologia de
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

<script type="text/javascript" >

/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

</script>


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
