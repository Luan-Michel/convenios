@extends('app')

@section('content')
    <div class="container">
        <h1>Pessoa Jurídica</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
            @endif
            <br>
            {!! Form::open(['route'=>'pessoa.storeinstituicao', 'files' =>true])!!}
            <div class="col-md-2">
                {!! Form::label('cnpj','CNPJ')!!}
                <input required type="text" id="cnpj" data-mask="99.999.999/9999-99" placeholder="" name="cnpj" class="form-control" onblur="valida_cnpj()"/>
            </div>
            <div class="col-md-6">
                {!! Form::label('nm_fantasia','Nome Fantasia')!!}
                <input required type="text" id="nm_fantasia" placeholder="" name="nm_fantasia" class="form-control" />
            </div>

            <div class="col-md-2">
                {!! Form::label('inscricao_estadual','Inscrição Estadual')!!}
                <input type="number" id="inscricao_estadual" placeholder="" name="inscricao_estadual" class="form-control" />
            </div>
            <div class="col-md-2">
                {!! Form::label('cd_siaf','CD siaf')!!}
                <input type="text" id="cd_siaf" data-mask="99.999.999" placeholder="" name="cd_siaf" class="form-control" />
            </div>
            <div class="anexo">
                <div class="col-md-12 arquivoAnexoPrincipal">
                    <div class="col-md-8 inputanexo"><br>
                        {!! Form::label('anexo','Email:')!!}
                        <input required name="email[]" id="email[]" type="email"  class="form-control">
                    </div>
                    <div id="addanexo" class="col-md-2 addanexo"><br>
                        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                        <br>
                        <button type="button" id="addarquivoAnexo" class="addarquivoAnexo btn btn-primary">
                            <span class="glyphicon glyphicon-plus"></span>
                            <span class="glyphicon glyphicon-envelope"></span>
                        </button>
                    </div>
                    <div id="removeadd" class="col-md-2 remAdd"><br>
                        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                        <br>
                        <button type="button" id="remgeral" class="btn btn-danger" data-toggle="tooltip"
                                data-placement="top"
                                title="Não anexar nenhum arquivo">
                            <span class="glyphicon glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                </div>
                <div id="outrosanexos" class="col-md-12 arqAnexo">
                </div>
            </div>

            <!--Bot�o-->
            <div class="col-md-4">
                <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                <div class="form-group">
                    {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
                </div>
            </div>
        {!! Form::close()!!}


        <!--Bot�o voltar-->
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

        $(document).ready(function () {
            var wrapperTelPF = $('.arqAnexo');
            var add_buttonTelPF = $(".addarquivoAnexo");
            var base = $('.anexo');
            var xTelPF = 1;
            var hab = 1;

            $(add_buttonTelPF).click(function (e) {
                if (hab == 1) {
                    e.preventDefault();
                    console.log("1");
                    $(wrapperTelPF).append('<div class=\"col-lg-12\"><div class=\"col-lg-7\"><label for=\"firstName\" class=\"control-label\"><font color=\"#F0F0F0\">.</font></label><input required name=\"email[]\" id=\"email[]\" type=\"email\" class=\"form-control\" ></div><div class=\"remTelefone col-lg-1\"><br><button class=\"btn btn-danger\" type=\"button\"><span class=\"glyphicon glyphicon-minus\"></span></button></div></div>');
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
                document.getElementById("email[]").disabled = true;
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
                document.getElementById('email[]').disabled = false;
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
        function valida_cnpj() {
            var cnpj = document.getElementById('cnpj').value;
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                url: '{{url("pessoa/valida_cnpj")}}',
                data: {_token: csrf_token, cnpj: cnpj},
                dataType: "json"
            }).done(function (data) {
                window.location.href = data+"/editar";
            }).error(function (data) {
            });
        }
    </script>
@endsection