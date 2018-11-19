@extends('app')
@section('content')
    <div class="container">
        <div class="col-md-6">
          <h1>Financiador</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#financiador" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        @endif

    {!! Form::open(['route'=>'financiador.store', 'id'=>'signupForm'])!!}

    <!--Nome Form input-->
        <div class="form-group">
            <label class="col-md-12 control-label" for="textinput">Nome do Financiador</label>
            <div class="col-md-12">
                <input type="text" id="nm_financiador" name="nm_financiador" class="form-control nm_financiador">

            </div>
        </div>

        <!--Sigla Form input-->
        <div class="col-md-6">
            <br>
            {!! Form::label('ds_sigla_financiador','Sigla')!!}
            <input id="ds_sigla_financiador" name="ds_sigla_financiador" class="form-control ds_sigla_financiador" type="text">
        </div>

        <!--Esfera Form input-->
        <div class="col-md-6">
            <br>
            {!! Form::label('tp_esfera','Esfera')!!}
            <select name="tp_esfera" class="form-control tp_esfera">
                <option value=""></option>
                <option value="E">Estadual</option>
                <option value="F">Federal</option>
                <option value="I">Internacional</option>
            </select>
        </div>

        <!--Form valida convenio-->
        <div class="col-md-0">
            <br>
            {!! Form::label('','')!!}
            <input type="hidden"id="validaconv" name="validaconv" class="form-control validaconv" >
        </div>

        <!--Bot�o-->
        <div class="col-md-2">
            <br>
            <label for="firstName" class="control-label">{{--<font color="#F0F0F0">.</font>--}}</label>
            <div class="form-group">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </div>
        </div>

        <!--Bot�o voltar-->
        <div class="col-md-1">
            <br>
            <label for="firstName" class="control-label">{{--<font color="#F0F0F0">.</font>--}}</label>
            <a href="<?php echo url('financiador'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>
    </div>
@endsection

@section('content_js')
    <script type="text/javascript">
        $().ready(function () {
            $("#signupForm").validate({
                rules: {
                    nm_financiador: "required",
                    ds_sigla_financiador: "required",
                    tp_esfera: "required"
                },
                messages: {
                    nm_financiador: "Informar o nome do financiador.",
                    ds_sigla_financiador: "Informar a sigla do financiador.",

                    tp_esfera: "Informar a esfera de atuação do financiador."
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
                    $(element).parents(".col-md-12").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-12").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
                }
            });
        });

        // add valid and remove error classes on select2 element if valid
        $('.select').on('change', function () {
            if ($(this).valid()) {
                $(this).next('span').removeClass('has-error').addClass('valid');
            }
        });
    </script>

@endsection
