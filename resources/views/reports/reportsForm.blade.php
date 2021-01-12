@extends('esqueleton.header')
@section('middleSection')
<script type="text/javascript">
    $(document).ready(function(e) {

       // $('#formGenerateReport').validator();
        $('#formGenerateReport').validator().on('submit', function (e) {
            $('#btnGenerateReport').html('<i class="fas fa-circle-notch fa-fw fa-spin"></i> Generando ..');

        });
    });
</script>
<div class="card text-left border-0 mt-0">
    <form name="formGenerateReport" id="formGenerateReport" action="{{url('reports/processorReport')}}" role="form" data-toggle="validator" method="post">

        <div class="card-header" style="background-color: #FFF">
            <!--<h4>Especialidades y pizzas</h4>-->
            <h3>Reportes </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="clearfix"></div>
                <div class="container-fluid mt-3 mb-5">
                    <h7 class=""><i class="fas fa-info-circle"></i> Para generar algún reporte predefinido, selecciona los parámetros que a continuación se indican </h7>
                </div>
                <div class="col-md-12">
                    <h6>Por tipo</h6>

                    <div class="form-group ">

                        <select class="custom-select text-secondary " required name="post_type_report" id="post_type_report">
                            <option selected="selected" value="">Selecciona alguna opción </option>
                            <option value="1">Por tipo </option>
                           <?php /* <option value="2">Supervisor/Gerente de zona </option>
                            <option value="3">Por zona </option>
                            <option value="4">UBE's con más quejas </option> */?>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-12">
                    <h6>PP</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary " name="post_pp" id="post_pp">
                            @if(!empty($data['PP']))
                            <option selected="selected" value="null">Selecciona alguna opción </option>
                            @for($i=$data['PPInit']; $i<=$data['PP'];$i++) <option value="{{ $i }}">P{{ $i }} </option>
                                @endfor
                                @else
                                <option selected="selected" value="-1">No se identificaron periodos </option>

                                @endif
                        </select>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h6>PA</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary " name="post_pa" id="post_pa">
                            @if(!empty($data['PA']))
                            <option selected="selected" value="null">Selecciona alguna opción </option>
                            @for($i=$data['PAInit']; $i<=$data['PA'];$i++) <option value="{{ $i }}">P{{ $i }} </option>
                                @endfor
                                @else
                                <option selected="selected" value="-1">No se identificaron periodos </option>

                                @endif

                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" id="btnGenerateReport" class="btn btn-primary btnOrderRed ">Generar reporte</button>
            </div>
            <div class="col-md-12 text-right">
                <br />
                <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
            </div>
        </div>
    </form>
</div>
@endsection
