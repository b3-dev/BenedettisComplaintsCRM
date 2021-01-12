<div class="modal fade" id="modalUserProfile" tabindex="-1" role="dialog" aria-labelledby="modalUserProfile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title" id="exampleModalCenterTitle">Perfil de usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="color:#F00" class="fas fa-times-circle fa-fw"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUpdateUserAccount" name="formUpdateUserAccount" role="form" data-toggle="validator" method="post">
                    <h7 class="mt-2 mb-4"><i class="fas fa-info-circle fa-fw"></i> Revisa que los datos estén correctos antes de actualizar</h7>
                    <div class="form-group mt-5">
                        <h6 for="post_auth_id">Autoridad </h6>
                        <select class="custom-select text-secondary " name="post_auth_id" id="post_auth_id">
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <h6 for="post_department_id">Departamento </h6>
                        <select class="custom-select text-secondary " name="post_department_id" id="post_department_id">
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <h6 for="post_first_name">Nombre(s) </h6>
                        <input type="text" required class="form-control"  autocomplete="none" id="post_first_name" name="post_first_name">
                        <div class="text-left help-block with-errors"></div>
                    </div>
                    <div class="form-group mt-3">
                        <h6 for="post_last_name">Apellido(s) </h6>
                        <input type="text" required class="form-control"  autocomplete="none" id="post_last_name" name="post_last_name">
                        <div class="text-left help-block with-errors"></div>
                    </div>
                    <div class="form-group mt-3">
                        <h6 for="post_email">Email </h6>
                        <input type="text" required class="form-control"  autocomplete="none" id="post_email" name="post_email">
                        <div class="text-left help-block with-errors"></div>
                    </div>
                    <div class="form-group mt-3">
                        <h6 for="post_phone">Teléfono </h6>
                        <input type="text" pattern="^[0-9]{1,}$" minlength="10" maxlength="10" required class="form-control"  autocomplete="none" id="post_phone" name="post_phone">
                        <div class="text-left help-block with-errors"></div>
                    </div>
                    <br />

                    <h7 class="textBeneDanger float-right " id="msgValidationErrors" ></h7>
                    <br />

                    <input type="hidden" id="post_user_id" name="post_user_id">
                    <button type="submit" id="btnUpdateUserAccount" class="btn btnOrderRed btn-primary float-right mt-2" >Actualizar cuenta</button>
                </form>

            </div>

        </div>
    </div>
</div>
