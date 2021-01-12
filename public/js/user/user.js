$(document).ready(function (e) {

    $('#formUserProfile').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnCreateUserAccount').html();
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            e.preventDefault();
            $('#btnCreateUserAccount').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Creando cuenta..');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/api/users/createUser',
                type: 'POST',
                dataType: 'json',
                context: this,
               // data: $('#formUserProfile').serialize(),
               data: $('#formUserProfile').serialize(),
              /* beforeSend: function (xhr) {
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem("access_token"));
                    xhr.setRequestHeader('Accept', 'application/json');
                },*/
            }).done(function (data) {
                if(data['success']==true){
                   $('#formUserProfile')[0].reset();

                   $('#toastNotificationSuccess').toast('show');
                   $('#h7textMsg').empty().html('<i class="far fa-check-circle"></i> '+data['msg']);

                    $('#btnCreateUserAccount').html(HTML_ITEM_CONTENT);
                    //console.log(data);
                }
                else{
                    $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> '+data['msg']).effect("shake");
                    $('#btnCreateUserAccount').html(HTML_ITEM_CONTENT).effect("shake");

                    console.error('error al insertar');
                }

            }).fail(function (jqXHR, textStatus) {
                $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> '+textStatus);
                $('#btnCreateUserAccount').html(HTML_ITEM_CONTENT).effect("shake");
            });

        }
    });

    $('#formUpdateUserAccount').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnUpdateUserAccount').html();
        $('#msgValidationErrors').empty().html('');
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            e.preventDefault();
            $('#btnUpdateUserAccount').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Actualizado cuenta..');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/api/users/updateUserAccountById',
                type: 'POST',
                dataType: 'json',
                context: this,
               // data: $('#formUserProfile').serialize(),
               data: $('#formUpdateUserAccount').serialize(),
              /* beforeSend: function (xhr) {
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem("access_token"));
                    xhr.setRequestHeader('Accept', 'application/json');
                },*/
            }).done(function (data) {
                if(data['success']==true){
                    //window.location.reload();
                    $('#table').bootstrapTable('refresh');
                    console.log('success..');

                    $('#msgValidationErrors').removeClass('textBeneDanger').addClass('textBeneSuccess').empty().html('<i class="far fa-check-circle fa-fw"></i> '+data['msg']);
                    $('#btnUpdateUserAccount').html(HTML_ITEM_CONTENT);
                    console.log(data);
                }
                else{
                    $('#msgValidationErrors').removeClass('textBeneSuccess').addClass('textBeneDanger').empty().html('<i class="fas fa-exclamation-circle"></i> '+data['msg']).effect("shake");
                    $('#btnUpdateUserAccount').html(HTML_ITEM_CONTENT).effect("shake");
                    console.error('error al insertar');
                }

            }).fail(function (jqXHR, textStatus) {
                //console.log('fail aca');
                $('#msgValidationErrors').removeClass('textBeneSuccess').addClass('textBeneDanger').empty().html('<i class="fas fa-exclamation-circle"></i> '+data['msg']).effect("shake");
                $('#btnUpdateUserAccount').html(HTML_ITEM_CONTENT).effect("shake");
            });

        }
    });




});

function generatePass(long, inputField) {
    var chars = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ2346789";
    var password = "";
    for (i = 0; i < long; i++) password += chars.charAt(Math.floor(Math.random() * chars.length));
    document.getElementById(inputField).value = password;
    document.getElementById(inputField).focus;
}
