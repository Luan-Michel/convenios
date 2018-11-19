@extends('app')

@section('content')
    <div class="container">
      <div class="col-md-12" id="cabecalho">
        <div class="col-md-6">
          <h1>Categoria de convênio</h1>
        </div>
        <div style="padding-top: 20px" class="col-md-6">
           <a href="{{route('ajuda')}}#categoria" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
        </div>
      </div>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
        @endif


        {!! Form::open(['route'=>'categoriaconvenio.store', 'id'=>'signupForm'])!!}
    <!--Nome Form input-->
        <div class="col-md-12">
            {!! Form::label('ds_categoria','Nome') !!}
            {!! Form::text('ds_categoria', null, ['class'=>'form-control'])!!}
        </div>

        <!--Bot�o-->
        <div class="col-md-3">
            <br><br>
            {!!Form::submit('Salvar Categoria de convênio', ['id'=>'save','class'=>'btn btn-success'])!!}
        </div>
        {!!Form::close()!!}
        <div class="col-md-3">

            <br><br>
            <div class="col-md-1" align="left">
                <a href="<?php echo url('categoriaconvenio'); ?>">
                    {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
                </a>
              </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br>
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
@endsection
