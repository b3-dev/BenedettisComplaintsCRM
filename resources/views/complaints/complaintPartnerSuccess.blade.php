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
        <h3>Solicitud registrada</h3>
    </div>
    <div class="card-body">
        <h5 class="mb-3 font-weight-normal textBeneGreen "> <i class="far fa-check-circle fa-fw fa-2x"></i>
            Enhorabuena, tu solicitud ha sido registrada exitosamente</h5>

        <br />
        <p>Los detalles para el seguimiento son los siguientes:
            <br />
            <br />

            <h7 class="m-5">Folio <b><span id="complaintNo">{{ str_pad($data['arrayComplaint'][0]->complaint_id, 7, "0", STR_PAD_LEFT) }}</span></b></h7>
            <br />
            <h7 class="m-5">UBE <b><span id="complaintUbe">{{ $data['arrayComplaint'][0]->store_id }}</span></b></h7>
            <br />
            <h7 class="m-5">Supervisor a cargo <b><span id="supervisorName">{{ $data['arraySupervisor']->first_name.' '.$data['arraySupervisor']->last_name }}</span></b></h7>
            <br />
            <h7 class="m-5">Gerente de zona a cargo <b><span id="managerName">{{ $data['arrayManager']->first_name.' '.$data['arrayManager']->last_name }}</span></b></h7>
            <br />

        </p>

        <br />
        <p><i class="fas fa-info-circle fa-fw"></i> También se ha generado una notificación de email para:
            @if(!empty($data['arrayEmails']))
                <br />
                <br />
                @foreach($data['arrayEmails'] as $row)
                <a class="m-5" href="mailto:{{$row['email']}}"><h7>{{$row['email']}}</h7></a><br />
                @endforeach
            @endif
        </p>




    </div>
    <div class="row">
        <div class="col-md-12 text-right">

        </div>
        <div class="col-md-12 text-right">
            <br />
            <h5> <a class="float-right" href="{{ url('/complaintReportByPartner') }}">Ver mis solicitudes</a></h5>
        </div>
    </div>
    </form>
</div>
@endsection
