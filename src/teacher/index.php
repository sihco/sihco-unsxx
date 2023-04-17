<?php
require('header.php');
?>

                    <div class="container-fluid px-4">

                        <h2 class="mt-4">Pacientes derivados en linea</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                            &nbsp; Fila &nbsp;<span class="border border-danger table-danger rounded ">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span> &nbsp; Significa que requiere urgente autorización
                        </ol>
<div class="table-responsive">
<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Paciente</th>
            <th scope="col">Edad</th>
            <th scope="col">Consulta</th>
            <th scope="col">Diagnostico Presuntivo</th>
            <th scope="col">Especialidad Derivada</th>
            <th scope="col">Fecha Remisión</th>
            <th scope="col">Estudiante Designado</th>
            <th scope="col">Autorizado por</th>
        </tr>
    </thead>
    <tbody>
<?php
//$usr = DBAllUserInfo();

//$pr = DBAllPatientRemissionInfo();
$pr=DBAllRemissionPatientInfo($_SESSION['usertable']['usernumber'], false, true);
//$pr = DBAllRemissionInfo(null, false, $limit);
$size=count($pr);
for ($i=0; $i < $size; $i++) {
      if($pr[$i]['status']=='new'&& $pr[$i]['authorized']=='t')
        echo " <tr class=\"table-danger\">\n";
      else
        echo " <tr>\n";
      echo "   <td>" . ($size-$i) . "</td>";
      $fullname=$pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"];
      echo "   <td>" . $fullname ."</td>";
      echo "   <td>" . $pr[$i]["patientage"] . "</td>";
      echo "   <td>" . $pr[$i]["motconsult"] . "</td>";
      echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";

			echo "   <td>" . $pr[$i]['clinicalspecialty'] . "</td>";

			echo "   <td>" . datetimeconv($pr[$i]["updatetimeremission"]) ."</td>";

      if($pr[$i]["studentid"]!=NULL&& is_numeric($pr[$i]["studentid"])){
        $u=DBUserInfo($pr[$i]['studentid']);
        echo " <td>".$u['userfullname']."</td>";
      }else{
        echo "   <td><div class=\"btn-group\"><button type=\"button\" cli=\"".$pr[$i]['clinicalid']."\" ".
        "pname=\"".$fullname."\" remp=\"".$pr[$i]['remissionid']."\" class=\"assigned btn btn-sm btn-primary\" data-bs-toggle=\"modal\" ".
        "data-bs-target=\"#modalassigned\">Designar</button>".
        "<a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Ver Ficha</a></div></td>";

      }
      echo "<td>";
      if($pr[$i]["teacherid"]!=NULL&& is_numeric($pr[$i]["teacherid"])){
        if($pr[$i]["teacherid"]!=0){
          $u=DBUserInfo($pr[$i]['teacherid']);
          echo $u['userfullname'];
        }else{
          echo "   <div class=\"btn-group\"><input type=\"button\" class=\"btn btn-sm btn-primary btn_autorization\" name=\"btn_autorization\" hc=".$pr[$i]['remissionidch']." value=\"Autorizar\">".
          "<a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Ver Ficha</a></div>";
        }

      }
      echo "</dt>";
      echo "</tr>";
}
echo "</tbody></table>\n";

?>
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
function insert(id, val){
   event.preventDefault();
   $('#examinedid').val(id);
   $('#studentfullname').val(val);
}
$(document).ready(function(){
      $('.btn_autorization').click(function(){
        var ch=$(this).attr('hc');
        Stop();
        if (confirm("¿Estas seguro de autorizar?")) {
          $.ajax({

               url:"../include/i_clinichistory.php",
               method:"POST",
               data: {ch:ch},
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

      });
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
