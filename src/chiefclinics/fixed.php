<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBFixedInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=2&&$pat["clinicalid"]!=10)
    ForceLoad("index.php");
}else{
  ForceLoad("index.php");
}
$pat2=$r;
$pat=array_merge($pat, $pat2);
//$s=DBSessionPeriodonticsiiInfo($_GET['id']);
?>
<a id="personales"></a>
            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->

                <main>

                    <div class="container-fluid px-4">

                        <?php
                        if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Prostodoncia Fija III</h2>";
                        }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Prostodoncia Fija II</h2>";
                        }else{
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Prostodoncia Fija</h2>";
                        }

                        ?>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>

                        <!--notificaciones inicio-->
                        <?php
                        if(isset($pat['observationevaluated'])&&$pat['observationevaluated']=='f'){
                          echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica aun no esta revisado.".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['fixedstatus'])&&$pat['fixedstatus']!='fail'){
                          echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica tiene observaciones:<b>".$pat['observationdesc']."</b>".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='t'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'){
                          echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Se concluyó tu ficha clinica".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['fixedstatus'])&&$pat['fixedstatus']=='fail'){
                          echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica está en un estado de Abandono.".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }

                        ?>

                        <!--notificaciones fin-->
<!--<div class="container">-->




<!--formulario para paciente inicio-->
<!--id para paciente-->
<input type="hidden" name="patientid" id="patientid" value="<?php if(isset($pat["patientid"])) echo $pat["patientid"];  ?>">
<input type="hidden" name="ficha" id="ficha" value="<?php echo $_GET['id']; ?>">
<div class="from-group">

<div class="border rounded border-primary px-3">
  <!--<div class="container">-->
    <br>
    <div class="row">
      <?php
      $userinfo=DBUserInfo($pat['student']);
      ?>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for=""><b>Alumno:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["userfullname"])) echo $pat["userfullname"];  ?></label>

      </div>
      <div class="col-lg-2 col-md-2 col-sm-6 col-6">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==10){
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;5to. Año</label> </label>";
        }elseif(isset($pat["clinicalid"])&&$pat["clinicalid"]==2){
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;4to. Año</label> </label>";
        }else{
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">......................</label> </label>";
        }
        ?>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for=""><b>Gestión:</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
          </div>
          <div class="col-lg-6 col-md-6 col-sm-8 col-8">
            <select name="year" class="form-select" aria-label="Default select example">
              <?php
              $Year = date("Y");
              $ac='';
              $nyes=true;
              $ac.= "<option";
              if(!isset($pat["fixedyear"]) || $pat["fixedyear"] == '' || $pat['fixedyear']==$Year){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".$Year."\">".$Year."</option>\n";
              $ac.= "<option";
              if(isset($pat["fixedyear"]) && $pat["fixedyear"] == $Year-1){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-1)."\">".($Year-1)."</option>\n";
              $ac.= "<option";
              if(isset($pat["fixedyear"]) && $pat["fixedyear"] == $Year-2){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-2)."\">".($Year-2)."</option>\n";
              $ac.= "<option";
              if(isset($pat["fixedyear"]) && $pat["fixedyear"] == $Year-3){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-3)."\">".($Year-3)."</option>\n";

              if($nyes&& isset($pat['fixedyear'])&&$pat['fixedyear']!=''){
                $ac.="<option selected value=\"".$pat['fixedyear']."\">".$pat['fixedyear']."</option>\n";
              }
              echo $ac;
              ?>

            </select>
          </div>
        </div>


      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="patientfullname"><b>Paciente:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?></label><br>

      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientage"><b>Edad:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></label>

      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientgender"><b>Género:</b>&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
          if(!isset($pat) || $pat["patientgender"] == '--') echo "indefinido";
          if(isset($pat) && $pat["patientgender"] == 'masculino') echo "Masculino";
          if(isset($pat) && $pat["patientgender"] == 'femenino') echo "Femenino";
          ?>
        </label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientprovenance"><b>Procedencia:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"]; ?></label><br>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientoccupation"><b>Ocupación:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientoccupation"])) echo $pat["patientoccupation"]; ?></label><br>

      </div>
      <div class="col-6">
        <label for="patientdirection"><b>Domicilio:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"]; ?></label><br>

      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientphone"><b>Telf.:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientphone"])) echo $pat["patientphone"]; ?></label><br>
      </div>
    </div>


    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="diagnosis"><b>Diagnostico</b></label>
        <textarea class="form-control" name="diagnosis" id="diagnosis"rows="4"><?php if(isset($pat["fixeddiagnosis"])&& $pat["fixeddiagnosis"]!=''){ echo $pat["fixeddiagnosis"];}  ?></textarea>

      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="etiology"><b>Etiología:</b></label>
        <input type="text" class="form-control" name="etiology" id="etiology" value="<?php if(isset($pat["fixedetiology"])) echo $pat["fixedetiology"];  ?>">

      </div>

    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="forecast"><b>Pronostico:</b></label>
        <input type="text" class="form-control" name="forecast" id="forecast" value="<?php if(isset($pat["fixedforecast"])) echo $pat["fixedforecast"];  ?>">

      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="patientdatebirth"><b>Plan de Tratamiento:</b></label>
        <div class="form-check">
          <input class="form-check-input treatment" type="checkbox" value="" name="treatment" id="tratamiento1" <?php if(isset($pat["tratamiento1"])&&$pat["tratamiento1"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="tratamiento1">
            <?php
            if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
              echo "Puente Ant";
            }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
              echo "Corona Metálica";
            }else{
              echo "Corona Metálica";
            }
            ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input treatment" type="checkbox" value="" name="treatment" id="tratamiento2" <?php if(isset($pat["tratamiento2"])&&$pat["tratamiento2"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="tratamiento2">
            <?php
            if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
              echo "Póntico";
            }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
              echo "Corona Veneer";
            }else{
              echo "Corona Veneer";
            }
            ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input treatment" type="checkbox" value="" name="treatment" id="tratamiento3" <?php if(isset($pat["tratamiento3"])&&$pat["tratamiento3"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="tratamiento3">
            <?php
            if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
              echo "Puente Post";
            }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
              echo "Corona Pivot";
            }else{
              echo "Corona Pivot";
            }
            ?>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input treatment" type="checkbox" value="" name="treatment" id="tratamiento4" <?php if(isset($pat["tratamiento4"])&&$pat["tratamiento4"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="tratamiento4">
            <?php
            if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
              echo "Póntico";
            }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
              echo "Corona Jacket";
            }else{
              echo "Corona Jacket";
            }
            ?>
          </label>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="container">
        <a class="btn btn-success" href="" data-toggle="modal" data-target="#procedimiento">Procedimientos</a>
      </div>
    </div>
    <style media="screen">

    .modal2{
     padding: 0 !important;
    }
    .modal-dialog2 {
      max-width: 80% !important;
      height: auto;
      padding: 0;
      margin: 0;
    }

    .modal-content2 {
      border-radius: 0 !important;
      height: 100%;
    }

    </style>

    <!--modal procedimiento inicio-->
    <div class="modal modal2 fade" role="dialog" id="procedimiento">
    <div class="modal-dialog modal-dialog2">
      <div class="modal-content modal-content2">
        <div class="modal-header">
          <h3 class="modal-title">Procedimientos</h3>
          <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
        </div>

        <div class="modal-body">

          <div class="from-group border border-primary rounded">
            <div class="container">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Procedimiento</th>
                    <th scope="col">Vo. Bo. Docente</th>
                    <th scope="col">Materiales</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">
                      <span id="radfecha">
                        <?php
                        if(isset($pat['radfecha'])) echo $pat['radfecha'];
                        ?>
                      </span>
                    </th>
                    <td>Radiografía</td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['radvobo']))||(isset($pat['radvobo'])&&$pat['radvobo']=='')){

                        $sms.="   <input class=\"form-check-input radvobo\" name=\"radvobo\" id=\"radvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['radvobo']=='t'){
                          $sms.=" <span class=\"radvobo text-success\" name=\"radvobo\" id=\"radvobo\" >Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input radvobo\" name=\"radvobo\" id=\"radvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['radmaterial']))||(isset($pat['radmaterial'])&&$pat['radmaterial']=='')){

                        $sms.="   <input class=\"form-check-input radmaterial\" name=\"radmaterial\" name=\"radmaterial\" id=\"radmaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['radmaterial']=='f'){
                          $sms.="   <input class=\"form-check-input radmaterial\" name=\"radmaterial\" id=\"radmaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"radmaterial text-success\" name=\"radmaterial\" id=\"radmaterial\" >".$pat['radmaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="prefecha">
                        <?php
                        if(isset($pat['prefecha'])) echo $pat['prefecha'];
                        ?>
                      </span>
                    </th>
                    <td>Preparación Dentaria</td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['prevobo']))||(isset($pat['prevobo'])&&$pat['prevobo']=='')){

                        $sms.="   <input class=\"form-check-input prevobo\" name=\"prevobo\" id=\"prevobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['prevobo']=='t'){
                          $sms.=" <span class=\"prevobo text-success\" name=\"prevobo\" id=\"prevobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input prevobo\" name=\"prevobo\" id=\"prevobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['prematerial']))||(isset($pat['prematerial'])&&$pat['prematerial']=='')){

                        $sms.="   <input class=\"form-check-input prematerial\" name=\"prematerial\" id=\"prematerial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['prematerial']=='f'){
                          $sms.="   <input class=\"form-check-input prematerial\" name=\"prematerial\" id=\"prematerial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"prematerial text-success\" name=\"prematerial\" id=\"prematerial\">".$pat['prematerial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="impfecha">
                        <?php
                        if(isset($pat['impfecha'])) echo $pat['impfecha'];
                        ?>
                      </span>
                    </th>
                    <td>Impresión</td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['impvobo']))||(isset($pat['impvobo'])&&$pat['impvobo']=='')){

                        $sms.="   <input class=\"form-check-input impvobo\" name=\"impvobo\" id=\"impvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['impvobo']=='t'){
                          $sms.=" <span class=\"impvobo text-success\" name=\"impvobo\" id=\"impvobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input impvobo\" name=\"impvobo\" id=\"impvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['impmaterial']))||(isset($pat['impmaterial'])&&$pat['impmaterial']=='')){

                        $sms.="   <input class=\"form-check-input impmaterial\" name=\"impmaterial\" id=\"impmaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['impmaterial']=='f'){
                          $sms.="   <input class=\"form-check-input impmaterial\" name=\"impmaterial\" id=\"impmaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"impmaterial text-success\" name=\"impmaterial\" id=\"impmaterial\">".$pat['impmaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="modfecha">
                        <?php
                        if(isset($pat['modfecha'])) echo $pat['modfecha'];
                        ?>
                      </span>
                    </th>
                    <td>Modelo de trabajo y Antagonista</td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['modvobo']))||(isset($pat['modvobo'])&&$pat['modvobo']=='')){

                        $sms.="   <input class=\"form-check-input modvobo\" name=\"modvobo\" id=\"modvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['modvobo']=='t'){
                          $sms.=" <span class=\"modvobo text-success\" name=\"modvobo\" id=\"modvobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input modvobo\" name=\"modvobo\" id=\"modvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['modmaterial']))||(isset($pat['modmaterial'])&&$pat['modmaterial']=='')){

                        $sms.="   <input class=\"form-check-input modmaterial\" name=\"modmaterial\" id=\"modmaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['modmaterial']=='f'){
                          $sms.="   <input class=\"form-check-input modmaterial\" name=\"modmaterial\" id=\"modmaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"modmaterial text-success\" name=\"modmaterial\" id=\"modmaterial\">".$pat['modmaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="tomecha">
                        <?php
                        if(isset($pat['tomfecha'])) echo $pat['tomfecha'];
                        ?>
                      </span>
                    </th>
                    <td>Toma de mordida</td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['tomvobo']))||(isset($pat['tomvobo'])&&$pat['tomvobo']=='')){

                        $sms.="   <input class=\"form-check-input tomvobo\" name=\"tomvobo\" id=\"tomvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['tomvobo']=='t'){
                          $sms.=" <span class=\"tomvobo text-success\" name=\"tomvobo\" id=\"tomvobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input tomvobo\" name=\"tomvobo\" id=\"tomvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['tommaterial']))||(isset($pat['tommaterial'])&&$pat['tommaterial']=='')){

                        $sms.="   <input class=\"form-check-input tommaterial\" name=\"tommaterial\" id=\"tommaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['tommaterial']=='f'){
                          $sms.="   <input class=\"form-check-input tommaterial\" name=\"tommaterial\" id=\"tommaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"tommaterial text-success\" name=\"impmaterial\" id=\"tommaterial\">".$pat['tommaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="monfecha">
                        <?php
                        if(isset($pat['monfecha'])) echo $pat['monfecha'];
                        ?>
                      </span>
                    </th>
                    <td>Montaje de modelo en Oclusor</td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['monvobo']))||(isset($pat['monvobo'])&&$pat['monvobo']=='')){

                        $sms.="   <input class=\"form-check-input monvobo\" name=\"monvobo\" id=\"monvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['monvobo']=='t'){
                          $sms.=" <span class=\"monvobo text-success\" name=\"monvobo\" id=\"monvobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input monvobo\" name=\"monvobo\" id=\"monvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['monmaterial']))||(isset($pat['monmaterial'])&&$pat['monmaterial']=='')){

                        $sms.="   <input class=\"form-check-input monmaterial\" name=\"monmaterial\" id=\"monmaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['monmaterial']=='f'){
                          $sms.="   <input class=\"form-check-input monmaterial\" name=\"monmaterial\" id=\"monmaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"monmaterial text-success\" name=\"monmaterial\" id=\"monmaterial\">".$pat['monmaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="corfecha">
                        <?php
                        if(isset($pat['corfecha'])) echo $pat['corfecha'];
                        ?>
                      </span>
                    </th>
                    <td>
                      <?php
                      if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                        echo "Puente provisional";
                      }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                        echo "Coronas Provisionales";
                      }else{
                        echo "Coronas Provisionales";
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['corvobo']))||(isset($pat['corvobo'])&&$pat['corvobo']=='')){

                        $sms.="   <input class=\"form-check-input corvobo\" name=\"corvobo\" id=\"corvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['corvobo']=='t'){
                          $sms.=" <span class=\"corvobo text-success\" name=\"corvobo\" id=\"corvobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input corvobo\" name=\"corvobo\" id=\"corvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['cormaterial']))||(isset($pat['cormaterial'])&&$pat['cormaterial']=='')){

                        $sms.="   <input class=\"form-check-input cormaterial\" name=\"cormaterial\" id=\"cormaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['cormaterial']=='f'){
                          $sms.="   <input class=\"form-check-input cormaterial\" name=\"cormaterial\" id=\"cormaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"cormaterial text-success\" name=\"cormaterial\" id=\"cormaterial\" >".$pat['cormaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="talfecha">
                        <?php
                        if(isset($pat['talfecha'])) echo $pat['talfecha'];
                        ?>
                      </span>
                    </th>
                    <td>
                      <?php
                      if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                        echo "Tallado patrón de cera";
                      }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                        echo "Tallado patrón de cera de la corona";
                      }else{
                        echo "Tallado patrón de cera de la corona";
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['talvobo']))||(isset($pat['talvobo'])&&$pat['talvobo']=='')){

                        $sms.="   <input class=\"form-check-input talvobo\" name=\"talvobo\" id=\"talvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['talvobo']=='t'){
                          $sms.=" <span class=\"talvobo text-success\" name=\"talvobo\" id=\"talvobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input talvobo\" name=\"talvobo\" id=\"talvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['talmaterial']))||(isset($pat['talmaterial'])&&$pat['talmaterial']=='')){

                        $sms.="   <input class=\"form-check-input talmaterial\" name=\"talmaterial\" id=\"talmaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['talmaterial']=='f'){
                          $sms.="   <input class=\"form-check-input talmaterial\" name=\"talmaterial\" id=\"talmaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"talmaterial text-success\" name=\"talmaterial\" id=\"talmaterial\">".$pat['talmaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="profecha">
                        <?php
                        if(isset($pat['profecha'])) echo $pat['profecha'];
                        ?>
                      </span>
                    </th>
                    <td>
                      <?php
                      if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                        echo "Procesador del puente";
                      }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                        echo "Procesado de la corona";
                      }else{
                        echo "Procesado de la corona";
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['provobo']))||(isset($pat['provobo'])&&$pat['provobo']=='')){

                        $sms.="   <input class=\"form-check-input provobo\" name=\"provobo\" id=\"provobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['provobo']=='t'){
                          $sms.=" <span class=\"provobo text-success\" name=\"provobo\" id=\"provobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input provobo\" name=\"provobo\" id=\"provobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['promaterial']))||(isset($pat['promaterial'])&&$pat['promaterial']=='')){

                        $sms.="   <input class=\"form-check-input promaterial\" name=\"promaterial\" id=\"promaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['promaterial']=='f'){
                          $sms.="   <input class=\"form-check-input promaterial\" name=\"promaterial\" id=\"promaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"promaterial text-success\" name=\"promaterial\" id=\"promaterial\">".$pat['promaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="prufecha">
                        <?php
                        if(isset($pat['prufecha'])) echo $pat['prufecha'];
                        ?>
                      </span>
                    </th>
                    <td>Prueba en boca</td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['pruvobo']))||(isset($pat['pruvobo'])&&$pat['pruvobo']=='')){

                        $sms.="   <input class=\"form-check-input pruvobo\" name=\"pruvobo\" id=\"pruvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['pruvobo']=='t'){
                          $sms.=" <span class=\"pruvobo text-success\" name=\"pruvobo\" id=\"pruvobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input pruvobo\" name=\"pruvobo\" id=\"pruvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['prumaterial']))||(isset($pat['prumaterial'])&&$pat['prumaterial']=='')){

                        $sms.="   <input class=\"form-check-input prumaterial\" name=\"prumaterial\" id=\"prumaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['prumaterial']=='f'){
                          $sms.="   <input class=\"form-check-input prumaterial\" name=\"prumaterial\" id=\"prumaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"prumaterial text-success\" name=\"prumaterial\" id=\"prumaterial\">".$pat['prumaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">
                      <span id="cemfecha">
                        <?php
                        if(isset($pat['cemfecha'])) echo $pat['cemfecha'];
                        ?>
                      </span>
                    </th>
                    <td>
                      <?php
                      if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                        echo "Cementado del puente protético";
                      }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                        echo "Cementado de la corona";
                      }else{
                        echo "Cementado de la corona";
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['cemvobo']))||(isset($pat['cemvobo'])&&$pat['cemvobo']=='')){

                        $sms.="   <input class=\"form-check-input cemvobo\" name=\"cemvobo\" id=\"cemvobo\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['cemvobo']=='t'){
                          $sms.=" <span class=\"cemvobo text-success\" name=\"cemvobo\" id=\"cemvobo\">Firmado</span>";

                        }else{
                          $sms.="   <input class=\"form-check-input cemvobo\" name=\"cemvobo\" id=\"cemvobo\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";
                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                    <td>
                      <?php
                      $sms='';
                      if((!isset($pat['cemmaterial']))||(isset($pat['cemmaterial'])&&$pat['cemmaterial']=='')){

                        $sms.="   <input class=\"form-check-input cemmaterial\" name=\"cemmaterial\" id=\"cemmaterial\" type=\"checkbox\">".
                        "   <div>".
                        "     <label class=\"form-check-label\">Solicitar</label>".
                        "   </div>";

                      }else{
                        if($pat['cemmaterial']=='f'){
                          $sms.="   <input class=\"form-check-input cemmaterial\" name=\"cemmaterial[]\" id=\"cemmaterial\" type=\"checkbox\" checked>".
                          "   <div>".
                          "     <label class=\"form-check-label\">Solicitar</label>".
                          "   </div>";

                        }else{
                          $sms.=" <span class=\"cemmaterial text-success\" name=\"cemmaterial\" id=\"cemmaterial\">".$pat['cemmaterial']."</span>";

                        }
                      }

                      echo $sms;
                      ?>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
          <?php

          if((isset($pat['fixedstatus']) && $pat['fixedstatus']!='fail'&&
          $pat['fixedstatus']!='canceled'&&$pat['fixedstatus']!='end') &&
          ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
          (!isset($pat['observationaccepted'])) )){
              echo "<button type=\"submit\" class=\"btn btn-success\" id=\"procedimiento_button\" name=\"procedimiento_button\">Enviar</button>";
          }

          ?>

        </div>

      </div>

      </div>
    </div>
    <!--modal procedimiento fin-->
    <br>
  <!--</div>-->
