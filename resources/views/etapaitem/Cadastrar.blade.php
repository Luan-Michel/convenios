@extends('app')

@section('content')

    <div class="container">
        <h1>Item na Etapa</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
        @endif

        {!! Form::open(['route'=>'etapaitem.store'])!!}

        <div class="col-md-4">
            {!! Form::label('id_etapa_aplic','Etapa Plano de Trabalho')!!}
            <select required name="id_etapa_aplic" class="form-control margin-bottom-10" id="id_etapa_aplic" onchange="selectajax()" >
                <option value=""></option>
                @foreach($etapaplanodetrabalho as $etapaplanodetrabalho)
                    <option value="{{$etapaplanodetrabalho->id_etapa_aplic}}">{{$etapaplanodetrabalho->ds_titulo_etapa}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            {!! Form::label('cd_desp','Despesa')!!}
            <input type="text" class="form-control" name="cd_desp" id="cd_desp">
        </div>

        <div class="col-md-5">
          {!! Form::label('cd_tabela','Nome da Despesa/Tabela')!!}
          <select class="form-control" name="nm_desp" id="nm_desp">
           <option value='0'>- Search user -</option>
          </select>
        </div>

        <div class="col-md-6">
            {!! Form::label('id_pais','País')!!}
            <select required name="id_pais" class="form-control margin-bottom-10" id="id_pais">
                <option value=""></option>
                @foreach($pais as $pais)
                    <option value="{{$pais->id_pais}}">{{$pais->nm_pais}} ({{$pais->sigla_pais}})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            {!! Form::label('id_moeda','Moeda')!!}
            <select required name="id_moeda" class="form-control margin-bottom-10" id="id_moeda">
                <option value=""></option>
                @foreach($moeda as $moeda)
                    <option value="{{$moeda->id_moeda}}">{{$moeda->ds_moeda}} ({{$moeda->sigla_moeda}})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 margin-bottom-5" id="dp2">
            {!! Form::label('dt_aplicacao','Data Aplicação')!!}
            <br><input id="dt_aplicacao" required class="date" name="dt_aplicacao" type="text"/><br>
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_item','Valor unitário Item')!!}
            <input required id="vl_item" name="vl_item" type="text" data-mask="#.##0,00" data-mask-reverse="true">
        </div>
        <div class="col-md-3">
            {!! Form::label('qt_item','Quantidade Item')!!}
            <input required id="qt_item" name="qt_item" type="number" min="0">
        </div>
        <div class="col-md-3">
            {!! Form::label('vl_total_item','Valor Total Item')!!}
            <input required id="vl_total_item" name="vl_total_item" type="text" data-mask="#.##0,00" data-mask-reverse="true">
        </div>
        <div class="col-md-12">
            {!! Form::label('ds_item','Descrição Item')!!}
            {!! Form::textarea('ds_item', null, ['class'=>'form-control'])!!}
        </div>
        <br>


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
                {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
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
                  if(data[0].text)
                  {
                    for(var d = 0; d < data.length; d++){
                      var item = data[d];
                      var option = new Option(item .text, item .id, true, true);
                      // Append it to the select
                      $("#nm_desp").append(option);
                    }
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
