@extends('app')

@section('content')

    <div class="container">
        <div class="col-md-12" id="cabecalho">
          <div class="col-md-6">
            <h1>Item na Etapa</h1>
          </div>
          <div style="padding-top: 20px" class="col-md-6">
             <a href="{{route('ajuda')}}#item_etapa" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
          </div>
        </div>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
        @endif

        {!! Form::open(['route'=>['etapaitem.atualizabanco', $etapaitem->id_etapa_item_aplic], 'method'=>'put'])!!}

        <div class="col-md-4">
            {!! Form::label('id_etapa_aplic','Etapa Plano de Trabalho')!!}
            <select required name="id_etapa_aplic" class="form-control margin-bottom-10" id="id_etapa_aplic" onchange="selectajax()" >
                @foreach($etapas as $etp)
                  @if($etp->id_etapa_aplic == $etapaitem->id_etapa_aplic)
                    <option selected value="{{$etp->id_etapa_aplic}}">{{$etp->ds_titulo_etapa}}</option>
                  @else
                    <option value="{{$etp->id_etapa_aplic}}">{{$etp->ds_titulo_etapa}}</option>
                  @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            {!! Form::label('cd_desp','Despesa')!!}
            <input type="text" class="form-control" value="{{$etapaitem->cd_desp}}" name="cd_desp" id="cd_desp">
        </div>

        <div class="col-md-5">
          {!! Form::label('nm_desp','Nome da Despesa')!!}
          <select class="form-control" onchange="despesa(this.value)"  name="nm_desp" id="nm_desp">
             <option value='{{$etapaitem->cd_desp}}'>{{$despesa->NM_DESP}}</option>
          </select>
        </div>

        <div class="col-md-6">
            {!! Form::label('id_pais','País')!!}
            <select required name="id_pais" class="form-control margin-bottom-10" id="id_pais">
                @foreach($pais as $p)
                  @if($p->id_pais == $etapaitem->id_pais)
                    <option selected value="{{$p->id_pais}}">{{$p->nm_pais}} ({{$p->sigla_pais}})</option>
                  @else
                    <option value="{{$p->id_pais}}">{{$p->nm_pais}} ({{$p->sigla_pais}})</option>
                  @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            {!! Form::label('id_moeda','Moeda')!!}
            <select required name="id_moeda" class="form-control margin-bottom-10" id="id_moeda">
                <option value=""></option>
                @foreach($moeda as $m)
                  @if($m->id_moeda == $etapaitem->id_moeda)
                    <option selected value="{{$m->id_moeda}}">{{$m->ds_moeda}} ({{$m->sigla_moeda}})</option>
                  @else
                    <option value="{{$m->id_moeda}}">{{$m->ds_moeda}} ({{$m->sigla_moeda}})</option>
                  @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-3 margin-bottom-5" id="dp2">
            {!! Form::label('dt_aplicacao','Data Aplicação')!!}
            <br><input id="dt_aplicacao" required class="date" value="{{$etapaitem->dt_aplicacao}}" name="dt_aplicacao" type="text"/><br>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_item','Valor unitário Item')!!}
            <input required id="vl_item" name="vl_item" type="text" value="{{$etapaitem->vl_item}}" data-mask="#.##0,00" data-mask-reverse="true">
        </div>
        <div class="col-md-3">
            {!! Form::label('qt_item','Quantidade Item')!!}
            <input required id="qt_item" name="qt_item" value="{{$etapaitem->qt_item}}" type="number" min="0">
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_total_item','Valor Total Item')!!}
            <input required id="vl_total_item" name="vl_total_item" value="{{$etapaitem->vl_total_item}}" type="text" data-mask="#.##0,00" data-mask-reverse="true">
        </div>
        <div class="col-md-12">
            {!! Form::label('ds_item','Descrição Item')!!}
            {!! Form::textarea('ds_item', $etapaitem->ds_item, ['class'=>'form-control'])!!}
        </div>
        <br>

        <div class="col-md-1">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('etapaitem'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>

        <!--Bot�o-->
        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}

        </div>


        {!! Form::close()!!}

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
              return 'editar/nm_desp/search/' + params.term;
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

    function despesa(desp){

      document.getElementById('cd_desp').value = desp;
    }

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