</div>
<hr>
<div class="border border-primary rounded px-3">
  <div class="" align="center">
    <b> <u>ODONTOGRAMA</u> </b>
  </div>
  <div  class="row border border-warning mx-3">
    <?php
    if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
    ?>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="metalica">
        <input class="form-check-input" type="radio" name="options" id="options1" checked>
        <label class="form-check-label" for="options1">
          Retenedores
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6" >
      <div class="form-check" id="pontico">
        <input class="form-check-input" type="radio" name="options" id="options2">
        <label class="form-check-label" for="options2">
          Póntico
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="red">
        <input class="form-check-input" type="radio" name="options" id="options3">
        <label class="form-check-label" for="options3">
          Conectores
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="limpiar">
        <input class="form-check-input" type="radio" name="options" id="options4">
        <label class="form-check-label" for="options4">
          Limpiar
        </label>
      </div>
    </div>
    <?php
    }else{
    ?>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="pivot">
        <input class="form-check-input" type="radio" name="options" id="options1"  checked>
        <label class="form-check-label" for="options1">
          Corona Pivot
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6" >
      <div class="form-check" id="jacket">
        <input class="form-check-input" type="radio" name="options" id="options2">
        <label class="form-check-label" for="options2">
          Corona Jacket
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="veneer">
        <input class="form-check-input" type="radio" name="options" id="options3">
        <label class="form-check-label" for="options3">
          Corona Veneer
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="metalica">
        <input class="form-check-input" type="radio" name="options" id="options4">
        <label class="form-check-label" for="options4">
          Corona Metalica
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="limpiar">
        <input class="form-check-input" type="radio" name="options" id="options5">
        <label class="form-check-label" for="options5">
          Limpiar
        </label>
      </div>
    </div>
    <?php } ?>
  </div>
  <!--odontograma inicio-->

  <!--inicio wrapper-->
  <div id="wrapper">
  <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat['fixedodontogram'])) echo $pat['fixedodontogram']; ?>">

  <table id="tabla-superior">
    <tbody>
      <tr>
        <!--de los numeros-->
        <td>
          <table id="tabla-1">
            <tbody>
        <tr>
          <!--<td class="titulo">Vestibular</td>-->
          <td class="noborde">
            <div class="">18</div>
            <div id="lineas-gr"></div>
            <div id="visualization18a" name="diente18-a" class="click"></div>
            <div id="diente18-a">
              <div id="furca18"></div>
            </div>
          </td>
          <td class="noborde">
            <div class="">17</div>
            <div id="visualization17a" name="diente17-a" class="click"></div>
            <div id="diente17-a">
              <div id="furca17"></div>
            </div>
          </td>
          <td class="noborde">
            <div class="">16</div>
            <div id="visualization16a" name="diente16-a" class="click"></div>
            <div id="diente16-a">
              <div id="furca16"></div>
            </div>
          </td>
          <td class="noborde">
            <div class="">15</div>
            <div id="visualization15a" name="diente15-a" class="click"></div>
            <div id="diente15-a"></div>
          </td>
          <td class="noborde">
            <div class="">14</div>
            <div id="visualization14a" name="diente14-a" class="click"></div>
            <div id="diente14-a"></div>
          </td>
          <td class="noborde">
            <div class="">13</div>
            <div id="visualization13a" name="diente13-a" class="click"></div>
            <div id="diente13-a"></div>
          </td>
          <td class="noborde">
            <div class="">12</div>
            <div id="visualization12a" name="diente12-a" class="click"></div>
            <div id="diente12-a"></div>
          </td>
          <td class="noborde">
            <div class="">11</div>
            <div name="diente11-a" class="click" id="visualization11a"></div>
            <div id="diente11-a"></div></td>
          </tr>
        </tbody>
      </table>
    </td>
    <td>
      <table id="tabla-2">
        <tbody>

        <tr>
          <td class="noborde">
            <div class="">21</div>
            <div id="lineas-gr"></div>
            <div id="visualization21a" name="diente21-a" class="click"></div>
            <div id="diente21-a"></div>
          </td>
          <td class="noborde">
            <div class="">22</div>
            <div id="visualization22a" name="diente22-a" class="click"></div>
            <div id="diente22-a"></div>
          </td>
          <td class="noborde">
            <div class="">23</div>
            <div id="visualization23a" name="diente23-a" class="click"></div>
            <div id="diente23-a"></div>
          </td>
          <td class="noborde">
            <div class="">24</div>
            <div id="visualization24a" name="diente24-a" class="click"></div>
            <div id="diente24-a"></div>
          </td>
          <td class="noborde">
            <div class="">25</div>
            <div id="visualization25a" name="diente25-a" class="click"></div>
            <div id="diente25-a"></div>
          </td>
          <td class="noborde">
            <div class="">26</div>
            <div id="visualization26a" name="diente26-a" class="click">
            </div>
            <div id="diente26-a">
              <div id="furca26"></div>
            </div>
          </td>
          <td class="noborde">
            <div class="">27</div>
            <div id="visualization27a" name="diente27-a" class="click"></div>
            <div id="diente27-a">
              <div id="furca27">
              </div>
            </div>
          </td>
          <td class="noborde">
            <div class="">28</div>
            <div id="visualization28a" name="diente28-a" class="click"></div>
            <div id="diente28-a">
              <div id="furca28"></div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </td>
  </tr>
  <tr>
  <td>
  <table id="tabla-7">
    <tbody>
      <tr>
        <!--<td class="titulo">Vestibular</td>-->
        <td class="noborde">
          <div id="lineas-gr-inf"></div>
          <div id="visualization48b" name="diente48b-a" class="click"></div>
          <div id="diente48b-a">
            <div id="furca48b"></div>
          </div>
          <div class="">48</div>
        </td>
        <td class="noborde">
          <div id="visualization47b" name="diente47b-a" class="click"></div>
          <div class="click"  id="diente47b-a">
            <div id="furca47b"></div>
          </div>
          <div class="">47</div>
        </td>
        <td class="noborde">
          <div id="visualization46b" name="diente46b-a" class="click"></div>
          <div id="diente46b-a">
            <div id="furca46b"></div>
          </div>
          <div class="">46</div>
        </td>
        <td class="noborde">
          <div id="visualization45b" name="diente45b-a" class="click"></div>
          <div id="diente45b-a"></div>
          <div class="">45</div>
        </td>
        <td class="noborde">
          <div id="visualization44b" name="diente44b-a" class="click"></div>
          <div id="diente44b-a"></div>
          <div class="">44</div>
        </td>
        <td class="noborde">
          <div id="visualization43b" name="diente43b-a" class="click"></div>
          <div id="diente43b-a" ></div>
          <div class="">43</div>
        </td>
        <td class="noborde">
          <div id="visualization42b" name="diente42b-a" class="click"></div>
          <div id="diente42b-a"></div>
          <div class="">42</div>
        </td>
        <td class="noborde">
          <div id="visualization41b" name="diente41b-a" class="click"></div>
          <div id="diente41b-a" ></div>
          <div class="">41</div>
        </td>
      </tr>

  </tbody></table>
  </td>
  <td>
  <table id="tabla-8">

  <tbody><tr>
  <td class="noborde">
  <div id="lineas-gr-inf"></div>
  <div id="visualization31b" name="diente31b-a" class="click" style="width: 23px; height: 160px;position:absolute;margin:0 0 0 7px;"></div>

  <div id="diente31b-a"></div>
  <div class="">31</div>
  </td>

  <td class="noborde">
  <div id="visualization32b" name="diente32b-a" class="click" style="width: 22px; height: 160px;position:absolute;margin:0 0 0 7px;"></div>
  <div id="diente32b-a"></div>
  <div class="">32</div>
