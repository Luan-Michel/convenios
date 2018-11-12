@extends('app')
@section('content')
    @if(Session::has('success'))
        <div align="center" class="alert alert-success">
            <strong>{{Session::get('success')}}</strong>
        </div>
    @endif
    <div class="container">
        <h1>Plano de trabalho</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        @endif
        <br>
    {!! Form::open(['route'=>'planodetrabalho.store'])!!}
    <!--Financiador-->
        <div class="col-md-12">
            <!--Convênio-->
            <div class="col-md-6">
                {!! Form::label('nr_convenio', 'Convênio')!!}
                @if(isset($conv))
                    <select required readonly="" name="nr_convenio" class="form-control margin-bottom-10" id="nr_convenio">
                        <option value="{{$conv}}/{{ $ano}}">{{$conv}}/{{ $ano}}</option>
                    </select>
                @elseif($ano_convenio != null)
                    <select required readonly="" name="nr_convenio" class="form-control margin-bottom-10" id="nr_convenio">
                        <option value="{{$nr_convenio}}/{{ $ano_convenio}}">{{$nr_convenio}}/{{ $ano_convenio}}</option>
                    </select>
                @else
                    <select required name="nr_convenio" class="form-control margin-bottom-10" id="nr_convenio">
                        <option value=""></option>
                    </select>

                @endif
            </div>
            <!--Sequencia meta aplicativo Form input-->
            <div class="col-md-6">
                {!! Form::label('seq_meta_aplic','Sequência meta aplicação')!!}
                {!! Form::number('seq_meta_aplic', null, ['class'=>'form-control', 'min'=>'0'])!!}
            </div>
            <!--Titulo convenio Form input-->
            <div class="col-md-6">
                {!! Form::label('ds_titulo_meta_aplic','Título meta aplicação')!!}
                {!! Form::text('ds_titulo_meta_aplic', null, ['class'=>'form-control'])!!}
            </div>
            <!--Datas inicio e fim-->
            <div class="col-md-3 margin-bottom-5" id="dp1">
                <label for="firstName" class="control-label">Início da meta</label>
                <br><input id="dt_inicio_meta" required class="date" name="dt_inicio_meta" type="text"  onchange="termino()"/><br>
            </div>
            <div class="col-md-3 margin-bottom-5" id="dp2">
                <label for="lastName" class="control-label">Término da meta</label>
                <br><input id="dt_termino_meta" required class="date" name="dt_termino_meta" type="text"  /><br>
            </div>
            <br>
            <!--Meta Form input-->
            <div class="form-group">
                <label class="col-md-12 control-label" for="textarea"><br>Meta aplicação</label>
                <div class="col-md-12">
                    <textarea class="form-control" required type="text" id="ds_meta_aplic" name="ds_meta_aplic"></textarea>
                </div>
            </div>

            <br><br>

            <div class="col-md-3">
                <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
                <div class="form-group">
                    <a href="<?php echo url('pessoaconvenio'); ?>">
                        {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
                    </a>
                </div>
            </div>

            {!! Form::close()!!}
            <div class="col-md-1">
                <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label><br>
                <a href="{{ route('planodetrabalho',[$ano,$conv,$fin[0]->id_financiador])}}"class="btn btn-primary">&nbspVoltar</a>

            </div>

        </div>
    </div>
@endsection

@section('content_js')
    <script >

        //    $('#id_financiador').selectize({
        //        create: true,
        //        sortField: {
        //            field: 'text',
        //            direction: 'asc'
        //        },
        //        dropdownParent: 'body'
        //    });
        //
        //    $('#nr_convenio').selectize({
        //        create: true,
        //        sortField: {
        //            field: 'text',
        //            direction: 'asc'
        //        },
        //        dropdownParent: 'body'
        //    });


        $('#dp1 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});
        $('#dp2 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});

        function termino(){
            var valorselecionado = $("#dt_inicio_meta").val();
            $('#dp2 .date').datepicker('setStartDate', valorselecionado);
            $('#dp2 .date').datepicker('update', valorselecionado);
        }
        function selectconvenios(){
            $( "#nr_convenio option").remove();
            var id_fin = $("#id_financiador").val();
            $.get("../convenio/financiador/"+id_fin, {id : id_fin}).done(function(data, status){
                console.log(data);
                for (i = 0; i < data.length; ++i) {
                    var nr_conv = (data[i].nr_convenio);
                    var ano_conv = (data[i].ano_convenio);
                    var ds_sigla = (data[i].ds_sigla_objeto);
                    var traco = "   -   ";
                    if(nr_conv == null || ds_sigla == null){
                        $("#nr_convenio").attr("disabled", true);
                        $('#nr_convenio').append($('<option>', {
                            text : "Nenhum convênio encontrado!"
                        }));
                    }else{
                        var res = nr_conv.concat(traco);
                        var result = res.concat(ds_sigla);
                        $("#nr_convenio").attr("disabled", false);
                        $('#nr_convenio').append($('<option>', {
                            value: nr_conv+ '|' +ano_conv ,
                            text : result
                        }));
                    }
                }
            });
        }
    </script>
@endsection
