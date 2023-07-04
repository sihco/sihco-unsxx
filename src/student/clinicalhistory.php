<?php
require('header.php');
?>
                    <div class="container-fluid px-4">

                        <h2 class="mt-4">Mis Fichas Clínicas</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>
<div class="table-responsive">


<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Paciente</th>
            <th scope="col">Edad</th>
            <th scope="col">Consulta</th>
            <th scope="col">Especilidad</th>
            <th scope="col">Autorizado por</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha inicio</th>
            <th scope="col">Fecha culminación</th>
            <th scope="col">Acciones para historial</th>
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
$historytable=array(2=>'removable', 3=>'fixed', 4=>'operative', 5=>'endodontics',
  6=>'surgeryii', 7=>'periodonticsii', 8=>'pediatricsi', 9=>'orthodontics', 10=>'removable',
  11=>'fixed', 12=>'operative', 13=>'endodontics', 14=>'surgeryiii', 15=>'periodonticsiii',
  16=>'pediatricsi', 17=>'orthodontics');
$pr=DBAllRemissionPatientInfo($_SESSION['usertable']['usernumber'], true);
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
      if($pr[$i]["teacherid"]!=0&& is_numeric($pr[$i]["teacherid"])&& $pr[$i]['authorized']=='t'){
        $t=DBUserInfo($pr[$i]["teacherid"]);
        echo "   <td>".$t['userfullname']."</td>";
      }else{
        if($pr[$i]["teacherid"]==0&& $pr[$i]['authorized']=='t'){
          echo " <td><div class=\"catimg\"><img src=\"../images/loading.gif\" alt=\"...\"></div></td>";
        }else{
          echo " <td><input type=\"button\" class=\"btn btn-sm btn-success btn_autorization\" name=\"btn_autorization\" hc=".$pr[$i]['remissionidch']." value=\"Solicitar\">";
          echo "<button type=\"button\"".
          "ch=\"".$pr[$i]['remissionidch']."\" class=\"btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
          "data-bs-target=\"#modalautorization\"><i class=\"fa fa-2x fa-solid fa-info\"></i></button>";
          echo "</td>";

        }
      }
      echo "   <td>".$namestatus[$pr[$i]["status"]]."</td>";

      echo "   <td>" . datetimeconv($pr[$i]["stdatetime"]) ."</td>";
      if(isset($pr[$i]['endatetime'])&& $pr[$i]['endatetime']!=-1) echo '<td>'.dateconv($pr[$i]['endatetime']).'</td>';
      else echo "   <td></td>";
      echo "   <td>";

      echo "<div class=\"btn-group\">" ;
      if(isset($pr[$i]["status"])&& $pr[$i]["status"]!='end'){
        echo "<button type=\"button\"".
        "ch=\"".$pr[$i]['remissionidch']."\" class=\"send_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
        "data-bs-target=\"#subfile\"><i class=\"fas fa-2x fa-regular fa-upload\"></i></button>";
      }

      if (isset($pr[$i]["inputfile"])&& $pr[$i]["inputfile"] != null) {
        $tx = $pr[$i]["inputfilehash"];
        echo "<a href=\"#\" class=\"btn btn-sm btn-outline-primary\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".filedownload($pr[$i]["inputfile"], $pr[$i]["inputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\"><i class=\"fas fa-2x fa-solid fa-eye\"></i></a>";
        echo "  <a class=\"btn btn-sm btn-outline-success\" href=\"../filedownload.php?" . filedownload($pr[$i]["inputfile"] ,$pr[$i]["inputfilename"]) ."\">" .
              "<i class=\"fas fa-2x fa-solid fa-download\"></i></a>";
      }
      echo "<button type=\"button\"".
      "ch=\"".$pr[$i]['remissionidch']."\" class=\"detail_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
      "data-bs-target=\"#detail\"><i class=\"fa fa-2x fa-solid fa-info\"></i></button>";
      if($pr[$i]['clinicalid']==6){
        echo "  <a class=\"btn btn-sm btn-outline-primary\" href=\"".$historytable[$pr[$i]['clinicalid']].".php?id=".$pr[$i]['remissionidch']."\">" .
              "<i class='fa fa-2x fa-edit'></i></a>";
      }


      echo "</div>";



      echo "</td>";

      echo "</tr>";
}
echo "</tbody></table>\n";

?>
</div>
<!--tabla para pacientes remitidos fin-->

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
<script>
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
