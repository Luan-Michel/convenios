@extends('app')
@section('content')
    @if(Session::has('message_editar'))
        <div align="center" class="alert alert-danger">
            <strong>{{Session::get('message_editar')}}</strong>
        </div>
    @endif
    @if($errors->any())
        <ul class="alert alert-warning">
            @foreach($errors->all()as$error)
                <li>{{ $error}}</li>
            @endforeach
        </ul>
    @endif
    <div class='container'>
        <div class="col-md-6">
          <h1>Financiador</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#financiador" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>

        {!!Form::open(['route'=>['financiador.atualizabanco', $financiador->id_financiador], 'id'=>'signupForm', 'method'=>'put'])!!}

    <!--Nome Form input-->
        <div class="col-md-12">
            {!!Form::label('nm_financiador','Nome:')!!}
            <input type="text" class="form-control" value="{{$financiador->nm_financiador}}" {{--disabled--}} name="nm_financiador" id="nm_financiador">
        </div>

        <!--Sigla Form input-->
        <div class="col-md-6" style="margin-top: 15px">
            {!!Form::label('ds_sigla_financiador','Sigla:')!!}
            {!!Form::text('ds_sigla_financiador', $financiador->ds_sigla_financiador,['class'=>'form-control'])!!}

        </div>

        <!--Esfera Form input-->
        <div class="col-md-6" style="margin-top: 15px">
            {!! Form::label('tp_esfera','Esfera')!!}
            <select required name="tp_esfera" id="tp_esfera" class="form-control">
                <option value="E" {{ ($financiador->tp_esfera == "E" || $financiador->tp_esfera == "e") ? 'selected' : '' }}>Estadual</option>
                <option value="F" {{ ($financiador->tp_esfera == "F" || $financiador->tp_esfera == "f") ? 'selected' : '' }}>Federal</option>
                <option value="I" {{ ($financiador->tp_esfera == "I" || $financiador->tp_esfera == "i") ? 'selected' : '' }}>Internacional</option>
            </select>
        </div>

        <!--Form valida convenio-->
        <div class="col-md-0">
            <br>
            {!! Form::label('','')!!}
            <input type="hidden"id="validaconv" name="validaconv" value="{{$possuiconv}}" class="form-control validaconv" >
        </div>

        <div class="col-md-2" style="margin-top: 15px">
            <br>
            <div class="form-group">
                {!!Form::submit('Salvar Financiador', ['id'=>'save','class'=>'btn btn-success'])!!}
            </div>
        </div>
        {!!Form::close()!!}

        <div class="col-md-1" style="margin-top: 15px">
            <br>
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
    <script type="text/javascript">
        $().ready(function () {
            var valida = document.getElementById("validaconv").value;
            console.log(valida);

            if(valida == 1){
                document.getElementById('save').disabled = true;
                document.getElementById('save').className = " btn btn-danger";
            }
        })

    </script>

@endsection
