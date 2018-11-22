@extends('app')
@section('content')
    <div class='container'>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="col-md-12" id="cabecalho">
          <div class="col-md-6">
            <h1>Convênio {{$convenio->ds_sigla_objeto}}</h1>
          </div>
          <div style="padding-top: 20px" class="col-md-6">
             <a href="{{route('ajuda')}}#convenio" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
          </div>
        </div>
        <br>
        {!! Form::open(['route'=>['convenio.atualizabanco', $convenio->ano_convenio,$convenio->nr_convenio,$convenio->id_financiador], 'method'=>'put', 'id'=> 'signupForm', 'files' =>true])!!}
        <div class="col-md-6">
            {!! Form::label('id_financiador','Financiador')!!}
            <select readonly name="id_financiador" class="form-control margin-bottom-10"  id="id_financiador">
                <option value="{{$financiador[0]['id_financiador']}}">{{$financiador[0]['nm_financiador']}}</option>
            </select>
        </div>

        <div class="col-md-2">
            {!! Form::label('nr_convenio','Número')!!}
            <input readonly type="number" id="nr_convenio" min="1" name="nr_convenio"
                   value="{{$convenio->nr_convenio}}" class="form-control"/>
        </div>

        <div class="col-md-2">
            {!! Form::label('ano_convenio','Ano')!!}
            <input readonly type="number" id="ano_convenio" min="1966" max="9999"
                   value="{{$convenio->ano_convenio}}" name="ano_convenio" class="form-control"/>
        </div>

        <div class="col-md-2">
            {!! Form::label('nr_protocolo','Número do protocolo')!!}
            <input type="number" id="nr_protocolo" min="1" name="nr_protocolo" value="{{$convenio->nr_protocolo}}"
                   class="form-control"/>
        </div>
        <div class="col-md-2">
            <br>
            {!! Form::label('nr_processo','Número do processo')!!}
            <input required type="number" id="nr_processo" min="1" value="{{$convenio->nr_processo}}"
                   name="nr_processo" class="form-control"/>
        </div>

        <div class="col-md-2">
            <br>
            {!! Form::label('ano_processo','Ano do processo')!!}
            <input required type="number" id="ano_processo" min="1966" max="9999" {{--placeholder=""--}}
            value="{{$convenio->ano_processo}}" name="ano_processo" class="form-control"/>
        </div>

        <div class="col-md-8">
            <br>
            {!! Form::label('id_categoria','Categoria')!!}
            <select required name="id_categoria" id="id_categoria" class="form-control">
                <option value="{{$categoria[0]['id_categoria']}}">{{$categoria[0]['ds_categoria']}}</option>
                @foreach($categorias as $categorias)
                    <option value="{{$categorias->id_categoria}}">{{$categorias->ds_categoria}}</option>
                @endforeach
            </select>
        </div>

        <!--Objeto Form input-->
        <div class="col-md-6">
            <br>
            {!! Form::label('ds_objeto','Objeto')!!}
            {!! Form::text('ds_objeto', $convenio->ds_objeto, ['class'=>'form-control'])!!}
        </div>

        <!--Sigla objeto Form input-->
        <div class="col-md-2">
            <br>
            {!! Form::label('ds_sigla_objeto','Sigla do objeto')!!}
            <input type="text" id="ds_sigla_objeto" name="ds_sigla_objeto" value="{{$convenio->ds_sigla_objeto}}"
                   class="form-control"/>
        </div>

        <!--nr_sit_tce ??????? Form input-->
        <div class="col-md-2">
            <br>
            {!! Form::label('nr_sit_tce','SIT')!!}
            <input required type="number" id="nr_sit_tce" min="1" max="99999999" value="{{$convenio->nr_sit_tce}}"
                   name="nr_sit_tce" class="form-control"/>
        </div>

        <div class="col-md-2">
            <br>
            {!! Form::label('vl_convenio','Valor do convênio')!!}
            <input required type="text" data-mask="#.##0,00" data-mask-reverse="true"
                   value="{{$convenio->vl_convenio}}" id="vl_convenio" name="vl_convenio" class="form-control"/>
        </div>

        <div class="col-md-3">
            <br>
            {!! Form::label('idcontas_plano','Conta Contábil')!!}
            <select required name="idcontas_plano_contabil" id="idcontas_plano_contabil" class="form-control">
                <option value="{{$cc[0]['idcontas_plano']}}">{{$cc[0]['cdred']}}</option>
                @foreach($contabils as $contabils)
                    <option value="{{$contabils->idcontas_plano}}">{{$contabils->cdred}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <br>
            {!! Form::label('idcontas_plano','Conta Contábil - Banco')!!}
            <select required name="idcontas_plano_banco" id="idcontas_plano_banco" class="form-control">
                <option value="{{$cb[0]['idcontas_plano']}}">{{$cb[0]['cdred']}}</option>
                @foreach($cons as $cons)
                    <option value="{{$cons->idcontas_plano}}">{{$cons->cdred}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 margin-bottom-5" id="dp1">
            <br>
            {!! Form::label('dt_inicio','Data de início')!!}
            <br><input id="dt_inicio" required value="{{$convenio->dt_inicio}}" class="form-control" data-mask="00/00/0000"  placeholder="__/__/____"
                       name="dt_inicio" type="text" onblur="limitedeexecucao()"/><br>
        </div>

        <div class="col-md-3 margin-bottom-5" id="dp2">
            <br>
            {!! Form::label('dt_limite_execucao','Data limite de execução')!!}
            <br><input id="dt_limite_execucao" required value="{{$convenio->dt_limite_execucao}}"
                       class="form-control" data-mask="00/00/0000"  type="text" placeholder="__/__/____" name="dt_limite_execucao" onblur="prestacaodecontas()"/><br>
        </div>

        <div class="col-md-3 margin-bottom-5" id="dp3">
            <br>
            {!! Form::label('dt_prest_contas','Data prestação de contas')!!}
            <br><input id="dt_prest_contas"  required class="form-control" data-mask="00/00/0000"  type="text" placeholder="__/__/____" value="{{$convenio->dt_prest_contas}}"
                       name="dt_prest_contas" onblur="limitevigencia()"/><br>
        </div>

        <div class="col-md-3 margin-bottom-5" id="dp4">
            <br>
            {!! Form::label('dt_limite_vigencia','Data limite de vigência')!!}
            <br><input id="dt_limite_vigencia" required value="{{$convenio->dt_limite_vigencia}}"
                       class="form-control" name="dt_limite_vigencia" type="text"/><br>
        </div>

        <div class="col-md-12">
            <br>
            {!! Form::label('ds_resumo_plano','Resumo do plano de trabalho')!!}
            {!! Form::textarea('ds_resumo_plano', $convenio->ds_resumo_plano, ['class'=>'form-control'])!!}
        </div>

        {{--Anexos--}}
        <div class="margin-bottom-5">
            <br>
            @if (!empty($anexo[0]))
                @foreach($anexo as $anexo)
                    <div style="display: none;" class="alert alert-success" role="alert" id="success_{{$anexo['id_anexo']}}">
                        <label class="alert-link">{{$anexo['ds_titulo_anexo']}} excluido com sucesso!</label>
                    </div>
                    <div class="col-md-12" id="{{$anexo['id_anexo']}}">
                        <div class="col-md-8">
                            <br>
                            <input disabled type="text" id="id_anexo" name="id_anexo"
                                   value="{{$anexo['ds_titulo_anexo']}}"
                                   class="form-control"/>
                            <br>
                        </div>
                        <div class="col-md-2"   >
                            <br>
                            <a class="btn btn-primary {{--pull-left--}}" href="#" onclick="window.open('/convenios/public/app/storage/uploads/{{$anexo['ds_titulo_anexo']}}', '_blank', 'fullscreen=yes'); return false;">
                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <br>
                            <a class="btn btn-danger {{--pull-right--}}" onclick="removediv({{$anexo['id_anexo']}})">
                                <span class="glyphicon glyphicon-trash " aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

            {{--Novos Anexos--}}
            <div class="anexo">
                <br>
                <br>
                <div class="arquivoAnexoPrincipal">
                    <div class="col-md-8 inputanexo" disabled="true">
                        {!! Form::label('anexo','Novos anexos:')!!}

                        <input {{--required--}}  name="anexo[]"  id="anexo[]" type="file" size="50" accept="application/pdf"
                               class="form-control" disabled="true">
                    </div>
                    <div  id="addanexo" class="col-md-2 addanexo disabled">
                        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                        <br>

                        <button type="button" id="addarquivoAnexo" class="addarquivoAnexo btn btn-primary {{--pull-left--}}">
                            <span class="glyphicon glyphicon-plus"></span>
                            {{--<span class="glyphicon glyphicon glyphicon-inbox"></span>--}}
                        </button>
                    </div>
                    <div id="removeadd" class="col-md-2 remAdd">
                        <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                        <br>
                        <button type="button" id="remgeral" class="btn btn-danger {{--pull-right--}}" data-toggle="tooltip"
                                data-placement="top"
                                title="Não anexar nenhum arquivo">
                            <span class="glyphicon glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                </div>
                <div id="outrosanexos" class="col-md-12 arqAnexo">
                </div>
            </div>
        </div>

        <div class="col-md-12" align="left">
            <br><br>
            <?php
                $ano = $convenio->ano_convenio;
                $nr = $convenio->nr_convenio;
                $f = $convenio->id_financiador;
            ?>

            <a href="{{ route('planodetrabalho', [$ano,$nr,$f])}}" class="btn btn-primary">&nbsp;Plano de Trabalho</a>
        </div>
        <br>
        <br>

        <!--Bot�o voltar-->
        <div class="col-md-1">
            {{--<label for="firstName" class="control-label"><font color="#F0F0F0"></font></label>--}}
            <br>
            <br>
            <a href="<?php echo url('convenio'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>

        <!--Bot�o-->
        <div class="col-md-2">
            <div class="form-group">
                <br>
                <br>
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </div>
        </div>
    {!! Form::close()!!}

    </div>
@endsection
@section('content_js')
    <script type="text/javascript">
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
            var wrapperTelPF = $('.arqAnexo');
            var add_buttonTelPF = $(".addarquivoAnexo");
            var base = $('.anexo');
            var xTelPF = 1;
            var hab = 1;

            $(add_buttonTelPF).click(function (e) {
                document.getElementById("anexo[]").disabled = false;
                document.getElementById("anexo[]").required = true;

            });
            /*     //add campo pra add mais 1 anexo
             if (hab == 1) {
             e.preventDefault();
             console.log("1");
             $(wrapperTelPF).append('<div class=\"col-lg-12\"><div class=\"col-lg-7\"><label for=\"firstName\" class=\"control-label\"><font color=\"#F0F0F0\">.</font></label><input required name=\"anexo[]\" id=\"anexo[]\" type=\"file\" class=\"form-control\" size=\"50\" accept=\"application/pdf\"></div><div class=\"remTelefone col-lg-1\"><br><button class=\"btn btn-danger\" type=\"button\"><span class=\"glyphicon glyphicon-minus\"></span></button></div></div>');
             xTelPF++;
             }
             });*/

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
                document.getElementById("anexo[]").disabled = true;
                document.getElementById("anexo[]").required = false;

                /*document.getElementById("addarquivoAnexo").className = "btn btn-default";
                 document.getElementById('addarquivoAnexo').id = 'temp';*/

                // botão remove vira plus
                /*document.getElementById("removeadd").className = "col-md-2 addAdd";
                 document.getElementById("remgeral").className = "btn btn-success";
                 document.getElementById("remgeral").innerHTML = "<span class=\"glyphicon glyphicon glyphicon-plus disabled\"></span>";*/
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
                document.getElementById("remgeral").innerHTML = "<span class=\"glyphicon glyphicon glyphicon-remove\"> </span>";
                xTelPF = 1;
                hab = 1;
            });
        });

    </script>
    <script>
        $().ready(function () {
            $.validator.addMethod("dateBR", function(value, element) {
                if(value == "") return true;
                if(value.length!=10) return false;
                // verificando data
                var data        = value;
                var dia         = data.substr(0,2);
                var barra1      = data.substr(2,1);
                var mes         = data.substr(3,2);
                var barra2      = data.substr(5,1);
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
