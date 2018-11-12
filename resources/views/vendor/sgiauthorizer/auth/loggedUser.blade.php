@if(Auth::check())
        <a style="color: white;" href="{{ url(Config::get('sgiauthorizer.app.userInfoRoute')) }}">
            <span class="glyphicon glyphicon-user"></span>
            {{Auth::user()->username}}
        </a>
        <a style="color: white;" href="{{ url('logout') }}">
            <span class="glyphicon glyphicon-log-out"></span>
            Sair
        </a>
@else
	<a href="{{ url(Config::get('sgiauthorizer.app.loginRoute')) }}" class="btn btn-default btn-lg active" role="button">Login</a>
@endif
