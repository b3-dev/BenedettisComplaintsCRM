@extends('esqueleton.header')
@section('middleSection')
<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Usuarios registrados </h3>
    </div>
    <div class="card-body">
        <!--datatable -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Autoridad</th>
                    <th scope="col">F.Creación</th>
                    <th scope="col">Ultimo acceso</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">100</th>
                    <td>Soriana</td>
                    <td>Domicilio</td>
                    <td>Telefono</td>
                </tr>
                <tr>
                    <th scope="row">100</th>
                    <td>Soriana</td>
                    <td>Domicilio</td>
                    <td>Telefono</td>
                </tr>

            </tbody>
        </table>

        <!--enddatatable-->
    </div>
    <div class="row">
        <div class="col-md-12 text-right">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
        <div class="col-md-12 text-right">
            <br />
            <h5> <a class="float-right" href="{{ url('/') }}">Ir al inicio</a></h5>
        </div>
    </div>
</div>
@endsection
