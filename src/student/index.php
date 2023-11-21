<?php
require('header.php');
?>
                    <div class="container-fluid px-3">

                        <h2 class="mt-3">Mis Fichas Clínicas</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>
                        <style media="screen">
                          .catimg {
                            width: 30px;
                          }
                          img {
                            max-width: 100%;
                            max-height: 100%;
                          }
                          td,th{
                            text-align: center;
                          }
                          table{
                            font-size: 15px
                          }
                        </style>
<div class="table-responsive">
<div class='d-flex flex-wrap flex-sm-row justify-content-between' id="pagination-data"></div>
<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">
              Paciente
              <input type="text" class="form-control" name='patientname' id='patientname' aria-label="Buscar" aria-describedby="boton-buscar">
            </th>
            <th scope="col">Edad</th>
            <th scope="col">Consulta</th>
            <th scope="col">Esp. Derivada
              <select class="form-control" onchange="PatientDerivative(1)" id='specialty' name = 'specialty'>
                <?php
                $a = DBAllSpecialtyInfo($_SESSION["usertable"]["usernumber"], true);
                $size=count($a);
                if($size>0)
                  echo "<option value=''>Todos</option>";
                for ($i=0; $i < $size; $i++) {
                      $clinical=DBClinicalInfo($a[$i]['clinicalid']);
                      echo "<option value=".$clinical['clinicalid'].">" . $clinical["clinicalspecialty"] . "</option>";
                }
                ?>
      				</select>
            </th>
            <th scope="col">Autorizado por</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha inicio</th>
            <th scope="col">Fecha culminación</th>
            <th scope="col">Acciones para historial</th>
        </tr>
    </thead>
    <tbody id = "table-data">
    </tbody>
</table>
</div>
<!--tabla para pacientes remitidos fin-->
<?php require('../leftscannerqr.php'); ?>

<!--modal para autorizar paciente INICIO-->
<div class="modal fade" id="modalautorization" tabindex="-1" aria-labelledby="modallabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modallabel">Autorización</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="Restart()"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Docente:</label>
            <div id="allteacher"></div>
            <span id='spantext'></span>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="Restart()">Cerrar</button>
        <button type="button" class="btn btn-primary" id="designed_button">Designar</button>
      </div>
    </div>
  </div>
</div>
<!--modal para autorizar paciente FIN-->
<script>
  var modal = document.getElementById('modalautorization');

  modal.addEventListener('touchstart', function (e) {
    if (e.target === modal){
      var initialTouchPos = e.touches[0].clientY;

      modal.addEventListener('touchmove', function (e) {
        var deltaY = initialTouchPos - e.touches[0].clientY;
        if(deltaY > 0 && modal.scrollTop === 0){
          e.preventDefault();
        }
      });
    }
  });

  var patternbutton = document.getElementsByClassName('patterndiv');
  var datoRegistrado = '';

  for (var i = 0; i < patternbutton.length; i++) {

    patternbutton[i].addEventListener('touchmove', function (e){
      var divId = e.target.id;
      //alert(divId);
      document.getElementById('spantext').innerHTML = divId;
      //console.log(divId);
    });
  }

</script>

<!--MODAL INICIO-->

<div class="modal fade" id="subfile" tabindex="-1" aria-labelledby="modallabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form name="form_submit" id="form_submit" enctype="multipart/form-data" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="modallabel">Documento Culminado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="Restart()"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <input type="hidden" name="formch" id="formch" value="">
          </div>
          <div class="mb-3">
            <div class="from-group">
              <label for="probleminput">Subir Ficha Clínica Culminado en .pdf</label>
              <input type="file" name="finalinput" accept=".pdf" id="finalinput" class="form-control" value="">
            </div>

          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="Restart()">Cerrar</button>
        <button type="button" class="btn btn-primary" id="Submit3">Enviar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--MODAL FIN-->
<!--MODAL INICIO-->
<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="modallabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modallabel">Detalle de ficha</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="Restart()"></button>
      </div>
      <div class="modal-body" id="modaldetail">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="Restart()">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--MODAL FIN-->

                    </div>

