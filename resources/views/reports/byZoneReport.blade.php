@extends('esqueleton.header')
@section('middleSection')

<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Reportes </h3>
    </div>
    <div class="card-body">
        <form name="formCreateCustomer" id="formCreateCustomer" action="{{url('createCustomer')}}" role="form" data-toggle="validator" method="post">
            <div class="row">
                <div class="clearfix"></div>
                <div class="container-fluid mt-3 mb-5">
                    <h7 class="">Antes de disfrutar de una deliciosa pizza, por favor proporcionanos algunos datos para crear tu cuenta </h7>
                </div>
                <div class="col-md-12">
                    <h6>Por tipo</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary " name="size_item" id="size_item_detail">
                            <option selected="selected" value="">Selecciona alguna opción </option>
                            <option>10 Sevilla </option>
                            <option>8 Galvan </option>
                            <option value="-1">Aplica para todas mis UBE's </option>

                        </select>
                    </div>

                </div>
                <div class="col-md-6 col-sm-12">


                    <h6>PP</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary " name="size_item" id="size_item_detail">
                            <option selected="selected" value="">Selecciona alguna opción </option>

                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">


                    <h6>PA</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary " name="size_item" id="size_item_detail">
                            <option selected="selected" value="">Selecciona alguna opción </option>

                        </select>
                    </div>
                </div>


            </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" id="btnCreateCustomerRecord" class="btn btn-primary btnOrderRed ">Generar reporte</button>
        </div>
        <div class="col-md-12 text-right">
            <br />
            <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
        </div>
    </div>
    </form>
</div>
@endsection
