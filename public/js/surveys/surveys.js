$(document).ready(function (e) {
      /* beforeSend: function (xhr) {
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem("access_token"));
                    xhr.setRequestHeader('Accept', 'application/json');
                },*/
    $('#formCreateSurvey').validator().on('submit', function (e) {
       // alert('aca submit');
        var HTML_ITEM_CONTENT = $('#btnCreateSurvey').html();
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            e.preventDefault();
            $('#btnCreateSurvey').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Guardando ..');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/surveys/createSurvey',
                type: 'POST',
                dataType: 'json',
                context: this,
                data: $('#formCreateSurvey').serialize(),

            }).done(function (data) {
                console.log(data);
                if(data['success']==true){
                    window.location.href=raiz_url+'/surveys/surveySuccess';

                    //ENVIAR ALERTA DE ALTA..
                    console.log(data);
                }
                else{
                    $('#btnCreateSurvey').html(HTML_ITEM_CONTENT);
                    console.error('error al insertar');
                }

            }).fail(function (jqXHR, textStatus) {

                $('#btnCreateUserAccount').html(HTML_ITEM_CONTENT);
                console.log('error al insertar..');
            });

        }
    });


});