<?php
require('footer.php');
?>
<script src="../leftscannerqr.js"></script>
<script>
var formData = new FormData(); // Crear un objeto FormData vacío
function restartFormData(){
  for (var key of formData.keys()) {
    formData.delete(key);
  }
}
//var checkboxStates = new Array(16).fill(1);
function AddFormData(page){
  restartFormData();//reinicia el formulario
  formData.append('page', page);
  formData.append('specialty', $('#specialty').val());
  formData.append('patientfullname', $('#patientname').val());
  //formData.append('studentfullname', $('#studentname').val());
  //formData.append('stdate', $('#stdate').val());
  //formData.append('endate', $('#endate').val());
}
function loadData(page){
  AddFormData(page);
  //alert('entra');
  $.ajax({
    url: "tableindex.php",
    type: "POST",
    data: formData,
    contentType: false, // Deshabilitar la codificación de tipo MIME
    processData: false, // Deshabilitar la codificación de datos
    success: function(r) {
      $('#table-data').html(r);
      //var jsonData = JSON.parse(r);
      //$('#table-data').html(jsonData.tableData);
      //$('#pagination-data').html(jsonData.paginationData);
    }
  });
}
$('#patientname, #specialty').on('change', function() {
  loadData(1);
});
//cargar datos en la pagina inicial
loadData(1);

function registerqr(content){
  var ch = $('#functionname').val();
  if(ch=='authorizeqr'){
    authorizeqr(content);
  }
}
function authorizeqr(content){
  var rh = $('#inputqr').val();
  //var ficha = $('#ficha').val();
  //window.location.href=content;
  //alert(content);
  $.ajax({
       url:"../include/i_clinichistory.php",
       method:"POST",
       data: {content:content, rh:rh},
       success:function(data)
       {
          if(data=='yes'){
            alert('Se autorizó la ficha');
            location.reload();
          }else{
            alert(data);
          }
       }
  });
}

//fin funciones qr
$(document).ready(function(){
  $(".detail_modal").click(function(event) {
    Stop();
    var ch=$(this).attr('ch');
    $.ajax({
         url:"../include/i_clinichistorydetail.php",
         method:"POST",
         data: {ch:ch},
         success:function(data)
         {
            $('#modaldetail').html(data);
         }
    });
  });
  $('#Submit3').click(function(){
      var finalinput = String($('#finalinput').val());
      var ext = finalinput.split('.').pop();
      // Convertimos en minúscula porque
      // la extensión del archivo puede estar en mayúscula
      ext = ext.toLowerCase();
      if(finalinput.length > 1){
        if(ext=='pdf'){
          //crea un nuevo objet de stipo FormData
          var formdata= new FormData($("#form_submit")[0]);
          //alert(formdata);
          $.ajax({
             data: formdata,
             url:"../include/i_clinichistory.php",
             type:"POST",
             contentType: false,
             processData: false,
             success:function(data)
             {
               if(data == "Yes"){
                 alert(".:YES:.");
                 //$('#subproblem').hide();
                 location.reload();
               }else {
                    if(data == "No"){
                    alert("Error al subir");
                    //$('#subproblem').hide();
                    location.reload();
                  }else {
                      alert(data);
                    //$('#subproblem').hide();
                    //location.reload();
                  }
               }
             }
          });
        }else{
          alert('el archivo subido debe ser en extension .pdf y no .'+ext);
        }
      }
      else{
         alert("Debe subir el documento finalizado");
      }
   });
      $(".send_modal").click(function(event) {
        var ch=$(this).attr('ch');
        $('#formch').val(ch);
        Stop();
      });
      //btn_autorization
      $('.btn_autorization').click(function(){
        var ch=$(this).attr('hc');
        $.ajax({

             url:"../include/i_clinichistory.php",
             method:"POST",
             data: {ch:ch},
             success:function(data)
             {
                if(data=='yes'){
                  alert('Se envió la solicitud');
                  location.reload();
                }else{
                  alert(data);
                }

             }
        });


      });


});
</script>
