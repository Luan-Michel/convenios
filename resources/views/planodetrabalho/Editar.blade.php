@extends('app')
@section('content')
    @if(Session::get('success'))

        <div align="center" class="alert alert-success">
            <strong>{{Session::get('success')}}</strong>
        </div>
    @endif

    <div class='container'>
        <h1>Meta: {{$planodetrabalho->ds_titulo_meta_aplic}}</h1>

        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>
    @endif

    {!!Form::open(['route'=>['planodetrabalho.atualizabanco', $planodetrabalho->id_aplicacao], 'method'=>'put'])!!}

    <!--Nome Form input-->
        <div class="col-md-12">
            <!--Convênio-->
            <div class="col-md-12">
                {!! Form::label('nr_convenio', 'Convênio')!!}
                <select required readonly name="nr_convenio" class="form-control margin-bottom-10" id="nr_convenio">
                    <option value="{{$convenio->nr_convenio}}|{{$convenio->ano_convenio}}">{{$convenio->ds_sigla_objeto}}</option>
                </select>
            </div>
            <!--Sequencia meta aplicativo Form input-->
            <!--Titulo convenio Form input-->
            <div class="col-md-6">
                {!! Form::label('ds_titulo_meta_aplic','Título')!!}
                {!! Form::text('ds_titulo_meta_aplic', $planodetrabalho->ds_titulo_meta_aplic, ['class'=>'form-control'])!!}
            </div>
            <!--Datas inicio e fim-->
            <div id="datepairExample">
                <div class="col-md-3 margin-bottom-5" id="dp1">
                    <label for="firstName" class="control-label">Data de Início</label>
                    <br><input id="dt_inicio_meta" value="{{$planodetrabalho->dt_inicio_meta}}" required
                               onkeypress="return false" name="dt_inicio_meta" type="text" class="date start"/><br>
                </div>
                <div class="col-md-3 margin-bottom-5" id="dp2">
                    <label for="lastName" class="control-label">Data de Término</label>
                    <br><input id="dt_termino_meta" value="{{$planodetrabalho->dt_termino_meta}}" required
                               onkeypress="return false" name="dt_termino_meta" type="text" class="date end"/><br>
                </div>
            </div>
            <br>
            <!--Meta Form input-->
            <div class="form-group">
                <label class="col-md-12 control-label" for="textarea"><br>Descrição</label>
                <div class="col-md-6">
                    <textarea class="form-control" rows="4" required type="text" id="ds_meta_aplic" name="ds_meta_aplic">{{$planodetrabalho->ds_meta_aplic}}</textarea>
                </div>
            </div>

            <div class="col-md-3">
                <br><br>
                {{--wagner resolver dependencia rota.adicionar referente a cada pessoa--}}
                <a href="{{ route('etapaplanodetrabalho.Cadastrar')}}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>&nbsp;Etapa plano de trabalho</a>

            </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <br>
                    <br>
                    {!!Form::submit('Salvar Plano de Trabalho', ['class'=>'btn btn-success'])!!}
                </div>
                {!!Form::close()!!}

                <div class="col-md-3">
                    <br>
                    <br>
                    <a href="{{ route('planodetrabalho',[$planodetrabalho->ano_convenio,$planodetrabalho->nr_convenio,$planodetrabalho->id_financiador])}}"class="btn btn-warning">&nbspVoltar</a>
                </div>
            </div>
            <br><br><br><br><br><br>
        </div>
    </div>
@endsection

@section('content_js')
    <script type="text/javascript">
        function selectconvenios() {
            $("#ano_convenio").attr("required", false);
            $("#nr_convenio option").remove();
            var id_fin = $("#id_financiador").val();
            $.get("../../convenio/financiador/" + id_fin, {id: id_fin}).done(function (data, status) {
                console.log(data);
                for (i = 0; i < data.length; ++i) {
                    var nr_conv = (data[i].nr_convenio);
                    var ano_conv = (data[i].ano_convenio).required=false;
                    var ds_sigla = (data[i].ds_sigla_objeto);
                    var traco = "   -   ";
                    if (nr_conv == null || ds_sigla == null) {
                        $("#nr_convenio").attr("disabled", true);
                        $('#nr_convenio').append($('<option>', {
                            text: "Nenhum convênio encontrado!"
                        }));
                    } else {
                        var res = nr_conv.concat(traco);
                        var result = res.concat(ds_sigla);
                        $("#nr_convenio").attr("disabled", false);
                        $('#nr_convenio').append($('<option>', {
                            value: nr_conv + '|' + ano_conv,
                            text: result
                        }));
                    }
                }

            });
        }

        $('#dp1 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});
        $('#dp2 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});

        function termino() {
            var valorselecionado = $("#dt_inicio_meta").val();
            $('#dp2 .date').datepicker('setStartDate', valorselecionado);
            $('#dp2 .date').datepicker('update', valorselecionado);
        }


    </script>

@endsection
