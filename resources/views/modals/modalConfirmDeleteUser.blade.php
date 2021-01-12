<div class="modal fade" id="modalConfirmDeleteUser" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="exampleModalCenterTitle">Desactivar cuenta de usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="color:#F00" class="fas fa-times-circle fa-fw"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDeleteUser" name="formDeleteUser" role="form" data-toggle="validator" method="post">
                    <h7 class="mt-2 mb-3"><i class="fas fa-info-circle fa-fw"></i> Esta acción desactivará la cuenta seleccionada</h7>
                    <br/>
                    <br/>
                    <br/>
                    <div class="form-group ">
                        <h6>¿Estas seguro que quieres desactivar la cuenta seleccionada?</h6>

                    </div>
                    <br />

                    <h7 class="textBeneDanger" id="msgValidationErrorsDelete" ></h7>
                    <br />
                    <input type="hidden" name="post_user_delete" id="post_user_delete" value="">
                    <button type="submit" id="btnDeleteUser" class="btn btnOrderRed btn-primary float-right mt-2" >Si, desactivar cuenta</button>
                </form>

            </div>

        </div>
    </div>
</div>
