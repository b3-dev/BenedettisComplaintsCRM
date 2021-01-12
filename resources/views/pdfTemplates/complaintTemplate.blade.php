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
    <meta http-equiv="conten-type" content="text/html; charset=UTF-8" />
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="description" content="CASA">
    <meta name="author" content="Eduardo Pérez">
    <meta name="generator" content="Benedetti's Platform Development">
    <title>Benedetti's Pizza</title>
    <!-- Bootstrap core CSS -->
    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" type="text/css" href="./assets/bootstrap-4.5.2/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/bootstrap-4.5.2/dist/css/bootstrap_hero.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/site.css">
    <link rel="stylesheet" type="text/css" href="./assets/fontawesome-free-5.11.2-web/css/all.min.css">

    <!--    {!! Html::style('assets/boostrap4.1.3/css/bootstrap.css') !!} -->
    <!--  {!! Html::style('assets/font-awesome-4.7.0/css/font-awesome.min.css') !!} -->
    <script src="./assets/jquery3/jquery3.1.1.min.js" type="text/javascript"></script>
    <script src="./assets/bootstrap-4.5.2/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/bootstrap-extension/js/4.5.1/bootstrap-extension.min.js" type="text/javascript"></script>
    <!-- Favicons -->
    <!--JS SITE-->
    <style>
        @font-face {
            font-family: 'Roboto-Regular';
            src: url('./assets/fonts/Roboto/Roboto-Regular.ttf') format('truetype')
        }

        body {
            font-family: 'Roboto-Regular' !important;
        }

        fieldset {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend {
            font-size: 1.2em !important;
            text-align: left !important;
            width: inherit;
            /* Or auto */
            padding: 0 10px;
            /* To give a bit of padding on the left and right */
            border-bottom: none;
            margin-top: -10px !important;
        }

        .badgePdfPrimary {
            border-radius: 10px;
            background-color: #B81E2A !important;
            color: #FFF;
        }

        .labelPdfResponse{
            font-size: 0.8em !important;
            margin-top: -10px !important;
            color:#3c4c54 !important;

        }
        .pSecondary{
            font-size: 0.8em !important;
            color:#3c4c54 !important;
        }

    </style>

</head>

<body>
    <div>
        <div style="float:left;  width:20%;" class="text-left">
            <img class="" src="./assets/images/system/imgLogoCasaBlack.png" alt="" width="150" class="p-2 m-3">
        </div>
        <div style="float:left;  width:80%;" class="text-left">
                <h5 style="margin-left:40px !important">Solicitud de {{strtolower($arrayComplaint['customer_type'])}}
                <br />
                <span style="margin-left:40px !important;  margin-top:-14px !important; font-size:12px !important">Impreso por <b>{{ $user_name }}  </b>  {{ date('Y-m-d h:i:s') }}</span>

                </h5>

        </div>
        <div style="clear:both"></div>
    </div>
    <div style="clear:both"></div>
    <div>
        <fieldset style="border:solid !important" class="mt-3">
            <legend>Solicitud <span style="color:#F00">#{{ $arrayComplaint['complaint_folio'] }}</span></legend>
            <br />
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Tipo de solicitud </span>
                <br />
                <label class="labelPdfResponse" > {{ $arrayComplaint['description_request'] }} </label>

            </div>
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">UBE </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['store_data'] }}  </label>


            </div>
            <div style="float:left;  width:33%; " class="text-left">
                <span class="badge badgePdfPrimary">#F.Registro </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['register_date'] }}  </label>

            </div>
            <div class="clearfix"></div>
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">#F.Revisión </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['solved_date'] }}  </label>
            </div>

            <!--line-->
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Supervisor a cargo </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['supervisor_data'] }}  </label>


            </div>

            <div style="float:left;  width:33%; " class="text-left">
                <span class="badge badgePdfPrimary">Gerente de zona </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['manager_data'] }} </label>


            </div>
            <div class="clearfix"></div>

            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Zona </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['name_zone'] }} </label>

            </div>

            <!--line 3-->


            <div style="float:left; width:33%; " class="text-left">
                <span class="badge badgePdfPrimary">Prioridad </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['priority_description'] }} </label>


            </div>
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Status </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['status_description'] }} </label>

            </div>
            <div class="clearfix"></div>
            <!--line 3 asociado-->
            @if($arrayComplaint['group_id']==2)
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Departamento </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['department_description'] }} </label>

            </div>
            @else
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Categoría </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['category_description'] }} </label>

            </div>
            @endif
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Solicitud por parte de </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['customer_type'] }} </label>

            </div>
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Generada por </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['user_name_data'] }} </label>

            </div>
            <div class="clearfix"></div>

        </fieldset>

        <!--line 3-->
        <div class="clearfix"><br /></div>
        <fieldset style="border:solid !important" class="mt-1">
            <legend>Información del {{strtolower($arrayComplaint['customer_type'])}}</legend>
            <br />
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Nombre </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['name_data'] }} </label>

            </div>
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Email </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['email_data'] }} </label>

            </div>
            <div style="float:left;  width:33%;" class="text-left">
                <span class="badge badgePdfPrimary">Teléfono </span>
                <br />
                <label class="labelPdfResponse" >{{ $arrayComplaint['phone_data'] }} </label>

            </div>

            <div class="clearfix"></div>


        </fieldset>
        <!--line 4-->
        <div class="clearfix"><br /></div>
        <fieldset style="border:solid !important" class="mt-1">
            <legend>Descripción de la {{ strtolower($arrayComplaint['description_request']) }}</legend>
            <br />
            <div style="float:left; width:100%;" class="text-left">
                <p class="pSecondary">{{ $arrayComplaint['complaint_description_full'] }}</p>
            </div>

            <div class="clearfix"></div>


        </fieldset>

        <div class="clearfix"><br /></div>
        <fieldset style="border:solid !important" class="mt-1">
            <legend>Respuesta ó solución</legend>
            <br />
            <div style="float:left;  width:100%;" class="text-left">
                <p class="pSecondary">{{ $arrayComplaint['complaint_solution_full'] }}</p>
            </div>

            <div class="clearfix"></div>


        </fieldset>





    </div>



</body>

</html>
