<div class="modal fade" id="modalSurveyInfo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalSurveyInfo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hComplaintTitle">Encuesta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="color:#F00" class="fas fa-times-circle fa-fw"></i>
                </button>
            </div>
            <div class="modal-body row m-1">
                <div class="col-md-6 col-sm-12 mt-1 mb-2">
                    <h6 class="">#Folio </h6>
                    <h7 class="textBeneDanger" id="hSurveyFolio"></h7>
                </div>
                <div class="col-md-6 col-sm-12 mt-1 mb-2">
                    <h6>Fecha de registro </h6>
                    <h7 id="hRegisterSurveyDate"></h7>
                </div>
                <div class="col-md-6 col-sm-12 mt-1 mb-2">
                    <h6>Asociado</h6>
                    <h7 id="hPartnerData"></h7>
                </div>
                <div class="col-md-6 col-sm-12 mt-1 mb-2">
                    <h6>#Solicitud</h6>
                    <h7 id="hComplaintFolio"></h7>
                </div>
                <!--client -->
                <hr class="container" >

                <div class="col-12 mt-0 mb-2" id="divDetailSurvey">

                </div>

                <hr class="container mt-2" >

                <!--complaint_request -->
                <div class="col-12 mt-1">
                    <h6 >Comentario</h6>

                    <h7 id="hCommentSurvey"></h7>
                </div>
                <br />
            </div>
            <div class="modal-footer border-0" >
                <button type="button" class="btn btnOrderRed btn-primary" data-dismiss="modal">Entiendo</button>
            </div>
        </div>
    </div>
</div>
