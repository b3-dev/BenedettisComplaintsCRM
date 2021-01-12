@extends('esqueleton.header')
@section('middleSection')

<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Perfil de usuario </h3>
    </div>
    <div class="card-body">
        <form name="formUserProfile" id="formUserProfile" action="{{url('createCustomer')}}" role="form" data-toggle="validator" method="post">
            <div class="row">

                <div class="clearfix"></div>
                <div class="container-fluid mt-3 mb-5">
                    <h7 class="">Cambia tu contraseña de acceso al portal. </h7>
                </div>
                <div class="col-12">
                    <h6>Cotraseña anterior</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" maxlength="50" required id="RG_REFERECE" name="RG_REFERECE" placeholder="Ejem: Casa en esquina, portón negro ">
                        <div class="help-block with-errors"></div>
                    </div>
                    <h6>Contraseña nueva</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" maxlength="50" required id="RG_REFERECE" name="RG_REFERECE" placeholder="Ejem: Casa en esquina, portón negro ">
                        <div class="help-block with-errors"></div>
                    </div>
                    <h6>Repite la nueva contraseña</h6>
                    <div class="form-group ">
                        <input type="text" class="form-control" maxlength="50" required id="RG_REFERECE" name="RG_REFERECE" placeholder="Ejem: Casa en esquina, portón negro ">
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
                    <button type="submit" id="btnCreateCustomerRecord" class="btn btn-primary btnOrderRed ">Cambiar mi contraseña</button>
                </div>
                <div class="col-md-12 text-right">
                    <br />
                    <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
                </div>
            </div>
        </form>
    </div>
    <!--endcardbody-->

</div>
<!--endcard-->
@endsection
