<div class="modal fade" id="modalCreateComplaintSuccess" tabindex="-1" role="dialog" aria-labelledby="modalCreateComplaintSuccess" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">Registro correcto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="color:#F00" class="fas fa-times-circle fa-fw"></i>
                </button>
            </div>
            <div class="modal-body">
                    <h6 class="mt-2 mb-4 textBeneSuccess"><i class="far fa-check-circle fa-fw"></i> El registro se ha efectuado correctamente</h6>

                    <p >Los detalles para el seguimiento son los siguientes:
                        <br />
                        <br />
                        <h7 class="m-5" >Folio <b><span id="complaintNo"></span></b></h7>
                        <br />
                        <h7 class="m-5">UBE <b><span id="complaintUbe"></span></b></h7>
                        <br />
                        <h7 class="m-5">Supervisor a cargo <b><span id="supervisorName"></span></b></h7>
                        <br />
                        <h7 class="m-5">Gerente de zona a cargo <b><span id="managerName"></span></b></h7>
                        <br />
                        <br />
                        <h7 id="headerMailList"></h7>

                        <p id="mailList" >

                        <br />
                        </p>

                    </p>


                    <br />
                    <button type="button" id="btnOk" class="btn btnOrderRed btn-primary float-right mt-2" data-dismiss="modal">Entiendo</button>
            </div>
        </div>
    </div>
</div>
