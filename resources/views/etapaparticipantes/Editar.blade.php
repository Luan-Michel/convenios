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

        {!! Form::open(['route'=>['etapaparticipantes.atualizabanco', $etapaparticipante[0]['id_etapa_participante']], 'method'=>'put'])!!}
        <div class="col-md-12">
            {!! Form::label('id_aplicacao','Etapa Plano de trabalho')!!}
            <select required name="id_etapa_aplic" class="form-control margin-bottom-10" id="id_etapa_aplic">
                <option value="{{$etapaparticipante[0]['id_etapa_aplic']}}">{{$etapaparticipante[0]['ds_titulo_etapa']}} - {{$etapaparticipante[0]['ds_titulo_meta_aplic']}}</option>
                @foreach($planodetrabalho as $planodetrabalho)
                    <option value="{{$planodetrabalho->id_etapa_aplic}}">{{$planodetrabalho->ds_titulo_etapa}} - {{$planodetrabalho->ds_titulo_meta_aplic}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            {!! Form::label('id_pessoa_participante','Participantes')!!}
            <select required name="id_etapa_participante" class="form-control margin-bottom-10"
                    id="id_etapa_participante">
                <option value="{{$etapaparticipante[0]['id_pessoa_participante']}}|{{$etapaparticipante[0]['id_financiador']}}|{{$etapaparticipante[0]['ano_convenio']}}|{{$etapaparticipante[0]['nr_convenio']}}">{{$etapaparticipante[0]['id_pessoa_participante']}} - {{$etapaparticipante[0]['nm_pessoa_completo']}}</option>
                @foreach($participantes as $participantes)
                    <option value="{{$participantes->id_pessoa_participante}}|{{$participantes->id_financiador}}|{{$participantes->ano_convenio}}|{{$participantes->nr_convenio}}">{{$participantes->id_pessoa_participante}} - {{$participantes->nm_pessoa_completa}}</option>
                @endforeach
            </select>
        </div>

        <br>


        <!--Bot�o-->
        <div class="col-md-3">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <div class="form-group">
                {!! Form::submit('Atualizar Etapa Participante', ['class'=>'btn btn-primary'])!!}
            </div>
        </div>
    {!! Form::close()!!}
    <!--Bot�o voltar-->
        <div class="col-md-1">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <a href="<?php echo url('etapaparticipantes'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
            </a>
        </div>
        <br><br><br><br><br><br><br><br><br><br>
    </div>
@endsection

@section('content_js')
    <script type="text/javascript">
        $('#id_etapa_aplic').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
        $('#id_pessoa_participante').selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });
    </script>
@endsection
