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
    //formSolveComplaint
    //datePickers
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#starDate').datepicker({
        uiLibrary: 'bootstrap4',
        locale: 'es-es',
        format: 'yyyy-mm-dd',
        iconsLibrary: 'fontawesome',
       // minDate: today,
        maxDate: function () {
            return $('#endDate').val();
        }
    });
    $('#endDate').datepicker({
        uiLibrary: 'bootstrap4',
        locale: 'es-es',
        format: 'yyyy-mm-dd',
        iconsLibrary: 'fontawesome',
        minDate: function () {
            return $('#startDate').val();
        }
    });



    $('#formSolveComplaint').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnSolveComplaintRecord').html();
        $('#msgLoginError').empty().html('<br />');
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            e.preventDefault();
            $('#btnSolveComplaintRecord').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Guardando ..');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/api/complaints/solveComplaint',
                type: 'POST',
                dataType: 'json',
                context: this,
                data: $('#formSolveComplaint').serialize(),

            }).done(function (data) {
                console.log(data);
                $('#btnSolveComplaintRecord').html(HTML_ITEM_CONTENT);
                if(data['success']==true){

                    $('#formSolveComplaint')[0].reset();
                    //redirigir..
                    window.location.href=raiz_url+'/complaints/complaintSolvedSuccess/id/'+data['data'];
                    //ENVIAR ALERTA DE ALTA..
                    console.log(data);
                }
                else{
                    $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> '+data['msg']).effect("shake");
                    $('#btnCreateComplaintRecord').html(HTML_ITEM_CONTENT).effect("shake");
                    console.error('error al insertar');
                }
            }).fail(function (jqXHR, textStatus) {
                $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> Hubo un error al realizar la petición. Por favor, intenta nuevamente. Si el problema persiste comunicate al área de sistemas').effect("shake");
                $('#btnCreateComplaintRecord').html(HTML_ITEM_CONTENT).effect("shake");
                console.error(textStatus);
            });
        }
    });

    $('#formCreateComplaint').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnCreateComplaintRecord').html();
        $('#msgLoginError').empty().html('<br />');
        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            e.preventDefault();
            $('#btnCreateComplaintRecord').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Guardando ..');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/api/complaints/createComplaint',
                type: 'POST',
                dataType: 'json',
                context: this,
                data: $('#formCreateComplaint').serialize(),

            }).done(function (data) {
                console.log(data);
                $('#btnCreateComplaintRecord').html(HTML_ITEM_CONTENT);
                if(data['success']==true){

                    $('#formCreateComplaint')[0].reset();
                    //let dataJson =  JSON.stringify(data.data);
                    console.log('length emails'+data['data'][0].complaint_emails.length);
                   // window.location.reload();
                    if(data['data'].length){
                        console.log('aca adentro'+data['data'][0].complaint_folio);
                        $('#complaintNo').empty().html(data['data'][0].complaint_folio);
                        $('#complaintUbe').empty().html(data['data'][0].complaint_store);
                        $('#supervisorName').empty().html(data['data'][0].complaint_supervisor);
                        $('#managerName').empty().html(data['data'][0].complaint_manager);

                       // console.log('emails length' +data['data'][0].complaint_emails);
                        if (data['data'][0].complaint_emails.length) {
                            $('#mailList').empty().html('');
                            $.each(data['data'][0].complaint_emails[0], function (ARRAY_ID, ROW) {
                                //console.log('id'+ARRAY_ID);
                                $('#headerMailList').empty().html('También se ha generado una notificación de email para: <br />');
                                $('#mailList').append('<a class="m-5" href="mailto:'+ROW.email+'"><h7>'+ROW.email+'</h7></a>');
                                $('#mailList').append('<br />');
                            });
                            $('#modalCreateComplaintSuccess').modal('show');
                        }
                    }
                    //ENVIAR ALERTA DE ALTA..
                    console.log(data);
                }
                else{
                    $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> '+data['msg']).effect("shake");
                    $('#btnCreateComplaintRecord').html(HTML_ITEM_CONTENT).effect("shake");
                    console.error('error al insertar');
                }
            }).fail(function (jqXHR, textStatus) {
                $('#msgLoginError').empty().html('<i class="fas fa-exclamation-circle"></i> Hubo un error al realizar la petición. Por favor, intenta nuevamente. Si el problema persiste comunicate al área de sistemas').effect("shake");
                $('#btnCreateComplaintRecord').html(HTML_ITEM_CONTENT).effect("shake");
                console.error(textStatus);
            });
        }
    });

    $('#formCreateComplaintByPartner').validator().on('submit', function (e) {
        var HTML_ITEM_CONTENT = $('#btnCreateComplaintRecord').html();
        $('#msgMessageError').empty().html('<br />');

        if (e.isDefaultPrevented()) {
            console.log('prevented..')
        } else {
            e.preventDefault();
            $('#btnCreateComplaintRecord').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Guardando ..');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                },
            });

            $.ajax({
                url: raiz_url + '/api/complaints/createComplaintByPartner',
                type: 'POST',
                dataType: 'json',
                context: this,
                data: $('#formCreateComplaintByPartner').serialize(),

            }).done(function (data) {
                console.log(data);
                if(data['success']==true){
                    window.location.href=raiz_url+'/complaints/complaintSuccess/id/'+data['data'];
                    $('#btnCreateComplaintRecord').html(HTML_ITEM_CONTENT);
                    //ENVIAR ALERTA DE ALTA..
                    console.log(data);
                }
                else{
                    $('#btnCreateComplaintRecord').html(HTML_ITEM_CONTENT);

                    $('#msgMessageError').empty().html('<i class="fas fa-exclamation-circle"></i> Hubo un error al realizar la petición. '+data["msg"]).effect("shake");

                    console.error('error al insertar');
                }

            }).fail(function (jqXHR, textStatus) {

                $('#btnCreateComplaintRecord').html(HTML_ITEM_CONTENT);
                $('#msgMessageError').empty().html('<i class="fas fa-exclamation-circle"></i> Hubo un error al realizar la petición. '+textStatus).effect("shake");

            });

        }
    });

});
