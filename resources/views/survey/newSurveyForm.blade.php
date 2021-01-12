<?php

use Illuminate\Support\Facades\Route;
use App\Survey;

?>
<!doctype html>
<html lang="es">

<head>

    <head>
        <script type="text/javascript">
            var raiz_url = "{{ url('/') }}";
        </script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="conten-type" content="text/html; charset=UTF-8" />
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="CASA">
        <meta name="author" content="Eduardo Pérez">
        <meta name="generator" content="Benedetti's Platform Development">
        <title>Benedetti's Pizza</title>

        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;1,100&display=swap" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        {!! Html::style('assets/bootstrap-4.5.2/dist/css/bootstrap.css') !!}
        {!! Html::style('assets/bootstrap-4.5.2/dist/css/bootstrap_hero.css') !!}
        {!! Html::style('assets/bootstrap-extension/css/4.5.1/bootstrap-extension.min.css') !!}
        <!--    {!! Html::style('assets/boostrap4.1.3/css/bootstrap.css') !!} -->
        <!--  {!! Html::style('assets/font-awesome-4.7.0/css/font-awesome.min.css') !!} -->
        {!! Html::style('assets/fontawesome-free-5.11.2-web/css/all.min.css') !!}
        {!! Html::style('assets/css/site.css?ver1.5') !!}
        <script src="{{ URL::asset('assets/jquery3/jquery3.1.1.min.js') }}" type="text/javascript"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="{{ URL::asset('assets/popper/popper1.14.min.js') }}" type="text/javascript"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
        <script src="{{ URL::asset('assets/bootstrap-4.5.2/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/bootstrap-extension/js/4.5.1/bootstrap-extension.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/boostrap-validator/validator.js') }}" type="text/javascript"></script>
        {!! Html::style('assets/bootstrap-4.5.2/site/docs/4.5/examples/dashboard/dashboard.css') !!}
        <script src="{{ URL::asset('js/surveys/surveys.js') }}" type="text/javascript"></script>

        <!-- Favicons -->
        <!-- Favicons -->



        <script type="text/javascript">
            $(window).on("load", function(e) {
                $(".loader").show().fadeOut();


            });
        </script>


        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <!-- Custom styles for this template -->

    </head>

<body>

    <nav class="navbar navbar-dark sticky-top  flex-md-nowrap p-0 " style="background-color:#B81E2A !important">
        <a class="col-md-3 col-lg-2 m-0 p-2" href="#">
            <img class="" src="{{ URL::asset('/assets/images/system/imgLogoCasaBlack.png') }}" alt="" width="150" class="p-2 m-3">
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
            </li>
        </ul>
    </nav>
    <div class="clearfix"></div>
    <div class="card text-left">
        <div class="card-header" style="background-color: #FFF">
            <!--<h4>Especialidades y pizzas</h4>-->
            <h3>Encuesta de satisfacción </h3>
            <div class="col-md-6 col-sm-12 mt-3 p-0">
                    <h7>Referente a la solicitud <h7 class="textBeneDanger" id="hComplaintFolio">#{{$data['complaint_folio']}}</h7></h7>

                </div>
        </div>
        <div class="card-body">

            @if(!empty($data['array_cuestions']))
            <form name="formCreateSurvey" id="formCreateSurvey" action="{{url('/api/surveys/createSurvey')}}" role="form" data-toggle="validator" method="post">
                <div class="row">
                    <div class="clearfix"></div>
                    <div class="container-fluid mt-2 mb-3">
                        <h6 ><span style="font-size:25px;" class="text-secondary">¡ Hola {{ $data['user_name']}}!</span> <br /><i class="fas fa-info-circle fa-fw mt-3"></i> tu opinión es muy importante para nosotros. Por favor, ayudanos a mejorar nuestra atención y servicio completando la siguiente encuesta. <br />¡Muchas gracias por tu preferencia!</h6>
                    </div>

                    @foreach($data['array_cuestions'] as $rowCuestion)
                    <?php
                    $dataCuestion['cuestion_id'] = $rowCuestion->cuestion_id;
                    $arrayAnswers = Survey::getAnswersByCuestion($dataCuestion);

                    ?>
                    @if(!empty($arrayAnswers))
                    <div class="col-12 mt-3">
                        <h6>{{$rowCuestion->cuestion_description}}</h6>
                        <div class="form-group ">

                            @foreach($arrayAnswers as $rowAnswer)
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="resp_cuestion[{{$rowCuestion->cuestion_id}}] " value="{{ $rowAnswer->answer_id  }}" required>
                                    <span class="ml-2">{{$rowAnswer->answer_description}}</span>
                                </h7>
                            </div>
                            @endforeach
                            <!--endanswers -->
                            <div class="help-block with-errors"></div>
                        </div>
                        <!--endformgroup-->
                    </div>
                    <!--endcol12-->
                    @endif
                    @endforeach


                    <!--endcustomerdata-->
                    <div class="col-12">
                        <h6>Tiene algún comentario respecto a la forma como el Grupo de Quejas prestó el servicio:</h6>
                        <div class="form-group ">
                            <textarea class="form-control" id="post_comment_survey" name="post_comment_survey" placeholder="Expresa tu comentario aquí"></textarea>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 mt-3 text-right">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="complaint_id" value="{{ $data['complaint_id'] }}">
                        <input type="hidden" name="partner_id" value="{{ $data['partner_id'] }}">
                        <input type="hidden" name="user_id" value="{{ $data['user_id'] }}">
                        <button type="submit" id="btnCreateSurvey" class="btn btn-primary btnOrderRed ">Guardar encuesta</button>
                    </div>
                    <div class="col-md-12 text-right">
                        <br />
                    </div>
                </div>
            </form>
        </div>

        @else
        <h6 class="m-5">¡Ups! No pudimos obtener los datos necesarios </h6>
        @endif
    </div>

</body>

</html>
