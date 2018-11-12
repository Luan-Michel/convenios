@extends('app')
@section('content')
    @if($errors->any())
        <ul class="alert alert-warning">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class='container'>
        <h1>Participante</h1>

        {!! Form::open(['route'=>['pessoaconvenio.atualizabanco'], 'method'=>'put'])!!}

        <div class="col-md-6" name="div_pessoa" id="div_pessoa">
            {!! Form::label('id_pessoa_participante','Nome')!!}
            <input type="text" value="{{$pessoa[0]['nm_pessoa_completo']}}" class="form-control" disabled>
            <input type="hidden" value="{{$pessoa[0]['id_pessoa']}}" name="id_pessoa" id="id_pessoa" >
            <br><br>
        </div>

        <div class="col-md-6">
            {!! Form::label('id_financiador', 'Financiador')!!}
            <input name="id_financiador" id="id_financiador" value="{{$financiador[0]['nm_financiador']}}" type="text"
                   class="form-control" disabled/>
            <br><br>
        </div>

        <!--Convênio-->
        <div class="col-md-6">
            {!! Form::label('nr_convenio', 'Convênio')!!}
            <input type="text" class="form-control"
                   value="{{ $convenio[0]['nr_convenio']}}/{{ $convenio[0]['ano_convenio']}}" disabled>
            <input type="hidden" id="nr_convenio" name="nr_convenio" value="{{ $convenio[0]['nr_convenio']}}">
            <br><br>
        </div>

        <div class="col-md-6">
            {!! Form::label('cd_coordenador','Coordenador')!!}
            <select required name="cd_coordenador" id="cd_coordenador" class="form-control">
                @if ($p[0]['cd_coordenador'] == "S")
                    <option value="{{$p[0]['cd_coordenador']}}">SIM</option>
                    <option value="N">NÃO</option>
                @endif
                @if ($p[0]['cd_coordenador'] == "N")
                    <option value="{{$p[0]['cd_coordenador']}}">NÃO</option>
                    <option value="S">SIM</option>
                @endif
            </select>
            <br><br>
        </div>

        <div class="col-md-6">
            {!! Form::label('cnpj_instituicao','CNPJ-Instituição')!!}
            <input required name="cnpj_instituicao" id="cnpj_instituicao" class="form-control"
                   data-mask="00.000.000/0000-00" data-mask-revers="true" value="{{$pessoajuridica[0]['cnpj']}}"
            onchange=" nome_inst()">
            <br><br>
        </div>

        <div class="col-md-6">
            {!! Form::label('id_pessoa_instituicao','Instituição')!!}
            <input  disabled name="id_pessoa_instituicao" id="id_pessoa_instituicao" class="form-control"
                 value="{{$pj[0]['nm_pessoa_completo']}}">
            <br><br>
        </div>
    </div>

    <div class='container'>
        <!--Bot�o-->
        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <div class="form-group">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </div>
            {!!Form::close()!!}

        </div>
        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('/pessoaconvenio'); ?>">
                {!! Form::button('Voltar', ['class'=>'btn btn-primary'])!!}
            </a>
        </div>

    </div>
@endsection
@section('content_js')
    <script type="text/javascript">
        function nome_inst() {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            console.log(csrf_token);
            var cnpj = document.getElementById('cnpj_instituicao').value;
            console.log(cnpj);
            $.ajax({
                type: 'get',
                url: '{{url("pessoaconvenio/ajaxInst")}}',
                data: {'X-CSRF-TOKEN': csrf_token, cnpj: cnpj},
                dataType: "json"
            }).done(function (data) {
                console.log(data);
                document.getElementById('id_pessoa_instituicao').value=data;
            }).fail(function (data) {
                console.log(data);
                document.getElementById('id_pessoa_instituicao').value="CNPJ NÃO CADASTRADO!";
               // $("#id_pessoa_instituicao").empty();

            });
        };
    </script>
@endsection