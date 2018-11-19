@extends('app')

@section('content')
    <div class='container'>
        <div class="col-md-12" id="cabecalho">
          <div class="col-md-6">
            <h1>Participantes</h1>
          </div>
          <div style="padding-top: 20px" class="col-md-6">
             <a href="{{route('ajuda')}}#participante" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
          </div>
        </div>

        <div class="col-md-1" align="right">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('pessoaconvenio.adicionar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>

        {{--<div class="col-md-6" align="right">--}}
        {{--<a href="{{ route('pessoa.adicionarpessoafisica')}}" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp; Pessoa Física</a>--}}
        {{--<a href="{{ route('pessoa.adicionarinstituicao')}}" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp; Pessoa Jurídica</a>--}}
        {{--</div>--}}
        <br><br><br>
        <br>
        <br><br><br>
        <div class="col-md-12">
            <table class="table tale-striped table-bordered table-hover" id="table">
                <thead>
                <tr>
                    <th>Pessoa</th>
                    <th>Instituição</th>
                    <th>Convênio</th>
                    <th>Alterar</th>
                    <th>Excluir</th>
                </tr>
                </thead>
                <tbody>

                @foreach($pessoas as $p)
                    <tr>
                        <td>{{$p->nm_pessoa_abreviado}}</td>
                        <td>{{$p->nm_fantasia}}</td>
                        <td>{{$p->ds_sigla_objeto}}</td>
                        <td align="center">
                            <a href="{{ route('pessoaconvenio.Editar',[$p->id_convenio, $p->id_pessoa_participante])}}" class="btn-sm btn-default">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                        </td>
                        <td align="center">
                           {{-- <a href="{{ route('pessoaconvenio.Deletar',[$p->id_convenio, $p->id_pessoa_participante])}}" class="btn-sm btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>--}}

                            <a  class=" glyphicon glyphicon-trash btn-sm btn-danger" aria-hidden="true" onclick="ajaxDelete({{$p->id_convenio, $p->id_pessoa_participante}})">
                            </a>
                            {{--<a href="/pessoaconvenio/{{$p->id_convenio}}/{{$p->id_pessoa_participante}}/visualizar" class="btn-sm btn-primary">Visualizar</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <div class="col-md-1" align="right">
          <a href="<?php echo url('principal'); ?>">
              {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
          </a>
        </div>
        <div class="col-md-offset-10 col-md-1" align="left">
            <a href="{{ route('pessoaconvenio.adicionar')}}" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo</a>
        </div>

    </div>
    <!-- Modal --> {{-- wagner BOTÃO POP UP--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"> <b>Nova pessoa a um convênio</b></h4>
                </div>
                <div class="modal-body" align="center">
                    <a href="{{ route('pessoa.adicionarpessoafisica')}}" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp; Pessoa Física</a>
                    <a href="{{ route('pessoa.adicionarinstituicao')}}" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>&nbsp; Pessoa Jurídica</a>
                </div>
                {{--<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>--}}
            </div>
        </div>
    </div>
    {{--wagner -> função para abrir o pop up com os botões estilo bootstrap--}}
    <script language="JavaScript" type="text/javascript">
        // when DOM is ready
        $(document).ready(function () {

            // Attach Button click event listener
            $("#myBtn").click(function(){

                // show Modal
                $('#myModal').modal('show');
            });
        });

    </script>
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

        //modificar para excluír participante

        function ajaxDelete($nr, $id) {
            var id_pessoa = $id;
            var id_convenio = $nr;
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var rota = window.location.href + "/" + id_convenio+"/"+ id_pessoa + "/deletar";
            swal({
                title: "Tem certeza?",
                text: "Você não será capaz de recuperar esse cadastro.",
                imageUrl: "{{asset('images/question.jpg')}}",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#DD6B55",
                confirmButtonColor: "#5cb85c",
                confirmButtonText: "Confirmar",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (!isConfirm) return;
                $.ajax({
                    type: "POST",
                    url: rota,
                    data: {_token: csrf_token, id_pessoa: id_pessoa, id_convenio: id_convenio},
                    dataType:"json",
                    success: function (data) {
                        console.log(data);
                        if (data.status == "Success") {
                            swal("Feito!", data.msg, "success");
                        } else {
                            swal("Erro ao Excluir!", data.msg, "error");
                        }
                    },
                    error: function (data) {
                        swal("Erro ao Excluir!", "O cadastro não pode ser excluído porque possui dependência", "error");
                    }
                });
            });
        }
    </script>
@endsection
