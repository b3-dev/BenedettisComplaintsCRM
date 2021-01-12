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

    <script src="{{ URL::asset('assets/moment/moment.js') }}" type="text/javascript"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/gijgo@1.9.13/js/messages/messages.es-es.js" type="text/javascript"></script>

    <!-- Favicons -->
    <!-- Favicons -->

    <script src="{{ URL::asset('js/user/user.js?ver1.0') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/complaints/complaints.js?ver=1.0') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/suggestions/suggestions.js?ver=1.0') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/congratulations/congratulations.js?ver=1.0') }}" type="text/javascript"></script>


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
    {!! Html::style('assets/bootstrap-4.5.2/site/docs/4.5/examples/dashboard/dashboard.css') !!}

</head>

<body >
    <div class="loader">

    </div>
    <nav  class="navbar navbar-dark sticky-top  flex-md-nowrap p-0 " style="background-color:#B81E2A !important">
        <a class="col-md-3 col-lg-2 m-0 p-2" href="#">
            <img class="" src="{{ URL::asset('/assets/images/system/imgLogoCasaBlack.png') }}" alt="" width="150" class="p-2 m-3">
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link " href="{{ url('/logout')}}" style="color:#FFF !important">
                    <h6>Salir</h6>
                </a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse">
                <div class="clearfix"><br /></div>
                    <!--menu-->
                    @include('esqueleton.menu')
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

                @yield('middleSection')
                <!--endsecction-->
            </main>
        </div>
    </div>

    <script src="{{ URL::asset('assets/bootstrap-4.5.2/site/docs/4.5/examples/dashboard/dashboard.js') }}"></script>

</body>

</html>
