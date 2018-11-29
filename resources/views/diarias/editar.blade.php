@extends('app')

@section('content')

    <div class="container">

        <div class="col-md-12" id="cabecalho">
          <div class="col-md-6">
            <h1>Atualizar Diárias</h1>
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

        {!! Form::open(['route'=>['diarias.update', $diaria->id_rpe], 'method' => 'post'])!!}

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-6">
                {!! Form::label('id_rpe','Prévio Empenho')!!}
              <select readonly required name="id_rpe" class="form-control margin-bottom-10" id="id_rpe"  >
                  @foreach($previoempenho as $rpe)
                      @if($diaria->id_rpe == $rpe->id_rpe)
                        <option selected value="{{$rpe->id_rpe}}">{{$rpe->ds_objetivo}}</option>
                      @else
                        <option value="{{$rpe->id_rpe}}">{{$rpe->ds_objetivo}}</option>
                      @endif
                  @endforeach
              </select>
          </div>

          <div class="col-md-6">
                {!! Form::label('cd_centro','Centro de Custo')!!}
              <select required name="cd_centro" class="form-control margin-bottom-10" id="cd_centro"  >
                  @foreach($centrocusto as $cc)
                      @if($diaria->cd_centro == $cc->cd_centro)
                        <option selected value="{{$cc->cd_centro}}">{{$cc->nm_centro}}</option>
                      @else
                        <option value="{{$cc->cd_centro}}">{{$cc->nm_centro}}</option>
                      @endif
                  @endforeach
              </select>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">


          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('dt_saida','Data da Saída')!!}
            <input id="dt_saida" required class="form-control" data-mask="00/00/0000" value="{{$diaria->dt_saida}}"  type="text" placeholder="__/__/____" name="dt_saida"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
              {!! Form::label('dt_retorno','Data do Retorno')!!}
              <input id="dt_retorno" required class="form-control" data-mask="00/00/0000" value="{{$diaria->dt_retorno}}"  type="text" placeholder="__/__/____" name="dt_retorno"/>
          </div>

          <div class="col-md-3">
                {!! Form::label('id_tipo_transporte','Transporte')!!}
              <select required name="id_tipo_transporte" class="form-control margin-bottom-10" id="id_tipo_transporte"  >
                  @foreach($transporte as $t)
                    @if($diaria->id_tipo_transporte == $t->id_tipo_transporte)
                      <option selected value="{{$t->id_tipo_transporte}}">{{$t->ds_tipo_transporte}}</option>
                    @else
                      <option value="{{$t->id_tipo_transporte}}">{{$t->ds_tipo_transporte}}</option>
                    @endif
                  @endforeach
              </select>
          </div>

          <div class="col-md-3 margin-bottom-" id="dp2">
            {!! Form::label('dt_conversao_moeda','Data da Conversão da Moeda ')!!}
            <input id="dt_conversao_moeda" required class="form-control" data-mask="00/00/0000" value="{{$diaria->dt_conversao_moeda}}"  type="text" placeholder="__/__/____" name="dt_conversao_moeda"/>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-3">
                {!! Form::label('id_uf_origem','Estado de Origem')!!}
              <select required class="form-control margin-bottom-10" id="id_uf_origem"  >
                  @foreach($estados as $uf)
                    @if($origem->id_uf == $uf->id_uf)
                      <option selected value="{{$uf->id_uf}}">{{$uf->nm_uf}}</option>
                    @else
                      <option value="{{$uf->id_uf}}">{{$uf->nm_uf}}</option>
                    @endif
                  @endforeach
              </select>
          </div>

          <div class="col-md-6">
                {!! Form::label('id_cidade_origem','Cidade de Origem')!!}
              <select required name="id_cidade_origem" class="form-control margin-bottom-10" id="id_cidade_origem"  >
                  @foreach($cidades_origem as $c)
                    @if($diaria->id_cidade_origem == $c->id_cidade)
                      <option selected value="{{$c->id_cidade}}">{{$c->nm_cidade}}</option>
                    @else
                      <option value="{{$c->id_cidade}}">{{$c->nm_cidade}}</option>
                    @endif
                  @endforeach
              </select>
          </div>

          <div class="col-md-3">
              {!! Form::label('id_uf_destino','Estado de Destino')!!}
              <select required class="form-control margin-bottom-10" id="id_uf_destino"  >
                  @foreach($estados as $uf)
                    @if($destino->id_uf == $uf->id_uf)
                      <option selected value="{{$uf->id_uf}}">{{$uf->nm_uf}}</option>
                    @else
                      <option value="{{$uf->id_uf}}">{{$uf->nm_uf}}</option>
                    @endif
                  @endforeach
              </select>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-6">
              {!! Form::label('id_cidade_destino','Cidade de Destino')!!}
              <select required name="id_cidade_destino" class="form-control margin-bottom-10" id="id_cidade_destino"  >
                  @foreach($cidades_destino as $c)
                    @if($diaria->id_cidade_destino == $c->id_cidade)
                      <option selected value="{{$c->id_cidade}}">{{$c->nm_cidade}}</option>
                    @else
                      <option value="{{$c->id_cidade}}">{{$c->nm_cidade}}</option>
                    @endif
                  @endforeach
              </select>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_aux_financeiro','Quantidade de Auxilios Financeiros')!!}
            <input id="qt_aux_financeiro" required class="form-control" value="{{$diaria->qt_aux_financeiro}}" type="number" name="qt_aux_financeiro"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('vl_aux_financeiro','Valor do Auxílio Financeiro')!!}
            <input id="vl_aux_financeiro" required class="form-control" data-mask="#.##0,00" value="{{$diaria->vl_aux_financeiro}}" data-mask-reverse="true"  type="text" name="vl_aux_financeiro"/>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_diaria_alim','Quantidade de Alimentações')!!}
            <input id="qt_diaria_alim" required class="form-control"  type="number" value="{{$diaria->qt_diaria_alim}}" name="qt_diaria_alim"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('vl_diaria_alim','Valor da Alimentação Diária')!!}
            <input id="vl_diaria_alim" required class="form-control" data-mask="#.##0,00" value="{{$diaria->vl_diaria_alim}}" data-mask-reverse="true" type="text" name="vl_diaria_alim"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('qt_diaria_hosp','Quantidade de Hopedagens')!!}
            <input id="qt_diaria_hosp" required class="form-control"  type="number" value="{{$diaria->qt_diaria_hosp}}" name="qt_diaria_hosp"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('vl_diaria_hosp','Valor da Hospedagem Diária')!!}
            <input id="vl_diaria_hosp" required class="form-control" data-mask="#.##0,00" value="{{$diaria->vl_diaria_hosp}}" data-mask-reverse="true" type="text" name="vl_diaria_hosp"/>
          </div>

        </div>

        <div style="padding-bottom: 20px" class="row">

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('vl_adic_desl','Valor de Desligamento')!!}
            <input id="vl_adic_desl" required class="form-control" data-mask="#.##0,00" data-mask-reverse="true" value="{{$diaria->vl_adic_desl}}" type="text" name="vl_adic_desl"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('vl_conversao_moeda','Valor de Conversão da Moeda')!!}
            <input id="vl_conversao_moeda" required class="form-control" data-mask="#.##0,00" data-mask-reverse="true" value="{{$diaria->vl_conversao_moeda}}" type="text" name="vl_conversao_moeda"/>
          </div>

          <div class="col-md-3 margin-bottom-5">
            {!! Form::label('perc_aux_financeiro','Percentual de Auxílio')!!}
            <input id="perc_aux_financeiro" required class="form-control"  type="number" min="0" max="100" value="{{$diaria->perc_aux_financeiro}}" name="perc_aux_financeiro"/>
          </div>

        </div>

        <!--Bot�o-->
        <div class="col-md-3">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <div class="form-group">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
            </div>
        </div>
        {!! Form::close()!!}
                <!--Bot�o voltar-->
        <div class="col-md-1">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <a href="<?php echo url('diarias'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>

        <link href="{{asset('select2-4.0.6-rc.1/dist/css/select2.min.css')}}" rel="stylesheet" />
        <script src="{{asset('select2-4.0.6-rc.1/dist/js/select2.min.js')}}"></script>

        <br><br>
    </div>
@endsection

@section('content_js')

    <script type="text/javascript">

    $('#id_uf_destino').on('change', function (evt) {
        var id_uf = $('#id_uf_destino').val();
        if(id_uf != '')
        {
            $.ajax({
              url: "editar/id_cidade_destino/"+id_uf,
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
                  if(data[0].text)
                  {
                    $("#id_cidade_destino").empty();
                    for(i=0; i < data.length; i++){
                      var option = new Option(data[i].text, data[i].id, true, true);
                      $("#id_cidade_destino").append(option);
                      $("#id_cidade_destino").trigger('change')
                    }
                  }else{

                  }
              }
          });
        }
      });

      $('#id_uf_origem').on('change', function (evt) {
          var id_uf = $('#id_uf_origem').val();
          if(id_uf != '')
          {
              $.ajax({
                url: "editar/id_cidade_destino/"+id_uf,
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
                    if(data[0].text)
                    {
                      $("#id_cidade_origem").empty();
                      for(i=0; i < data.length; i++){
                        var option = new Option(data[i].text, data[i].id, true, true);
                        $("#id_cidade_origem").append(option);
                        $("#id_cidade_origem").trigger('change')
                      }
                    }else{

                    }
                }
            });
          }
        });

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