</td>
  <td class="noborde">
  <div name="diente33b-a" class="click" id="visualization33b" style="width: 25px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div id="diente33b-a"></div>
  <div class="">33</div>
  </td>
  <td class="noborde">
  <div id="visualization34b" name="diente34b-a" class="click" style="width: 22px; height: 160px;position:absolute;margin:0 0 0 10px;"></div>
  <div id="diente34b-a"></div>
  <div class="">34</div>
  </td>
  <td class="noborde">
  <div id="visualization35b" name="diente35b-a" class="click" style="width: 25px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div id="diente35b-a"></div>
  <div class="">35</div>
  </td>
  <td class="noborde">
  <div id="visualization36b" name="diente36b-a" class="click" style="width: 50px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div id="diente36b-a">
    <div id="furca36b"></div></div>
    <div class="">36</div>
  </td>
  <td class="noborde">
  <div id="visualization37b" name="diente37b-a" class="click"style="width: 47px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div id="diente37b-a"><div id="furca37b"></div></div>
  <div class="">37</div>
  </td>
  <td class="noborde">
  <div id="visualization38b" name="diente38b-a" class="click" style="width: 47px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div id="diente38b-a"><div id="furca38b"></div></div>
  <div class="">38</div>
  </td>
  </tr>

  </tbody></table>
  </td>
  </tr>


  </tbody></table>


  </div>
  <!--fin wrapper-->
  <!--odontograma fin-->


  <div class="" align="center">
    <b> <u>OBSERVACIONES</u> </b>
  </div>
  <div class="row">
      <div class="col-12">
        <textarea readonly onmousedown="return false;" name="observation" id="observation" rows="4" class="form-control"><?php if(isset($pat['observationdesc'])) echo $pat['observationdesc'];?></textarea>
      </div>
  </div>
  <br>
  <div class="row">
    <?php

    if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['fixedstatus'])&&$pat['fixedstatus']!='fail'&&$pat['fixedstatus']!='canceled'){
      echo "
      <div class=\"col-4\">
        <button id=\"patientregister_button\" class=\"btn btn-success\" type=\"button\" name=\"patientregister_button\">Enviar Datos</button>
      </div>
      <div class=\"col-4\">
        <button id=\"cancel_button\" class=\"btn btn-danger\" type=\"button\" name=\"cancel_button\">Cancelar</button>
      </div>
      ";
    }
    if(!isset($pat['observationaccepted'])){
      echo "
      <div class=\"col-4\">
        <button id=\"patientregister_button\" class=\"btn btn-success\" type=\"button\" name=\"patientregister_button\">Enviar Datos</button>
      </div>
      <div class=\"col-4\">
        <button id=\"cancel_button\" class=\"btn btn-danger\" type=\"button\" name=\"cancel_button\">Cancelar</button>
      </div>
      ";
    }
    ?>

  </div>
  <br>
