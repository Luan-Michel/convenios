@extends('app')
@section('content')
    <div class='container'>
        <h1>Conta Corrente - {{$id_pessoa[0]->nm_pessoa_completo}}</h1>
        <div class="col-md-6" align="left">
            <a href="{{ route('contacorrente.Cadastrar',[$id_pessoa[0]->id_pessoa])}}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>
        <div class="col-md-6" align="right">
        </div>

        <br><br><br>
        <div class="col-md-12">
            <table class="table tale-striped table-bordered table-hover" id="table">
                <thead>
                <tr>
                    <th>Nome do Banco</th>
                    <th>Nome da Agência</th>
                    <th>Tipo da Conta</th>
                    <th>Conta Corrente</th>
                    <th>DAC</th>
                    <th>Alterar</th>
                    <th>Excluir</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cc as $cc)
                    <tr>
                        <td>{{$cc->nr_banco}}</td>
                        <td>{{$cc->nr_agencia}}</td>
                        @if($cc->cd_tipo_conta == null)
                            <td>Não possui</td>
                        @else
                            <td>{{$cc->cd_tipo_conta}}</td>
                        @endif
                        <td>{{$cc->nr_conta}}</td>
                        <td>{{$cc->nr_dac}}</td>
                        <td align="center">
                            <a href="{{ route('contacorrente.Editar', [$cc->id_pessoa, $cc->seq_bancario])}}" class="btn-sm btn-default ">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                        </td>
                        <td align="center">
                            <a href="{{ route('contacorrente.Deletar',[$cc->id_pessoa, $cc->seq_bancario])}}" class="btn-sm btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br>
        </div>
    </div>
@endsection
@section('content_js')
    <script> $("table").dataTable({
            "language": {
                "url": "/Portuguese.json",
                "search":"Pesquisar",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "info" : '',
                "paginate": {
                    "previous": "Anterior",
                    "next": "Próximo"
                },
                "sEmptyTable":"Nenhum registro encontrado."
        }});
    </script>
@endsection
