<div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="modalChangePassword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="exampleModalCenterTitle">Cambio de contraseña</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="color:#F00" class="fas fa-times-circle fa-fw"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRecoveryProccess" name="formRecoveryProccess" role="form" data-toggle="validator" method="post">
                    <h7 class="mt-2 mb-3"><i class="fas fa-info-circle fa-fw"></i> Una vez que actualices tu contraseña de acceso deberás iniciar sesión nuevamente</h7>
                    <br/>
                    <div class="form-group mt-3">
                        <h6 for="post_email">Contraseña anterior </h6>
                        <div class="input-group mb-3">
                            <input type="password" required class="form-control" value="" autocomplete="none" id="post_password" name="post_password">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary btnOrderRed " onclick="showPassText(this,event,'post_password');" type="button" id="button-addon1">
                                    <i class="fas fa-eye fa-fw"></i>
                                </button>
                            </div>

                        </div>
                        <div class="text-left help-block with-errors"></div>
                    </div>
                    <br />
                    <div class="form-group">
                        <h6 for="post_email">Contraseña nueva </h6>
                        <div class="input-group mb-3">
                            <input type="password" required class="form-control" value="" minlength="8" autocomplete="none" id="post_new_password" name="post_new_password">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary btnOrderRed " onclick="showPassText(this,event,'post_new_password');" type="button" id="button-addon1">
                                    <i class="fas fa-eye fa-fw"></i>
                                </button>
                            </div>

                        </div>
                        <div class="text-left help-block with-errors"></div>
                    </div>
                    <br />
                    <div class="form-group">
                        <h6 for="post_email">Repite la contraseña nueva </h6>
                        <div class="input-group mb-3">
                            <input type="password" required class="form-control" value="" minlength="8" autocomplete="none" id="post_new_password_confirmation" name="post_new_password_confirmation">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary btnOrderRed " onclick="showPassText(this,event,'post_new_password_confirmation');" type="button" id="button-addon1">
                                    <i class="fas fa-eye fa-fw"></i>
                                </button>
                            </div>

                        </div>
                        <div class="text-left help-block with-errors"></div>
                    </div>

                    <br />
                    <h7 class="textBeneDanger" id="msgValidationErrors" ><br /></h7>
                    <br />
                    <button type="submit" id="btnChangeUserPassword" class="btn btnOrderRed btn-primary float-right mt-2" >Cambiar contraseña</button>
                </form>

            </div>

        </div>
    </div>
</div>
