<?php
require('header.php');
if(!isset($other)){
  $other=false;
}
?>

                    <div class="container-fluid px-4">
                        <?php
                        if($other){
                          echo "<h2 class=\"mt-4\">Fichas clínicas para la revisión</h2>";
                        }else{
                          echo "<h2 class=\"mt-4\">Mis fichas clínicas autorizadas</h2>";
                        }
                        ?>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>


                                    <!-- Counter - Alerts -->
<div class="table-responsive">
<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Paciente</th>
            <th scope="col">Edad</th>
            <th scope="col">Consulta</th>
            <th scope="col">Especilidad</th>
            <th scope="col">Estudiante</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha inicio</th>
            <th scope="col">Fecha culminación</th>
            <th scope="col">Historial</th>
        </tr>
    </thead>
    <tbody>
      <style media="screen">
      .catimg {
        width: 30px;
      }
      img {
      max-width: 100%;
      max-height: 100%;
      }
      </style>
<?php
//$usr = DBAllUserInfo();
$color=array(''=>'', 'new'=>'table-default', 'process'=>'table-primary text-primary', 'fail'=>'table-danger', 'end'=>'table-success text-success', 'canceled'=>'table-dark');
$namestatus=array(''=>'', 'new'=>'Nuevo', 'process'=>'En proceso', 'fail'=>'Abandonado', 'end'=>'Finalizado', 'canceled'=>'Anulado');

$pr=DBAllRemissionPatientInfo($_SESSION['usertable']['usernumber'], true, false, true, $other);
//$pr = DBAllRemissionInfo(null, false, $limit);
$size=count($pr);
for ($i=0; $i < $size; $i++) {
      if(isset($pr[$i]['status'])&&isset($color[$pr[$i]['status']]))
        echo " <tr class=\"".$color[$pr[$i]['status']]."\">\n";
      else
        echo " <tr class==\"\">\n";
      echo "   <td>" . ($size-$i) . "</td>";
      echo "   <td>" . $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</td>";
      echo "   <td>" . $pr[$i]["patientage"] . "</td>";
      echo "   <td>" . $pr[$i]["motconsult"] . "</td>";
      echo "   <td>" . $pr[$i]['clinicalspecialty'] . "</td>";
      if(is_numeric($pr[$i]["studentid"])){
        $t=DBUserInfo($pr[$i]["studentid"]);
        echo "   <td>".$t['userfullname']."</td>";
      }else{
        echo "   <td></td>";
      }
      echo "   <td>".$namestatus[$pr[$i]["status"]]."</td>";

      echo "   <td>" . datetimeconv($pr[$i]["stdatetime"]) ."</td>";

      if(isset($pr[$i]['endatetime'])&& $pr[$i]['endatetime']!=-1) echo '<td>'.dateconv($pr[$i]['endatetime']).'</td>';
      else echo "   <td></td>";

      echo "   <td>";

      echo "<div class=\"btn-group\">" ;

      echo "<button type=\"button\"".
      "ch=\"".$pr[$i]['remissionidch']."\" class=\"send_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
      "data-bs-target=\"#subfile\"><i class=\"fas fa-2x fa-light fa-pen-nib\"></i>";
      if($pr[$i]["status"]=='process'&& $pr[$i]["reviewteacher"]!=''&& $pr[$i]["reviewstatus"]=='f'){
        echo "<i class=\"fas fa-bell fa-fw\"></i>".
        "<sub><span class=\"badge badge-danger badge-counter\">1+</span></sub>";
      }

      echo "</button>";



      if (isset($pr[$i]["inputfile"])&& $pr[$i]["inputfile"] != null) {
        $tx = $pr[$i]["inputfilehash"];
        echo "<a href=\"#\" class=\"btn btn-sm btn-outline-primary\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".filedownload($pr[$i]["inputfile"], $pr[$i]["inputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\"><i class=\"fas fa-2x fa-solid fa-eye\"></i></a>";
        echo "  <a class=\"btn btn-sm btn-outline-success\" href=\"../filedownload.php?" . filedownload($pr[$i]["inputfile"] ,$pr[$i]["inputfilename"]) ."\">" .
              "<i class=\"fas fa-2x fa-solid fa-download\"></i></a>";
      }

      echo "</td>";

      echo "</tr>";
}
echo "</tbody></table>\n";
?>
</div>
<!--tabla para pacientes remitidos fin-->
<!--MODAL INICIO-->
<div class="modal fade" id="subfile" tabindex="-1" aria-labelledby="modallabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form name="form_submit" id="form_submit" enctype="multipart/form-data" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="modallabel">EVALUACION</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="Restart()"></button>
      </div>
      <div class="modal-body" id="modalexam">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="Restart()">Cerrar</button>
        <button type="button" class="btn btn-primary" id="Submit3">Evaluar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--MODAL FIN-->


                    </div>
<?php
require('footer.php');
?>
<script>

$(document).ready(function(){
  $('#Submit3').click(function(){
    var formdata= new FormData($("#form_submit")[0]);
    $.ajax({
       data: formdata,
       url:"../include/i_clinichistory.php",
       type:"POST",
       contentType: false,
       processData: false,
       success:function(data)
       {
         if(data == "yes"){
           alert("Se guardó la evaluación");
           $('#subfile').hide();
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
   });
      $(".send_modal").click(function(event) {
        Stop();
        var ch=$(this).attr('ch');
        $.ajax({
             url:"../include/i_clinichistoryexam.php",
             method:"POST",
             data: {ch:ch},
             success:function(data)
             {
                $('#modalexam').html(data);
             }
        });
      });



});
</script>
