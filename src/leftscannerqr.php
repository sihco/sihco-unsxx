<!--inicio modal qr-->
<div class="modal fade" id="modalqr" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ModalLabel">SCANNER DE QR</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" name="functionname" id="functionname" value="">
        <input type="hidden" name="inputqr" id="inputqr" value="">
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 bg-secondary">
            <style>
                #preview {
                  width: 100%;
                  height: auto;
                    margin: 0px auto;
                }
            </style>
            <video id="preview"></video>
            <div class="btn-group btn-group-sm btn-group-toggle mb-5" data-toggle="buttons">
                <label class="btn btn-primary active">
                    <input type="radio" name="options" value="1" autocomplete="off" checked> Camara Frontal
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" value="2" autocomplete="off"> Camara Trasera 1
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" value="3" autocomplete="off"> Camara Trasera 2
                </label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>
<!--fin modal qr-->
