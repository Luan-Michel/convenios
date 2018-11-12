@extends(Config::get('sgiauthorizer.view.layout'))
@section(Config::get('sgiauthorizer.view.userInfoSection'))      
	<ul>
		<li>Username: {{$usuario->username}}</li>
		<li>Nome: {{$usuario->nome}}</li>
		<li>Cpf: {{$usuario->cpf}}</li>
		<li>Rg: {{$usuario->rg}}</li>
		<li>Email: {{$usuario->email}}</li>
		<br>
		<a class="btn btn-info" href="{{URL::previous()}}">Voltar</a>
	</ul>	
@stop