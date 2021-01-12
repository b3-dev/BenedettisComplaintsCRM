@extends('esqueleton.header')
@section('middleSection')

{!! Html::style('assets/bootstrap-table-master/dist/bootstrap-table.css') !!}
<script src="{{ URL::asset('assets/jqueryTableExport/tableExport.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/bootstrap-table.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/bootstrap-table-locale-all.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/extensions/export/bootstrap-table-export.min.js') }}"></script>

<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Felicitaciones registradas ({{date('Y')}})</h3>
    </div>
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

        </div>

        <table id="table"
            data-toolbar="#toolbar"
            data-search="false"
            data-show-refresh="false"
            data-show-toggle="true"
            data-show-fullscreen="false"
            data-show-columns="true"
            data-show-columns-toggle-all="true"
            data-detail-view="false" data-show-export="true"
            data-click-to-select="false"
            data-detail-formatter="detailFormatter"
            data-minimum-count-columns="2"
            data-show-pagination-switch="false"
            data-pagination="true"
            data-header-style="headerStyle"
            data-id-field="suggest_id"
            data-page-list="[10, 25, 50, 100, all]"
            data-show-footer="false"
            data-side-pagination="server"
            data-ajax-options="ajaxOptions"
            data-url="{{ url('/api/congratulations/getCongratulations') }}"
            data-response-handler="responseHandler">
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
                   /* '<a class="pdf" href="javascript:void(0)" title="pdf">',
                    '<i class="fas fa-file-pdf fa-fw"></i>',
                    '</a> ',*/
                    '</div>',

                ].join('')
            }

            window.operateEvents = {
                'click .details': function(e, value, row, index) {
                    console.log('row'+JSON.stringify(row.congratulation_id));
                    getCongratulationInfo(row.congratulation_id).then(function(data) {
                        //
                        console.log(row);
                        console.log('group id' +data['data'][0].group_id);

                        if (data['data'].length) {
                            console.log(data['data'][0].complaint_description_full);
                            var origin;
                            $('#hCongratulationFolio').empty().html(data['data'][0].congratulation_folio);
                            origin = (data['data'][0].group_id == 2) ? 'Asociado' : 'Cliente';
                            $('#hOriginCongratulation').empty().html('<h6>'+origin + '</h6> <h7 class="ml-0" >' + data['data'][0].name_data + '</h7>');
                            $('#hCongratulationCustomer').empty().html(data['data'][0].name_data);

                            $('#divEmailCustomer').empty().html('<h6>Email</h6>' + ' <h7 class="ml-0" >' + data['data'][0].email_data + '</h7>');
                            $('#hRegisterDate').empty().html(data['data'][0].register_date);
                            $('#hCongratulationDescription').empty().html(data['data'][0].congratulation_description_full);

                            $('#modalCongratulationInfo').modal('show');

                        }
                    });

                },
                'click .remove': function(e, value, row, index) {
                    $table.bootstrapTable('remove', {
                        field: 'id',
                        values: [row.id]
                    })
                }
            }

            function totalTextFormatter(data) {
                return 'Total'
            }

            function totalNameFormatter(data) {
                return data.length
            }

            function totalPriceFormatter(data) {
                var field = this.field
                return '$' + data.map(function(row) {
                    return +row[field].substring(1)
                }).reduce(function(sum, i) {
                    return sum + i
                }, 0)
            }

            function headerStyle(column) {
                return {
                    congratulation_folio: {
                        classes: 'tableHeader'
                    },
                    group_description: {
                        classes: 'tableHeader'
                    },
                    name_data: {
                        classes: 'tableHeader'
                    },
                    congratulation_description: {
                        classes: 'tableHeader'
                    },
                    register_date: {
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
                    exportTypes: ['csv', 'excel' ],
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
                                title: '#',
                                field: 'congratulation_folio',
                                // checkbox: true,
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                sortable: true,
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
                                title: 'Felicitación',
                                field: 'congratulation_description',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            },
                            {
                                title: 'F.Registro',
                                field: 'register_date',
                                //sortable: true,
                                align: 'center',
                                //footerFormatter: totalNameFormatter
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

            function getCongratulationInfo(congratulation_id) {

                return $.ajax({
                    url: raiz_url + '/api/congratulations/getCongratulationById?congratulation_id=' + congratulation_id,
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
@include('modals.modalCongratulationInfo')
