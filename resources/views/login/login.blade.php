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
    {!! Html::style('assets/css/site.css?ver1.2') !!}
    <script src="{{ URL::asset('assets/jquery3/jquery3.1.1.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ URL::asset('assets/popper/popper1.14.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/bootstrap-4.5.2/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/bootstrap-extension/js/4.5.1/bootstrap-extension.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/boostrap-validator/validator.js') }}" type="text/javascript"></script>

    <!--JS SITE-->
    <script src="{{ URL::asset('js/login/login.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        window.localStorage.removeItem('access_token');
    </script>

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
            background-color: #f5f5f5;
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

<body class="text-center m-4" >
    <div class="m-auto" style="max-width:400px !important">
        <form id="formLogin" name="formLogin" role="form" data-toggle="validator" method="post">
            <img class="mb-4 img-fluid" src="{{ URL::asset('/assets/images/system/imgLogoCasa.png') }}" alt="" width="400">
            <h5 class="mb-3 font-weight-normal text-left">Acceso</h5>

            <div class="form-group">
                <label for="post_email" class="sr-only">Email </label>
                <input type="email" id="post_email" name="post_email" class="form-control" placeholder="Email" required >
                <div class="text-left help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="post_password" class="sr-only">Password</label>
                <input type="password" id="post_password" name="post_password" class="form-control" placeholder="Password" required>
                <div class="text-left help-block with-errors"></div>
            </div>

            <br />
            <button id="btnLogin" class="mt-2 mb-2 btn btn-lg btn-primary btnOrderRed btn-block" type="submit">Entrar</button>
        </form>
        <h7 id="msgLoginError"  class="mt-3 textBeneDanger"><br /></h7>
        <div class="clearfix"></div>
        <a  href="{{url('/login/recoveryAccess')}}"><h6 class="m-3">¿Olvidaste tu contraseña?</h6></a>
    </div>

</body>

</html>

