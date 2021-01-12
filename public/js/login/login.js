$(document).ready(function (e) {

    $('#modalLoginError').show();

    $('#formAuthLoader').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnLogin').html();
        $('#msgLoginError').empty().html('<br />');
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            $('#btnLogin').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Conectando..');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/login/getAuthMenu',
                type: 'POST',
                dataType: 'json',
                context: this,
                data: $('#formAuthLoader').serialize(),

            }).done(function (data) {
                console.log(data);
                if(data['success']==true){
                    window.location.href=raiz_url+'/'+data['main_screen'];
                    //ENVIAR ALERTA DE ALTA..
                    console.log(data);
                }
                else{
                    $('#btnLogin').html(HTML_ITEM_CONTENT);
                    console.error('error al insertar');
                }
            }).fail(function (jqXHR, textStatus) {
                $('#btnLogin').html(HTML_ITEM_CONTENT);
                console.log('error al insertar..');
            });
        }
    });

    $('#formLogin').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnLogin').html();
        $('#msgLoginError').empty().html('<br />');
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            $('#btnLogin').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> conectando..');
            let email=$('#post_email').val();
            let password=$('#post_password').val();
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: raiz_url+"/login",
                context: this,
                data: { email: email,password:password},
                dataType: 'json',
                success: function (data) {
                    console.log('login first'+data);
                   if(data['success']==true){
                    localStorage.setItem("access_token", data['access_token']);
                        if(data['multiple_auth']==true){
                            //auth loader
                            window.location.href=raiz_url+'/login/authLoader';
                        }
                        else{
                            window.location.href=raiz_url+'/'+data['main_screen'];
                        }
                       //alert('access token'+data['access_token'])
                    }
                    else{
                        $('#btnLogin').html(HTML_ITEM_CONTENT);
                        console.error('not access token'+data)
                        $('#msgLoginError').empty().html('Tus datos de acceso son incorrectos');
                    }
                },
                error: function (data,status) {
                    console.error('data error..' + JSON.stringify(data.responseText))
                    $('#btnLogin').html(HTML_ITEM_CONTENT);
                    if (data.status == 401) {
                        $('#btnLogin').effect("shake");
                        console.error('error login..' + data.status);
                        $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> Tus datos de acceso son incorrectos').effect("shake");
                    }
                    else{
                        console.error('error login'+data.responseText);
                        $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> Hubo un error al realizar la petición. Por favor, intenta nuevamente. Si el problema persiste comunicate al área de sistemas').effect("shake");
                        $('#btnLogin').effect("shake");
                    }

                },
                load: function (data) {
                    $('#btnLogin').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> conectando..');
                }
            });
        }
    });

    $('#formRecoveryProccess').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnRecoveryAccess').html();
        $('#msgLoginError').empty().html('<br />');
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            $('#btnRecoveryAccess').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> procesando..');
            let email=$('#post_email').val();
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: raiz_url+"/login/recoveryProcess",
                context: this,
                data: { email: email},
                dataType: 'json',
                success: function (data) {
                   if(data['success']==true){
                       console.log(data);
                       window.location.href=raiz_url+'/login/recoverySuccess';

                    }
                    else{
                        $('#btnRecoveryAccess').html(HTML_ITEM_CONTENT).effect("shake");
                        console.error('not access token..'+data)
                        $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> '+data['msg']).effect("shake");

                    }
                },
                error: function (data) {
                    $('#btnRecoveryAccess').html(HTML_ITEM_CONTENT).effect("shake");
                    $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> '+data['msg']).effect("shake");;

                    console.error('error method');
                },
                load: function (data) {
                    $('#btnRecoveryAccess').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> conectando..');
                }
            });
        }
    });


});
