@extends('esqueleton.header')
@section('middleSection')

<script type="text/javascript">
    $(document).ready(function(e) {

       // $('#toastNotificationSuccess').toast('show');

    }); //enonready

    function generatePass(long, inputField) {
        var chars = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ2346789";
        var password = "";
        for (i = 0; i < long; i++) password += chars.charAt(Math.floor(Math.random() * chars.length));
        document.getElementById(inputField).value = password;
        document.getElementById(inputField).focus;
    }
</script>

<div class="card text-left border-0 mt-0" >
    <div class="card-header" style="background-color: #FFF" >
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Nuevo usuario </h3>
    </div>
    <div class="card-body">
        <form name="formUserProfile" id="formUserProfile" action="{{url('/api/users/createUser')}}" role="form" data-toggle="validator" method="post">
            <div class="row">
                <div class="clearfix"></div>
                <div class="container-fluid mt-3 mb-5">
                    <h7 class=""><i class="fas fa-info-circle fa-fw"></i> Por favor, revisa que los datos capturados estén correctos </h7>
                </div>
                <div class="col-md-6 col-sm-12">
                    <h6>Autoridad</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="auth_id" id="auth_id">

                            <?php
                            if (!empty($data['array_auth'])) :
                            ?>
                                <option selected="selected" value="">Selecciona alguna opción </option>
                                <?php
                                foreach ($data['array_auth'] as $rowAuth) :
                                ?>
                                    <option value="{{$rowAuth->auth_id}}">{{$rowAuth->auth_description}} </option>
                                <?php
                                endforeach;
                            else :
                                ?>
                                <option selected="selected" value="null">Niveles de autoridad no disponibles </option>
                            <?php
                            endif;
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                    <h6>Departamento</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary " name="department_id" id="department_id">

                            <?php
                            if (!empty($data['array_departments'])) :
                            ?>
                                <option selected="selected" value="">Selecciona alguna opción </option>

                                <?php
                                foreach ($data['array_departments'] as $rowDepartment) :
                                ?>
                                    <option value="{{$rowDepartment->department_id}}">{{$rowDepartment->department_description}} </option>
                                <?php
                                endforeach;
                                ?>
                                <option value="-1">No aplica para esta cuenta </option>
                            <?php
                            else :
                            ?>
                                <option selected="selected" value="null">Departamentos no disponibles </option>
                            <?php
                            endif;
                            ?>
                        </select>
                    </div>
                    <h6>Nombre(s)</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" maxlength="50" required id="first_name" name="first_name" placeholder="Nombre del usuario">
                        <div class="help-block with-errors"></div>
                    </div>
                    <h6>Apellidos(s)</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" maxlength="50" required id="last_name" name="last_name" placeholder="Apellido(s) del usuario ">
                        <div class="help-block with-errors"></div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-12">
                    <h6>Teléfono de contacto</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" maxlength="10" required id="phone" name="phone" placeholder="Ejem: 5554092141">
                        <div class="help-block with-errors"></div>
                    </div>
                    <h6>email</h6>
                    <div class="form-group ">
                        <input type="email" class="form-control" maxlength="50" required id="email" data-remote="{{URL('/users/validateUserEmail')}}" data-remote-error="La cuenta de email ya se encuentra registrada. Por favor, intenta con otra diferente." name="email" placeholder="Ejem: cuenta@ejemplo.com ">
                        <div class="help-block with-errors"></div>
                    </div>

                    <h6>Generar contraseña aleatoria</h6>
                    <div class="form-group ">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="password" value="" name="password" required placeholder="">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary btnOrderRed " onclick="generatePass('10','password');" type="button" id="button-addon1">
                                    <i class="fas fa-sync fa-fw"></i>
                                </button>
                            </div>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" id="btnCreateUserAccount" class="btn btn-primary btnOrderRed ">Guardar mi perfil</button>
                </div>
                <div class="col-md-12 text-right">
                    <br />
                    <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
                </div>
            </div>
        </form>
    </div>
    @include('modals.toastNotificationsSuccess')

    <!--endcardbody-->

</div>
<!--endcard-->
@endsection
