@extends('esqueleton.header')
@section('middleSection')
<?php
use App\Store;
?>

<script type="text/javascript">
    var arrayStores;

</script>

<div class="card text-left border-0 mt-0">
    <div class="card-header" style="background-color: #FFF">
        <!--<h4>Especialidades y pizzas</h4>-->
        <h3>Nueva solicitud </h3>
    </div>
    <div class="card-body">
        <form name="formCreateComplaintByPartner" id="formCreateComplaintByPartner" action="{{url('/api/complaints/createComplaintByPartner')}}" role="form" data-toggle="validator" method="post">
            <div class="row">
                <div class="clearfix"></div>
                <div class="container-fluid mt-3 mb-5">
                    <h7 class="">Por favor, completa el formulario siguiente </h7>
                </div>
                <div class="col-12">
                    <h6>UBE</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="post_store" id="post_store" >

                            @if(!empty($data['array_stores']))

                                <option selected="selected" value="">Selecciona alguna opción </option>

                                @foreach ($data['array_stores'] as $rowStore)
                                    <?php
                                        $data['id_unidad']=$rowStore->store_id;
                                        $arrayStoreName=Store::getStoreById($data);
                                        $storeName=(!empty($arrayStoreName))?$arrayStoreName[0]->id_unidad.' '.$arrayStoreName[0]->nombre_unidad:'N/A';
                                    ?>
                                    <option value="{{$rowStore->store_id}}">{{$storeName}} </option>

                                @endforeach
                            @else

                                <option selected="selected" value="null">UBE's no disponibles </option>

                            @endif

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-12">
                    <h6>Tipo de solicitud</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="post_category_request" id="post_category_request" >
                            <option selected="selected" value="">Selecciona alguna opción </option>
                            <option value="1" >Incidencia</option>
                            <option value="2" >Consulta</option>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <!--endcustomerdata-->
                <div class="col-md-6 col-sm-12">

                    <h6>Departamento</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="post_department" id="post_department">
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
                            else :
                                ?>
                                <option selected="selected" value="null">Datos no disponibles </option>
                            <?php
                            endif;
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>

                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                <?php
                /*    <h6>Categoría</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="post_category" id="post_category">
                            <?php
                            if (!empty($data['array_categories'])) :
                            ?>
                                <option selected="selected" value="null">Selecciona alguna opción </option>
                                <?php
                                foreach ($data['array_categories'] as $rowCategories) :
                                ?>
                                    <option value="{{$rowCategories->category_id}}">{{$rowCategories->category_description}} </option>
                                <?php
                                endforeach;
                            else :
                                ?>
                                <option selected="selected" value="null">Datos no disponibles </option>
                            <?php
                            endif;
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>

                    </div>

                    */?>
                    <h6>Prioridad de urgencia</h6>
                    <div class="form-group ">
                        <select class="custom-select text-secondary" required name="post_urgency" id="post_urgency">
                            <?php
                            if (!empty($data['array_priority'])) :
                            ?>
                                <option selected="selected" value="">Selecciona alguna opción </option>
                                <?php
                                foreach ($data['array_priority'] as $rowPriority) :
                                ?>
                                    <option value="{{$rowPriority->priority_id}}">{{$rowPriority->priority_description}} </option>
                                <?php
                                endforeach;
                            else :
                                ?>
                                <option selected="selected" value="null">Datos no disponibles </option>
                            <?php
                            endif;
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-12">
                    <h6>Por favor, describe tu solicitud</h6>
                    <div class="form-group ">
                        <textarea class="form-control" required id="post_description" name="post_description" placeholder="Describenos lo sucedido aquí"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>

                </div>

            </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <h7 id="msgMessageError"  class="m-3 textBeneDanger"><br /></h7>
            <br />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="post_category" id="post_category" value="1" >
            <input type="hidden" name="post_group" id="post_group" value="2" >
            <input type="hidden" name="post_partner" id="post_partner" value="{{Auth::user()->user_id}}" >

            <button type="submit" id="btnCreateComplaintRecord" class="btn btn-primary btnOrderRed mt-1 ">Guardar</button>
        </div>
        <div class="col-md-12 text-right">
            <br />
            <h5> <a class="float-right" href="{{ url('/dashboardByPartner') }}">Ir al inicio</a></h5>
        </div>
    </div>
    </form>
</div>
@endsection