</div>
<hr>

</div>


<!--</div>-->


  </div>
  </main>



                <!--pie de pagina-->
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Unsxx &copy; Clinica Odontologica</div>
                            <div>
                                <a href="#">Politicas de Privacidad</a>
                                &middot;
                                <a href="#">Terminos &amp; Condiciones</a>
                            </div>
                        </div>
                    </div>
                </footer>

        </div>
        <!--fin div primero-->
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/bootstrap.bundle.min.js"></script>

        <script src="../js/scripts.js"></script>

        <!--bootstrap-->
        <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/jquery-3.5.1.slim.min.js"></script>

        <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/popper.min.js"></script>

        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/bootstrap.min.js"></script>

        <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
        <script src="../assets/graphic/jquery-3.5.1.min.js"></script>

    </body>
</html>
<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>
<script>

$(document).ready(function(){
  var a=new Array();
  a['diente18-a']='';a['diente17-a']='';a['diente16-a']='';a['diente15-a']='';a['diente14-a']='';a['diente13-a']='';a['diente12-a']='';a['diente11-a']='';
  a['diente21-a']='';a['diente22-a']='';a['diente23-a']='';a['diente24-a']='';a['diente25-a']='';a['diente26-a']='';a['diente27-a']='';a['diente28-a']='';

  a['diente41b-a']='';a['diente42b-a']='';a['diente43b-a']='';a['diente44b-a']='';a['diente45b-a']='';a['diente46b-a']='';a['diente47b-a']='';a['diente48b-a']='';
  a['diente31b-a']='';a['diente32b-a']='';a['diente33b-a']='';a['diente34b-a']='';a['diente35b-a']='';a['diente36b-a']='';a['diente37b-a']='';a['diente38b-a']='';
  function encript(){
    var str='';
    for (const key in a) {
      //console.log(`${key}: ${a[key]}`);
    //  console.log(a[key]);
      str+='['+key+'='+a[key]+']';
    }
    $('#draw').val(str);
    //para imprimir
  }

  //var str='[diente18-a=][diente17-a=bg-primary][diente16-a=bg-primary][diente15-a=bg-primary]';
  function descript(str){
    var data=str.split(']');
    //console.log(a.length);
    for(var i=0;i<data.length-1;i++){

      var b=data[i].split('[');
      var c=b[1].split('=');
      //a[c[0]]=c[1];
      var desc=c[0];
      control=c[1];
      var ww=$('#'+desc).width();
      var hh=$('#'+desc).height();
      var backgroundPos = $('#'+desc).css('backgroundPosition').split(" ");
      var xPos = backgroundPos[0],
      yPos = backgroundPos[1];
      var img=$('#'+desc).css('background');
      var ini=img.indexOf('/tabla')+8;
      var fin=img.indexOf('.png"')+4;
      var ntable=img.substring(ini-18,ini);
      var ini=img.indexOf('/period')+1;
      var img=img.substring(ini, fin);

      if(control==''){
        a[desc]=control;
      }else{
        a[desc]=control;
        control=control+'/';
      }
      var url='../'+ntable+control+img;
      console.log(url)
      $('#'+desc).css({
          "background": `url(${url})`,
          "width": `${ww}`,
          "height": `${hh}`,
        	"background-position": `${xPos} ${yPos}`,
        	"background-repeat": "no-repeat"
      });

    }
  }
  descript(`<?php echo trim($pat["fixedodontogram"]); ?>`);

  $(".click").click(function(event) {

    //mostramos a la consola
    console.log($(this).attr('name'));
    var control = $('input:radio[name=options]:checked').parent().attr('id');
    console.log(control);
    var desc=$(this).attr('name');//que es una X
    if(control!=''){
      var ww=$('#'+desc).width();
      var hh=$('#'+desc).height();
      var backgroundPos = $('#'+desc).css('backgroundPosition').split(" ");
      //now contains an array like ["0%", "50px"]

      var xPos = backgroundPos[0],
      yPos = backgroundPos[1];
      //console.log(w+":"+h);
      //console.log(xPos+'::'+yPos);
      var img=$('#'+desc).css('background');
      var ini=img.indexOf('/tabla')+8;
      //var ini=img.indexOf('/period')+1;
      var fin=img.indexOf('.png"')+4;
      //console.log($('#'+desc).css('background'));
      //console.log(ini);
      //console.log(fin);
      var ntable=img.substring(ini-18,ini);
      var ini=img.indexOf('/period')+1;
      var img=img.substring(ini, fin);
      //para guardar opcion

      if(control=='limpiar'){
        control='';
        a[desc]=control;
      }else{
        a[desc]=control;
        control=control+'/';
      }
      var url='../'+ntable+control+img;
      console.log('url:'+url+':-:');

      //console.log(img);
      $('#'+desc).css({
          "background": `url(${url})`,
          "width": `${ww}`,
          "height": `${hh}`,
        	"background-position": `${xPos} ${yPos}`,
        	"background-repeat": "no-repeat"
      });
      encript();
    }

    return false;
  });





      //cancel cancel_button
     $('#cancel_button').click(function(){
        location.reload();
     });
     function procedures(){
       var ficha=$('#ficha').val();

       var radfecha=$('#radfecha').text();
       var radvobo="";
       if($('#radvobo').prop('checked')=== undefined){
         radvobo='t';
       }else{
         if($('#radvobo').prop('checked')==true){
           radvobo='f';
         }
       }
       var radmaterial="";
       if($('#radmaterial').prop('checked')=== undefined){
         radmaterial=$('#radmaterial').text();
       }else{
         if($('#radmaterial').prop('checked')==true){
           radmaterial='f';
         }
       }

       var prefecha=$('#prefecha').text();
       var prevobo="";
       if($('#prevobo').prop('checked')=== undefined){
         prevobo='t';
       }else{
         if($('#prevobo').prop('checked')==true){
           prevobo='f';
         }
       }
       var prematerial="";
       if($('#prematerial').prop('checked')=== undefined){
         prematerial=$('#prematerial').text();
       }else{
         if($('#prematerial').prop('checked')==true){
           prematerial='f';
         }
       }

       var impfecha=$('#impfecha').text();
       var impvobo="";
       if($('#impvobo').prop('checked')=== undefined){
         impvobo='t';
       }else{
         if($('#impvobo').prop('checked')==true){
           impvobo='f';
         }
       }
       var impmaterial="";
       if($('#impmaterial').prop('checked')=== undefined){
         impmaterial=$('#impmaterial').text();
       }else{
         if($('#impmaterial').prop('checked')==true){
           impmaterial='f';
         }
       }

       var modfecha=$('#modfecha').text();
       var modvobo="";
       if($('#modvobo').prop('checked')=== undefined){
         modvobo='t';
       }else{
         if($('#modvobo').prop('checked')==true){
           modvobo='f';
         }
       }
       var modmaterial="";
       if($('#modmaterial').prop('checked')=== undefined){
         modmaterial=$('#modmaterial').text();
       }else{
         if($('#modmaterial').prop('checked')==true){
           modmaterial='f';
         }
       }

       var tomfecha=$('#tomfecha').text();
       var tomvobo="";
       if($('#tomvobo').prop('checked')=== undefined){
         tomvobo='t';
       }else{
         if($('#tomvobo').prop('checked')==true){
           tomvobo='f';
         }
       }
       var tommaterial="";
       if($('#tommaterial').prop('checked')=== undefined){
         tommaterial=$('#tommaterial').text();
       }else{
         if($('#tommaterial').prop('checked')==true){
           tommaterial='f';
         }
       }

       var monfecha=$('#monfecha').text();
       var monvobo="";
       if($('#monvobo').prop('checked')=== undefined){
         monvobo='t';
       }else{
         if($('#monvobo').prop('checked')==true){
           monvobo='f';
         }
       }
       var monmaterial="";
       if($('#monmaterial').prop('checked')=== undefined){
         monmaterial=$('#monmaterial').text();
       }else{
         if($('#monmaterial').prop('checked')==true){
           monmaterial='f';
         }
       }

       var corfecha=$('#corfecha').text();
       var corvobo="";
       if($('#corvobo').prop('checked')=== undefined){
         corvobo='t';
       }else{
         if($('#corvobo').prop('checked')==true){
           corvobo='f';
         }
       }
       var cormaterial="";
       if($('#cormaterial').prop('checked')=== undefined){
         cormaterial=$('#cormaterial').text();
       }else{
         if($('#cormaterial').prop('checked')==true){
           cormaterial='f';
         }
       }

       var talfecha=$('#talfecha').text();
       var talvobo="";
       if($('#talvobo').prop('checked')=== undefined){
         talvobo='t';
       }else{
         if($('#talvobo').prop('checked')==true){
           talvobo='f';
         }
       }
       var talmaterial="";
       if($('#talmaterial').prop('checked')=== undefined){
         talmaterial=$('#talmaterial').text();
       }else{
         if($('#talmaterial').prop('checked')==true){
           talmaterial='f';
         }
       }

       var profecha=$('#profecha').text();
       var provobo="";
       if($('#provobo').prop('checked')=== undefined){
         provobo='t';
       }else{
         if($('#provobo').prop('checked')==true){
           provobo='f';
         }
       }
       var promaterial="";
       if($('#promaterial').prop('checked')=== undefined){
         promaterial=$('#promaterial').text();
       }else{
         if($('#promaterial').prop('checked')==true){
           promaterial='f';
         }
       }

       var prufecha=$('#prufecha').text();
       var pruvobo="";
       if($('#pruvobo').prop('checked')=== undefined){
         pruvobo='t';
       }else{
         if($('#pruvobo').prop('checked')==true){
           pruvobo='f';
         }
       }
       var prumaterial="";
       if($('#prumaterial').prop('checked')=== undefined){
         prumaterial=$('#prumaterial').text();
       }else{
         if($('#prumaterial').prop('checked')==true){
           prumaterial='f';
         }
       }

       var cemfecha=$('#cemfecha').text();
       var cemvobo="";
       if($('#cemvobo').prop('checked')=== undefined){
         cemvobo='t';
       }else{
         if($('#cemvobo').prop('checked')==true){
           cemvobo='f';
         }
       }
       var cemmaterial="";
       if($('#cemmaterial').prop('checked')=== undefined){
         cemmaterial=$('#cemmaterial').text();
       }else{
         if($('#cemmaterial').prop('checked')==true){
           cemmaterial='f';
         }
       }

            $.ajax({

               url:"../include/i_prosthodontics.php",
               method:"POST",
               data: {ficha:ficha, radfecha:radfecha, radvobo:radvobo, radmaterial:radmaterial, prefecha:prefecha, prevobo:prevobo,
                 prematerial:prematerial, impfecha:impfecha, impvobo:impvobo, impmaterial:impmaterial, modfecha:modfecha,
                 modvobo:modvobo, modmaterial:modmaterial, tomfecha:tomfecha, tomvobo:tomvobo, tommaterial:tommaterial,
                 monfecha:monfecha, monvobo:monvobo, monmaterial:monmaterial, corfecha:corfecha, corvobo:corvobo,
                 cormaterial:cormaterial, talfecha:talfecha, talvobo:talvobo, talmaterial:talmaterial, profecha:profecha,
                 provobo:provobo, promaterial:promaterial, prufecha:prufecha, pruvobo:pruvobo, prumaterial:prumaterial,
                 cemfecha:cemfecha, cemvobo:cemvobo, cemmaterial:cemmaterial},

               success:function(data)
               {

                 if(data=='yes'){
                   alert('Se envió los datos');
                 }else{
                   alert(data);
                   console.log(data);
                 }
               }
            });
     }
     $('#procedimiento_button').click(function(){
        procedures();
     });
     //funcion para registrar los datos de la ficha clinica de odontopediatria I
     function registerpatient(){

      var ficha=$('#ficha').val();
      var patientid = $('#patientid').val();
      var year=$('select[name=year]').val();
      var diagnosis=$('#diagnosis').val();
      var etiology=$('#etiology').val();
      var forecast=$('#forecast').val();
      var draw=$('#draw').val();
      var treatment='';

      $(".treatment").each(function() {
         var j=$(this);
         if($(this).prop('checked')==true){
           treatment+='[t]';
         }else{
           treatment+='[f]';
         }
      });
      console.log(treatment);

      var radfecha=$('#radfecha').text();
      var radvobo="";
      if($('#radvobo').prop('checked')=== undefined){
        radvobo='t';
      }else{
        if($('#radvobo').prop('checked')==true){
          radvobo='f';
        }
      }
      var radmaterial="";
      if($('#radmaterial').prop('checked')=== undefined){
        radmaterial=$('#radmaterial').text();
      }else{
        if($('#radmaterial').prop('checked')==true){
          radmaterial='f';
        }
      }

      var prefecha=$('#prefecha').text();
      var prevobo="";
      if($('#prevobo').prop('checked')=== undefined){
        prevobo='t';
      }else{
        if($('#prevobo').prop('checked')==true){
          prevobo='f';
        }
      }
      var prematerial="";
      if($('#prematerial').prop('checked')=== undefined){
        prematerial=$('#prematerial').text();
      }else{
        if($('#prematerial').prop('checked')==true){
          prematerial='f';
        }
      }

      var impfecha=$('#impfecha').text();
      var impvobo="";
      if($('#impvobo').prop('checked')=== undefined){
        impvobo='t';
      }else{
        if($('#impvobo').prop('checked')==true){
          impvobo='f';
        }
      }
      var impmaterial="";
      if($('#impmaterial').prop('checked')=== undefined){
        impmaterial=$('#impmaterial').text();
      }else{
        if($('#impmaterial').prop('checked')==true){
          impmaterial='f';
        }
      }

      var modfecha=$('#modfecha').text();
      var modvobo="";
      if($('#modvobo').prop('checked')=== undefined){
        modvobo='t';
      }else{
        if($('#modvobo').prop('checked')==true){
          modvobo='f';
        }
      }
      var modmaterial="";
      if($('#modmaterial').prop('checked')=== undefined){
        modmaterial=$('#modmaterial').text();
      }else{
        if($('#modmaterial').prop('checked')==true){
          modmaterial='f';
        }
      }

      var tomfecha=$('#tomfecha').text();
      var tomvobo="";
      if($('#tomvobo').prop('checked')=== undefined){
        tomvobo='t';
      }else{
        if($('#tomvobo').prop('checked')==true){
          tomvobo='f';
        }
      }
      var tommaterial="";
      if($('#tommaterial').prop('checked')=== undefined){
        tommaterial=$('#tommaterial').text();
      }else{
        if($('#tommaterial').prop('checked')==true){
          tommaterial='f';
        }
      }

      var monfecha=$('#monfecha').text();
      var monvobo="";
      if($('#monvobo').prop('checked')=== undefined){
        monvobo='t';
      }else{
        if($('#monvobo').prop('checked')==true){
          monvobo='f';
        }
      }
      var monmaterial="";
      if($('#monmaterial').prop('checked')=== undefined){
        monmaterial=$('#monmaterial').text();
      }else{
        if($('#monmaterial').prop('checked')==true){
          monmaterial='f';
        }
      }

      var corfecha=$('#corfecha').text();
      var corvobo="";
      if($('#corvobo').prop('checked')=== undefined){
        corvobo='t';
      }else{
        if($('#corvobo').prop('checked')==true){
          corvobo='f';
        }
      }
      var cormaterial="";
      if($('#cormaterial').prop('checked')=== undefined){
        cormaterial=$('#cormaterial').text();
      }else{
        if($('#cormaterial').prop('checked')==true){
          cormaterial='f';
        }
      }

      var talfecha=$('#talfecha').text();
      var talvobo="";
      if($('#talvobo').prop('checked')=== undefined){
        talvobo='t';
      }else{
        if($('#talvobo').prop('checked')==true){
          talvobo='f';
        }
      }
      var talmaterial="";
      if($('#talmaterial').prop('checked')=== undefined){
        talmaterial=$('#talmaterial').text();
      }else{
        if($('#talmaterial').prop('checked')==true){
          talmaterial='f';
        }
      }

      var profecha=$('#profecha').text();
      var provobo="";
      if($('#provobo').prop('checked')=== undefined){
        provobo='t';
      }else{
        if($('#provobo').prop('checked')==true){
          provobo='f';
        }
      }
      var promaterial="";
      if($('#promaterial').prop('checked')=== undefined){
        promaterial=$('#promaterial').text();
      }else{
        if($('#promaterial').prop('checked')==true){
          promaterial='f';
        }
      }

      var prufecha=$('#prufecha').text();
      var pruvobo="";
      if($('#pruvobo').prop('checked')=== undefined){
        pruvobo='t';
      }else{
        if($('#pruvobo').prop('checked')==true){
          pruvobo='f';
        }
      }
      var prumaterial="";
      if($('#prumaterial').prop('checked')=== undefined){
        prumaterial=$('#prumaterial').text();
      }else{
        if($('#prumaterial').prop('checked')==true){
          prumaterial='f';
        }
      }

      var cemfecha=$('#cemfecha').text();
      var cemvobo="";
      if($('#cemvobo').prop('checked')=== undefined){
        cemvobo='t';
      }else{
        if($('#cemvobo').prop('checked')==true){
          cemvobo='f';
        }
      }
      var cemmaterial="";
      if($('#cemmaterial').prop('checked')=== undefined){
        cemmaterial=$('#cemmaterial').text();
      }else{
        if($('#cemmaterial').prop('checked')==true){
          cemmaterial='f';
        }
      }

           $.ajax({

              url:"../include/i_prosthodontics.php",
              method:"POST",
              data: {ficha:ficha, patientid:patientid, year:year, diagnosis:diagnosis, draw:draw,
                etiology:etiology, forecast:forecast, treatment:treatment,
                radfecha:radfecha, radvobo:radvobo, radmaterial:radmaterial, prefecha:prefecha, prevobo:prevobo,
                prematerial:prematerial, impfecha:impfecha, impvobo:impvobo, impmaterial:impmaterial, modfecha:modfecha,
                modvobo:modvobo, modmaterial:modmaterial, tomfecha:tomfecha, tomvobo:tomvobo, tommaterial:tommaterial,
                monfecha:monfecha, monvobo:monvobo, monmaterial:monmaterial, corfecha:corfecha, corvobo:corvobo,
                cormaterial:cormaterial, talfecha:talfecha, talvobo:talvobo, talmaterial:talmaterial, profecha:profecha,
                provobo:provobo, promaterial:promaterial, prufecha:prufecha, pruvobo:pruvobo, prumaterial:prumaterial,
                cemfecha:cemfecha, cemvobo:cemvobo, cemmaterial:cemmaterial},

              success:function(data)
              {

                if(data=='yes'){
                  alert('Se envio los datos de la ficha clinica');
                  location.href="index.php";
                }else{
                  alert(data);
                  console.log(data);
                }
              }
           });

     }

     /*$('#patientregister_button').click(function(){
       if (confirm("Enviar los datos de ficha clinica?")) {
         registerpatient();
         GuardarImg(false);
       }else{
           location.reload();
       }
     });*/

     //
     $('#patientregister_button').click(function(){
       //if (confirm("Enviar los datos de ficha clinica?")) {
         registerpatient();
       //}else{
        //   location.reload();
       //}
     });

     //update
     $('#update_button').click(function(){
		 var username,userdesc,userfull,passHASHo,passHASHn;
		 if($('#passwordn1').val() != $('#passwordn2').val()){
			 alert('password confirmacion debe ser igual');
		 }else{
			 if($('#passwordn1').val() == $('#passwordo').val()){
				 alert('password nuevo debe ser diferente al anterior');
			 }else{
				 username = $('#username').val();
				 userdesc = $('#userdesc').val();
				 userfull = $('#userfull').val();
				 passHASHo = js_myhash(js_myhash($('#passwordo').val())+'<?php echo session_id(); ?>');
				 passHASHn = bighexsoma(js_myhash($('#passwordn2').val()),js_myhash($('#passwordo').val()));
				 $('#passwordn1').val('                                                     ');
				 $('#passwordn2').val('                                                     ');
				 $('#passwordo').val('                                                     ');

				 $.ajax({

						  url:"../include/i_optionlower.php",
						  method:"POST",
						  data: {username:username, userdesc:userdesc, userfullname:userfull, passwordo:passHASHo, passwordn:passHASHn},

						  success:function(data)
						  {
							   //alert(data);
							   if(data.indexOf('Data updated.') !== -1)
							   {
									alert("Data updated.");
									$('#updateModal').hide();
									location.reload();
							   }
							   else
							   {
								   if (data.indexOf('Incorrect password')!== -1) {
									   alert("Incorrect password");

								   }else{
									   alert(data);
								   }

							   }

						  }
				 });

			 }
		 }

     });

});

</script>
