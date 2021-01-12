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
        <h3 >Últimas encuestas registradas </h3>
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
            .textUnder{
                text-decoration: underline;
                font-weight: bold;
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
            data-detail-view="false"
            data-show-export="true"
            data-click-to-select="false"
            data-header-style="headerStyle"
            data-detail-formatter="detailFormatter"
            data-minimum-count-columns="2"
            data-show-pagination-switch="false"
            data-pagination="true" data-id-field="id"
            data-page-list="[10, 25, 50, 100, all]"
            data-show-footer="false"
            data-side-pagination="server"
            data-ajax-options="ajaxOptions"
            data-url="{{ url('/api/surveys/getSurveys') }}"
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


            function operateFormatter(value, row, index) {
                return [
                    '<a class="surveydetail" href="javascript:void(0)" title="surveydetail">',
                    '<i class="far fa-eye fa-fw"></i>',
                    '</a>  ',
                    '<a class="pdf" onclick="javascript:aOnClick(this)" href="' + raiz_url + '/surveys/surveyPDF/id/' + row.survey_id + '" title="pdf">',
                    '<i class="fas fa-file-pdf fa-fw"></i>',
                    '</a>  ',

                ].join('')
            }

            window.operateEvents = {
                'click .surveydetail': function(e, value, row, index) {
                    getSurveyInfo(row.survey_id).then(function(data) {
                        var dataJson = data['data'];
                        console.log('length' + dataJson[0].survey_id);

                        console.log('data' + data.survey_id);
                        //console.log('user' + dataArrayUser);
                        if (dataJson.length) {
                            $('#hSurveyFolio').html(dataJson[0]['survey_folio']);
                            $('#hRegisterSurveyDate').html(dataJson[0]['register_survey_date']);
                            $('#hPartnerData').html(dataJson[0]['partner_data']);
                            $('#hComplaintFolio').html(dataJson[0]['complaint_folio']);
                            $('#hCommentSurvey').html(dataJson[0]['comment_survey']);
                            $('#divDetailSurvey').empty();
                            var htmlDetail = '';
                            $.each(dataJson[0].cuestions, function(ARRAY_ID, ROW_CUESTION) {
                                console.log('aca auth' + ROW_CUESTION.cuestion_id);
                                htmlDetail += '<div  class="cuestion mt-2"><h7><strong>' +ROW_CUESTION.cuestion_id+'</strong> '+ROW_CUESTION.text+'</h7>';
                                htmlDetail += '<div class="m-4">';
                                $.each(ROW_CUESTION.answers, function(ARRAY_ANSWER, ROW_ANSWER) {
                                    var selected = (ROW_ANSWER.selected == 'true') ? 'checked disabled' : '';
                                    var spanClass = (ROW_ANSWER.selected == 'true') ? 'textBeneSuccess textUnder' : '';

                                    htmlDetail += '<div class="clearfix"></div>';
                                    htmlDetail += '<h7 >';
                                    htmlDetail += '<input type="radio" '+selected+'   >';
                                    htmlDetail += '<span class="'+spanClass+' ml-2 " >'+ROW_ANSWER.text+'</span>';
                                    htmlDetail += '</h7>';

                                });
                                htmlDetail += '</div>';
                                htmlDetail += '</div>';

                            });

                            $('#divDetailSurvey').html(htmlDetail);

                            // console.log(data['data'][0].survey_id);
                            $('#modalSurveyInfo').modal('show');

                        }
                        //$('#modalSurveyInfo').modal('show');
                        //mandar modal de detalle..
                        // alert('You click like action, row: ' + JSON.stringify(row))
                    });
                },

            }

            function headerStyle(column) {
                return {
                    survey_folio: {
                        classes: 'tableHeader'
                    },
                    partner_name_data: {
                        classes: 'tableHeader'
                    },
                    complaint_folio: {
                        classes: 'tableHeader'
                    },
                    comment_survey: {
                        classes: 'tableHeader'
                    },
                    register_survey_date: {
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
                                field: 'survey_folio',
                                // checkbox: true,
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                sortable: false,
                                //clickToSelect: false
                            },
                            {
                                title: 'Asociado',
                                field: 'partner_name_data',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            },

                            {
                                title: '#Solicitud',
                                field: 'complaint_folio',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            },
                            {
                                title: 'Comentario',
                                field: 'comment_survey',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            },
                            {
                                title: 'F.Registro',
                                field: 'register_survey_date',
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                sortable: true,
                                //footerFormatter: totalTextFormatter
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

            function getSurveyInfo(survey_id) {

                return $.ajax({
                    url: raiz_url + '/api/surveys/getSurveyById?survey_id=' + survey_id,
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
@include('modals.modalSurveyInfo')
