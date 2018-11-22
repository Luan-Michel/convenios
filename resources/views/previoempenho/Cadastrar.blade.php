@extends('app')
@section('content')
    <div class="container">
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        @endif
        <div class="col-md-12" id="cabecalho">
          <div class="col-md-6">
            <h1>Prévio Empenho</h1>
          </div>
          <div style="padding-top: 20px" class="col-md-6">
             <a href="{{route('ajuda')}}#previoempenho" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
          </div>
        </div>
        {!! Form::open(['route'=>'previoempenho.store', 'files' =>true])!!}
        <div class="col-md-2">
            {!! Form::label('ano_rpe','Ano do prévio')!!}
            <input required readonly type="number" id="ano_rpe" min="2010" value="{{$ano_rpe}}" max="{{ date("Y") }}" placeholder="" name="ano_rpe" class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('nr_rpe','Número do prévio')!!}
            <input required readonly type="number" id="nr_rpe" min="1" name="nr_rpe" value="{{$nr_rpe}}" class="form-control"/>
        </div>
        <div class="col-md-2">
            {!! Form::label('cd_tpcompra','Tipo compra')!!}
            <select required name="cd_tpcompra" id="cd_tpcompra" class="form-control">
                <option value=""></option>
                @foreach($cd_tpcompra as $aux)
                    <option value="{{$aux->CD_TPCOMPRA}}">{{$aux->DS_TPCOMPRA}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            {!! Form::label('cd_fonte','Fonte')!!}
            <select required id="cd_fonte" name="cd_fonte" class="form-control margin-bottom-10" >
                <option value=""></option>
                @foreach($cd_fonte as $aux)
                    <option value="{{$aux->cd_fonte}}">{{$aux->nm_fonte}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            {!! Form::label('id_convenio','Convênio')!!}
            <select required id="id_convenio" class="form-control change-event" name="id_convenio">
                <option value=""></option>
                @foreach($convenio as $c)
                    <option value='{{$c->id_convenio}}'>{{$c->ds_sigla_objeto}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4"> <br>
            {!! Form::label('id_etapa_aplic','Etapa aplicação')!!}
            <select required id="id_etapa_aplic" name="id_etapa_aplic"
                    class="form-control margin-bottom-10"  onchange="populapessoa()">
            </select>
        </div>

        <div class="col-md-4">
            <br>
            {!! Form::label('id_pessoa','Nome beneficiário')!!}
            <select required name="id_pessoa" class="form-control margin-bottom-10" id="id_pessoa"
                    onchange="limpaconta()">
            </select>
        </div>

        <div class="col-md-4">
            <br>
            {!! Form::label('seq_bancario','Conta corrente')!!}
            <select required id="seq_bancario" name="seq_bancario" class="form-control margin-bottom-10"></select>
        </div>

        <div class="col-md-3" id="dp1">
            <br>
            {!! Form::label('dt_rpe','Data do prévio')!!}
            <br><input required id="dt_rpe"  class="date" name="dt_rpe" type="text"/><br>
        </div>
        <div class="col-md-2">
            <br>
            {!! Form::label('vl_previo_empenho','Valor do prévio')!!}
            <input required type="text" data-mask="#.##0,00" data-mask-reverse="true" id="vl_previo_empenho" name="vl_previo_empenho" class="form-control"/>
        </div>
        <div class="col-md-4">
            <br>
            {!! Form::label('id_moeda','Moeda')!!}
            <select required name="id_moeda" class="form-control margin-bottom-10 select2" id="id_moeda">
                <option value=""></option>
                @foreach($id_moeda as $aux)
                    <option value="{{$aux->id_moeda}}">{{$aux->ds_moeda}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <br>
            {!! Form::label('tp_rpe','Tipo do prévio')!!}
            <select required name="tp_rpe" class="form-control margin-bottom-10" id="id_tp_rpe">
                <option value=""></option>
                <option value="A">Auxílio Financeiro</option>
                <option value="D">Diaria</option>
            </select>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-12 control-label" for="textarea"><br>Objetivo do Prévio Empenho</label>
            <div class="col-md-12">
                <textarea class="form-control" required rows="3" maxlength="250" type="text" id="ds_objetivo" name="ds_objetivo"></textarea>
            </div>
        </div>

        <!--Bot�o-->
        <!--<div class="col-md-2">
            <br><br>
            {{--<label for="firstName" class="control-label"></label>--}}
            <a id="btn_cc" value="contacorrente">
                {!! Form::button ('Conta Corrente', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>-->
        <div class="col-md-2">
            <br><br>
            {{--<label for="firstName" class="control-label"></label>--}}
            <a href="<?php echo url('previoempenho'); ?>">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </a>
        </div>
        <div class="col-md-2">
            <br><br>
            {{--<label for="firstName" class="control-label"></label>--}}
            <a href="<?php echo url('previoempenho'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>
    </div>

@endsection

@section('content_js')
    <script type="text/javascript">
        //Ajax Etapa Aplicação
        $('.change-event').change(function (event) {
            event.preventDefault();
            var csrf_token = $('input[name="_token"]').val();
            var id_convenio = $('#id_convenio option:selected').val();
            $('#id_etapa_aplic').empty();
            $('#id_pessoa').empty();
            $('#seq_bancario').empty();
            $.ajax({
                method: 'POST',
                url: '{{url("previoempenho/ajaxEtapaAplic")}}',
                data: {_token: csrf_token, id_convenio: id_convenio},
                dataType:"json",
                beforeSend: function(){
                  swal({
                      title: 'Carregando!',
                      icon: '{{asset("images/Loading_icon.gif")}}',
                      buttons: false,
                  });
                },
            }).done(function (response) {
                swal.close(); //remove o swal de carregamento
                $('#id_etapa_aplic').empty();
                $('#id_etapa_aplic').append('<option value="">' + '' +  '</option>');
                $(response).each(function (num_objeto, objeto) {
                    console.log(objeto);
                    $('#id_etapa_aplic').append('<option value='+objeto.id_etapa_aplic+'>' + objeto.ds_titulo_etapa +  '</option>');
                });
            }).error(function (response) {
                $('#id_etapa_aplic').empty();

            });

        });
    </script>


    <script type="text/javascript">

        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.select2').select2();
        });

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
                beforeSend: function(){
                  swal({
                      title: 'Carregando!',
                      icon: '{{asset("images/Loading_icon.gif")}}',
                      buttons: false,
                  });
                },
            }).done(function (response) {
                swal.close(); //remove o swal de carregamento
                $('#id_pessoa').empty();
                $('#id_pessoa').append('<option value="">'+''+'</option>');
                $(response).each(function (num_objeto, objeto) {
                    $('#id_pessoa').append('<option value='+objeto.id_pessoa+'>'+objeto.nm_pessoa_completo+'</option>');
                });
            }).error(function (response) {
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
                beforeSend: function(){
                  swal({
                      title: 'Carregando!',
                      icon: '{{asset("images/Loading_icon.gif")}}',
                      buttons: false,
                  });
                },
            }).done(function (response) {
                swal.close(); //remove o swal de carregamento
                $('#seq_bancario').empty();
                $('#seq_bancario').append('<option value="">' + '' +  '</option>');

                $(response).each(function (num_objeto, objeto) {
                    $('#seq_bancario').append('<option value='+objeto.seq_bancario+'>'+objeto.seq_bancario+' - Nº banco: '+objeto.nr_banco+' Ag: '+objeto.nr_agencia+'' +
                            ' C/C: '+objeto.nr_conta+'-'+objeto.nr_dac+'</option>');
                });
            }).error(function (response) {
                $('#seq_bancario').empty();
            });
        }
    </script>

    <script type="text/javascript">
        //CKEDITOR.replace( 'ds_objetivo' );
    </script>

@endsection
