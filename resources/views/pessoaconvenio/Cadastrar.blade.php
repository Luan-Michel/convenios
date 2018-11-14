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
        <h1>Incluir Participante</h1>
        <br>
        {!! Form::open(['route'=>'pessoaconvenio.store', 'files' =>true])!!}

        <link href="{{asset('select2-4.0.6-rc.1/dist/css/select2.min.css')}}" rel="stylesheet" />
        <script src="{{asset('select2-4.0.6-rc.1/dist/js/select2.min.js')}}"></script>

        <div class=" col-md-5 " name="div_pessoa" id="div_pessoa">
            {!! Form::label('busca','Nome')!!}
            <input required type="text" name="busca" id="busca" class="form-control">
            <select required name="id_pessoa_participante" disabled style="display:  none;"
                    id="id_pessoa_participante" class="form-control">
            </select>
            <br><br>
        </div>

        <a id="button_search"  name="button_search" class="btn btn-primary glyphicon glyphicon-search  " style="margin-top: 2%;"   ></a>
        <a id="button_refresh" name="button_refresh" class="btn btn-success glyphicon glyphicon-refresh " style="margin-top: 2%;" ></a>

        <div class="col-md-6  pull-right">
            {!! Form::label('cd_coordenador','Coordenador')!!}
            <select class="form-control" id="cd_coordenador" name="cd_coordenador">
              <option selected value="N">Não</option>
              <option value="S">Sim</option>
            </select>
            <br><br>
        </div>

        <div class="col-md-6  pull-right">
            {!! Form::label('cd_categoria','Categoria')!!}
            <select class="form-control" id="cd_categoria" name="cd_categoria">
              <option selected value="S">Servidor</option>
              <option value="A">Acadêmico</option>
              <option value="C">Convidado</option>
            </select>
            <br><br>
        </div>

        <div class=" col-md-6">
            {!! Form::label('id_convenio', 'Convenio')!!}
            <select class="form-control js-example-basic-single" id="id_convenio" name="id_convenio">
              <option value=""></option>
              @foreach($convenio as $c)
                  <option value="{{$c->id_convenio}}">{{$c->ds_sigla_objeto}}</option>
              @endforeach
            </select>
        </div>

        <div class="col-md-6">
            {!! Form::label('cnpj_instituicao','CNPJ-Instituição')!!}
            <input required name="cnpj_instituicao" id="cnpj_instituicao" class="form-control"
                   data-mask="00.000.000/0000-00" data-mask-revers="true"
                   onchange=" nome_inst()">
            <br><br>
        </div>

        <div class="col-md-6">
            {!! Form::label('id_pessoa_instituicao','Instituição')!!}
            <input  disabled name="instituicao" id="instituicao" class="form-control">
            <input  type="hidden" name="id_pessoa_instituicao" id="id_pessoa_instituicao" class="form-control">

            <br><br>
        </div>

    </div>

    <div class="container">
        <div class="col-md-12" align="left">
            <a href="{{ route('pessoa.adicionarpessoafisica')}}" class="btn btn-default"><i
                        class="glyphicon glyphicon-plus"></i>&nbsp; Pessoa Física</a>
            <a href="{{ route('pessoa.adicionarinstituicao')}}" class="btn btn-default"><i
                        class="glyphicon glyphicon-plus"></i>&nbsp; Pessoa Jurídica</a>
        </div>
        <!--Botão-->
        <div class="col-md-4">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <div class="form-group">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </div>
        </div>
    {!! Form::close()!!}

    <!--Botão voltar-->
        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="{{ url('pessoaconvenio') }}">
                {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
            </a>
        </div>

        <br><br><br>


    </div>
@endsection
@section('content_js')
    <script type="text/javascript">
          // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
          $('.js-example-basic-single').select2();
        });

        function nome_inst() {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            console.log(csrf_token);
            var cnpj = document.getElementById('cnpj_instituicao').value;
            console.log(cnpj);
            $.ajax({
                type: 'get',
                url: '{{url("pessoaconvenio/ajaxInst")}}',
                data: {'X-CSRF-TOKEN': csrf_token, cnpj: cnpj},
                dataType: "json"
            }).done(function (data) {
                console.log(data);
                document.getElementById('instituicao').value=data.nm_pessoa_abreviado;
                document.getElementById('id_pessoa_instituicao').value=data.id_pessoa;
            }).fail(function (data) {
                document.getElementById('instituicao').value="CNPJ NÃO CADASTRADO!";
                document.getElementById('id_pessoa_instituicao').value="";
                // $("#id_pessoa_instituicao").empty();

            });
        }

        $('#button_search').click( function () {

            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var search = $('#busca').val();
            var busca = document.getElementById('busca');
            var participante = document.getElementById('id_pessoa_participante');
            if ((search.length) > 2) {
                $.ajax({
                    type: 'get',
                    url: '{{url("pessoa/ajaxPesquisaPessoa")}}',
                    data: {'X-CSRF-TOKEN': csrf_token, search: search},
                    dataType: "json"
                }).done(function (data) {
                    $(participante).removeAttr("disabled");
                    $(participante).empty();
                    //$(participante).append('<option value="">' + 'Clique para escolher' +  '</option>');
                    //$(participante).append('<option value="">' + 'Clique para escolher' +  '</option>');
                    $(busca).hide();
                    $(participante).show();

                    for (var i = 0; i < data.length; i++) {
                        if (data[i].cpf != null) {
                            $('#id_pessoa_participante').append($('<option>', {
                                        value: data[i].id_pessoa,
                                        text: data[i].nm_pessoa_completo
                                    },'</option>'
                                    )
                            );
                        }
                    }
                }).error(function (data) {
                    $("#id_pessoa_participante").empty();
                });
            }
        });

        $( "#button_refresh" ).click(function() {
            var busca = document.getElementById('busca');
            var participante = document.getElementById('id_pessoa_participante');
            $(participante).empty();
            $(participante).disabled = true;
            $(participante).hide();
            $(busca).show();
        })
    </script>
@endsection
