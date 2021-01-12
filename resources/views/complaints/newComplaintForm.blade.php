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
                            <input type="email" required class="form-control" id="post_customer_email" name="post_customer_email" placeholder="email@ejemplo.com" >\n\
                            <div class="help-block with-errors"></div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="col-md-6 col-sm-12 ">\n\
                        <h6>Apellido</h6>\n\
                        <div class="form-group ">\n\
                            <input type="text" class="form-control" required id="post_customer_last_name" name="post_customer_last_name" placeholder="Apellido del cliente" >\n\
                            <div class="help-block with-errors"></div>\n\
                        </div>\n\
                        <h6>Telefono</h6>\n\
                        <div class="form-group ">\n\
                            <input type="text" pattern="^[0-9]{1,}$" maxlength="10" class="form-control" id="post_customer_phone" name="post_customer_phone" placeholder="ejem:5555326671">\n\
                            <div class="help-block with-errors"></div>\n\
                        </div>\n\
                    </div>');
            //allStores..
            $('#divComplaintType').empty().html('<h6>Tipo</h6>\n\
                <div class="form-group ">\n\
                    <select class="custom-select text-secondary" required name="post_category" id="post_category">\n\
                    </select>\n\
                    <div class="help-block with-errors"></div>\n\
                </div>');

            //const stuff = await doAjax();
            getAllStores().then(function(data) {
                if (data['rows'].length) {
                    console.log('si tiene');
                    $('#post_store').empty().append('<option selected="selected" value="">Selecciona alguna opción </option>');
                    $.each(data['rows'], function(ARRAY_ID, ROW) {
                        //llenando select..
                        $('#post_store').append('<option value="' + ROW.id_unidad + '" >' + ROW.id_unidad + ' ' + ROW.nombre_unidad + '</option>');
                    });
                }
            });

            getCategoryComplaint().then(function(data){
                if (data['data'].length) {
                    console.log('categorias..');
                    $('#post_category').empty().append('<option selected="selected" value="">Selecciona alguna opción </option>');
                    $.each(data['data'], function(ARRAY_ID, ROW) {
                        //llenando select..
                        $('#post_category').append('<option value="' + ROW.category_id + '" >' + ROW.category_description + '</option>');
                    });
                }
            });



        } else
        if ($(THAT).val() == 2) {
            //STORES..
            $('#divCustomerControl').empty();
            $('#post_store').empty().append('<option selected="selected" value="">Aún no eliges al asociado.. </option>');
            $('#divPartnerControl').empty().html('<h6>Asociado</h6>\n\
                    <div class="form-group ">\n\
                        <select class="custom-select text-secondary" required name="post_partner" onchange="getPartnerStores(this)" id="post_partner">\n\
                            <option selected="selected" value="">Selecciona alguna opción </option>\n\
                        </select>\n\
                        <div class="help-block with-errors"></div>\n\
                    </div>');

            $('#divPartnerUbeControl').empty().html('<h6>Departamento</h6>\n\
                    <div class="form-group">\n\
                        <select class="custom-select text-secondary" required name="post_department" id="post_department">\n\
                            <option selected="selected" value="">Selecciona alguna opción </option>\n\
                        </select>\n\
                      <div class="help-block with-errors"></div>\n\
                    </div>');

            $('#divComplaintType').empty().html('<h6>Tipo de solicitud</h6>\n\
                    <div class="form-group ">\n\
                        <select class="custom-select text-secondary" required name="post_category_request" id="post_category_request" >\n\
                            <option selected="selected" value="">Selecciona alguna opción </option>\n\
                            <option value="1" >Incidencia</option>\n\
                            <option value="2" >Consulta</option>\n\
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

            getDepartments().then(function(data) {
                if (data['data'].length) {
                    console.log('departamentos..');
                    $('#post_department').empty().append('<option selected="selected" value="">Selecciona alguna opción </option>');
                    $.each(data['data'], function(ARRAY_ID, ROW) {
                        //llenando select..
                        $('#post_department').append('<option value="' + ROW.department_id + '" >' + ROW.department_description + '</option>');
                    });
                }
            });


            getCategoryRequest().then(function(data){
                if (data['data'].length) {
                    console.log('categorias/solicitudes..');
                    $('#post_category_request').empty().append('<option selected="selected" value="">Selecciona alguna opción </option>');
                    $.each(data['data'], function(ARRAY_ID, ROW) {
                        //llenando select..
                        $('#post_category_request').append('<option value="' + ROW.category_request_id + '" >' + ROW.description_request+ '</option>');
                    });
                }
            });


        }

        // e.preventDefault();
        //$('#btnCreateUserAccount').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Creando cuenta..');

    }

    function getDepartments() {
        return $.ajax({
            url: raiz_url + '/api/departments/getDepartments',
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

    function getAllStores() {

        return $.ajax({
            url: raiz_url + '/api/stores/getStores',
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

    function getPartnerStores(THAT) {
        var partner_id = $(THAT).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer ' + localStorage.getItem("access_token")
            },
        });

        $.ajax({
            url: raiz_url + '/api/partners/getPartnerStores',
            type: 'POST',
            dataType: 'json',
            context: this,
            data: {
                partner_id: partner_id
            },

        }).done(function(data) {
            if (data['success'] == true) {
                //llenar lista de tiendas..
                if (data['data'].length > 0) {
                    $('#post_store').empty().append('<option selected="selected" value="">Selecciona alguna opción </option>');
                    $.each(data['data'], function(ARRAY_ID, ROW) {
                        //llenando select..
                        $('#post_store').append('<option value="' + ROW.store_id + '" >' + ROW.store_id + ' ' + ROW.store_name + '</option>');
                    });
                } else {
                    $('#post_store').empty().append('<option selected="selected" value="">No se obtuvieron datos </option>');
                }

            } else {

                console.error('error consultar');
            }

        }).fail(function(jqXHR, textStatus) {
            console.log(textStatus);
        });

    }

    function getCategoryComplaint(THAT) {

        return $.ajax({
            url: raiz_url + '/api/complaints/getCategoryComplaint',
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

    function getCategoryRequest(THAT) {
        return $.ajax({
            url: raiz_url + '/api/complaints/getCategoryRequest',
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
        <h3>Nueva Incidencia </h3>
    </div>
    <div class="card-body">
        <form name="formCreateComplaint" id="formCreateComplaint" action="{{url('/api/complaints/createComplaint')}}" role="form" data-toggle="validator" method="post">
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

                <div class="col-12">
                    <h6>UBE</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="post_store" id="post_store">
                            <option selected="selected" value="">Selecciona alguna opción </option>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-12" id="divPartnerUbeControl">

                </div>
                <!--endcustomerdata-->

                <div class="col-md-6 col-sm-12">
                    <div id="divComplaintType">
                        <h6>Tipo</h6>
                        <div class="form-group ">
                            <select class="custom-select text-secondary" required name="post_category" id="post_category">
                                <?php
                                if (!empty($data['array_categories'])) :
                                ?>
                                    <option selected="selected" value="null">Selecciona alguna opción </option>
                                    <?php
                                    foreach ($data['array_categories'] as $rowCategories) :
                                    ?>
                                        <option value="{{$rowCategories->category_id}}">{{$rowCategories->category_description}} </option>
                                    <?php
                                    endforeach;
                                else :
                                    ?>
                                    <option selected="selected" value="null">Datos no disponibles </option>
                                <?php
                                endif;
                                ?>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h6>Prioridad de urgencia</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="post_urgency" id="post_urgency">
                            <?php
                            if (!empty($data['array_priority'])) :
                            ?>
                                <option selected="selected" value="">Selecciona alguna opción </option>
                                <?php
                                foreach ($data['array_priority'] as $rowPriority) :
                                ?>
                                    <option value="{{$rowPriority->priority_id}}">{{$rowPriority->priority_description}} </option>
                                <?php
                                endforeach;
                            else :
                                ?>
                                <option selected="selected" value="null">Datos no disponibles </option>
                            <?php
                            endif;
                            ?>
                        </select>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-12">
                    <h6>Por favor, describe la solicitud</h6>
                    <div class="form-group ">
                        <textarea class="form-control" required id="post_description" name="post_description" placeholder="Ejem: describenos lo sucedido, algún comentario o cuestión"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>

                </div>

            </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <h7 id="msgLoginError"  class="mr-2 textBeneDanger"><br /></h7>
            <div class="clearfix"><br /></div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" id="btnCreateComplaintRecord" class="btn btn-primary btnOrderRed mt-1 ">Guardar</button>
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
