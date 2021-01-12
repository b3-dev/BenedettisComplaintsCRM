<?php

use Illuminate\Support\Facades\Route;
?>
<!doctype html>
<html lang="es">

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
    <!-- Bootstrap core CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;1,100&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    {!! Html::style('assets/bootstrap-4.5.2/dist/css/bootstrap.css') !!}
    {!! Html::style('assets/bootstrap-4.5.2/dist/css/bootstrap_hero.css') !!}
    {!! Html::style('assets/bootstrap-extension/css/4.5.1/bootstrap-extension.min.css') !!}
    <!--    {!! Html::style('assets/boostrap4.1.3/css/bootstrap.css') !!} -->
    <!--  {!! Html::style('assets/font-awesome-4.7.0/css/font-awesome.min.css') !!} -->
    {!! Html::style('assets/fontawesome-free-5.11.2-web/css/all.min.css') !!}
    {!! Html::style('assets/css/site.css') !!}
    <script src="{{ URL::asset('assets/jquery3/jquery3.1.1.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ URL::asset('assets/popper/popper1.14.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <script src="{{ URL::asset('assets/bootstrap-4.5.2/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/bootstrap-extension/js/4.5.1/bootstrap-extension.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/boostrap-validator/validator.js') }}" type="text/javascript"></script>
    <!-- Favicons -->

    <!--JS SITE-->
    <script src="{{ URL::asset('js/login/login.js') }}" type="text/javascript"></script>


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #FFFFFF !important;
        }


        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }
    </style>

</head>

<body class="text-center m-4">
    <div class="m-auto" style="background-color:#FFF !important;">
            <img class="mb-4" src="https://meganube.benedettis.com/casa/public/assets/images/system/imgLogoCasa.jpeg" alt="Benedetti's CASA" width="300">
            <h6 class="mb-3 font-weight-normal textBeneDanger"><i class="fas fa-exclamation-circle fa-fw"></i> {{$complaint_subjet}}</h6>
            <h7 class="mt-2"><b>Folio</b> {{ $complaint_folio }} </h7>
            <br />
            <h7 class="mt-2"><b>UBE</b> {{ $complaint_store }}  </h7>
            <br />
            <h7 class="mt-2"><b>Supervisor a cargo</b> {{ $complaint_supervisor }} </h7>
            <br />
            <h7 class="mt-2"><b>Fecha de registro</b> {{ $complaint_register_date }} </h7>
            <br />
            <h7 class="mt-2"><b>Prioridad</b> <i class="fas fa-exclamation-circle fa-fw"></i> {{ $complaint_priority }} </h7>
            <br />
            <hr />
            <h7 class="mt-2"><b>{{ $complaint_customer_header }}</b> {{ $complaint_customer_name }} </h7>
            <br />
            @if(!empty($complaint_customer_email) && strlen($complaint_customer_email)>1)
            <h7 class="mt-2"><b>Email</b> {{ $complaint_customer_email }} </h7>
            @endif

            @if(!empty($complaint_customer_phone) && strlen($complaint_customer_phone)>1)
            <br />
            <h7 class="mt-2"><b>Teléfono</b> {{ $complaint_customer_phone }} </h7>
            @endif
            <hr />
            <h7 class="mt-1"><b>Descripción de la solicitud </b></h7>
            <br />
            <p class="text-justify mt-2" style="max-width:500px !important;">
            {{ $complaint_description }}
            </p>

            <br />
            <br />
            <h7>Se les solicita de la manera más atenta atender la notificación a la brevedad posible
            <br />
            Favor de no contestar a este remitente

            <br/>
            <br />
            <small><b>{{ $complanint_footer }}</b></small>
            </h7>
    </div>
</body>
</html>


