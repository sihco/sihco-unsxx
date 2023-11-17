<?php
require('header.php');
?>

                    <div class="container-fluid px-3">

                        <h2 class="mt-4">Pacientes derivados en linea</h2>
                        <ol class="breadcrumb mb-3">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                            <div class="row">
                              <div class="col-12">
                                <table class="table table-sm table-hover">
                                  <tr>
                                    <td class="table-default">Nuevo</td>
                                    <td class="table-primary text-primary">En proceso</td>
                                    <td class="table-danger">Abandonado</td>
                                    <td class="table-success text-success">Finalizado</td>
                                    <td class="table-dark">Anulado</td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            &nbsp; --> Estado de ficha por fila
                        </ol>

<style media="screen">
  td,th{
    text-align: center;
  }
  table{
    font-size: 15px
  }
</style>

<div class="table-responsive">
  <div class='d-flex flex-wrap flex-sm-row justify-content-between' id="pagination-data"></div>
  <table class="table table-sm table-hover ">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Paciente
            <input type="text" class="form-control" name='patientname' id='patientname' aria-label="Buscar" aria-describedby="boton-buscar" onkeyup="PatientDerivative(1)">
          </th>
          <th scope="col">Edad</th>
          <th scope="col">Diagnostico Presuntivo</th>
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
          <th scope="col">
            Fecha Remisión
            <div class="input-group input-group-sm">
              <input type="date" id="stdate" name="stdate" value="2023-01-01" max="<?php echo date('Y-m-d'); ?>" class="form-control">
              <span class="input-group-text" id="inputGroup-sizing-sm"><></span>
              <input type="date" id="endate" name="endate" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" class="form-control">
            </div>
          </th>
          <th scope="col">Est. Designado
            <input type="text" class="form-control" name='studentname' id='studentname' aria-label="BuscarEstudiante" aria-describedby="boton-buscar-estudiante" onkeyup="PatientDerivative(1)">
          </th>
          <th scope="col">Autorizado por</th>
        </tr>
      </thead>
      <tbody id = "table-data">
        <!--Los datos se generan de forma automatica-->
      </tbody>
  </table>

</div>

<div class="modal fade" id="modalassigned" tabindex="-1" aria-labelledby="modallabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modallabel">Designar Estudiante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="Restart()"></button>
      </div>
      <div class="modal-body">


          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Paciente: <span class="text-primary" id="pname"></span> </label>
            <input type="hidden" name="clinical" id="clinical" value="">
          </div>
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text">Estudiante:</span>
              <div class="dropdown">
                <input type="hidden" name="examinedid" id="examinedid" value="">
                <input type="hidden" name="rem" id="rem" value="">
                <input type="text" class="form-control" id="studentfullname" name="studentfullname" value="" autocomplete="off" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    						<div class="dropdown-menu" aria-labelledby="search" id="resultstudent">
    	          </div>
    	        </div>
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="Restart()">Cerrar</button>
        <button type="button" class="btn btn-primary" id="designed_button">Designar</button>
      </div>
    </div>
  </div>
</div>
<!--tabla para pacientes remitidos fin-->



                    </div>
<?php
require('footer.php');
?>

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
  formData.append('studentfullname', $('#studentname').val());
  formData.append('stdate', $('#stdate').val());
  formData.append('endate', $('#endate').val());
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
      //$('#table-data').html(r);
      var jsonData = JSON.parse(r);
      $('#table-data').html(jsonData.tableData);
      $('#pagination-data').html(jsonData.paginationData);
    }
  });
}
$('#patientname, #studentname, #stdate, #endate, #specialty').on('change', function() {
  loadData(1);
});
//cargar datos en la pagina inicial
loadData(1);
function insert(id, val){
   event.preventDefault();
   $('#examinedid').val(id);
   $('#studentfullname').val(val);
}
function autorization(rh, page) {
  //var ch=$(this).attr('hc');
  Stop();
  $.ajax({

       url:"../include/i_clinichistory.php",
       method:"POST",
       data: {rh:rh},
       success:function(data)
       {
          if(data=='yes'){
            //PatientDerivative(page);
            loadData(page);
            //alert('Se autorizó la ficha');
            //location.reload();
            Swal.fire({
              icon: 'success',
              title: '¡Autorizado!',
              html: 'Se autorizó la ficha.',
              showConfirmButton: false,
              timer: 1600
            });
          }else{
            alert(data);
          }
       }
  });
}
$(document).ready(function(){
     $('#studentfullname').on('keyup', function(){
       var examined = $('#studentfullname').val()
			 var clinical = $('#clinical').val()
			 $.ajax({
				 type: 'POST',
				 url: '../include/search.php',
				 data: {examined:examined, clinical:clinical},
				 beforeSend: function(){
					 $('#result').html('<img src="../images/google.gif">')
				 }
			 })
			 .done(function(resultado){
				 //div para mostrar resultado
				 $('#resultstudent').html(resultado)
			 })
			 .fail(function(){
				 //alerta para un error
				 alert('Hubo un error :(')
			 })
     })
     $(".assigned").click(function(event) {
       var cli=$(this).attr('cli');
       var pname=$(this).attr('pname');
       var rem=$(this).attr('remp');
       $('#pname').text(pname);
       $('#clinical').val(cli);
       $('#rem').val(rem);
       Stop();
     });
     $('#designed_button').click(function(){

       var clinical=$('#clinical').val();
       var examinedid=$('#examinedid').val();
       var studentfullname=$('#studentfullname').val();
       var rem=$('#rem').val();
       if(studentfullname.trim()==''){
         alert('Debe introducir el nombre del estudiante');
         return false;
       }
       $.ajax({
            url:"../include/i_clinichistory.php",
            method:"POST",
            data: {clinical:clinical, examinedid:examinedid, studentfullname:studentfullname, rem:rem},
            success:function(data)
            {
               if(data=='yes'){
                 alert("Se designó el estudiante.");
                 $('#modalassigned').hide();
                 location.reload();
               }else{
                 alert(data);
               }

            }
       });
     });


});
</script>
