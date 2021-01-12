@extends('esqueleton.header')
@section('middleSection')


<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Solución o respuesta de solicitud</h3>
    </div>
    <div class="card-body">
        <form name="formSolveComplaint" id="formSolveComplaint" action="{{url('/api/complaints/solveComplaint')}}" role="form" data-toggle="validator" method="post">
            <div class="row">
                <div class="clearfix"></div>
                <div class="container-fluid mt-3 mb-4">
                    <h7 class="">Por favor, detalla la solución o respuesta a la solicitud registrada. Se claro y concreto </h7>
                </div>
                <div class="col-12">
                    <h6>Folio </h6>
                    <h7 class="textBeneRed">{{$data['arrayComplaint']['complaint_folio']}}</h7>
                </div>
                <?php
               // dd($data['arrayComplaint']);
                ?>

                <div class="col-12 mt-4">
                    <h6>{{$data['arrayComplaint']['description_request']}}</h6>
                    <h7 >{{$data['arrayComplaint']['complaint_description_full']}}</h7>

                </div>

                <div class="col-12 mt-4">
                    <h6>Por favor, describe la respuesta ó solución aquí</h6>
                    <div class="form-group ">
                        <textarea class="form-control" required id="post_description" name="post_description" placeholder="Ejem: describenos tu respuesta ó solución de la solicitud "></textarea>
                        <div class="help-block with-errors"></div>
                    </div>

                </div>

            </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <h7 id="msgLoginError" class="mr-2 textBeneDanger"></h7>
            <div class="clearfix"><br /></div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="complaint_id" value="{{$data['arrayComplaint']['complaint_id']}}">

            <button type="submit" id="btnSolveComplaintRecord" class="btn btn-primary btnOrderRed mt-1 ">Guardar</button>
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
