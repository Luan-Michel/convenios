@extends('app')
@section('content')
    <div class="container">
        <h1>Pessoa Física</h1>

        @if(Session::get('message_serv'))
            <div align="center" class="alert alert-danger">
                <strong>{{Session::get('message_serv')}}</strong>
            </div>
        @endif

        <br>
        {!!Form::open(['route'=>['pessoa.atualizabancopessoafisica', $pessoa[0]['id_pessoa']], 'method'=>'put'])!!}

        {!! Form::label('','')!!}
        <input type="hidden" id="valida_serv" name="valida_serv" value="{{ $valida_serv }}" class="form-control"/>

        <div class="col-md-2">
            {!! Form::label('cpf','CPF')!!}
            <input required type="text" id="cpf" value="{{ $pessoafisica[0]['cpf'] }}"
                   name="cpf" class="form-control" data-mask="999.999.999-99"/>
        </div>
        <div class="col-md-5">
            {!! Form::label('nm_pessoa_completo','Nome Completo')!!}
            <input required type="text" id="nm_pessoa_completo" value="{{ $pessoa[0]['nm_pessoa_completo'] }}"
                   name="nm_pessoa_completo" class="form-control" onblur="abrevianome()"/>
        </div>
        <div class="col-md-5">
            {!! Form::label('nm_pessoa_abreviado','Nome Abreviado')!!}
            <input required type="text" id="nm_pessoa_abreviado" value="{{ $pessoa[0]['nm_pessoa_abreviado'] }}"
                   name="nm_pessoa_abreviado" class="form-control"/>
        </div>

        @if($valida_serv == 0)

            @foreach($email as $email)

                <div id="{{ $email['id_pessoa'].".".$email['seq_email'] }}">
                    <br>
                    <div class="col-md-10">
                        <br>
                        {!! Form::label('email_usr[]','Email')!!}
                        {{--name="email_usr[]"--}}
                        <input type="text" id="{{$email['id_pessoa'].".".$email['seq_email'] }}" value="{{$email['ds_email'] }}"
                               name="{{$email['seq_email'] }}"  class="form-control"/>
                    </div>
                    <div class="col-md-2"><br>
                        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                        <br>
                        <button type="button" class="btn btn-danger glyphicon glyphicon glyphicon-remove"
                                id="{{ $email['id_pessoa'].".".$email['seq_email'] }}" data-toggle="tooltip"
                                data-placement="top"
                                onclick="removediv({{$email['id_pessoa'].".".$email['seq_email'] }})" ><br>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            @foreach($email as $email)

                <div id="{{ $email['id_pessoa'].".".$email['seq_email'] }}">
                    <br>
                    <div class="col-md-10">
                        <br>
                        {!! Form::label('email_usr[]','Email')!!}
                        {{--name="email_usr[]"--}}
                        <input type="text" readonly="true" id="email_usr[]" value="{{$email['ds_email'] }}"
                               name="{{$email['seq_email'] }}" class="form-control"/>
                    </div>
                    <div class="col-md-2"><br><br>
                        <label for="firstName" class="control-label"></label>
                        <button type="button" class="btn btn-danger glyphicon glyphicon glyphicon-remove" disabled
                                id="{{ $email['id_pessoa'].".".$email['seq_email'] }}" data-toggle="tooltip"
                                data-placement="top"
                                onclick="removediv({{$email['id_pessoa'].".".$email['seq_email'] }})" ><br>
                        </button>
                    </div>
                </div>
            @endforeach

        @endif

        <div class="anexo">
            <div class="col-md-12 arquivoAnexoPrincipal">
                <div class="col-md-8 inputanexo"><br>
                    <input required name="email[]" id="email[]" type="email" class="form-control">
                </div>
                <div id="addanexo" class="col-md-2 addanexo">
                    <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                    <br>
                    <button  type="button" id="addarquivoAnexo" class="addarquivoAnexo btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span class="glyphicon glyphicon-envelope"></span>
                    </button>
                </div>
                <div id="removeadd" class="col-md-2 remAdd">
                    <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                    <br>
                    <button disabled type="button" id="remgeral" class="btn btn-danger" data-toggle="tooltip"
                            data-placement="top"
                            title="Não anexar nenhum arquivo">
                        <span class="glyphicon glyphicon glyphicon-remove"></span>
                    </button>
                </div>
            </div>
            <div id="outrosanexos" class="col-md-12 arqAnexo">
            </div>
        </div>

        <div class="col-md-4">
            <label id="save" for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}

        </div>
        {!! Form::close()!!}

        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('/pessoa'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
            </a>
        </div>
    </div>


@endsection
@section('content_js')
    <script type="text/javascript">

        function removediv(id) {
            id = id + '';
            var res = id.split('.');
            var idpessoa = res[0];
            var seq = res[1];
            //ajax
            swal({
                title: "Tem certeza??",
                text: "Você não será capaz de recuperar esse e-mail após confirmar!",
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
                    type: "GET",
                    url: "../email/" + idpessoa + "/" + seq,
                    //data: {_token: csrf_token, id_pessoa: id_pessoa},
                    dataType:"json",
                    success: function (data) {
                        console.log(data);
                        if (data.status == "Success") {
                            swal("Feito!", data.msg, "success");
                            document.getElementById(id).innerHTML = '';
                        } else {
                            swal("Erro ao Excluir!", data.msg, "error");
                        }
                    },
                    error: function (data) {
                        swal("Erro ao Excluir!", "O e-mail não pode ser excluído porque possui dependência", "error");

                    }
                });

//                $.get("../email/" + idpessoa + "/" + seq)
//                        .done(function (data) {
//                            console.log(data);
//                            swal("Feito!", data.msg, "success");
//                        }).error(function (data) {
//                    console.log(data);
//                    swal("Erro ao Excluir!", data.msg, "error");
//                });
            });
        };



