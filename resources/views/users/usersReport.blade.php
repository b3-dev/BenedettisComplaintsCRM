@extends('esqueleton.header')
@section('middleSection')
{!! Html::style('assets/bootstrap-table-master/dist/bootstrap-table.css') !!}
<script src="{{ URL::asset('assets/jqueryTableExport/tableExport.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/bootstrap-table.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/bootstrap-table-locale-all.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-table-master/dist/extensions/export/bootstrap-table-export.min.js') }}"></script>

<script type="text/javascript">
    //onReady

    $(document).ready(function(e) {


        $('#formChangeUserPassword').validator().on('submit', function(e) {
            $('#msgValidationErrorsPassword').hide();

            var HTML_ITEM_CONTENT = $('#btnChangeUserPassword').html();
            if (e.isDefaultPrevented()) {
                console.log('prevented..')
            } else {
                e.preventDefault();
                $('#btnChangeUserPassword').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Actualizando ..');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                    },
                });

                $.ajax({
                    url: raiz_url + '/api/users/changeUserPasswordById',
                    type: 'POST',
                    dataType: 'json',
                    context: this,
                    data: $('#formChangeUserPassword').serialize(),

                }).done(function(data) {
                    console.log(data);
                    if (data['success'] == true) {
                        $('#table').bootstrapTable('refresh');
                        $('#btnChangeUserPassword').html(HTML_ITEM_CONTENT);
                        $('#msgValidationErrorsPassword').empty()
                            .removeClass('textBeneDanger')
                            .addClass('textBeneSuccess')
                            .html('<i class="far fa-check-circle fa-fw"></i> ' + data['msg']).show();
                        //ENVIAR ALERTA DE ALTA..
                        console.log(data);
                    } else {
                        $('#btnChangeUserPassword').html(HTML_ITEM_CONTENT);
                        $('#msgValidationErrorsPassword').empty()
                            .removeClass('textBeneSuccess')
                            .addClass('textBeneDanger')
                            .html('<i class="far fa-check-circle fa-fw"></i> ' + data['msg']).show().effect('shake');
                        $('#btnChangeUserPassword').effect("shake");
                    }

                }).fail(function(jqXHR, textStatus) {
                    //console.log(jqXHR.responseText);
                    if (textStatus == 'parsererror') {
                        $('#msgValidationErrorsPassword').empty()
                            .removeClass('textBeneSuccess')
                            .addClass('textBeneDanger')
                            .html('<i class="far fa-check-circle fa-fw"></i> ' + textStatus).show().effect('shake');
                        $('#btnChangeUserPassword').html(HTML_ITEM_CONTENT).effect("shake");
                    } else {
                        var response = JSON.parse(jqXHR.responseText);
                        console.log('response' + response.msg);
                        $('#msgValidationErrorsPassword').empty()
                            .removeClass('textBeneSuccess')
                            .addClass('textBeneDanger')
                            .html('<i class="far fa-check-circle fa-fw"></i> ' + response['msg']).show().effect('shake');
                        $('#btnChangeUserPassword').html(HTML_ITEM_CONTENT).effect("shake");
                    }

                });
            }
        });


        $('#formDeleteUser').validator().on('submit', function(e) {
            $('#msgValidationErrorsDelete').hide();

            var HTML_ITEM_CONTENT = $('#btnDeleteUser').html();
            if (e.isDefaultPrevented()) {
                console.log('prevented..')
            } else {
                e.preventDefault();
                $('#btnDeleteUser').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Actualizando ..');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                    },
                });

                $.ajax({
                    url: raiz_url + '/api/users/deleteUserById',
                    type: 'POST',
                    dataType: 'json',
                    context: this,
                    data: $('#formDeleteUser').serialize(),

                }).done(function(data) {
                    console.log(data);
                    if (data['success'] == true) {
                        $('#table').bootstrapTable('refresh');
                        $('#btnDeleteUser').html(HTML_ITEM_CONTENT);
                        $('#modalConfirmDeleteUser').modal('hide');
                        $('#toastNotificationSuccess').toast('show');
                        $('#h7textMsg').empty().html('<i class="far fa-check-circle"></i> ' + data['msg']);

                    } else {
                        $('#btnDeleteUser').html(HTML_ITEM_CONTENT);
                        $('#msgValidationErrorsDelete').empty()
                            .removeClass('textBeneSuccess')
                            .addClass('textBeneDanger')
                            .html('<i class="far fa-check-circle fa-fw"></i> ' + data['msg']).show().effect('shake');
                        $('#btnDeleteUser').effect("shake");
                    }

                }).fail(function(jqXHR, textStatus) {
                    var response = JSON.parse(jqXHR.responseText);
                    console.log('response' + response.msg);
                    $('#msgValidationErrorsDelete').empty()
                        .removeClass('textBeneSuccess')
                        .addClass('textBeneDanger')
                        .html('<i class="far fa-check-circle fa-fw"></i> ' + response['msg']).show().effect('shake');
                    $('#btnDeleteUser').html(HTML_ITEM_CONTENT).effect("shake");
                });
            }
        });


        $('#modalChangeUserPassword').on('shown.bs.modal', function() {
            $('#post_password').val('');
            $('#msgValidationErrorsPassword').empty().html('<br />');
        })

    }); //enonready
