<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Dashboard Template · Bootstrap</title>


    <!-- Bootstrap core CSS -->
    {!! Html::style('assets/bootstrap-4.5.2/dist/css/bootstrap.css') !!}
    {!! Html::style('assets/bootstrap-4.5.2/dist/css/bootstrap_hero.css') !!}
    {!! Html::style('assets/bootstrap-extension/css/4.5.1/bootstrap-extension.min.css') !!}
    <!--    {!! Html::style('assets/boostrap4.1.3/css/bootstrap.css') !!} -->
    <!--  {!! Html::style('assets/font-awesome-4.7.0/css/font-awesome.min.css') !!} -->
    {!! Html::style('assets/fontawesome-free-5.11.2-web/css/all.min.css') !!}
    <script src="{{ URL::asset('assets/jquery3/jquery3.1.1.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ URL::asset('assets/popper/popper1.14.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <script src="{{ URL::asset('assets/bootstrap-4.5.2/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/bootstrap-extension/js/4.5.1/bootstrap-extension.min.js') }}" type="text/javascript"></script>
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/4.5/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/4.5/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/4.5/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
    <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon.ico">
    <meta name="msapplication-config" content="/docs/4.5/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">


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
    <nav class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 m-0 p-0" href="#">
             <img class="" src="{{ URL::asset('/assets/images/system/imgLogoCASA.jpeg') }}" alt="" width="200"  class="p-0 m-0">
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#">Salir</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse">
        <div class="clearfix"><br /></div>

        <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link mt-3" href="#">
                                <i class="fas fa-tachometer-alt fa-fw"></i>
                                DASHBOARD <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <h6 class="sidebar-heading d-flex justify-content-between px-0 align-items-center mt-3 mb-1" >
                            <a class="nav-link" href="#">
                            <i class="fas fa-exclamation-triangle fa-fw"></i> Incidencias
                            </a>
                            <a class="d-flex align-items-center pr-3" href="#" aria-label="Add a new report">
                                <span data-feather="plus-circle"></span>
                            </a>
                        </h6>
                        <li class="nav-item px-4">
                            <a class="nav-link text-black-50" href="#">
                                Mes actual
                            </a>
                        </li>


                        <h6 class="sidebar-heading d-flex justify-content-between px-0 align-items-center mt-3 mb-1 ">
                            <a class="nav-link" href="#">
                                 <i class="fas fa-info-circle fa-fw"></i> SUGERECIAS</span>
                            </a>
                            <a class="d-flex align-items-center pr-3" href="#" aria-label="Add a new report">
                                <span data-feather="plus-circle"></span>
                            </a>
                        </h6>
                        <li class="nav-item px-4">
                            <a class="nav-link text-black-50" href="#">
                                Mes actual
                            </a>
                        </li>
                        <h6 class="sidebar-heading d-flex justify-content-between px-0 align-items-center mt-3 mb-1 ">
                            <a class="nav-link " href="#">
                                <i class="fas fa-store-alt fa-fw"></i> Mis UBE's</span>
                            </a>
                        </h6>
                        <h6 class="sidebar-heading d-flex justify-content-between px-0 align-items-center mt-3 mb-1 ">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user fa-fw"></i> Perfil de usuario</span>
                            </a>

                        </h6>

                        <li class="nav-item px-4">
                            <a class="nav-link text-black-50" href="#">
                                Cambiar mi contraseña
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="card text-left border-0 mt-0">
            <div class="card-header" style="background-color: #FFF">
                <!--<h4>Especialidades y pizzas</h4>-->
                <h3>Información complementaria </h3>
            </div>
            <div class="card-body">
                <form name="formCreateCustomer" id="formCreateCustomer" action="{{url('createCustomer')}}" role="form" data-toggle="validator" method="post">
                    <div class="row">
                        <div class="col-12">
                            <h7 class="mt-2 "> <i class="fas fa-map-marker-alt"></i> Repartir en <b><span id="spantextLocationCustomer">{{ $data['fullAddress'] }}</span></b> <a href="#" onclick="openModalChangeAddress(event)" data-toggle="modal" class="ml-2"> Cambiar calle/No.exterior</a></h7>
                        </div>
                        <div class="clearfix"></div>
                        <div class="container-fluid mt-3 mb-5">
                            <h7 class="">Antes de disfrutar de una deliciosa pizza, por favor proporcionanos algunos datos para crear tu cuenta </h7>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h6>Número interior</h6>
                            <div class="form-group ">
                                <input type="text" class="form-control" id="RG_NO_INT" name="RG_NO_INT" placeholder="Número interior">
                            </div>
                            <h6>Referencia de tu domicilio </h6>
                            <div class="form-group ">
                                <input type="text" class="form-control" maxlength="50" required id="RG_REFERECE" name="RG_REFERECE" placeholder="Ejem: Casa en esquina, portón negro ">
                                <div class="help-block with-errors"></div>
                            </div>
                            <h6>No. Teléfono</h6>
                            <div class="form-group">
                                <input type="text" pattern="^[0-9]{1,}$" maxlength="10" class="form-control" id="RG_PHONE" name="RG_PHONE" placeholder="ejem:5555326671">
                                <div class="help-block with-errors"></div>
                            </div>
                            <h6>Celular</h6>
                            <div class="form-group">
                                <input type="text" pattern="^[0-9]{1,}$" maxlength="10" class="form-control" id="RG_PHONE_CELL" name="RG_PHONE_CELL" required placeholder="ejem:5555326671">
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h6>Nombre</h6>
                            <div class="form-group ">
                                <input type="text" class="form-control" id="RG_FIRSTNAME" name="RG_FIRSTNAME" required placeholder="Nombre">
                                <div class="help-block with-errors"></div>
                            </div>

                            <h6>Apellido</h6>
                            <div class="form-group ">
                                <input type="text" class="form-control" id="RG_LASTNAME" name="RG_LASTNAME" required placeholder="Apellido">
                                <div class="help-block with-errors"></div>
                            </div>

                            <h6>Email</h6>
                            <div class="form-group ">
                                <input type="email" class="form-control" id="RG_EMAIL" name="RG_EMAIL" data-remote="" data-remote-error="La cuenta de email ya se encuentra registrada. Por favor, intenta con otra diferente." placeholder="email@ejemplo.com" required placeholder="email@ejemplo.com">
                                <div class="help-block with-errors"></div>
                            </div>
                            <h6>Contraseña de acceso </h6>
                            <div class="form-group ">
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="RG_PASSWORD" data-minlength="6" data-error="Por favor, llena este campo. Mínimo 6 caracteres" name="RG_PASSWORD" required placeholder="">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-primary btnOrderRed " onclick="" type="button" id="button-addon1">
                                            <i class="fas fa-eye fa-fw"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <h6>Repite tu contraseña </h6>
                            <div class="form-group ">
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" data-match="#RG_PASSWORD" data-match-error="Las contraseñas no coinciden" id="RG_RE_PASSWORD" name="RG_RE_PASSWORD" required placeholder="">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-primary btnOrderRed " onclick="showPassText(this,event,'RG_RE_PASSWORD');" type="button" id="button-addon1">
                                            <i class="fas fa-eye fa-fw"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <h6 class="mt-2 font-weight-bold"><?= $data['web_desc_status_garantia_ube'] ?></h6>
                            <br />
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="chkTerms" name="chkTerms" required value='1' class="custom-control-input">
                                    <label class="custom-control-label control-label" for="chkTerms">
                                        <small class="text-secondary">
                                            Acepto que soy mayor de 18 años y he leido los términos y condiciones.
                                            Acepto que mis datos personales sean tratados conforme a los términos y condiciones, así como al aviso de privacidad.
                                            Acepto las condiciones de garantia de reparto de la sucursal asignada

                                        </small>
                                    </label>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <br />
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="chkPromoOk" name="chkPromoOk" value='1' class="custom-control-input">
                                    <label class="custom-control-label control-label" for="chkPromoOk">
                                        <small class="text-secondary">
                                            Deseo recibir promociones de Benedetti's a mi email
                                        </small>
                                    </label>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <input type="hidden" name="currentLat" id="currentLat" value="">
                            <input type="hidden" name="currentLong" id="currentLong" value="">
                            <input type="hidden" name="REG_STORE_ID" id="REG_STORE_ID" value="">
                            <input type="hidden" name="REG_ZIPCODE" id="REG_ZIPCODE" value="">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" id="btnCreateCustomerRecord" class="btn btn-primary btnOrderRed ">Registrarme</button>
                        </div>
                        <div class="col-md-12 text-right">
                            <br />
                            <h5> <a class="float-right" href="{{ url('/') }}">Cambiar mi ubicación &rsaquo;</a></h5>
                        </div>
                    </div>
                </form>
            </div>

            <br>
            <br>
        </div>

            </main>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="{{ URL::asset('assets/bootstrap-4.5.2/site/docs/4.5/examples/dashboard/dashboard.js') }}"></script>

</body>

</html>
