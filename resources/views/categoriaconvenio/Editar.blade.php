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
        <h1>Categoria de convênio{{-- {{$categoria->ds_categoria}}--}}</h1>



    {!!Form::open(['route'=>['categoriaconvenio.atualizabanco', $categoria->id_categoria], 'id'=>'signupForm','method'=>'put'])!!}

    <!--Nome Form input--><br>
        <div class="col-md-12">
            {!!Form::label('ds_categoria','Nome:')!!}
            {!!Form::text('ds_categoria', $categoria->ds_categoria,['class'=>'form-control'])!!}
        </div>

        <!--Form valida convenio-->
        <div class="col-md-0">
            <br>
            {!! Form::label('','')!!}
            <input type="hidden"id="validaconv" name="validaconv" value="{{$possuiconv}}" class="form-control validaconv" >
        </div>

        <div class="col-md-3">
            <br><br>
            {!!Form::submit('Salvar Categoria de convênio', ['id'=>'save','class'=>'btn btn-success'])!!}
        </div>
        {!!Form::close()!!}
        <div class="col-md-3">

            <br><br>

            <a href="<?php echo url('categoriaconvenio'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
            </a>
        </div>
        <br><br><br><br><br><br>
    </div>
@endsection
@section('content_js')
    <script type="text/javascript">
        $().ready(function () {
            $("#signupForm").validate({
                rules: {
                    ds_categoria: "required"
                },
                messages: {
                    ds_categoria: "Informar o nome da categoria.",
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
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-12").addClass("has-success").removeClass("has-error");
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
