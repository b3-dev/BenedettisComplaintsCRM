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
    {!! Html::style('assets/css/site.css?ver1.1') !!}
    <script src="{{ URL::asset('assets/jquery3/jquery3.1.1.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ URL::asset('assets/popper/popper1.14.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <script src="{{ URL::asset('assets/bootstrap-4.5.2/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/bootstrap-extension/js/4.5.1/bootstrap-extension.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/boostrap-validator/validator.js') }}" type="text/javascript"></script>

    <!--js files-->
    <script src="{{ URL::asset('js/user/user.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/complaints/complaints.js') }}" type="text/javascript"></script>



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

<body>
    <nav class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 ">
        <a class="col-md-3 col-lg-2 m-0 p-0" href="#">
            <img class="" src="{{ URL::asset('/assets/images/system/imgLogoCasaBlack.png') }}" alt="" width="200" class="p-0 m-0">
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
            </li>
        </ul>
    </nav>

    <div class="card col-lg-8 m-auto text-left border-0 mt-0">
        <div class="card-header" style="background-color: #FFF">
            <!--<h4>Especialidades y pizzas</h4>-->
            <h3>Encuesta de satisfacción </h3>
        </div>
        <div class="card-body">
            <form name="formCreateComplaint" id="formCreateComplaint" action="{{url('/api/complaints/createComplaint')}}" role="form" data-toggle="validator" method="post">
                <div class="row">
                    <div class="clearfix"></div>
                    <div class="container-fluid mt-2 mb-4">
                        <h6 class="">Tu opinión es muy importante para nosotros. Por favor, ayudanos a mejorar completando la siguiente encuesta . <br />¡Muchas gracias por tu preferencia!</h6>
                    </div>
                    <div class="col-12">
                        <h6 class="mt-2"><i class="fas fa-star fa-fw textBeneRed mr-2"></i>Considera que el trámite dado a su requerimiento, en términos de solución al mismo, logró que su petición haya sido:</h6>
                        <div class="form-group ">
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Solucionado</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">No solucionado</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Necesitan más tiempo para ser solucionado</span>
                                </h7>
                            </div>

                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h6 class="mt-2"><i class="fas fa-star fa-fw textBeneRed mr-2"></i>La atención en términos de oportunidad y rapidez en el tiempo de respuesta fue:</h6>
                        <div class="form-group ">
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Excelente</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Buena</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Regular</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Mala</span>
                                </h7>
                            </div>

                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h6 class="mt-2"><i class="fas fa-star fa-fw textBeneRed mr-2"></i>¿La respuesta, dada a su requerimiento por el GRUPO DE QUEJAS Y RECLAMOS cumplió sus expectativas?</h6>
                        <div class="form-group ">
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Si</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">No</span>
                                </h7>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h6 class="mt-2"><i class="fas fa-star fa-fw textBeneRed mr-2"></i>La respuesta dada por el DEPARTAMENTO o COLABORADOR contra quien dirigió su requerimiento, cumplió sus expectativas, en términos de solución, o explicación de las razones de la respuesta, y fue:</h6>
                        <div class="form-group ">
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Excelente</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Buena</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Regular</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Mala</span>
                                </h7>
                            </div>

                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h6 class="mt-2"><i class="fas fa-star fa-fw textBeneRed mr-2"></i>La atención recibida por parte del GRUPO DE QUEJAS Y RECLAMOS, en términos de AMABILIDAD fue:</h6>
                        <div class="form-group ">
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Excelente</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Buena</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Regular</span>
                                </h7>
                            </div>
                            <div class="radio">
                                <h7>
                                    <input type="radio" name="underwear" required>
                                    <span class="ml-2">Mala</span>
                                </h7>
                            </div>

                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <!--endcustomerdata-->
                    <div class="col-12">
                        <h6 class="mt-2"><i class="fas fa-star fa-fw textBeneRed mr-2"></i> Tiene algún comentario respecto a la forma como el Grupo de Quejas prestó el servicio:</h6>
                        <div class="form-group ">
                            <textarea class="form-control" required id="post_description" name="post_description" placeholder="Ejem: expresa tu comentario aquí"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>

                </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" id="btnCreateComplaintRecord" class="btn btn-primary btnOrderRed ">Guardar</button>
            </div>
            <div class="col-md-12 text-right">
                <br />
                <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
            </div>
        </div>
        </form>
    </div>
</body>

</html>
