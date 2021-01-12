$(document).ready(function (e) {
    console.log('local storage'+localStorage.getItem('access_token'));
    if(localStorage.getItem('access_token')==null){
        window.location.href=raiz_url+'/logout';
    }
      /* beforeSend: function (xhr) {
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem("access_token"));
                    xhr.setRequestHeader('Accept', 'application/json');
                },*/
    $('#formCreateSuggestion').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnCreateSuggestionRecord').html();
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            e.preventDefault();
            $('#btnCreateSuggestionRecord').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Guardando ..');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/api/suggestions/createSuggestion',
                type: 'POST',
                dataType: 'json',
                context: this,
                data: $('#formCreateSuggestion').serialize(),

            }).done(function (data) {
                console.log(data);
                $('#btnCreateSuggestionRecord').html(HTML_ITEM_CONTENT);
                if(data['success']==true){

                    $('#formCreateSuggestion')[0].reset();
                    //let dataJson =  JSON.stringify(data.data);

                    console.log('length emails'+data['data'][0].Suggestion_emails.length);

                   // window.location.reload();
                    if(data['data'].length){
                        console.log('aca adentro'+data['data'][0].Suggestion_folio);
                        $('#SuggestionNo').empty().html(data['data'][0].Suggestion_folio);
                        $('#SuggestionUbe').empty().html(data['data'][0].Suggestion_store);
                        $('#supervisorName').empty().html(data['data'][0].Suggestion_supervisor);
                        $('#managerName').empty().html(data['data'][0].Suggestion_manager);

                       // console.log('emails length' +data['data'][0].Suggestion_emails);
                        if (data['data'][0].Suggestion_emails.length) {
                            $('#mailList').empty().html('');
                            $.each(data['data'][0].Suggestion_emails[0], function (ARRAY_ID, ROW) {
                                //console.log('id'+ARRAY_ID);
                                $('#mailList').append('<a class="m-5" href="mailto:'+ROW.email+'"><h7>'+ROW.email+'</h7></a>');
                                $('#mailList').append('<br />');

                            });

                            $('#modalCreateSuggestionSuccess').modal('show');
                        }


                    }
                    //ENVIAR ALERTA DE ALTA..
                    console.log(data);
                }
                else{

                    console.error('error al insertar');
                }

            }).fail(function (jqXHR, textStatus) {

                $('#btnCreateSuggestionRecord').html(HTML_ITEM_CONTENT);
                alert(textStatus);
            });

        }
    });

    $('#formCreateSuggestionByPartner').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnCreateSuggestionRecord').html();
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            e.preventDefault();
            $('#btnCreateSuggestionRecord').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Guardando ..');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/api/Suggestions/createSuggestionByPartner',
                type: 'POST',
                dataType: 'json',
                context: this,
                data: $('#formCreateSuggestionByPartner').serialize(),

            }).done(function (data) {
                console.log(data);
                if(data['success']==true){
                    window.location.href=raiz_url+'/Suggestions/SuggestionSuccess/id/'+data['data'];
                    $('#btnCreateSuggestionRecord').html(HTML_ITEM_CONTENT);
                    //ENVIAR ALERTA DE ALTA..
                    console.log(data);
                }
                else{

                    console.error('error al insertar');
                }

            }).fail(function (jqXHR, textStatus) {

                $('#btnCreateUserAccount').html(HTML_ITEM_CONTENT);
                alert(textStatus);
            });

        }
    });

});
