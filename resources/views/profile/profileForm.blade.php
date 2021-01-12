@extends('esqueleton.header')
@section('middleSection')
<script type="text/javascript">
    //onReady

    $(document).ready(function(e) {

        $('#formRecoveryProccess').validator().on('submit', function(e) {
            var HTML_ITEM_CONTENT = $('#btnChangeUserPassword').html();
            $('#msgValidationErrors').empty().html('<br />');
            if (e.isDefaultPrevented()) {
                console.log('prevented..')
            } else {
                e.preventDefault();
                $('#btnChangeUserPassword').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Actualizando ..');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                    },
                });

                $.ajax({
                    url: raiz_url + '/api/profile/changeUserPassword',
                    type: 'POST',
                    dataType: 'json',
                    context: this,
                    data: $('#formRecoveryProccess').serialize(),

                }).done(function(data) {
                    console.log(data);
                    if (data['success'] == true) {
                        $('#msgValidationErrors').empty()
                            .html('<i class="far fa-check-circle fa-fw"></i> Tu contraseña se ha actualizado correctamente. Por favor, inicia sesión nuevamente')
                            .removeClass('textBeneDanger').addClass('textBeneSuccess');
                        setTimeout(function() {
                            window.location.reload();
                        }, 4000);

                        // $('#btnChangeUserPassword').html(HTML_ITEM_CONTENT);
                        //ENVIAR ALERTA DE ALTA..
                        console.log(data);
                    } else {

                        $('#msgValidationErrors').empty().html('<i class="fas fa-exclamation-circle fa-fw"></i> ' + data['msg']).effect("shake");
                        $('#btnChangeUserPassword').effect("shake");
                    }

                }).fail(function(jqXHR, textStatus) {

                    //json
                    var response = JSON.parse(jqXHR.responseText);
                    console.log('response' + response.msg);
                    $('#btnChangeUserPassword').html(HTML_ITEM_CONTENT).effect("shake");
                    $('#msgValidationErrors').empty().html('<i class="fas fa-exclamation-circle fa-fw"></i> ' + response.msg).effect("shake");
                });

            }
        });

        $('#formUpdateUserProfile').validator().on('submit', function(e) {
            $('#msgUpdateProfile').hide();

            var HTML_ITEM_CONTENT = $('#btnUpdateUserProfile').html();
            if (e.isDefaultPrevented()) {
                console.log('prevented..')
            } else {
                e.preventDefault();
                $('#btnUpdateUserProfile').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Actualizando ..');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                    },
                });

                $.ajax({
                    url: raiz_url + '/api/profile/updateUserProfile',
                    type: 'POST',
                    dataType: 'json',
                    context: this,
                    data: $('#formUpdateUserProfile').serialize(),

                }).done(function(data) {
                    console.log(data);
                    if (data['success'] == true) {

                        $('#btnUpdateUserProfile').html(HTML_ITEM_CONTENT);
                        $('#msgUpdateProfile').empty()
                            .removeClass('textBeneDanger')
                            .addClass('textBeneSuccess')
                            .html('<i class="far fa-check-circle fa-fw"></i> ' + data['msg']).show();
                        //ENVIAR ALERTA DE ALTA..
                        console.log(data);
                    } else {
                        $('#btnUpdateUserProfile').html(HTML_ITEM_CONTENT);
                        $('#msgUpdateProfile').empty()
                            .removeClass('textBeneSuccess')
                            .addClass('textBeneDanger')
                            .html('<i class="far fa-check-circle fa-fw"></i> ' + data['msg']).show().effect('shake');
                        $('#btnUpdateUserProfile').effect("shake");
                    }

                }).fail(function(jqXHR, textStatus) {
                    var response = JSON.parse(jqXHR.responseText);
                    console.log('response' + response.msg);
                    $('#msgUpdateProfile').empty()
                        .removeClass('textBeneSuccess')
                        .addClass('textBeneDanger')
                        .html('<i class="far fa-check-circle fa-fw"></i> ' + response['msg']).show().effect('shake');
                    $('#btnUpdateUserProfile').html(HTML_ITEM_CONTENT).effect("shake");
                });

            }
        });


        $('#modalChangePassword').on('shown.bs.modal', function() {
            $('#formRecoveryProccess')[0].reset();
            $('#msgValidationErrors').empty().html('<br />');
        })

    }); //enonready



    function showPassText(THAT, e, inputField) {
        //alert($('#'+inputField).val());
        var HTML_ITEM_CONTENT = $(THAT).html();
        if ($('#' + inputField).attr('type') == 'text') {
            $('#' + inputField).attr('type', 'password');
            $(THAT).html('<i class="fas fa-eye fa-fw"></i>');

        } else {
            $('#' + inputField).attr('type', 'text');
            $(THAT).html('<i class="fas fa-eye-slash fa-fw"></i>');
        }

    }
</script>

<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Perfil de usuario </h3>
    </div>
    <div class="card-body">
        <form name="formUpdateUserProfile" id="formUpdateUserProfile" action="{{url('profile/updateUserProfile')}}" role="form" data-toggle="validator" method="post">
            <div class="row">

                <div class="clearfix"></div>
                <div class="container-fluid mt-3 mb-5">
                    <h7 class=""><i class="fas fa-info-circle fa-fw"></i> Estos son los datos con los que te identificas con los demás colaboradores de Benedetti's. Por favor, revisa que estén correctos </h7>
                    <br />
                    <a href="#modalChangePassword" data-toggle="modal" data-target="#modalChangePassword">
                        <h7 class="mt-3 float-right"><i class="fas fa-lock fa-fw"></i> Cambiar contraseña de acceso aquí</h7>
                    </a>

                </div>
                <div class="col-12 mt-1 mb-4">
                    <h6 class="textBeneGreen"><i class="fas fa-key fa-fw"></i> Nivel {{ $data['array_auth']->auth_description }}</h6>
                </div>

                <div class="col-md-6 col-sm-12">

                    <h6>Nombre(s)</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" value="{{$data['array_user']->first_name}}" required id="post_first_name" name="post_first_name" placeholder="Nombre(s) ">
                        <div class="help-block with-errors"></div>
                    </div>
                    <h6>Teléfono de contacto</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" pattern="^[0-9]{1,}$" maxlength="10" value="{{$data['array_user']->phone}}" required id="post_phone" name="post_phone" placeholder="ejem:5555023141">
                        <div class="help-block with-errors"></div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-12">

                    <h6>Apellidos(s)</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" value="{{$data['array_user']->last_name}}" required id="post_last_name" name="post_last_name" placeholder="Apellido(s)">
                        <div class="help-block with-errors"></div>
                    </div>
                    <h6>Email</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" disabled maxlength="10" value="{{$data['array_user']->email}}" required id="post_email" name="post_email" placeholder="ejem:5555023141">
                        <div class="help-block with-errors">Si requieres cambiar tu cuenta de email por favor, comunicate al área de sistemas</div>
                    </div>

                </div>


            </div>
            <div class="row">
                <div class="col-md-12 text-right">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <h7 id="msgUpdateProfile" style="display:none"> </h7>
                    <br />
                    <br />
                    <button type="submit" id="btnUpdateUserProfile" class="btn btn-primary btnOrderRed ">Actualizar mi perfil</button>
                </div>
                <div class="col-md-12 text-right">
                    <br />
                    <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
                </div>
            </div>
        </form>
    </div>
    <!--endcardbody-->

</div>
<!--endcard-->
@endsection
@include('modals.modalChangePassword')
