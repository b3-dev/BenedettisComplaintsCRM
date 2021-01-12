@extends('esqueleton.header')
@section('middleSection')

{!! Html::style('assets/bootstrap-table-master/dist/bootstrap-table.css') !!}
<script src="{{ URL::asset('assets/jqueryTableExport/tableExport.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/bootstrap-table.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/bootstrap-table-locale-all.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/extensions/export/bootstrap-table-export.min.js') }}"></script>


<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <h3>UBE's </h3>
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


        <table id="table"
            data-toolbar="#toolbar"
            data-search="false"
            data-show-refresh="false"
            data-show-toggle="true"
            data-show-fullscreen="false"
            data-show-columns="true"
            data-show-columns-toggle-all="true"
            data-detail-view="false"
            data-show-export="true"
            data-click-to-select="false"
            data-detail-formatter="detailFormatter"
            data-minimum-count-columns="2"
            data-show-pagination-switch="false"
            data-header-style="headerStyle"
            data-pagination="true"
            data-id-field="id"
            data-page-list="[10, 25, 50, 100, all]"
            data-page-size="100"
            data-show-footer="true" data-side-pagination="server"
            data-ajax-options="ajaxOptions"
            data-url="{{ url('/api/stores/getStores') }}"
            data-response-handler="responseHandler">
        </table>

        <script>
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

            function detailFormatter(index, row) {
                var html = []
                $.each(row, function(key, value) {
                    html.push('<p><b>' + key + ':</b> ' + value + '</p>')
                })
                return html.join('')
            }

            function operateFormatter(value, row, index) {
                return [
                    '<a class="like" href="javascript:void(0)" title="Like">',
                    '<i class="fa fa-heart"></i>',
                    '</a>  ',
                    '<a class="remove" href="javascript:void(0)" title="Remove">',
                    '<i class="fa fa-trash"></i>',
                    '</a>'
                ].join('')
            }

            window.operateEvents = {
                'click .like': function(e, value, row, index) {
                    alert('You click like action, row: ' + JSON.stringify(row))
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
                    id_unidad: {
                        classes: 'tableHeader'
                    },
                    nombre_unidad: {
                        classes: 'tableHeader'
                    },
                    domicilio_unidad: {
                        classes: 'tableHeader'
                    },
                    colonia_unidad: {
                        classes: 'tableHeader'
                    },
                    codigo_postal_unidad: {
                        classes: 'tableHeader'
                    },
                    telefono_unidad: {
                        classes: 'tableHeader'
                    },


                } [column.field]
            }


            function initTable() {
                $table.bootstrapTable('destroy').bootstrapTable({
                    height: 550,
                    locale: 'es-MX',
                    exportTypes: ['csv', 'excel'],
                    columns: [
                        [{
                                title: '#',
                                field: 'id_unidad',
                                // checkbox: true,
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                sortable: true,
                                //clickToSelect: false
                            }, {
                                title: 'Nombre',
                                field: 'nombre_unidad',
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                sortable: true,
                                //footerFormatter: totalTextFormatter
                            }, {
                                title: 'Calle',
                                field: 'domicilio_unidad',
                                //colspan: 3,
                                align: 'center'
                            },
                            {
                                title: 'Colonia',
                                field: 'colonia_unidad',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            }, {
                                title: 'C.P',
                                field: 'codigo_postal_unidad',
                                //sortable: true,
                                align: 'center',
                                //footerFormatter: totalNameFormatter
                            }, {
                                title: 'Teléfono',
                                field: 'telefono_unidad',
                                align: 'center',
                                //clickToSelect: false,
                                // events: window.operateEvents,
                                // formatter: operateFormatter
                            }
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
</div>
@endsection
