@extends('app')
@section('content')
    @if($errors->any())
        <ul class="alert alert-warning">
            @foreach($errors->all()as$error)
                <li>{{ $error}}</li>
            @endforeach
        </ul>
    @endif

    <div class="container">
        <div class="col-md-12" id="cabecalho">
          <div class="col-md-6">
            <h1>Convênio</h1>
          </div>
          <div style="padding-top: 20px" class="col-md-6">
             <a href="{{route('ajuda')}}#convenio" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
          </div>
        </div>
        <br>
        {!! Form::open(['route'=>'convenio.store', 'id'=>'signupForm', 'files' =>true])!!}
        <div class="col-md-6">
            {!! Form::label('id_financiador','Financiador')!!}
            <select required name="id_financiador" class="form-control margin-bottom-10 change-event" id="id_financiador">
                <option value=""></option>
                @foreach($financiador as $financiador)
                    <option value="{{$financiador->id_financiador}}">{{$financiador->nm_financiador}}</option>
                @endforeach
            </select>
        </div>

        <!--Numero convenio Form input-->
        <div class="col-md-2">
            {!! Form::label('nr_convenio','Número')!!}
            <input type="number" required id="nr_convenio" min="1" name="nr_convenio" class="form-control change-event"/>
        </div>

        <div class="col-md-2">
            {!! Form::label('ano_convenio','Ano')!!}
            <input required type="number" id="ano_convenio" min="1960" max="{{ date("Y") }}" placeholder="" name="ano_convenio"
                   class="form-control change-event"/>
        </div>

        <div class="col-md-2">
            {!! Form::label('nr_protocolo','Número do protocolo')!!}
            <input type="number" id="nr_protocolo" min="1" name="nr_protocolo" class="form-control"/>
        </div>

        <div class="col-md-2">
            <br>
            {!! Form::label('nr_processo','Número do processo')!!}
            <input required type="number" id="nr_processo" min="1" name="nr_processo" class="form-control"/>
        </div>

        <div class="col-md-2">
            <br>
            {!! Form::label('ano_processo','Ano do processo')!!}
            <input required type="number" id="ano_processo" min="2000" max="{{ date("Y") }}" placeholder="" name="ano_processo"
                   class="form-control"/>
        </div>

        <div class="col-md-8">
            <br>
            {!! Form::label('id_categoria','Categoria')!!}
            <select required name="id_categoria" id="id_categoria" class="form-control">
                <option value=""></option>
                @foreach($categoria as $categoria)
                    <option value="{{$categoria->id_categoria}}">{{$categoria->ds_categoria}}</option>
                @endforeach
            </select>
        </div>

        <!--Objeto Form input-->
        <div class="col-md-6">
            <br>
            {!! Form::label('ds_objeto','Objeto')!!}
            <input type="text" name="ds_objeto" id="ds_objeto" class="form-control"/>
        </div>

        <!--Sigla objeto Form input-->
        <div class="col-md-2">
            <br>
            {!! Form::label('ds_sigla_objeto','Sigla do objeto')!!}
            <input type="text" id="ds_sigla_objeto" name="ds_sigla_objeto" class="form-control"/>
        </div>

        <!--nr_sit_tce ??????? Form input-->
        <div class="col-md-2">
            <br>
            {!! Form::label('nr_sit_tce','SIT')!!}
            <input required type="number" id="nr_sit_tce" min="1" max="99999999" name="nr_sit_tce"
                   class="form-control"/>
        </div>

        <div class="col-md-2">
            <br>
            {!! Form::label('vl_convenio','Valor do convênio')!!}
            <input required type="text" data-mask="#.##0,00" data-mask-reverse="true" value="" id="vl_convenio"
                   name="vl_convenio" class="form-control"/>
        </div>

        <!--Valor Convenio Form input-->
        <div class="col-md-3">
            <br>
            {!! Form::label('idcontas_plano_contabil','Conta Contábil - Plano')!!}
            <select required name="idcontas_plano_contabil" class="form-control" id="idcontas_plano_contabil" >
                <option value=""></option>
                @foreach($contabil as $contabil)
                    <option value="{{$contabil->idcontas_plano}}">{{$contabil->cdred}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <br>
            {!! Form::label('idcontas_plano_banco','Conta Contábil - Banco')!!}
            <select required name="idcontas_plano_banco" class="form-control" id="idcontas_plano_banco" >
                <option value=""></option>
                @foreach($con as $con)
                    <option value="{{$con->idcontas_plano}}">{{$con->cdred}}</option>
                @endforeach
            </select>
        </div>

        <!--Valor Convenio Form input-->
        <div class="col-md-3 margin-bottom-5" id="dp1">
            <br>
            {!! Form::label('dt_inicio','Data de início')!!}
            <br><input class="form-control" data-mask="00/00/0000" type="text" placeholder="__/__/____" id="dt_inicio" required  name="dt_inicio"
                       onblur="limitedeexecucao()"/><br>
        </div>

        <div class="col-md-3 margin-bottom-5" id="dp2">
            <br>
            {!! Form::label('dt_limite_execucao','Data limite de execução')!!}
            <br><input id="dt_limite_execucao" required class="form-control" data-mask="00/00/0000"  type="text" placeholder="__/__/____" name="dt_limite_execucao"
                       onblur="prestacaodecontas()"/><br>
        </div>

        <div class="col-md-3 margin-bottom-5" id="dp3">
            <br>
            {!! Form::label('dt_prest_contas','Data prestação de contas')!!}
            <br><input id="dt_prest_contas" required class="form-control" data-mask="00/00/0000" type="text" placeholder="__/__/____" name="dt_prest_contas"
                       onblur="limitevigencia()"/><br>
        </div>

        <div class="col-md-3 margin-bottom-5" id="dp4">
            <br>
            {!! Form::label('dt_limite_vigencia','Data limite de vigência')!!}
            <br><input id="dt_limite_vigencia" required class="form-control" data-mask="00/00/0000" type="text" placeholder="__/__/____" name="dt_limite_vigencia"/><br>
        </div>

        <!--Objeto Form input-->
        <div class="col-md-12">
            <br>
            {!! Form::label('ds_resumo_plano','Resumo do Plano de Trabalho')!!}
            <textarea type="text" name="ds_resumo_plano" id="ds_resumo_plano" class="form-control"></textarea>
        </div>


        <div class="anexo">
            <br>
            <div class="arquivoAnexoPrincipal">
                <div class="col-md-8 pull-left inputanexo ">
                    <br>
                    {!! Form::label('anexo','Anexo:')!!}
                    <input  name="anexo[]" id="anexo[]" type="file" size="50" accept="application/pdf"
                            class="form-control" onchange="testararquivo(this)">
                </div>

                <div id="addanexo" class="escondido col-md-1"><!--col-md-2 addanexo-->
                  <br>
                  <br>
                    <button type="button" id="addarquivoAnexo" class="addarquivoAnexo btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>
                        <span class="glyphicon glyphicon glyphicon-inbox"></span>
                    </button>
                </div>

                <div id="removeadd" class="escondido col-md-1">
                  <br>
                  <br>
                    <button type="button" id="remgeral" class="btn btn-danger" data-toggle="tooltip"
                            data-placement="top"
                            title="Não anexar nenhum arquivo">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </div>
            </div>

            <div id="outrosanexos" class="col-md-12 arqAnexo">
            </div>
        </div>

        <!--Bot�o voltar-->
        <div class="col-md-1">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('convenio'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>

        <!--Bot�o-->
        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
        </div>
    {!! Form::close()!!}

    </div>

@endsection
@section('content_js')
    <script type="text/javascript">


        function testararquivo(input) {
            var extPermitidas = ['pdf'];
            var extArquivo = input.value.split('.').pop();

            if(input.value == ""){
              return;
            }

            if(typeof extPermitidas.find(function(ext){ return extArquivo == ext; }) == 'undefined') {
              swal('Erro', 'Extensão "' + extArquivo + '" não permitida!', 'error');
              input.value = "";
              return;
            }
            if (document.getElementById("anexo[]").value.length > 4) {
                document.getElementById("addanexo").className = "col-md-2 addanexo";
                document.getElementById("removeadd").className = "col-md-2 remAdd";
            }
        }

        function limitedeexecucao() {
            var dt_inicio = document.getElementById('dt_inicio').value;
            document.getElementById('dt_limite_execucao').min=dt_inicio;
        }
        function prestacaodecontas() {
            var lim = document.getElementById('dt_limite_execucao').value;
            document.getElementById('dt_prest_contas').min=lim;

        }

        function limitevigencia() {
            var cont = document.getElementById('dt_prest_contas').value;
            document.getElementById('dt_limite_vigencia').min=cont;
        }

        //anexos
        $(document).ready(function () {
            //  $('.date').mask('00/00/0000');
            var wrapperTelPF = $('.arqAnexo');
            var add_buttonTelPF = $(".addarquivoAnexo");
            var base = $('.anexo');
            var xTelPF = 1;
            var hab = 1;

            $(add_buttonTelPF).click(function (e) {
                if (hab == 1) {
                    e.preventDefault();
                    $(wrapperTelPF).append('<div class=\"col-lg-12\"><div class=\"col-lg-7\"><label for=\"firstName\" class=\"control-label\"><font color=\"#F0F0F0\">.</font></label><input required name=\"anexo[]\" id=\"anexo[]\" type=\"file\" onchange=\"testararquivo(this)\" class=\"form-control\" size=\"50\" accept=\"application/pdf\"></div><div class=\"remTelefone col-lg-1\"><br><button class=\"btn btn-danger\" type=\"button\"><span class=\"glyphicon glyphicon-minus\"></span></button></div></div>');
                    xTelPF++;
                }
            });

            $(base).on("click", ".remTelefone", function (e) {
                e.preventDefault();
                $(this).parent('div').remove();
                xTelPF--;
            });

            $(base).on("click", ".remAdd", function (e) {
                e.preventDefault();
                document.getElementById("outrosanexos").innerHTML = '';
                document.getElementById("anexo[]").disabled = true;
                document.getElementById("anexo[]").required = false;

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
                document.getElementById('anexo[]').disabled = false;
                document.getElementById("anexo[]").required = true;

                document.getElementById('temp').id = 'addarquivoAnexo';
                document.getElementById("addarquivoAnexo").className = "addarquivoAnexo btn btn-primary";

                document.getElementById("removeadd").className = "col-md-2 remAdd";
                document.getElementById("remgeral").className = "btn btn-danger";
                document.getElementById("remgeral").innerHTML = "<span class=\"glyphicon glyphicon-trash\"></span>";
                xTelPF = 1;
                hab = 1;
            });

        });

    </script>

    <script type="text/javascript">
        //passar financiador, ano convenio, número convenio para plano de trabaho ao salvar
        $('#btn_plan').click(function () {
            $id_financiador = document.getElementById('$id_financiador').value;
            $ano_convenio = document.getElementById('$ano_convenio').value;
            $nr_convenio = document.getElementById('$ano_convenio').value;
            window.open('<?php echo url('/contacorrente') ?>/'+$id_pessoa,'_blank');
        });
    </script>

    <script type="text/javascript">
        $('.change-event').change(function (event) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var id_financiador = $('#id_financiador option:selected').val();
            var ano_convenio = document.getElementById('ano_convenio').value;
            var nr_convenio = document.getElementById('nr_convenio').value;
            $.ajax({
                type: 'POST',
                url: '{{url("convenio/ajaxVerificaConv")}}',
                data: {_token: csrf_token, id_financiador: id_financiador, ano_convenio: ano_convenio,
                    nr_convenio: nr_convenio},
                dataType:"json"
            }).done(function (data) {
                console.log(data);
                if (data != 0) {
                    window.location.href = ano_convenio+"/"+nr_convenio+"/"+id_financiador+"/editar";
                }
            }).error(function (data) {
            });
        });
    </script>

    <script>
        $().ready(function () {
            $.validator.addMethod("dateBR", function(value, element) {
                if(value == "") return true;
                if(value.length!=10) return false;
                // verificando data
                var data       = value;
                var dia         = data.substr(0,2);
                var barra1   = data.substr(2,1);
                var mes        = data.substr(3,2);
                var barra2   = data.substr(5,1);
                var ano         = data.substr(6,4);
                if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)return false;
                if((mes==4||mes==6||mes==9||mes==11) && dia==31)return false;
                if(mes==2 && (dia>29||(dia==29 && ano % 4 != 0 || ano % 100 == 0 && ano % 400 != 0)))return false;
                if(ano < 1900)return false;
                return true;
            }, "Informe uma data válida"); // Mens

            $.validator.addMethod("datamaiorigualque", function(value, element,target) {
                        var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
                        var anotherValue = element.min;

                        if( re.test(value) && re.test(anotherValue) ){
                            var adata = value.split('/');
                            var gg = parseInt(adata[0],10);
                            var mm = parseInt(adata[1],10);
                            var aaaa = parseInt(adata[2],10);
                            var xdata = new Date(aaaa,mm-1,gg);

                            var adata = anotherValue.split('/');
                            var gg = parseInt(adata[0],10);
                            var mm = parseInt(adata[1],10);
                            var aaaa = parseInt(adata[2],10);
                            var ydata = new Date(aaaa,mm-1,gg);

                            if ( ydata < xdata )
                                check = true;
                            else
                                check = false;
                        } else
                            check = false;
                        return this.optional(element) || check;
                    },
                    'A data deve ser maior que a do campo anterior.'); //mensagem padrão

            $("#signupForm").validate({
                rules: {
                    id_financiador: "required",
                    nr_convenio: "required",
                    ano_convenio: "required",
                    nr_protocolo: "required",
                    nr_processo: "required",
                    ano_processo: "required",
                    id_categoria: "required",
                    ds_objeto: "required",
                    ds_sigla_objeto: "required",
                    nr_sit_tce: "required",
                    vl_convenio: "required",
                    idcontas_plano_contabil: "required",
                    idcontas_plano_banco: "required",
                    dt_inicio: {
                        required: true,
                        dateBR:true
                    },
                    dt_limite_execucao: {
                        required: true,
                        dateBR:true,
                        datamaiorigualque :true

                    },
                    dt_prest_contas: {
                        required: true,
                        dateBR:true,
                        datamaiorigualque :true

                    },
                    dt_limite_vigencia: {
                        required: true,
                        dateBR:true,
                        datamaiorigualque :true
                    },
                    ds_resumo_plano: "required"
                },
                messages: {
                    id_financiador: "Campo obrigatório",
                    nr_convenio: "Campo obrigatório",
                    ano_convenio: "Campo obrigatório",
                    nr_protocolo: "Campo obrigatório",
                    nr_processo: "Campo obrigatório",
                    ano_processo: "Campo obrigatório",
                    id_categoria: "Campo obrigatório",
                    ds_objeto: "Campo obrigatório",
                    ds_sigla_objeto: "Campo obrigatório",
                    nr_sit_tce: "Campo obrigatório",
                    vl_convenio: "Campo obrigatório",
                    idcontas_plano_contabil: "Campo obrigatório",
                    idcontas_plano_banco: "Campo obrigatório",
                    dt_inicio: {
                        required: "Campo obrigatório",
                        dateBR : "Formato dd/mm/aaaa"
                    },
                    dt_limite_execucao: {
                        required: "Campo obrigatório",
                        dateBR : "Formato dd/mm/aaaa",
                        datamaiorigualque: "Deve ser posterior a data início"
                    },
                    dt_prest_contas: {
                        required: "Campo obrigatório",
                        dateBR : "Formato dd/mm/aaaa",
                        datamaiorigualque: "Deve ser posterior a execução"
                    },
                    dt_limite_vigencia: {
                        required: "Campo obrigatório",
                        dateBR : "Formato dd/mm/aaaa",
                        datamaiorigualque: "Deve ser posterior a prestação de contas"
                    },
                    ds_resumo_plano: "Campo obrigatório"
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.closest('.has-error').find('.select2'));
                    } else if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-8").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-12").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-8").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-12").addClass("has-success").removeClass("has-error");
                }
            });


            // add valid and remove error classes on select2 element if valid
            $('.select').on('change', function() {
                if($(this).valid()) {
                    $(this).next('span').removeClass('has-error').addClass('valid');
                }
            });
        });

    </script>
@endsection
