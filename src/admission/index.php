<?php
require('header.php');

?>
<div class="container-fluid px-4">

    <h2 class="mt-3">MODULOS DE LA CLINICA</h2>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
    </ol>
    <div class="row">
      <div class="col-12">

        <!--inicio datos de totales paciente-->
        <div class="row p-3" style="background-color: rgba(0, 0, 0, 0.3);">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">PROSTODONCIA<div class="spinner-grow spinner-grow-sm" role="status"></div></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <b><span id="prosthodontics" class = "text-white border border-2 rounded p-1">0</span></b>
                        <span class="small text-white">
                          PACIENTES REMITIDOS
                        </span>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">OPERATORIA<div class="spinner-grow spinner-grow-sm" role="status"></div></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <b><span id="operative" class = "text-white border border-2 rounded p-1">0</span></b>
                        <span class="small text-white">
                          PACIENTES REMITIDOS
                        </span>
                    </div>

                </div>
            </div>
            <!--PARA MODULOS DE CIRUGIA II-->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">CIRUGIA<div class="spinner-grow spinner-grow-sm" role="status"></div></div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <b><span id="surgery" class = "text-white border border-2 rounded p-1">0</span></b>
                        <span class="small text-white">
                          PACIENTES REMITIDOS
                        </span>
                    </div>

                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">ODONTOPEDIATRIA
                      <div class="spinner-grow spinner-grow-sm" role="status"></div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <b><span id="pediatrics" class = "text-white border border-2 rounded p-1">0</span></b>
                        <span class="small text-white">
                           PACIENTES REMITIDOS
                        </span>
                    </div>

                </div>
            </div>
            <div class="col-12">
              <div class="simg-2" align="center">
                <img src="../images/dentista.gif"alt="No disponible .gif">
              </div>
            </div>
        </div>
        <!--fin datos de totales paciente-->

      </div>
    </div>
</div>

<?php
require('footer.php');
?>

<script>
  function patientCount(){
    $.ajax({
      url: "../include/i_patientcount.php",
      contentType: false, // Deshabilitar la codificación de tipo MIME
      processData: false, // Deshabilitar la codificación de datos
      success: function(r) {
        //$('#table-data').html(r);
        var jsonData = JSON.parse(r);
        $('#prosthodontics').text(jsonData.prosthodontics);
        $('#operative').text(jsonData.operative);
        $('#surgery').text(jsonData.surgery);
        $('#pediatrics').text(jsonData.pediatrics);
      }
    });
  }
  patientCount();
</script>
