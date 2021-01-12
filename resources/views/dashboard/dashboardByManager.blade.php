@extends('esqueleton.header')
@section('middleSection')
<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <h3>Dashboard </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-black mb-3 border-0">
                    <div class="card-header ">Solicitudes ({{date('Y')}})</div>
                    <div class="card-body">
                        <h5 class="card-title">Registradas</h5>
                        <h3 class="card-text text-right">
                            <?php
                            $complaintsRegistered = (!empty($data['complaints_registered'])) ? count($data['complaints_registered']) : 0;
                            echo $complaintsRegistered;
                            ?>


                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 mx-auto">
                <div class="card text-black mb-3 border-0">
                    <div class="card-header">Solicitudes ({{date('Y')}})</div>
                    <div class="card-body">
                        <h5 class="card-title">Pendientes</h5>
                        <h3 class="card-text text-right textBeneDanger">
                            <?php
                            $complaintsPending = (!empty($data['complaints_pending'])) ? count($data['complaints_pending']) : 0;
                            ?>
                            @if($complaintsPending>0)
                            <i class="fas fa-exclamation-circle fa-fw"></i> {{ $complaintsPending }}
                            @else
                            {{ 0 }}
                            @endif
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-black mb-3 border-0">
                    <div class="card-header ">Solicitudes ({{date('Y')}})</div>
                    <div class="card-body">
                        <h5 class="card-title">Solucionadas</h5>
                        <h3 class="card-text text-right textBeneSuccess">
                            <?php
                            $complaintsSolved = (!empty($data['complaints_solved'])) ? count($data['complaints_solved']) : 0;
                            ?>
                            @if($complaintsSolved>0)
                            <i class="fas fa-check-circle fa-fw"></i> {{ $complaintsSolved }}
                            @else
                            {{ 0 }}
                            @endif

                        </h3>
                    </div>
                </div>
            </div>

        </div>


    </div>

</div>
@endsection
