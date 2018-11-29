@extends('app')
@section('content')

    <div class="container">
        <div class="col-md-12" id="cabecalho">
          <div class="col-md-6">
            <h1>Participante de Etapa</h1>
          </div>
          <div style="padding-top: 20px" class="col-md-6">
             <a href="{{route('ajuda')}}#participante_etapa" target="_blank" style="float:right;" class="btn btn-default"> <span class="glyphicon glyphicon-question-sign"></span> </a>
          </div>
        </div>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach

            </ul>
        @endif

        {!! Form::open(['route'=>'etapaparticipantes.store'])!!}

        <div class="col-md-12">
            {!! Form::label('id_aplicacao','Etapa Plano de trabalho')!!}
            <select required name="id_etapa_aplic" class="form-control margin-bottom-10" id="id_etapa_aplic">
                <option value=""></option>
                @foreach($planodetrabalho as $planodetrabalho)
                    <option value="{{$planodetrabalho->id_etapa_aplic}}">{{$planodetrabalho->ds_titulo_etapa}} - {{$planodetrabalho->ds_titulo_meta_aplic}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            {!! Form::label('id_pessoa_participante','Participante')!!}
            <select required name="id_pessoa_participante" class="form-control margin-bottom-10" id="id_pessoa_participante">
                <option value=""></option>
            </select>
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
            <a href="<?php echo url('etapaparticipantes'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-warning'])!!}
            </a>
        </div>
        <br><br><br><br><br><br><br><br><br><br>
    </div>
@endsection

@section('content_js')
    <script type="text/javascript">

    $('#id_etapa_aplic').on('change', function (evt) {
        var etapa = $('#id_etapa_aplic').val();
        if(etapa != '')
        {
            $.ajax({
              url: "adicionar/getetapa/"+etapa,
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
                    $("#id_pessoa_participante").empty();
                    for(i=0; i < data.length; i++){
                      var option = new Option(data[i].text, data[i].id, true, true);
                      $("#id_pessoa_participante").append(option);
                      $("#id_pessoa_participante").trigger('change')
                    }
                  }else{

                  }
              }
          });
        }
      });

    </script>
@endsection
