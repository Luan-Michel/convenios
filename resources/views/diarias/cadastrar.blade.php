@extends('app')

@section('content')

    <div class="container">

        <div class="col-md-12" id="cabecalho">
          <div class="col-md-6">
            <h1>Cadastrar Diárias</h1>
          </div>
          <div style="padding-top: 20px" class="col-md-6">
             <a href="{{route('ajuda')}}#diaria" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
          </div>
        </div>

        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
        @endif

        {!! Form::open(['route'=>'diarias.store'])!!}

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-6">
                {!! Form::label('cd_centro','Centro de Custo')!!}
              <select required name="id_etapa_aplic" class="form-control margin-bottom-10" id="id_etapa_aplic" onchange="selectajax()" >
                  <option value=""></option>
                  @foreach($etapaplanodetrabalho as $etapaplanodetrabalho)
                      <option value="{{$etapaplanodetrabalho->id_etapa_aplic}}">{{$etapaplanodetrabalho->ds_titulo_etapa}}</option>
                  @endforeach
              </select>
          </div>


          <div class="col-md-3 margin-bottom-" id="dp2">
              {!! Form::label('dt_conversao_moeda','Data da Conversão da Moeda ')!!}
              <input id="dt_conversao_moeda" required class="form-control" data-mask="00/00/0000"  type="text" placeholder="__/__/____" name="dt_limite_execucao"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('dt_saida','Data da Saída')!!}
            <input id="dt_saida" required class="form-control" data-mask="00/00/0000"  type="text" placeholder="__/__/____" name="dt_limite_execucao"/>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-3 margin-bottom-5">
              {!! Form::label('dt_retorno','Data do Retorno')!!}
              <input id="dt_retorno" required class="form-control" data-mask="00/00/0000"  type="text" placeholder="__/__/____" name="dt_limite_execucao"/>
          </div>

          <div class="col-md-3">
                {!! Form::label('id_uf','Estado de Origem')!!}
              <select required name="id_uf" class="form-control margin-bottom-10" id="id_uf" onchange="selectajax()" >
                  <option value=""></option>
                  @foreach($estados as $uf)
                      <option value="{{$uf->id_uf}}">{{$uf->nm_uf}}</option>
                  @endforeach
              </select>
          </div>

          <div class="col-md-6">
                {!! Form::label('id_cidade','Cidade de Origem')!!}
              <select required name="id_cidade" class="form-control margin-bottom-10" id="id_cidade" onchange="selectajax()" >
                  <option value=""></option>
                  @foreach($cidades as $c)
                      <option value="{{$c->id_cidade}}">{{$c->id_cidade}}</option>
                  @endforeach
              </select>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-3">
                {!! Form::label('id_uf','Estado de Destino')!!}
              <select required name="id_uf" class="form-control margin-bottom-10" id="id_uf" onchange="selectajax()" >
                  <option value=""></option>
                  @foreach($estados as $uf)
                      <option value="{{$uf->id_uf}}">{{$uf->nm_uf}}</option>
                  @endforeach
              </select>
          </div>

          <div class="col-md-6">
                {!! Form::label('id_cidade','Cidade de Destino')!!}
              <select required name="id_cidade" class="form-control margin-bottom-10" id="id_cidade" onchange="selectajax()" >
                  <option value=""></option>
                  @foreach($cidades as $c)
                      <option value="{{$c->id_cidade}}">{{$c->id_cidade}}</option>
                  @endforeach
              </select>
          </div>

          <div class="col-md-3">
                {!! Form::label('id_tipo_transporte','Transporte')!!}
              <select required name="id_tipo_transporte" class="form-control margin-bottom-10" id="id_tipo_transporte" onchange="selectajax()" >
                  <option value=""></option>
                  @foreach($cidades as $c)
                      <option value="{{$c->id_cidade}}">{{$c->id_cidade}}</option>
                  @endforeach
              </select>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Quantidade de Auxilios Financeiros')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Valor do Auxílio Financeiro')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Quantidade de Alimentações')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Valor da Alimentação Diária')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Quantidade de Hopedagens')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Valor da Hospedagem Diária')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Valor de Desligamento')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Valor de Conversão da Moeda')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Percentual de Auxílio')!!}
            <input id="qt_aux_financeiro" required class="form-control"  type="number" name="qt_aux_financeiro"/>
          </div>

        </div>

        <!--Bot�o-->
        <div class="col-md-3">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <div class="form-group">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </div>
        </div>
        {!! Form::close()!!}
                <!--Bot�o voltar-->
        <div class="col-md-1">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <a href="<?php echo url('etapaitem'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>

        <link href="{{asset('select2-4.0.6-rc.1/dist/css/select2.min.css')}}" rel="stylesheet" />
        <script src="{{asset('select2-4.0.6-rc.1/dist/js/select2.min.js')}}"></script>

        <br><br><br><br><br><br><br><br><br><br>
    </div>
@endsection

@section('content_js')

    <script type="text/javascript">

    $(document).ready(function(){
       $("#nm_desp").select2({
           minimumInputLength: 5,
           ajax: {
           url: function (params) {
              return 'adicionar/nm_desp/search/' + params.term;
           },
           type: "get",
           dataType: 'json',
           delay: 250,
           data: function (params) {
            return {
              searchTerm: params.term // search term
            };
           },
           processResults: function (response) {
             console.log(response);
             return {
                results: response
             };
           },
           cache: true
          }
         });
    });

    $('#cd_desp').on('blur', function (evt) {
        var cd_desp = $('#cd_desp').val();
        var cd_tab = $('#cd_tabela').val();
        if(cd_desp != '' && cd_tab != '')
        {
            $.ajax({
              url: "adicionar/cd_desp/"+cd_desp,
              type: "get",
              dataType: "json",
              beforeSend: function(){
                swal({
                    title: 'Carregando!',
                    icon: '{{asset("images/Loading_icon.gif")}}',
                    buttons: false,
                });
              },
              success: function (data) {
                  swal.close(); //remove o swal de carregamento
                  console.log(data);
                  if(data.text)
                  {
                    var option = new Option(data.text, data.id, true, true);
                    $("#nm_desp").append(option);
                    $("#nm_desp").trigger('change');
                  }else{

                  }
              }
          });
        }
      });


        function selectajax(){
            var id_fin = $("#teste").val();
            $.get("../etapaitem/despesas/"+id_fin).done(function(data, status){
                alert(data);
                /*var array_atividade = data.split("/");
                var i;
                for (i = 0; i < array_atividade.length; ++i) {
                    var atividade = array_atividade[i].split("%");
                    if(atividade[0] == null || atividade[1] == null){
                        $("#cod_produto").attr("disabled", true);
                        $('#cod_produto').append($('<option>', {
                            text : "Nenhum produto encontrado!"
                        }));
                    }else{
                        $("#cod_produto").attr("disabled", false);
                        $('#cod_produto').append($('<option>', {
                            value: atividade[0],
                            text : atividade[1]
                        }));
                    }
                }*/
            });
        }

        //datepicker
        $('#dp1 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});
        $('#dp2 .date').datepicker({'format': 'd/m/yyyy', 'autoclose': true, todayHighlight: true});

        $('#id_etapa_aplic').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
        $('#id_pais').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
        $('#id_moeda').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
    </script>
@endsection
