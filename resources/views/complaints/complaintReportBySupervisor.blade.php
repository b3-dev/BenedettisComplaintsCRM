@extends('esqueleton.header')
@section('middleSection')
{!! Html::style('assets/bootstrap-table-master/dist/bootstrap-table.css') !!}
<script src="{{ URL::asset('assets/jqueryTableExport/tableExport.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/bootstrap-table.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/bootstrap-table-locale-all.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/extensions/export/bootstrap-table-export.min.js') }}"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.0/dist/extensions/toolbar/bootstrap-table-toolbar.min.js"></script>

<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Solicitudes registradas ({{date('Y')}})</h3>
    </div>
    @if(!empty($data['pendingsComplaint']) && $data['pendingsComplaint']>0)
    <div class="alert alert-danger alert-dismissible alertUnsuccessMsg fade show" role="alert">
        <strong class="p-2"> <i class="fas fa-exclamation-circle fa-fw"></i> {{Auth::user()->first_name }}</strong>Te recordamos que tienes <span style="font-size:16px;"><b>({{ $data['pendingsComplaint'] }})</b></span> solicitudes pendientes.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @else
    <div class="alert alert-success alert-dismissible alertSuccessMsg fade show " role="alert">
        <strong class="p-2"> <i class="fas fa-check-circle fa-fw"></i> Enhorabuena</strong>No tienes solicitudes pendientes
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card-body">
        <!--datatable -->
        <style>
            .select,
            #locale {
                width: 100%;
            }

            .like {
                margin-right: 10px;
            }
        </style>
        <div class="select">

            <h6 class=""><i class="fas fa-search fa-fw"></i> Filtros de búsqueda</h6>

            <div class="row">
                <div class="col-md-6 m-0 p-0 mt-3">
                    <select class="custom-select text-secondary mt-2" name="param_status_id" id="param_status_id">
                        <option value="-1" selected>Todos los status</option>
                        <option value="1">Pendiente</option>
                        <option value="2">Solucionado</option>
                    </select>
                </div>
                <div class="col-md-6 m-0 p-0 mt-3">

                    @if(!empty($data['array_stores']))

                    <select class="custom-select text-secondary mt-2" name="param_store_id" id="param_store_id">
                        <option value="-1" selected>En todas tus UBES</option>
                        @foreach($data['array_stores'] as $rowStores)
                        <option value="{{$rowStores['id_unidad']}}">{{$rowStores['id_unidad'].' '.$rowStores['nombre_unidad']}}</option>

                        @endforeach
                    </select>
                    @endif
                </div>

                <div class="col-md-6 m-0 p-0 mt-4">
                    <h7><b>F.Registro desde</b> </h7>
                    <input id="starDate" width="98%" />
                </div>
                <div class="col-md-6 m-0 p-0 mt-4">
                    <h7><b>F.Registro Hasta</b> </h7>
                    <input id="endDate" width="98%" />
                </div>

                <div class="col-12 p-0 mt-4 ">
                    <a href="" class="pull-right"><i class="fas fa-redo-alt fa-fw"></i> Reestablecer filtros</a>
                    <button type="button" onclick="getComplaintsByParams(this,event)" class="btn btn-primary btnOrderRed float-right">Buscar</button>
                </div>
            </div>
        </div>

        <table id="table" data-id-table="table" data-toolbar="#toolbar" data-search="false" data-advanced-search="false" data-show-refresh="false" data-show-toggle="true" data-header-style="headerStyle" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="true" data-detail-view="false" data-show-export="true" data-click-to-select="false" data-minimum-count-columns="2" data-show-pagination-switch="false" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="false" data-side-pagination="server" data-ajax-options="ajaxOptions" data-url="{{ url('/api/complaints/getComplaintsBySupervisor') }}" data-response-handler="responseHandler">

        </table>

        <script type="text/javascript">
            var $table = $('#table')
            var $remove = $('#remove')
            var selections = []

            window.ajaxOptions = {
                beforeSend: function(xhr) {

                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem("access_token"));
                    xhr.setRequestHeader('Accept', 'application/json');
                }
            }


            function getIdSelections() {
                return $.map($table.bootstrapTable('getSelections'), function(row) {
                    return row.id
                })
            }

            function responseHandler(res) {
                $.each(res.rows, function(i, row) {
                    row.state = $.inArray(row.id, selections) !== -1
                })
                return res
            }

            function cellStyle(value, row, index, field) {

                if (value == 'Pendiente') {
                    console.log('pendiente=>');
                    return {
                        classes: 'textBeneTableDanger'
                    };
                } else
                if (value == 'Solucionado') {
                    console.log('solucionado..');
                    return {
                        classes: 'textBeneTableSuccess'
                    };
                } else {
                    //ambar o anaranjado..
                    return {
                        classes: 'textBeneWarning'
                    };
                }
            }


            function detailFormatter(index, row) {
                var html = []
                $.each(row, function(key, value) {
                    html.push('<p><b>' + key + ':</b> ' + value + '</p>')
                })
                return html.join('')
            }

            function operateFormatter(value, row, index) {
                return [
                    '<div style="min-width:60px!important" class="containter-fluid"><a class="details" href="javascript:void(0)" title="Details">',
                    '<i class="far fa-eye fa-fw"></i>',
                    '</a>  ',
                    '<a class="pdf" onclick="aOnClick(this)" href="' + raiz_url + '/complaints/complaintPDF/id/' + row.complaint_id + '" title="pdf">',
                    '<i class="fas fa-file-pdf fa-fw"></i>',
                    '</a> </div> ',

                ].join('')
            }

            window.operateEvents = {
                'click .details': function(e, value, row, index) {
                    getComplaintInfo(row.complaint_id).then(function(data) {
                        //
                        console.log('length' + data['data'].length);

                        if (data['data'].length) {
                            console.log(data['data'][0].complaint_description);
                            var origin;
                            var responseLink;
                            var divComplaintResponse;
                            $('#hComplaintFolio').empty().html(data['data'][0].complaint_folio);
                            origin = (data['data'][0].group_id == 2) ? 'Asociado' : 'Cliente';
                            $('#hOriginComplaint').empty().html('<h6>' + origin + '</h6>' + ' <h7 class="ml-0" >' + data['data'][0].name_data + '</h7>');
                            $('#divEmailCustomer').empty().html('<h6>Email</h6>' + ' <h7 class="ml-0" >' + data['data'][0].email_data + '</h7>');
                            $('#divStoreCustomer').empty().html('<h6>UBE</h6>' + ' <h7 class="ml-0" >' + data['data'][0].store_data + '</h7>');
                            $('#divSupervisor').empty().html('<h6>Supervisor</h6>' + ' <h7 class="ml-0" >' + data['data'][0].supervisor_data + '</h7>');
                            $('#divManager').empty().html('<h6>Gerente de zona</h6>' + ' <h7 class="ml-0" >' + data['data'][0].manager_data + '</h7>');
                            $('#divStatusComplaint').empty().html('<h6>Status</h6>' + ' <h7 class="ml-0" >' + data['data'][0].status_description + '</h7>');
                            $('#hComplaintRequest').empty().html(data['data'][0].description_request);
                            $('#hComplaintTitle').empty().html(data['data'][0].description_request);
                            $('#hRegisterDate').empty().html(data['data'][0].register_date);
                            $('#hComplaintDescription').empty().html(data['data'][0].complaint_description_full);
                            if (data['data'][0].status_id == 1 && data['data'][0].group_id == 1) { //queja clientes
                                divComplaintResponse = '';
                                responseLink = '<a href="' + raiz_url + '/complaints/createComplaintSolution/id/' + data['data'][0].complaint_id + '">Responder a la solicitud aquí</a>';
                                $('#divResponseLinkById').removeClass('text-left').addClass('text-right');
                            } else {
                                $('#divResponseLinkById').removeClass('text-right').addClass('text-left');

                                responseLink = '<h7 class="ml-0 text-left"><i class="fas fa-info-circle"></i> La respuesta a esta solicitud debe generarla el encargado del departamento correspondiente o el gerente de tu zona</h7>';
                                divComplaintResponse = '<h6>Respuesta o solución <small>' +
                                    data['data'][0].solved_date + '</small></h6><h7>' + data['data'][0].complaint_solution_full + '</h7>';
                            }

                            $('#divComplaintResponse').empty().html(divComplaintResponse);
                            $('#divResponseLinkById').empty().html(responseLink);
                            $('#modalComplaintInfoBySupervisor').modal('show');

                        }
                    });

                },

            }

            function headerStyle(column) {
                return {
                    complaint_folio: {
                        classes: 'tableHeader'
                    },
                    group_description: {
                        classes: 'tableHeader'
                    },
                    name_data: {
                        classes: 'tableHeader'
                    },
                    store_data: {
                        classes: 'tableHeader'
                    },
                    supervisor_data: {
                        classes: 'tableHeader'
                    },
                    supervisor_data: {
                        classes: 'tableHeader'
                    },

                    complaint_description: {
                        classes: 'tableHeader'
                    },

                    register_date: {
                        classes: 'tableHeader'
                    },
                    solved_date: {
                        classes: 'tableHeader'
                    },

                    user_name_data: {
                        classes: 'tableHeader'
                    },
                    department_description: {
                        classes: 'tableHeader'
                    },
                    category_description: {
                        classes: 'tableHeader'
                    },
                    priority_description: {
                        classes: 'tableHeader'
                    },
                    status_description: {
                        classes: 'tableHeader'
                    },
                    '': {
                        classes: 'tableHeader'
                    },


                } [column.field]
            }


            function initTable() {
                $table.bootstrapTable('destroy').bootstrapTable({
                    height: 600,
                    locale: 'es-MX',
                    exportTypes: ['csv', 'excel'],
                    columns: [
                        [


                            {
                                title: '',
                                field: '',
                                align: 'center',
                                //clickToSelect: false,
                                events: window.operateEvents,
                                formatter: operateFormatter
                            },
                            {
                                title: 'Status',
                                field: 'status_description',
                                align: 'center',
                                cellStyle: cellStyle,
                                //clickToSelect: false,
                                // events: window.operateEvents,
                                //  formatter: statusFormatter
                            },

                            {
                                title: '#',
                                field: 'complaint_folio',
                                // checkbox: true,
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                sortable: false,
                                //clickToSelect: false
                            },
                            {
                                title: 'Origen',
                                field: 'group_description',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            },
                            {
                                title: 'Nombre',
                                field: 'name_data',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            },
                            {
                                title: 'UBE',
                                field: 'store_data',
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                sortable: false,
                                //footerFormatter: totalTextFormatter
                            }, {
                                title: 'Supervisor',
                                field: 'supervisor_data',
                                //colspan: 3,
                                align: 'center'
                            },
                            {
                                title: 'Solicitud',
                                field: 'complaint_description',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            },
                            {
                                title: 'F.Registro',
                                field: 'register_date',
                                sortable: true,
                                align: 'center',
                                //footerFormatter: totalNameFormatter
                            },
                            {
                                title: 'F.Revisión',
                                field: 'solved_date',
                                //sortable: true,
                                align: 'center',
                                //footerFormatter: totalNameFormatter
                            }, {
                                title: 'Registrada por',
                                field: 'user_name_data',
                                //colspan: 3,
                                align: 'center'
                            }, {
                                title: 'Departamento',
                                field: 'department_description',
                                //colspan: 3,
                                align: 'center'
                            }, {
                                title: 'Tipo',
                                field: 'category_description',
                                //colspan: 3,
                                align: 'center'
                            }, {
                                title: 'Prioridad',
                                field: 'priority_description',
                                //colspan: 3,
                                align: 'center'
                            },

                        ]
                    ]
                })
                $table.on('check.bs.table uncheck.bs.table ' +
                    'check-all.bs.table uncheck-all.bs.table',
                    function() {
                        $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)

                        // save your data, here just save the current page
                        selections = getIdSelections()
                        // push or splice the selections if you want to save all data selections
                    })
                $table.on('all.bs.table', function(e, name, args) {
                    console.log(name, args)
                })
                $remove.click(function() {
                    var ids = getIdSelections()
                    $table.bootstrapTable('remove', {
                        field: 'id',
                        values: ids
                    })
                    $remove.prop('disabled', true)
                })
            }

            function getComplaintInfo(complaint_id) {

                return $.ajax({
                    url: raiz_url + '/api/complaints/getComplaintById?complaint_id=' + complaint_id,
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

            function getComplaintsByParams(THAT, e) {
                //dateFrom
                var inputStartDate = $('#starDate').val();
                var parseInputStartDate = moment.parseZone(inputStartDate).format("YYYY-MM-DD");
                console.log('Fecha para validar startdate' + parseInputStartDate);
                //var validStartDate = moment(parseInputStartDate);
                //dateTo
                var inputEndDate = $('#endDate').val();
                var parseInputEndDate = moment.parseZone(inputEndDate).format("YYYY-MM-DD");
                console.log('Fecha para validar enddate' + parseInputEndDate);
                // var validEndDate = moment(parseInputEndDate);
                //isValid());
                var dateFrom = (parseInputStartDate != 'Invalid date') ? parseInputStartDate : '';
                var dateTo = (parseInputEndDate != 'Invalid date') ? parseInputEndDate : '';
                //validations
                console.log('Es valida from?' + dateFrom);
                console.log('Es valida To?' + dateTo);
                $table.bootstrapTable("refresh", {
                    url: raiz_url + "/api/complaints/getComplaintsBySupervisor?store_id=" + $('#param_store_id').val() +
                        "&status_id=" + $('#param_status_id').val() +
                        "&dateFrom=" + dateFrom +
                        "&dateTo=" + dateTo
                });
                $(".loader").show().fadeOut();
            }


            function aOnClick(THAT) {
                console.log('click..');
                $(".loader").show().fadeOut();
                //$(THAT).html('cargando..');
            }


            $(function() {
                initTable()

                $('#locale').change(initTable)


            })
        </script>

        <!--enddatatable-->
    </div>
    <div class="row">
        <div class="col-md-12 text-right">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
        <div class="col-md-12 text-right">
            <br />
            <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
        </div>
    </div>
    </form>
</div>
@endsection

<!--MODAL -->
@include('modals.modalComplaintInfoBySupervisor')
