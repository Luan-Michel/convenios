@extends('app')
@section('content')
    <div class='container'>
        <div class="col-md-6">
          <h1>Pessoa</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#pessoa" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
        <div class="col-md-6">
          <br>
        </div>
        <a href="{{ route('pessoa.adicionarpessoafisica')}}" class="btn btn-default">
            <i class="glyphicon glyphicon-plus"></i>&nbsp; Pessoa Física</a>
        <a href="{{ route('pessoa.adicionarinstituicao')}}" class="btn btn-default">
            <i class="glyphicon glyphicon-plus"></i>&nbsp; Pessoa Jurídica</a>
        <br><br>
        <div class="col-md-12" type="hidden">
            <input type="hidden" id="result" value="">
        </div>
        <div>
            <label class="control-label" for="selectbasic">Pesquisa:</label><br>
            <input type="text" id="search" placeholder="Pesquise uma pessoa ou instituição..." name="searc" class="col-md-6"/>
        </div>
        <div onclick="search()">
            <label class="control-label" ></label>
            <a id="button_search" name="button_search" class="btn btn-success glyphicon glyphicon-search align-left" ></a>
        </div>
        <br><br>
        <div class="table">
            <table  class="table table-striped table-hover table-bordered" id="table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th style="text-align: center">CPF/CNPJ</th>
                    <th style="text-align: center">Alterar</th>
                    <th style="text-align: center">Excluir</th>
                </tr>
                </thead>
                {!! Form::open(['method'=>'get', 'route'=>['pessoa.ajaxDelete']]) !!}
                <tbody id="tasks-list">
                </tbody>
                {!! Form::close() !!}
            </table>
        </div>
        <a href="<?php echo url('principal'); ?>">
            {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}</a>
    </div>
@endsection
@section('content_js')
    <script type="text/javascript">
        $(document).ready(function (){
            $('#search').on("keydown", function (e) {
                if(e.keyCode == 13) {
                    search();
                }
            });
        });

        function search() {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var search = $('#search').val();
            if ((search.length) > 2) {
                $.ajax({
                    type: 'get',
                    url: '{{url("pessoa/ajaxPesquisaPessoa")}}',
                    data: {'X-CSRF-TOKEN': csrf_token, search: search},
                    dataType: "json"
                }).done(function (data) {
                    var url = window.location.href + "/";
                    $("#tasks-list").empty();
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].cpf == null && data[i].cnpj == null) {
                            data[i].cpf = 'Não possui';
                        } else {
                            if (data[i].cpf == null && data[i].cnpj != null) {
//                                data[i].cpf = data[i].cnpj;
                                data[i].cpf = data[i].cnpj[0]+data[i].cnpj[1]+'.'+data[i].cnpj[2]+data[i].cnpj[3]+
                                        data[i].cnpj[4]+'.'+data[i].cnpj[5]+data[i].cnpj[6]+data[i].cnpj[7]+'/'+
                                        data[i].cnpj[8]+data[i].cnpj[9]+data[i].cnpj[10]+data[i].cnpj[11]+'-'+
                                        data[i].cnpj[12]+data[i].cnpj[13];
                            } else {
                                if (data[i].cpf == null) {
                                    data[i].cpf = "Não possui";
                                }else{
                                    data[i].cpf = data[i].cpf[0]+data[i].cpf[1]+data[i].cpf[2]+'.'+data[i].cpf[3]+
                                            data[i].cpf[4]+data[i].cpf[5]+'.'+data[i].cpf[6]+data[i].cpf[7]+
                                            data[i].cpf[8]+'-'+data[i].cpf[9]+data[i].cpf[10];

                                }
                            }
                        };
                        var task = '<tr id="pessoa"><td>' + data[i].nm_pessoa_completo + '</td><td align="center">' + data[i].cpf + ' </td>';
                        task += '<td align="center"><a class="btn-sm btn-default glyphicon glyphicon-pencil"  href="' + url + data[i].id_pessoa + '/editar"></a></td>';
                        task += '<div><td align="center">' + '<a id="delete" onclick="ajaxDelete(' + data[i].id_pessoa + ')"  class=" delete btn-sm btn-danger glyphicon glyphicon-trash"></div></a></td>';
                        $("#tasks-list").append(task);
                    }
                }).error(function (data) {
                    $("#tasks-list").empty();
                });
            }
        }

        function ajaxDelete($id) {
            var id_pessoa = $id;
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var rota = window.location.href + "/" + id_pessoa + "/ajaxDelete";
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
                console.log("entrou no confirm");
                $.ajax({
                    type: "POST",
                    url: rota,
                    data: {_token: csrf_token, id_pessoa: id_pessoa},
                    dataType:"json",
                    success: function (data) {
                        console.log(data);
                        if (data.status == "Success") {
                            swal("Feito!", data.msg, "success");
                            search();
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
