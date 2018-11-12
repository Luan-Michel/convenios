@extends('app')
@section('content')
    @if(Session::has('message'))
        <div class="alert alert-danger">
            <strong>{{ Session::get('message') }}</strong>
        </div>
    @endif
    <div class="container">
        <h1>Conta Corrente - {{$id_pessoa[0]->nm_pessoa_completo}}</h1>
        @if($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all()as$error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        @endif
        <br>
        {!! Form::open(['route'=>['contacorrente.atualizabanco', $cc[0]['id_pessoa'], $cc[0]['seq_bancario']], 'method'=>'put', 'files' =>true])!!}
        <div class="col-md-3">
            {!! Form::label('nm_banco','Nome do Banco')!!}
            <select required name="nr_banco" class="form-control margin-bottom-10 change-event" value="" onchange="tipoconta()" id="nr_banco">
                <option value='{{$banco[0]['nr_banco']}}'>{{$banco[0]['nm_banco']}}</option>
                @foreach($nm_banco as $nm_banco)
                    <option value='{{$nm_banco->nr_banco}}'>{{$nm_banco->nm_banco}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            {!! Form::label('nm_agencia', 'Nome da Agência') !!}
            <select required name="nr_agencia" class="form-control margin-botton-10" id="nr_agencia">
                <option value='{{$agencia[0]['nr_agencia']}}'>{{$agencia[0]['nm_agencia']}}</option>
            </select>
        </div>
        <div class="col-md-3">
            {!! Form::label('cd_tipo_conta', 'Tipo da Conta')!!}
            @if($cc[0]['nr_banco'] == 104)
                <select required name="cd_tipo_conta" class="form-control margin-botton-10" id="cd_tipo_conta">
                    <option value='{{$cd_tipo_conta[0]['cd_tipo_conta']}}'>{{$cd_tipo_conta[0]['ds_tipo_conta']}}</option>
                </select>
            @else
                <select disabled value=null name="cd_tipo_conta" class="form-control margin-botton-10" id="cd_tipo_conta">
                </select>
            @endif
        </div>

        <div class="col-md-2">
            {!! Form::label('nr_conta', 'Conta Corrente') !!}
            <input required type="number" value="{{$cc[0]['nr_conta']}}" id="nr_conta"  placeholder="" name="nr_conta" class="form-control"/>
        </div>

        <div class="col-md-1">
            {!! Form::label('nr_dac', 'DAC') !!}
            <input required type="text" value='{{$cc[0]['nr_dac']}}' id="nr_dac" placeholder="" max="1" name="nr_dac" class="form-control"/>
        </div>

    {{--{!! Form::close() !!}--}}

    <!--Bot�o voltar-->
        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('/contacorrente', $id_pessoa[0]->id_pessoa); ?>">
                {!! Form::submit('Salvar', ['class'=>'btn btn-success'])!!}
            </a>
        </div>

        <div class="col-md-2">
            <label for="firstName" class="control-label"><font color="#F0F0F0">.</font></label>
            <br>
            <a href="<?php echo url('/contacorrente', $id_pessoa[0]->id_pessoa); ?>">
                {!! Form::button ('Voltar', ['class'=>'btn btn-primary'])!!}
            </a>
        </div>

    </div>
@endsection
@section('content_js')
    <script type="text/javascript">
        //agencia
        $('.change-event').change(function (event) {
            event.preventDefault();
            var csrf_token = $('input[name="_token"]').val();
            var nm_banco = $('#nr_banco option:selected').val();
            $.ajax({
                method: 'POST',
                url: '{{url("contacorrente/ajaxAgencia")}}',
                data: {_token: csrf_token, nm_banco: nm_banco},
                dataType:"json",
            }).done(function (response) {
                $('#nr_agencia').empty();
                $('#nr_agencia').append('<option value="">' + '' +  '</option>');
                $(response).each(function (num_objeto, objeto) {
                    $('#nr_agencia').append('<option value='+objeto.nr_agencia+'>' + objeto.nm_agencia +  '</option>');
                });
            }).error(function (response) {
                $('#nr_agencia').empty();
            });
        });


        //tipo conta
        function tipoconta() {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var nm_banco = $('#nr_banco option:selected').val();
            console.log('entrei no tp conta');
            $('#cd_tipo_conta').empty();
            document.getElementById('cd_tipo_conta').disabled = true;
            document.getElementById('cd_tipo_conta').required = false;

            $.ajax({
                type: 'POST',
                url: '{{url("contacorrente/ajaxTipoConta")}}',
                data: {_token: csrf_token, nm_banco: nm_banco},
                dataType:"json",
            }).done(function (response) {
                console.log("Certo tp conta");
                console.log(response);
                document.getElementById('cd_tipo_conta').disabled = false;
                document.getElementById('cd_tipo_conta').required = true;
                $('#cd_tipo_conta').empty();
                $('#cd_tipo_conta').append('<option value="">' + '' +  '</option>');
                $(response).each(function (num_objeto, objeto) {
                    $('#cd_tipo_conta').append('<option value='+objeto.cd_tipo_conta+'>' + objeto.ds_tipo_conta +  '</option>');
                });
            }).error(function (response) {
                console.log("Erro tp conta");
                $('#cd_tipo_conta').empty();
                document.getElementById('cd_tipo_conta').disabled = true;
                document.getElementById('cd_tipo_conta').required = false;

            });
        };
    </script>
@endsection