</script>


<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Usuarios registrados </h3>
    </div>
    <div class="card-body">
        <!--datatable -->

        <style>
            .select,
            #locale {
                width: 100%;
            }
        </style>

        <table id="table" data-toolbar="#toolbar" data-search="false" data-show-refresh="false" data-show-toggle="true" data-header-style="headerStyle" data-show-fullscreen="false" data-show-columns="true" data-show-columns-toggle-all="false" data-detail-view="false" data-show-export="true" data-click-to-select="false" data-detail-formatter="detailFormatter" data-minimum-count-columns="2" data-show-pagination-switch="false" data-pagination="false" data-id-field="user_id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="false" data-side-pagination="server" data-ajax-options="ajaxOptions" data-url="{{ url('/api/users/getUsers') }}" data-response-handler="responseHandler">
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
                    '<div style="min-width:60px!important" class="containter-fluid"><a class="details" href="javascript:void(0)" title="details">',
                    '<i class="far fa-eye fa-fw mr-1"></i>',
                    '</a>  ',
                    '<a class="password" href="javascript:void(0)" title="password">',
                    '<i class="fas fa-lock fa-fw mr-1"></i>',
                    '</a>',
                    '<a class="delete" href="javascript:void(0)" title="delete">',
                    '<i class="far fa-trash-alt fa-fw"></i>',
                    '</a> </div> ',
                ].join('')
            }

            window.operateEvents = {
                'click .details': function(e, value, row, index) {

                    getUserInfo(row.user_id).then(function(data) {
                        //
                        var dataArrayAuth = JSON.stringify(data['data'].array_auth);
                        var dataArrayUser = JSON.stringify(data['data'].array_user);
                        var dataArrayDepartment = JSON.stringify(data['data'].array_department);

                        console.log('data' + dataArrayUser.length);
                        console.log('user' + dataArrayUser);

                        if (dataArrayUser.length) {
                            var selectAuth = JSON.parse(dataArrayAuth);
                            var selectDepartment = JSON.parse(dataArrayDepartment);
                            var rowUser = JSON.parse(dataArrayUser);
                            console.log('row user' + rowUser.user_id);
                            if (selectAuth.length) {
                                $('#post_auth_id').empty();
                                $.each(selectAuth, function(ARRAY_ID, ROW) {
                                    console.log('aca auth');
                                    $('#post_auth_id').append('<option value="' + ROW.auth_id + '" >' + ROW.auth_description + '</option>');
                                });
                                //department
                                if (selectDepartment.length) {
                                    $('#post_department_id').empty();
                                    var selectedIDepartmentId = 0;
                                    $.each(selectDepartment, function(ARRAY_ID, ROW) {
                                        console.log('aca auth');
                                        $('#post_department_id').append('<option value="' + ROW.department_id + '" >' + ROW.department_description + '</option>');
                                    });

                                    $('#post_department_id').append('<option value="-1" >No aplica para esta cuenta</option>');
                                }
                                selectedIDepartmentId = (rowUser.department_id > 0) ? rowUser.department_id : -1;
                                console.log('department id' + selectedIDepartmentId);
                                $('#post_auth_id').val(rowUser.auth_id);
                                $('#post_department_id').val(selectedIDepartmentId);
                                $('#post_first_name').val(rowUser.first_name);
                                $('#post_last_name').val(rowUser.last_name);
                                $('#post_email').val(rowUser.email);
                                $('#post_phone').val(rowUser.phone);
                                $('#post_user_id').val(rowUser.user_id);
                                $('#msgValidationErrors').empty().html('');
                                $('#modalUserProfile').modal('show');
                            } else {
                                alert('error al traer información')
                            }


                        }
                    });

                    // $('#modalUserProfile').modal('show');
                    // alert('You click like action, row: ' + JSON.stringify(row))
                },
                'click .password': function(e, value, row, index) {
                    console.log('aca=' + row.user_id);
                    $('#post_user').val(row.user_id);
                    $('#modalChangeUserPassword').modal('show');
                },
                'click .delete': function(e, value, row, index) {
                    console.log('aca=' + row.user_id);
                    $('#post_user_delete').val(row.user_id);
                    $('#modalConfirmDeleteUser').modal('show');
                }

            }

            function getUserInfo(user_id) {

                return $.ajax({
                    url: raiz_url + '/api/users/getUserById?user_id=' + user_id,
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

            function headerStyle(column) {
                return {
                    user_id: {
                        classes: 'tableHeader'
                    },
                    first_name: {
                        classes: 'tableHeader'
                    },
                    last_name: {
                        classes: 'tableHeader'
                    },
                    email: {
                        classes: 'tableHeader'
                    },
                    password: {
                        classes: 'tableHeader'
                    },
                    auth_description: {
                        classes: 'tableHeader'
                    },
                    auth_description: {
                        classes: 'tableHeader'
                    },
                    data_department: {
                        classes: 'tableHeader'
                    },
                    created_at: {
                        classes: 'tableHeader'
                    },

                    '': {
                        classes: 'tableHeader'
                    },


                } [column.field]
            }


            function initTable() {
                $table.bootstrapTable('destroy').bootstrapTable({
                    height: 700,
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
                            },{
                                title: 'ID',
                                field: 'user_id',
                                // checkbox: true,
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                //clickToSelect: false
                            }, {
                                title: 'Nombre(s)',
                                field: 'first_name',
                                //rowspan: 2,
                                align: 'center',
                                valign: 'middle',
                                sortable: true,
                                //footerFormatter: totalTextFormatter
                            }, {
                                title: 'Apellidos',
                                field: 'last_name',
                                //colspan: 3,
                                align: 'center'
                            },
                            {
                                title: 'Email',
                                field: 'email',
                                //sortable: true,
                                //footerFormatter: totalNameFormatter,
                                align: 'center'
                            }, {
                                title: 'Password-Crypt',
                                field: 'password',
                                //sortable: true,
                                align: 'center',
                                //footerFormatter: totalNameFormatter
                            }, {
                                title: 'Autoridad',
                                field: 'auth_description',
                                align: 'center',
                                //clickToSelect: false,
                                // events: window.operateEvents,
                                // formatter: operateFormatter
                            },
                            {
                                title: 'Departamento',
                                field: 'data_department',
                                align: 'center',
                                //clickToSelect: false,
                                // events: window.operateEvents,
                                // formatter: operateFormatter
                            },

                            {
                                title: 'F.Creación',
                                field: 'created_at',
                                align: 'center',
                                //clickToSelect: false,
                                // events: window.operateEvents,
                                // formatter: operateFormatter
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
    @include('modals.toastNotificationsSuccess')


</div>
@endsection
@include('modals.modalUserProfile')
@include('modals.modalChangeUserPassword')
@include('modals.modalConfirmDeleteUser')
