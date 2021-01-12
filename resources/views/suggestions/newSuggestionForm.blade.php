@extends('esqueleton.header')
@section('middleSection')

<script type="text/javascript">
    var arrayStores;
    $('#post_description').empty().html('');

    function changeGroup(THAT, e) {
        console.log('on change');
        //1,Cliente, 2 Asociado
        $(".loader").show().fadeOut();
        if ($(THAT).val() == 1) {
            //Si el origen es cliente desplegar los campos de captura
            $('#divPartnerControl').empty();
            $('#divCustomerControl').empty().html('<div class="col-md-6 col-sm-12">\n\
                        <h6>Nombre</h6>\n\
                        <div class="form-group ">\n\
                            <input type="text" class="form-control" required id="post_customer_first_name" name="post_customer_first_name" placeholder="Nombre del cliente">\n\
                            <div class="help-block with-errors"></div>\n\
                        </div>\n\
                        <h6>Email</h6>\n\
                        <div class="form-group ">\n\
                            <input type="email" class="form-control" id="post_customer_email" name="post_customer_email" placeholder="email@ejemplo.com" required>\n\
                            <div class="help-block with-errors"></div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="col-md-6 col-sm-12 ">\n\
                        <h6>Apellido</h6>\n\
                        <div class="form-group ">\n\
                            <input type="text" class="form-control" id="post_customer_last_name" name="post_customer_last_name" placeholder="Apellido del cliente" required>\n\
                            <div class="help-block with-errors"></div>\n\
                        </div>\n\
                        <h6>Telefono</h6>\n\
                        <div class="form-group ">\n\
                            <input type="text" pattern="^[0-9]{1,}$" maxlength="10" class="form-control" id="post_customer_phone" name="post_customer_phone" placeholder="ejem:5555326671">\n\
                            <div class="help-block with-errors"></div>\n\
                        </div>\n\
                    </div>');



        } else
        if ($(THAT).val() == 2) {
            //STORES..
            $('#divCustomerControl').empty();
            $('#post_store').empty().append('<option selected="selected" value="">Aún no eliges al asociado.. </option>');
            $('#divPartnerControl').empty().html('<h6>Asociado</h6>\n\
                    <div class="form-group ">\n\
                        <select class="custom-select text-secondary" required name="post_partner"   id="post_partner">\n\
                            <option selected="selected" value="">Selecciona alguna opción </option>\n\
                        </select>\n\
                        <div class="help-block with-errors"></div>\n\
                    </div>');



            //getPartners..
            getPartners().then(function(data) {
                if (data['data'].length) {
                    console.log('si tiene asociados');
                    $('#post_partner').empty().append('<option selected="selected" value="">Selecciona alguna opción </option>');
                    $.each(data['data'], function(ARRAY_ID, ROW) {
                        //llenando select..
                        $('#post_partner').append('<option value="' + ROW.user_id + '" >' + ROW.first_name + ' ' + ROW.last_name + '</option>');
                    });
                }
            });

        }
        // e.preventDefault();
        //$('#btnCreateUserAccount').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Creando cuenta..');

    }

    function getPartners() {
        return $.ajax({
            url: raiz_url + '/api/partners/getPartners',
            type: 'get',
            dataType: 'json',
            context: this,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem("access_token"));
                xhr.setRequestHeader('Accept', 'application/json');
            }
        });
    }

</script>


<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Nueva sugerencia </h3>
    </div>
    <div class="card-body">
        <form name="formCreateSuggestion" id="formCreateSuggestion" action="{{url('/api/suggestions/createSuggestion')}}" role="form" data-toggle="validator" method="post">
            <div class="row">
                <div class="clearfix"></div>
                <div class="container-fluid mt-3 mb-4">
                    <h7 class="">Por favor, completa el formulario </h7>
                </div>
                <div class="col-12">
                    <h6>Origen</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="post_group" id="post_group" onchange="changeGroup(this,event);">
                            <?php
                            if (!empty($data['array_groups'])) :
                            ?>
                                <option selected="selected" value="">Selecciona alguna opción </option>
                                <?php
                                foreach ($data['array_groups'] as $rowGroup) :
                                ?>
                                    <option value="{{$rowGroup->group_id}}">{{$rowGroup->group_description}} </option>
                                <?php
                                endforeach;
                            else :
                                ?>
                                <option selected="selected" value="null">Niveles de autoridad no disponibles </option>
                            <?php
                            endif;
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-12" id="divPartnerControl">

                </div>
                <!--customer data -->
                <div class="row container-fluid p-0 m-0" id="divCustomerControl">

                </div>

                <!--endcustomerdata-->

                <div class="col-12 mt-2">
                    <h6>Por favor, describe la sugerencia</h6>
                    <div class="form-group ">
                        <textarea class="form-control" required id="post_description" name="post_description" placeholder="Ejem: describenos tu sugerencia aquí"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>

                </div>

            </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" id="btnCreateComplaintRecord" class="btn btn-primary btnOrderRed ">Guardar</button>
        </div>
        <div class="col-md-12 text-right">
            <br />
            <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
        </div>
    </div>
    </form>
</div>

@endsection
@include('modals.modalCreateComplaintSuccess')
