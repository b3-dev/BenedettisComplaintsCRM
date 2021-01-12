@extends('esqueleton.header')
@section('middleSection')
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.css">
<script src="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.js"></script>
<link href="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.17.1/dist/extensions/export/bootstrap-table-export.min.js"></script>

<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Respuesta a solicitud registrada</h3>
    </div>
    <div class="card-body">
         <h5 class="mb-3 font-weight-normal textBeneGreen "> <i class="far fa-check-circle fa-fw fa-2x"></i>
         Enhorabuena, tu respuesta a la solicitud ha sido registrada exitosamente</h5>



    </div>
    <div class="row">
        <div class="col-md-12 text-right">

        </div>
        <div class="col-md-12 text-right">
            <br />
            <h5> <a class="float-right" href="{{ url('/'.$data['HtmlViewReturn']) }}">Ir a solicitudes</a></h5>
        </div>
    </div>
    </form>
</div>
@endsection

