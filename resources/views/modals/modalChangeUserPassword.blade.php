<div class="modal fade" id="modalChangeUserPassword" tabindex="-1" role="dialog" aria-labelledby="modalChangeUserPassword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="exampleModalCenterTitle">Cambio de contraseña</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="color:#F00" class="fas fa-times-circle fa-fw"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formChangeUserPassword" name="formChangeUserPassword" role="form" data-toggle="validator" method="post">
                    <h7 class="mt-2 mb-3"><i class="fas fa-info-circle fa-fw"></i> Reestablece la contraseña de acceso de la cuenta de usuario aquí</h7>
                    <br/>
                    <br/>
                    <br/>
                    <div class="form-group ">
                        <h6>Generar contraseña aleatoria</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="post_password" value="" name="post_password" required placeholder="">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary btnOrderRed " onclick="generatePass('10','post_password');" type="button" id="button-addon1">
                                    <i class="fas fa-sync fa-fw"></i>
                                </button>
                            </div>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                    <br />

                    <h7 class="textBeneDanger" id="msgValidationErrorsPassword" ></h7>
                    <br />
                    <input type="hidden" name="post_user" id="post_user" value="">
                    <button type="submit" id="btnChangeUserPassword" class="btn btnOrderRed btn-primary float-right mt-2" >Cambiar contraseña</button>
                </form>

            </div>

        </div>
    </div>
</div>
