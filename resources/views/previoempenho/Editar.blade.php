@extends('app')
@section('content')
    <div class="container">
        <h1>Prévio Empenho</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
            @endif
            <br>
            {!!Form::open(['route'=>['previoempenho.atualizabanco', $previoempenho[0]->nr_rpe], 'method'=>'put'])!!}
            <div class="col-md-2">
                {!! Form::label('ano_rpe','Ano do prévio')!!}
                <input required readonly type="number" id="ano_rpe" min="2010" value="{{$previoempenho[0]['ano_rpe']}}" max="{{ date("Y") }}" placeholder="" name="ano_rpe" class="form-control"/>
            </div>
            <div class="col-md-2">
                {!! Form::label('nr_rpe','Número do prévio')!!}
                <input required readonly type="number" id="nr_rpe" min="1" name="nr_rpe" value="{{$previoempenho[0]['nr_rpe']}}" class="form-control"/>
            </div>
            <div class="col-md-3">
                {!! Form::label('cd_tpcompra','Tipo compra')!!}
                <select required name="cd_tpcompra" id="cd_tpcompra" class="form-control">
                    <option value="{{$cd[0]['CD_TPCOMPRA']}}">{{$cd[0]['DS_TPCOMPRA']}}</option>
                    @foreach($cd_tpcompra as $aux)
                        <option value="{{$aux->CD_TPCOMPRA}}">{{$aux->DS_TPCOMPRA}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                {!! Form::label('cd_fonte','Fonte')!!}
                <select required id="cd_fonte" name="cd_fonte" class="form-control margin-bottom-10" >
                    <option value="{{$cd_fonte[0]['CD_FONTE']}}">{{$cd_fonte[0]['NM_FONTE']}}</option>
                    @foreach($fonte as $aux)
                        <option value="{{$aux->CD_FONTE}}">{{$aux->NM_FONTE}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                {!! Form::label('ano_convenio','Ano do convênio')!!}
                <select required type="number" id="ano_convenio" min="2000" max="{{ date("Y") }}" placeholder="" name="ano_convenio"
                        class="form-control change-event">
                <option value="{{$financiador[0]->ano_convenio}}">{{$financiador[0]->ano_convenio}}</option>
                @foreach($convenios as $ano_convenio)
                    <option value="{{$ano_convenio->ano_convenio}}">{{$ano_convenio->ano_convenio}}</option>
                    @endforeach
                    </select>
            </div>
            <div class="col-md-6"><br>
                {!! Form::label('id_financiador','Financiador')!!}
                <select required name="id_financiador" class="form-control margin-bottom-10 change-event" id="id_financiador">
                    <option value="{{$financiador[0]->id_financiador}}">{{$financiador[0]->nm_financiador}}</option>
                    @foreach($financiadores as $aux)
                        <option value="{{$aux->id_financiador}}">{{$aux->nm_financiador}}</option>
                    @endforeach
                </select>
            </div>
            <!--Numero convenio Form input-->
            <div class="col-md-2"> <br>
                {!! Form::label('nr_convenio','Número do Convênio')!!}
                <select required id="nr_convenio" placeholder="" name="nr_convenio" class="form-control change-event">
                <option value="{{$financiador[0]->nr_convenio}}">{{$financiador[0]->nr_convenio}}</option>
                @foreach($convenios as $nr_convenio)
                    <option value="{{$nr_convenio->nr_convenio}}">{{$nr_convenio->nr_convenio}}</option>
                    @endforeach
                    </select>
            </div>
            <div class="col-md-4"> <br>
                {!! Form::label('id_etapa_aplic','Etapa aplicação')!!}
                <select required id="id_etapa_aplic" name="id_etapa_aplic" class="form-control margin-bottom-10"  onchange="populapessoa()">
                    <option value="{{$aplic[0]['id_etapa_aplic']}}">{{$aplic[0]['ds_titulo_etapa']}}</option>
                    @foreach($aplicgeral as $aux)
                        <option value="{{$aux->id_etapa_aplic}}">{{$aux->ds_titulo_etapa}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <br>
                {!! Form::label('tp_beneficiario','Tipo beneficiário')!!}
                <select required name="tp_beneficiario" class="form-control margin-bottom-10" id="tp_beneficiario">
                    <option value="{{$tp_beneficiario}}">{{$tp_beneficiario}}</option>
                    <option value="A">Acadêmico</option>
                    <option value="C">Convidado</option>
                    <option value="S">Servidor</option>
                </select>
            </div>
            <div class="col-md-6">
                <br>
                {!! Form::label('id_pessoa','Nome beneficiário')!!}
                <select required name="id_pessoa" class="form-control margin-bottom-10 " id="id_pessoa"
                        onchange="limpaconta()">
                    <option value="{{$pessoa[0]->id_pessoa}}">{{$pessoa[0]->nm_pessoa_completo}}</option>
                </select>
            </div>
            <div class="col-md-4">
                <br>
                {!! Form::label('seq_bancario','Conta corrente')!!}
                <select required id="seq_bancario" name="seq_bancario" class="form-control margin-bottom-10">
                    <option value="{{$cc[0]->seq_bancario}}">{{$cc[0]->seq_bancario}} - Nº banco: {{$cc[0]->nr_banco}} Ag: {{$cc[0]->nr_agencia}} C/C: {{$cc[0]->nr_conta}}-{{$cc[0]->nr_dac}}</option>
                    @foreach($ccgeral as $aux)
                        <option value="{{$aux->seq_bancario}}">{{$aux->seq_bancario}} - Nº banco: {{$aux->nr_banco}} Ag: {{$aux->nr_agencia}} C/C: {{$aux->nr_conta}}-{{$aux->nr_dac}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3" id="dp1">
                <br>
                {!! Form::label('dt_rpe','Data do prévio')!!}
                <br><input required id="dt_rpe"  value="{{$previoempenho[0]['dt_rpe']}}" class="date" name="dt_rpe" type="text"/><br>
            </div>


            <div class="col-md-2">
                <br>
                {!! Form::label('vl_previo_empenho','Valor do prévio')!!}
                <input required type="number"  value="{{$previoempenho[0]['vl_previo_empenho']}}" id="vl_previo_empenho" name="vl_previo_empenho" min="1" class="form-control"/>
            </div>
            <div class="col-md-4">
                <br>
                {!! Form::label('id_moeda','Moeda')!!}
                <select required name="id_moeda" class="form-control margin-bottom-10" id="id_moeda">
                    <option value="{{$moedap[0]->id_moeda}}">{{$moedap[0]->ds_moeda}}</option>
                    @foreach($moeda as $aux)
                        <option value="{{$aux->id_moeda}}">{{$aux->ds_moeda}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <br>
                {!! Form::label('tp_rpe','Tipo do prévio')!!}
                <select required name="tp_rpe" class="form-control margin-bottom-10" id="id_tp_rpe">
                    <option value="{{$tp_rpe}}">{{$tp_rpe}}</option>
                    <option value="A">Auxílio Financeiro</option>
                    <option value="D">Diaria</option>
                </select>
            </div>

        <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-12 control-label" for="textarea"><br>Objetivo do Prévio</label>
                <div class="col-md-12">
                    <textarea class="form-control" required type="text" id="ds_objetivo" name="ds_objetivo">{{$previoempenho[0]['ds_objetivo']}}</textarea>
                </div>
            </div>

            <!--Bot�o-->
            <div class="col-md-2">
                <br><br>
                <label for="firstName" class="control-label"></label>
                <a  id="btn_cc" value="conutacorrente" {{--target="_blank"--}}>
                    {!! Form::button ('Conta Corrente', ['class'=>'btn btn-warning'])!!}
                </a>

            </div>


            <div class="col-md-6" >
                {{--espaçamento entre botoões conta corrente e salvar--}}
                <br><br>
                <label for="firstName" class="control-label"></label>
            </div>
            <div class="col-md-2">
                <br><br>
                <label for="firstName" class="control-label"></label>
                {!!Form::submit('Salvar', ['class'=>'btn btn-success'])!!}

            </div>
            {!! Form::close()!!}

            <div class="col-md-2">
                <br><br><br>
                <label for="firstName" class="control-label"></label>
                <a href="<?php echo url('previoempenho'); ?>">
                    {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
                </a>
            </div>
    </div>
@endsection

@section('content_js')
    <script      type="text/javascript">
        //Ajax Etapa Aplicação
        $('.change-event').change(function (event) {
            event.preventDefault();
            var csrf_token = $('input[name="_token"]').val();
            var nr_convenio = $('#nr_convenio option:selected').val();
            var ano_convenio = $('#ano_convenio option:selected').val();
            var id_financiador = $('#id_financiador option:selected').val();
            console.log(nr_convenio);
            console.log(ano_convenio);
            console.log(id_financiador);
            console.log("cheguei aqui");
            $('#id_etapa_aplic').empty();
            $('#id_pessoa').empty();
            $('#seq_bancario').empty();
            $.ajax({
                method: 'POST',
                url: '{{url("previoempenho/ajaxEtapaAplic")}}',
                data: {_token: csrf_token, nr_convenio: nr_convenio, ano_convenio: ano_convenio,
                    id_financiador: id_financiador},
                dataType:"json",
            }).success(function (response) {
                console.log(response);
                console.log("cheguei bem");
                $('#id_etapa_aplic').empty();
                $('#id_etapa_aplic').append('<option value="">' + '' +  '</option>');
                $(response).each(function (num_objeto, objeto) {
                    //console.log(objeto);
                    $('#id_etapa_aplic').append('<option value='+objeto.id_etapa_aplic+'>' + objeto.ds_titulo_etapa +  '</option>');
                });
            }).error(function (response) {
                console.log("cheguei mal");
                $('#id_etapa_aplic').empty();

            });

        });
    </script>


    <script type="text/javascript">
        //Ajax beneficiario
        function populapessoa() {
            //event.preventDefault();
            var csrf_token = $('input[name="_token"]').val();
            var id_etapa_aplic = $('#id_etapa_aplic option:selected').val();
            $('#id_pessoa').empty();
            $('#seq_bancario').empty();

            $.ajax({
                method: 'POST',
                url: '{{url("previoempenho/ajaxBeneficiario")}}',
                data: {_token: csrf_token, id_etapa_aplic: id_etapa_aplic},
                dataType:"json",
            }).success(function (response) {
                console.log(response);
                $('#id_pessoa').empty();
                $('#id_pessoa').append('<option value="">'+''+'</option>');
                $(response).each(function (num_objeto, objeto) {
                    console.log(objeto);
                    $('#id_pessoa').append('<option value='+objeto.id_pessoa+'>'+objeto.nm_pessoa_completo+'</option>');
                });
            }).error(function (response) {
                console.log(response);
                $('#id_pessoa').empty();
            });
        };
    </script>

    <script type="text/javascript">
        //datepicker
        $('#dp1 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});
    </script>

    <script type="text/javascript">
        //passar id pessoa para botão contacorrente
        $('#btn_cc').click(function () {
            $id_pessoa = document.getElementById('id_pessoa').value;
            window.open('<?php echo url('/contacorrente') ?>/'+$id_pessoa,'_blank');
        });
    </script>

    <script type="text/javascript">
        function limpaconta() {
            //document.getElementById('seq_bancario').value= " " ;
            var csrf_token = $('input[name="_token"]').val();
            var id_pessoa = document.getElementById('id_pessoa').value;
            $('#seq_bancario').empty();
            $.ajax({
                method: 'POST',
                url: '{{url("previoempenho/ajaxConta")}}',
                data: {_token: csrf_token, id_pessoa: id_pessoa},
                dataType:"json",
            }).done(function (response) {
                console.log(response);
                $('#seq_bancario').empty();
                $('#seq_bancario').append('<option value="">' + '' +  '</option>');

                $(response).each(function (num_objeto, objeto) {
                    $('#seq_bancario').append('<option value='+objeto.seq_bancario+'>'+objeto.seq_bancario+' - Nº banco: '+objeto.nr_banco+' Ag: '+objeto.nr_agencia+'' +
                            ' C/C: '+objeto.nr_conta+'-'+objeto.nr_dac+'</option>');
                    console.log(objeto);
                });
            }).error(function (response) {
                $('#seq_bancario').empty();
            });
        }
    </script>

    <script type="text/javascript">
        CKEDITOR.replace( 'ds_objetivo' );
    </script>

@endsection