//            $.get("../email/" + idpessoa + "/" + seq).done(function (data, status) {
//                console.log(data);
//            });


        $(document).ready(function () {
            var wrapperTelPF = $('.arqAnexo');
            var add_buttonTelPF = $(".addarquivoAnexo");
            var base = $('.anexo');
            var xTelPF = 1;
            var hab = 1;

            document.getElementById("outrosanexos").innerHTML = '';
            document.getElementById("email[]").readOnly = true;
            document.getElementById("email[]").required = false;

            document.getElementById("addarquivoAnexo").className = "btn btn-default";
            document.getElementById('addarquivoAnexo').id = 'temp';

            document.getElementById("removeadd").className = "col-md-2 addAdd";
            document.getElementById("remgeral").className = "btn btn-success";
            document.getElementById("remgeral").innerHTML = "<span class=\"glyphicon glyphicon glyphicon-plus\"></span>";

            var valida_serv = document.getElementById("valida_serv").value;
            if(valida_serv == 1) {
                document.getElementById("cpf").readOnly = true;
                document.getElementById("nm_pessoa_completo").readOnly = true;
                document.getElementById("nm_pessoa_abreviado").readOnly = true;
                document.getElementById("addarquivoAnexo").disabled = true;
                document.getElementById("email[]").disabled = true;
                document.getElementById("email[]").required = false;
                document.getElementById("removeadd").disabled = true;
                document.getElementById("remgeral").disabled = true;
                document.getElementById("temp").disabled = true;
            } else{
                document.getElementById("remgeral").disabled = false;

            }


            $(add_buttonTelPF).click(function (e) {
                if (hab == 1) {
                    e.preventDefault();
                    console.log("1");
                    $(wrapperTelPF).append('<div class=\"col-lg-12\">' +
                            '<div class=\"col-lg-7\"><label for=\"firstName\" class=\"control-label\">' +
                            '<font color=\"#F0F0F0\">.</font></label>' +
                            '<input required name=\"email[]\" id=\"email[]\" type=\"email\" class=\"form-control\" >' +
                            '</div><div class=\"remTelefone col-lg-1\"><br>' +
                            '<button class=\"btn btn-danger\" type=\"button\">' +
                            '<span class=\"glyphicon glyphicon-minus\"></span></button></div></div>');
                    xTelPF++;
                }
            });

            $(base).on("click", ".remTelefone", function (e) {
                e.preventDefault();
                console.log("2");
                $(this).parent('div').remove();
                xTelPF--;
            });


            $(base).on("click", ".remAdd", function (e) {
                e.preventDefault();
                console.log("3");
                document.getElementById("outrosanexos").innerHTML = '';
                document.getElementById("email[]").readOnly = true;
                document.getElementById("email[]").value = '';
                document.getElementById("email[]").required = false;

                document.getElementById("addarquivoAnexo").className = "btn btn-default";
                document.getElementById('addarquivoAnexo').id = 'temp';

                document.getElementById("removeadd").className = "col-md-2 addAdd";
                document.getElementById("remgeral").className = "btn btn-success";
                document.getElementById("remgeral").innerHTML = "<span class=\"glyphicon glyphicon glyphicon-plus\"></span>";
                xTelPF = 0;
                hab = 0;
            });

            $(base).on("click", ".addAdd", function (e) {
                e.preventDefault();
                console.log("4");
                document.getElementById('email[]').readOnly = false;
                document.getElementById("email[]").required = true;

                document.getElementById('temp').id = 'addarquivoAnexo';
                document.getElementById("addarquivoAnexo").className = "addarquivoAnexo btn btn-primary";

                document.getElementById("removeadd").className = "col-md-2 remAdd";
                document.getElementById("remgeral").className = "btn btn-danger";
                document.getElementById("remgeral").innerHTML = "<span class=\"glyphicon glyphicon glyphicon-remove\"></span>";
                xTelPF = 1;
                hab = 1;
            });

        });

    </script>

    <script type="text/javascript">
        function abrevianome() {
            var nome = document.getElementById('nm_pessoa_completo').value;
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                url: '{{url("pessoa/gera_nome_abreviado")}}',
                data: {_token: csrf_token, nome: nome},
                dataType: "json"
            }).done(function (data) {
                document.getElementById('nm_pessoa_abreviado').value = data;
            }).error(function (data) {
            });
        }
    </script>
@endsection

