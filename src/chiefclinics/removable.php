<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBRemovableInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=1&&$pat["clinicalid"]!=9)
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
                        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==9){
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Prostodoncia Removible III</h2>";
                        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==1) {
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Prostodoncia Removible II</h2>";
                        }else{
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Prostodoncia Removible</h2>";
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['removablestatus'])&&$pat['removablestatus']!='fail'){
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['removablestatus'])&&$pat['removablestatus']=='fail'){
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
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==9){
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;5to. Año</label> </label>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==1) {
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;4to. Año</label> </label>";
        }else{
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;..................</label> </label>";
        }
        ?>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="patientfullname"><b>Paciente:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?></label><br>

      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientgender"><b>Sexo:</b>&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
          if(!isset($pat) || $pat["patientgender"] == '--') echo "indefinido";
          if(isset($pat) && $pat["patientgender"] == 'masculino') echo "Masculino";
          if(isset($pat) && $pat["patientgender"] == 'femenino') echo "Femenino";
          ?>
        </label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientage"><b>Edad:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></label>

      </div>

    </div>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientcivilstatus"><b>Estado Civil:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientcivilstatus"])) echo $pat["patientcivilstatus"]; ?></label><br>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientoccupation"><b>Ocupación:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientoccupation"])) echo $pat["patientoccupation"]; ?></label><br>

      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientdirection"><b>Domicilio:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"]; ?></label><br>

      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientphone"><b>Telf.:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientphone"])&&$pat["patientphone"]!=0) echo $pat["patientphone"]; ?></label><br>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <label for="patientprovenance"><b>Procedencia:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"]; ?></label><br>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for=""><b>Fecha de Inicio:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["startdatetime"])&&$pat["startdatetime"]!=-1) echo datetimeconv($pat["startdatetime"]); ?></label><br>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for=""><b>Autorizado por Docente:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["teacher"])&&$pat["teacher"]!=0){ $a=DBUserInfo($pat["teacher"]); echo $a['userfullname']; }?></label><br>

      </div>
    </div>
    <hr>
    <div class="" align="center">
      <b>HISTORIA CLÍNICA</b>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12 col-12">
        <label for="hereditary">Antecedentes hereditarios:</label>
        <input type="text" class="form-control" name="hereditary" id="hereditary" value="<?php if(isset($pat["removablehereditary"])) echo $pat["removablehereditary"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <label for="personal">Antecedentes personales generales:</label>
        <input type="text" class="form-control" name="personal" id="personal" value="<?php if(isset($pat["removablepersonal"])) echo $pat["removablepersonal"];  ?>">
      </div>
      <div class="col-lg-2 col-md-2 col-sm-5 col-5">
        <label for="">Tipo psicológico:</label>
        <select name="psychological" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['removablepsychological']) || $pat["removablepsychological"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['removablepsychological']) && $pat["removablepsychological"] == 'receptivo') echo "selected"; ?> value="receptivo">Receptivo</option>
          <option <?php if(isset($pat['removablepsychological']) && $pat["removablepsychological"] == 'escéptico') echo "selected"; ?> value="escéptico">Escéptico</option>
          <option <?php if(isset($pat['removablepsychological']) && $pat["removablepsychological"] == 'histérico') echo "selected"; ?> value="histérico">Histérico</option>
          <option <?php if(isset($pat['removablepsychological']) && $pat["removablepsychological"] == 'pasivo') echo "selected"; ?> value="pasivo">Pasivo</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-7 col-7">
        <label for="toothless">Tipo de desdentado:</label>
        <input type="text" class="form-control" name="toothless" id="toothless" value="<?php if(isset($pat["removabletoothless"])) echo $pat["removabletoothless"];  ?>">
      </div>
    </div>
    <div class="row">

      <div class="col-12">
        <div class="row">
          <div class="col-12">
            <label for=""><u>Clasificación de kenedy:</u></label>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="">Superior</label>
            <div class="row">
              <div class="col-5">
                <select name="kenedysc" class="form-select" aria-label="Default select example">
                  <option <?php if(!isset($pat['kenedysc']) || $pat["kenedysc"] == '') echo "selected"; ?> value="">--</option>
                  <option <?php if(isset($pat['kenedysc']) && $pat["kenedysc"] == 'clasei') echo "selected"; ?> value="clasei">Clase I</option>
                  <option <?php if(isset($pat['kenedysc']) && $pat["kenedysc"] == 'claseii') echo "selected"; ?> value="claseii">Clase II</option>
                  <option <?php if(isset($pat['kenedysc']) && $pat["kenedysc"] == 'claseiii') echo "selected"; ?> value="claseiii">Clase III</option>
                  <option <?php if(isset($pat['kenedysc']) && $pat["kenedysc"] == 'claseiv') echo "selected"; ?> value="claseiv">Clase IV</option>
                  <option <?php if(isset($pat['kenedysc']) && $pat["kenedysc"] == 'clasev') echo "selected"; ?> value="clasev">Clase V</option>
                  <option <?php if(isset($pat['kenedysc']) && $pat["kenedysc"] == 'clasevi') echo "selected"; ?> value="clasevi">Clase VI</option>
                </select>
              </div>
              <div class="col-7">
                <select name="kenedysm" class="form-select" aria-label="Default select example">
                  <option <?php if(!isset($pat['kenedysm']) || $pat["kenedysm"] == '') echo "selected"; ?> value="">--</option>
                  <option <?php if(isset($pat['kenedysm']) && $pat["kenedysm"] == 'modificacion1') echo "selected"; ?> value="modificacion1">Modificación 1</option>
                  <option <?php if(isset($pat['kenedysm']) && $pat["kenedysm"] == 'modificacion2') echo "selected"; ?> value="modificacion2">Modificación 2</option>
                  <option <?php if(isset($pat['kenedysm']) && $pat["kenedysm"] == 'modificacion3') echo "selected"; ?> value="modificacion3">Modificación 3</option>
                  <option <?php if(isset($pat['kenedysm']) && $pat["kenedysm"] == 'modificacion4') echo "selected"; ?> value="modificacion4">Modificación 4</option>
                  <option <?php if(isset($pat['kenedysm']) && $pat["kenedysm"] == 'modificacion5') echo "selected"; ?> value="modificacion5">Modificación 5</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="">Inferior</label>
            <div class="row">
              <div class="col-5">
                <select name="kenedyic" class="form-select" aria-label="Default select example">
                  <option <?php if(!isset($pat['kenedyic']) || $pat["kenedyic"] == '') echo "selected"; ?> value="">--</option>
                  <option <?php if(isset($pat['kenedyic']) && $pat["kenedyic"] == 'clasei') echo "selected"; ?> value="clasei">Clase I</option>
                  <option <?php if(isset($pat['kenedyic']) && $pat["kenedyic"] == 'claseii') echo "selected"; ?> value="claseii">Clase II</option>
                  <option <?php if(isset($pat['kenedyic']) && $pat["kenedyic"] == 'claseiii') echo "selected"; ?> value="claseiii">Clase III</option>
                  <option <?php if(isset($pat['kenedyic']) && $pat["kenedyic"] == 'claseiv') echo "selected"; ?> value="claseiv">Clase IV</option>
                  <option <?php if(isset($pat['kenedyic']) && $pat["kenedyic"] == 'clasev') echo "selected"; ?> value="clasev">Clase V</option>
                  <option <?php if(isset($pat['kenedyic']) && $pat["kenedyic"] == 'clasevi') echo "selected"; ?> value="clasevi">Clase VI</option>
                </select>
              </div>
              <div class="col-7">
                <select name="kenedyim" class="form-select" aria-label="Default select example">
                  <option <?php if(!isset($pat['kenedyim']) || $pat["kenedyim"] == '') echo "selected"; ?> value="">--</option>
                  <option <?php if(isset($pat['kenedyim']) && $pat["kenedyim"] == 'modificacion1') echo "selected"; ?> value="modificacion1">Modificación 1</option>
                  <option <?php if(isset($pat['kenedyim']) && $pat["kenedyim"] == 'modificacion2') echo "selected"; ?> value="modificacion2">Modificación 2</option>
                  <option <?php if(isset($pat['kenedyim']) && $pat["kenedyim"] == 'modificacion3') echo "selected"; ?> value="modificacion3">Modificación 3</option>
                  <option <?php if(isset($pat['kenedyim']) && $pat["kenedyim"] == 'modificacion4') echo "selected"; ?> value="modificacion4">Modificación 4</option>
                  <option <?php if(isset($pat['kenedyim']) && $pat["kenedyim"] == 'modificacion5') echo "selected"; ?> value="modificacion5">Modificación 5</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <!--seleccionantes
        <select name="kenedy" class="form-select" aria-label="Default select example">
          <option <?php //if(!isset($pat['removablekenedy']) || $pat["removablekenedy"] == '') echo "selected"; ?> value=""></option>
          <option <?php //if(isset($pat['removablekenedy']) && $pat["removablekenedy"] == 'superior') echo "selected"; ?> value="superior">Superior</option>
          <option <?php //if(isset($pat['removablekenedy']) && $pat["removablekenedy"] == 'inferior') echo "selected"; ?> value="inferior">Inferior</option>
        </select>

        -->


      </div>
    </div>
    <hr>
    <div class="" align="center">
      <b>DIAGNÓSTICO</b>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <label for="">¿Usa o usó alguna vez una prótesis bucal?</label>
        <select name="diagnosticobucal" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['diagnosticobucal']) || $pat["diagnosticobucal"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['diagnosticobucal']) && $pat["diagnosticobucal"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['diagnosticobucal']) && $pat["diagnosticobucal"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-6 col-6">
        <label for="diagnosticodeque">De qué?</label>
        <input type="text" class="form-control" name="diagnosticodeque" id="diagnosticodeque" value="<?php if(isset($pat["diagnosticodeque"])) echo $pat["diagnosticodeque"];  ?>">
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="diagnosticoduracion">Duración</label>
        <input type="text" class="form-control" name="diagnosticoduracion" id="diagnosticoduracion" value="<?php if(isset($pat["diagnosticoduracion"])) echo $pat["diagnosticoduracion"];  ?>">
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12 col-12">
        <label for="diagnosticoresultado">Resultado</label>
        <input type="text" class="form-control" name="diagnosticoresultado" id="diagnosticoresultado" value="<?php if(isset($pat["diagnosticoresultado"])) echo $pat["diagnosticoresultado"];  ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <label for="diagnosticoproblema">Si la prótesis anterior no fue enteramente satisfactoria ¿Cuál cree Ud. Que fue el problema?</label>
        <input type="text" class="form-control" name="diagnosticoproblema" id="diagnosticoproblema" value="<?php if(isset($pat["diagnosticoproblema"])) echo $pat["diagnosticoproblema"];  ?>">
      </div>
    </div>
    <div class="row">

      <label for="">¿Cuál fue la causa de la pérdida de sus dientes naturales?</label>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <select name="diagnosticodiente" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['diagnosticodiente']) || $pat["diagnosticodiente"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['diagnosticodiente']) && $pat["diagnosticodiente"] == 'period.') echo "selected"; ?> value="period.">Period.</option>
          <option <?php if(isset($pat['diagnosticodiente']) && $pat["diagnosticodiente"] == 'caries') echo "selected"; ?> value="caries">Caries</option>
          <option <?php if(isset($pat['diagnosticodiente']) && $pat["diagnosticodiente"] == 'traumatismo') echo "selected"; ?> value="traumatismo">Traumatismo</option>
          <option <?php if(isset($pat['diagnosticodiente']) && $pat["diagnosticodiente"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
        </select>
      </div>
    </div>
    <hr>
    <div class="" align="center">
      <b>OBSERVACIONES INTRAORALES</b>
    </div>
    <br>

    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="occlusion">Higiene Oral</label>
        <select name="hygiene" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalhygiene"] == 'buena') echo "selected"; ?> value="buena">Buena</option>
          <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'regular') echo "selected"; ?> value="regular">Regular</option>
          <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'mala') echo "selected"; ?> value="mala">Mala</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="cavities">Indice de caries</label>
        <select name="cavities" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["removablecavities"]) || $pat["removablecavities"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["removablecavities"]) && $pat["removablecavities"] == 'alto') echo "selected"; ?> value="alto">Alto</option>
          <option <?php if(isset($pat["removablecavities"]) && $pat["removablecavities"] == 'moderado') echo "selected"; ?> value="moderado">Moderado</option>
          <option <?php if(isset($pat["removablecavities"]) && $pat["removablecavities"] == 'bajo') echo "selected"; ?> value="bajo">Bajo</option>
        </select>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="row">
          <label for="central">Coincide la oclusión céntrica y la relación céntrica?</label>
          <div class="col-6">
            <select name="central" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat) || $pat["removablecentral"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat) && $pat["removablecentral"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat) && $pat["removablecentral"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <label for="bracesoption">¿Existen frenillos o inserciones musculares que podrán intervenir en el máximo ajuste y comodidad?</label>
      <div class="col-lg-3 col-md-3 col-sm-4 col-4">
        <select name="bracesoption" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["bracesoption"]) || $pat["bracesoption"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["bracesoption"]) && $pat["bracesoption"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat["bracesoption"]) && $pat["bracesoption"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="text" class="form-control" name="bracesobs" id="bracesobs" value="<?php if(isset($pat["bracesobs"])) echo $pat["bracesobs"];  ?>" placeholder="Escribir Observación">
      </div>
    </div>
    <div class="row">
      <label for="salivaoption">¿La saliva es de tipo y calidad normal?</label>
      <div class="col-lg-3 col-md-3 col-sm-4 col-4">
        <select name="salivaoption" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["salivaoption"]) || $pat["salivaoption"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["salivaoption"]) && $pat["salivaoption"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat["salivaoption"]) && $pat["salivaoption"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="text" class="form-control" name="salivaobs" id="salivaobs" value="<?php if(isset($pat["salivaobs"])) echo $pat["salivaobs"];  ?>" placeholder="Escribir Observación">
      </div>
    </div>
    <div class="row">
      <label for="">Examine las aéreas siguientes en busca de posibles interferencias en el ajuste y la comodidad optima:</label>

      <div class="col-12">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <span>Línea milohoidea normal:</span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-5 col-5">
            <input type="text" class="form-control" name="milohoideadesc" id="milohoideadesc" value="<?php if(isset($pat["milohoideadesc"])) echo $pat["milohoideadesc"];  ?>" >
          </div>
          <div class="col-lg-4 col-md-4 col-sm-7 col-7">
            <input type="text" class="form-control" name="milohoideaobs" id="milohoideaobs" value="<?php if(isset($pat["milohoideaobs"])) echo $pat["milohoideaobs"];  ?>" placeholder="Escribir Observación">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <span>Tejido de crestas alveolares normales:</span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-5 col-5">
            <input type="text" class="form-control d-inline" name="alveolaresdesc" id="alveolaresdesc" value="<?php if(isset($pat["alveolaresdesc"])) echo $pat["alveolaresdesc"];  ?>" >

          </div>
          <div class="col-lg-4 col-md-4 col-sm-7 col-7">
            <input type="text" class="form-control d-inline" name="alveolaresobs" id="alveolaresobs" value="<?php if(isset($pat["alveolaresobs"])) echo $pat["alveolaresobs"];  ?>" placeholder="Escribir Observación">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <span>Tuberosidad normal:</span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-5 col-5">
            <input type="text" class="form-control" name="tuberosidaddesc" id="tuberosidaddesc" value="<?php if(isset($pat["tuberosidaddesc"])) echo $pat["tuberosidaddesc"];  ?>" >
          </div>
          <div class="col-lg-4 col-md-4 col-sm-7 col-7">
            <input type="text" class="form-control" name="tuberosidadobs" id="tuberosidadobs" value="<?php if(isset($pat["tuberosidadobs"])) echo $pat["tuberosidadobs"];  ?>" placeholder="Escribir Observación">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <span>Hueso alveolar de soporte normal:</span>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-5 col-5">
            <input type="text" class="form-control" name="alveolardesc" id="alveolardesc" value="<?php if(isset($pat["alveolardesc"])) echo $pat["alveolardesc"];  ?>" >
          </div>
          <div class="col-lg-4 col-md-4 col-sm-7 col-7">
            <div class="row">
              <div class="col-7">
                <input type="text" class="form-control" name="alveolarobs" id="alveolarobs" value="<?php if(isset($pat["alveolarobs"])) echo $pat["alveolarobs"];  ?>" placeholder="Escribir Observación">
              </div>
              <div class="col-5">
                <span>a. Cicatrizado b. En evolución</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="palateoption">Paladar:</label><br>
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-5 col-5">
            <select name="palateoption" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat["palateoption"]) || $pat["palateoption"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat["palateoption"]) && $pat["palateoption"] == 'triangular') echo "selected"; ?> value="triangular">Triangular</option>
              <option <?php if(isset($pat["palateoption"]) && $pat["palateoption"] == 'cuadrado') echo "selected"; ?> value="cuadrado">Cuadrado</option>
              <option <?php if(isset($pat["palateoption"]) && $pat["palateoption"] == 'ovoide') echo "selected"; ?> value="ovoide">Ovoide</option>
              <option <?php if(isset($pat["palateoption"]) && $pat["palateoption"] == 'plano') echo "selected"; ?> value="plano">Plano</option>
            </select>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-7 col-7">
            <input type="text" class="form-control" name="palateobs" id="palateobs" value="<?php if(isset($pat["palateobs"])) echo $pat["palateobs"];  ?>" placeholder="Escribir Observación">
          </div>
        </div>

      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="residual">Evaluación del reborde residual:</label>
        <input type="text" class="form-control" name="residual" id="residual" value="<?php if(isset($pat["removableresidual"])) echo $pat["removableresidual"];  ?>">
      </div>
    </div>
    <hr>

    <div class="" align="center">
      <b>ASPECTO FACIAL Y ZONAS PRÓXIMAS</b>
    </div>
    <br>
    <div class="row">

      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="faces">Cara:</label>
        <select name="faces" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalfaces"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'simetrico') echo "selected"; ?> value="simetrico">Simétrico</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'asimetrico') echo "selected"; ?> value="asimetrico">Asimétrico</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'triangular') echo "selected"; ?> value="triangular">Triangular</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'ovoide') echo "selected"; ?> value="ovoide">Ovoide</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'cuadrangular') echo "selected"; ?> value="cuadrangular">Cuadrangular</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="tez">Tez:</label>
        <select name="tez" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["dentaltez"]) || $pat["dentaltez"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["dentaltez"]) && $pat["dentaltez"] == 'morena') echo "selected"; ?> value="morena">Morena</option>
          <option <?php if(isset($pat["dentaltez"]) && $pat["dentaltez"] == 'triguena') echo "selected"; ?> value="triguena">Triguena</option>
          <option <?php if(isset($pat["dentaltez"]) && $pat["dentaltez"] == 'blanca') echo "selected"; ?> value="blanca">Blanca</option>
          <option <?php if(isset($pat["dentaltez"]) && $pat["dentaltez"] == 'negra') echo "selected"; ?> value="negra">Negra</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="profile">Perfil del mentón</label>
        <select name="profile" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalprofile"] == 'recto') echo "selected"; ?> value="recto">Recto</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'concavo') echo "selected"; ?> value="concavo">Cóncavo</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'convexo') echo "selected"; ?> value="convexo">Cónvexo</option>
        </select>
      </div>
    </div>
    <hr>
    <div class="" align="center">
      <b>ANÁLISIS DE LOS MODELOS PARA DIAGNOSTICO</b>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <span>EN EL ARTICULADOR</span>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="interocclusal">¿Existe espacio adecuado entre los rebordes para la prótesis proyectada?</label>
        <div class="col-5">
          <select name="interocclusal" class="form-select" aria-label="Default select example">
            <option <?php if(!isset($pat["removableinterocclusal"]) || $pat["removableinterocclusal"] == '') echo "selected"; ?> value="">--</option>
            <option <?php if(isset($pat["removableinterocclusal"]) && $pat["removableinterocclusal"] == 'si') echo "selected"; ?> value="si">Si</option>
            <option <?php if(isset($pat["removableinterocclusal"]) && $pat["removableinterocclusal"] == 'no') echo "selected"; ?> value="no">No</option>
          </select>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="residual">¿Existe espacio interoclusal adecuado para los descansos de apoyo y los apouos proyectados, donde sean necesarios?</label>
        <div class="col-5">
          <select name="prosthesis" class="form-select" aria-label="Default select example">
            <option <?php if(!isset($pat["removableprosthesis"]) || $pat["removableprosthesis"] == '') echo "selected"; ?> value="">--</option>
            <option <?php if(isset($pat["removableprosthesis"]) && $pat["removableprosthesis"] == 'si') echo "selected"; ?> value="si">Si</option>
            <option <?php if(isset($pat["removableprosthesis"]) && $pat["removableprosthesis"] == 'no') echo "selected"; ?> value="no">No</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="row">
          <label for="planeocclusal">¿El plano oclusal es recuperable?</label>
          <div class="col-6">

            <select name="planeocclusal" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat["removableplaneocclusal"]) || $pat["removableplaneocclusal"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat["removableplaneocclusal"]) && $pat["removableplaneocclusal"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat["removableplaneocclusal"]) && $pat["removableplaneocclusal"] == 'dudoso') echo "selected"; ?> value="dudoso">Dudoso</option>
            </select>
          </div>
        </div>

      </div>
      <div class="col-lg-8 col-md-8 col-sm-12 col-12">
        <div class="row">
          <label for="">¿Existen anomalias que no fueron observables en boca?</label>
          <div class="col-4">
            <select name="anomaliesoption" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat["anomaliesoption"]) || $pat["anomaliesoption"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat["anomaliesoption"]) && $pat["anomaliesoption"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat["anomaliesoption"]) && $pat["anomaliesoption"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-8 col-8">
            <input type="text" class="form-control" name="anomaliesobs" id="anomaliesobs" value="<?php if(isset($pat["anomaliesobs"])) echo $pat["anomaliesobs"];  ?>" placeholder="Escribir Observación">
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <span>EN EL PARALELIZADOR:</span>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <label for="">¿Que dientes serian los pilares más adecuados?</label>
        <div class="row">
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="parpilar1">Pilar 1:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="parpilar1" id="parpilar1" value="<?php if(isset($pat["parpilar1"])) echo $pat["parpilar1"];  ?>">
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="parpilar2">Pilar 2:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="parpilar2" id="parpilar2" value="<?php if(isset($pat["parpilar2"])) echo $pat["parpilar2"];  ?>">
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="parpilar3">Pilar 3:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="parpilar3" id="parpilar3" value="<?php if(isset($pat["parpilar3"])) echo $pat["parpilar3"];  ?>">
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="parpilar4">Pilar 4:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="parpilar4" id="parpilar4" value="<?php if(isset($pat["parpilar4"])) echo $pat["parpilar4"];  ?>">
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="parotros">Otros:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="parotros" id="parotros" value="<?php if(isset($pat["parotros"])) echo $pat["parotros"];  ?>">
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-12 col-12">
        <label for="">¿Los pilares tiene áreas retentivas adecuades en ubicación favorable?</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="parfavorable" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["parfavorable"]) || $pat["parfavorable"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["parfavorable"]) && $pat["parfavorable"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat["parfavorable"]) && $pat["parfavorable"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-12 col-12">
        <label for="">¿Pueden formarse planos de guia apropiados sobre los probables pilares?</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="parprobables" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["parprobables"]) || $pat["parprobables"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["parprobables"]) && $pat["parprobables"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat["parprobables"]) && $pat["parprobables"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <label for="">¿Se requerirán alteraciones dentales?</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="paralteraciones" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["paralteraciones"]) || $pat["paralteraciones"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["paralteraciones"]) && $pat["paralteraciones"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat["paralteraciones"]) && $pat["paralteraciones"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
          <input type="text" class="form-control" name="parobs" id="parobs" value="<?php if(isset($pat["parobs"])) echo $pat["parobs"];  ?>" placeholder="Escribir Observación">
      </div>
    </div>
    <hr>
    <div class="" align="center">
      <b>INTERPRETACIÓN RADIOGRÁFICA</b>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <label for="">¿Cómo es la relación coronoradicular de cada pilar?</label>
        <div class="row">
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="radpilar1">Pilar 1:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="radpilar1" id="radpilar1" value="<?php if(isset($pat["radpilar1"])) echo $pat["radpilar1"];  ?>">
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="radpilar2">Pilar 2:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="radpilar2" id="radpilar2" value="<?php if(isset($pat["radpilar2"])) echo $pat["radpilar2"];  ?>">
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="radpilar3">Pilar 3:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="radpilar3" id="radpilar3" value="<?php if(isset($pat["radpilar3"])) echo $pat["radpilar3"];  ?>">
          </div>
          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
            <label for="radpilar4">Pilar 4:</label>
          </div>
          <div class="col-lg-1 col-md-1 col-sm-4 col-4">
            <input type="text" class="form-control" name="radpilar4" id="radpilar4" value="<?php if(isset($pat["radpilar4"])) echo $pat["radpilar4"];  ?>">
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-5 col-lg-5 col-md-5 col-sm-12 col-12">
        <label for="">¿El hueso de soporte parece ser de buena calidad?</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="radhueso" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["radhueso"]) || $pat["radhueso"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["radhueso"]) && $pat["radhueso"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat["radhueso"]) && $pat["radhueso"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
    </div>
    <br>




  <!--</div>-->
</div>
<hr>
<div class="border rounded border-primary px-3">
  <div class="row">
    <div class="col-4">
      <br>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
        Tabla de Procedimiento
      </button>
      <!-- Inicio modal-->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Tabla de Procedimiento</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-3">
                  <label for="">Valor de trabajo Bs.</label>
                  <input type="text" class="form-control" name="valortrabajo" id="valortrabajo" value="<?php if(isset($pat["valortrabajo"])) echo $pat["valortrabajo"];  ?>">

                </div>
                <div class="col-9">
                  <label for="">Trabajos:</label>
                  <input type="text" class="form-control" name="trabajo" id="trabajo" value="<?php if(isset($pat["trabajo"])) echo $pat["trabajo"];  ?>">
                </div>
              </div>
              <br>
              <table width="100%" class="table table-bordered">
                <thead>
                  <tr align="center">
                    <th>PROCEDIMIENTO</th>
                    <th>Vo. Bo. Laboratorio</th>
                    <th>Vo. Bo Clínica</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Impresión diagnóstica</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro1']))||(isset($pat['remopro1'])&&($pat['remopro1']=='false'||$pat['remopro1']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro1\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro1\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro1'])&&$pat['remopro1']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro1\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro1\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro1'])&&$pat['selremopro1']&&isset($pat['tearemopro1'])&&is_numeric($pat['tearemopro1'])) {
                          echo "<span class=\"text-primary\" id=\"remopro1\"> <b>".strtoupper($pat['selremopro1'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro1\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro1\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro2']))||(isset($pat['remopro2'])&&($pat['remopro2']=='false'||$pat['remopro2']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro2\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro2\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro2'])&&$pat['remopro2']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro2\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro2\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro2'])&&$pat['selremopro2']&&isset($pat['tearemopro2'])&&is_numeric($pat['tearemopro2'])) {
                          echo "<span class=\"text-primary\" id=\"remopro2\"> <b>".strtoupper($pat['selremopro2'])."</b></span>";
                        }elseif (isset($pat['selremopro2'])&&$pat['selremopro2']==''&&isset($pat['tearemopro2'])&&is_numeric($pat['tearemopro2'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro2\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro2\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro2\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro2\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Cubeta individuales</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro3']))||(isset($pat['remopro3'])&&($pat['remopro3']=='false'||$pat['remopro3']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro3\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro3\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro3'])&&$pat['remopro3']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro3\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro3\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro3'])&&$pat['selremopro3']&&isset($pat['tearemopro3'])&&is_numeric($pat['tearemopro3'])) {
                          echo "<span class=\"text-primary\" id=\"remopro3\"> <b>".strtoupper($pat['selremopro3'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro3\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro3\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro4']))||(isset($pat['remopro4'])&&($pat['remopro4']=='false'||$pat['remopro4']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro4\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro4\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro4'])&&$pat['remopro4']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro4\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro4\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro4'])&&$pat['selremopro4']&&isset($pat['tearemopro4'])&&is_numeric($pat['tearemopro4'])) {
                          echo "<span class=\"text-primary\" id=\"remopro4\"> <b>".strtoupper($pat['selremopro4'])."</b></span>";
                        }elseif (isset($pat['selremopro4'])&&$pat['selremopro4']==''&&isset($pat['tearemopro4'])&&is_numeric($pat['tearemopro4'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro4\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro4\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro4\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro4\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Impresión definitiva superior</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro5']))||(isset($pat['remopro5'])&&($pat['remopro5']=='false'||$pat['remopro5']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro5\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro5\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro5'])&&$pat['remopro5']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro5\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro5\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro5'])&&$pat['selremopro5']&&isset($pat['tearemopro5'])&&is_numeric($pat['tearemopro5'])) {
                          echo "<span class=\"text-primary\" id=\"remopro5\"> <b>".strtoupper($pat['selremopro5'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro5\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro5\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro6']))||(isset($pat['remopro6'])&&($pat['remopro6']=='false'||$pat['remopro6']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro6\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro6\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro6'])&&$pat['remopro6']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro6\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro6\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro6'])&&$pat['selremopro6']&&isset($pat['tearemopro6'])&&is_numeric($pat['tearemopro6'])) {
                          echo "<span class=\"text-primary\" id=\"remopro6\"> <b>".strtoupper($pat['selremopro6'])."</b></span>";
                        }elseif (isset($pat['selremopro6'])&&$pat['selremopro6']==''&&isset($pat['tearemopro6'])&&is_numeric($pat['tearemopro6'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro6\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro6\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro6\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro6\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Impresión definitiva inferior</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro7']))||(isset($pat['remopro7'])&&($pat['remopro7']=='false'||$pat['remopro7']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro7\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro7\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro7'])&&$pat['remopro7']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro7\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro7\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro7'])&&$pat['selremopro7']&&isset($pat['tearemopro7'])&&is_numeric($pat['tearemopro7'])) {
                          echo "<span class=\"text-primary\" id=\"remopro7\"> <b>".strtoupper($pat['selremopro7'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro7\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro7\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro8']))||(isset($pat['remopro8'])&&($pat['remopro8']=='false'||$pat['remopro8']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro8\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro8\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro8'])&&$pat['remopro8']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro8\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro8\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro8'])&&$pat['selremopro8']&&isset($pat['tearemopro8'])&&is_numeric($pat['tearemopro8'])) {
                          echo "<span class=\"text-primary\" id=\"remopro8\"> <b>".strtoupper($pat['selremopro8'])."</b></span>";
                        }elseif (isset($pat['selremopro8'])&&$pat['selremopro8']==''&&isset($pat['tearemopro8'])&&is_numeric($pat['tearemopro8'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro8\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro8\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro8\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro8\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Modelos de Trabajo</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro9']))||(isset($pat['remopro9'])&&($pat['remopro9']=='false'||$pat['remopro9']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro9\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro9\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro9'])&&$pat['remopro9']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro9\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro9\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro9'])&&$pat['selremopro9']&&isset($pat['tearemopro9'])&&is_numeric($pat['tearemopro9'])) {
                          echo "<span class=\"text-primary\" id=\"remopro9\"> <b>".strtoupper($pat['selremopro9'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro9\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro9\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro10']))||(isset($pat['remopro10'])&&($pat['remopro10']=='false'||$pat['remopro10']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro10\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro10\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro10'])&&$pat['remopro10']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro10\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro10\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro10'])&&$pat['selremopro10']&&isset($pat['tearemopro10'])&&is_numeric($pat['tearemopro10'])) {
                          echo "<span class=\"text-primary\" id=\"remopro10\"> <b>".strtoupper($pat['selremopro10'])."</b></span>";
                        }elseif (isset($pat['selremopro10'])&&$pat['selremopro10']==''&&isset($pat['tearemopro10'])&&is_numeric($pat['tearemopro10'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro10\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro10\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro10\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro10\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Placas de acticulación</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro11']))||(isset($pat['remopro11'])&&($pat['remopro11']=='false'||$pat['remopro11']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro11\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro11\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro11'])&&$pat['remopro11']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro11\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro11\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro11'])&&$pat['selremopro11']&&isset($pat['tearemopro11'])&&is_numeric($pat['tearemopro11'])) {
                          echo "<span class=\"text-primary\" id=\"remopro11\"> <b>".strtoupper($pat['selremopro11'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro11\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro11\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro12']))||(isset($pat['remopro12'])&&($pat['remopro12']=='false'||$pat['remopro12']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro12\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro12\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro12'])&&$pat['remopro12']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro12\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro12\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro12'])&&$pat['selremopro12']&&isset($pat['tearemopro12'])&&is_numeric($pat['tearemopro12'])) {
                          echo "<span class=\"text-primary\" id=\"remopro12\"> <b>".strtoupper($pat['selremopro12'])."</b></span>";
                        }elseif (isset($pat['selremopro12'])&&$pat['selremopro12']==''&&isset($pat['tearemopro12'])&&is_numeric($pat['tearemopro12'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro12\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro12\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro12\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro12\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Relación maxilomandibular</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro13']))||(isset($pat['remopro13'])&&($pat['remopro13']=='false'||$pat['remopro13']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro13\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro13\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro13'])&&$pat['remopro13']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro13\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro13\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro13'])&&$pat['selremopro13']&&isset($pat['tearemopro13'])&&is_numeric($pat['tearemopro13'])) {
                          echo "<span class=\"text-primary\" id=\"remopro13\"> <b>".strtoupper($pat['selremopro13'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro13\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro13\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro14']))||(isset($pat['remopro14'])&&($pat['remopro14']=='false'||$pat['remopro14']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro14\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro14\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro14'])&&$pat['remopro14']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro14\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro14\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro14'])&&$pat['selremopro14']&&isset($pat['tearemopro14'])&&is_numeric($pat['tearemopro14'])) {
                          echo "<span class=\"text-primary\" id=\"remopro14\"> <b>".strtoupper($pat['selremopro14'])."</b></span>";
                        }elseif (isset($pat['selremopro14'])&&$pat['selremopro14']==''&&isset($pat['tearemopro14'])&&is_numeric($pat['tearemopro14'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro14\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro14\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro14\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro14\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Enfilado y encerado</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro15']))||(isset($pat['remopro15'])&&($pat['remopro15']=='false'||$pat['remopro15']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro15\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro15\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro15'])&&$pat['remopro15']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro15\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro15\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro15'])&&$pat['selremopro15']&&isset($pat['tearemopro15'])&&is_numeric($pat['tearemopro15'])) {
                          echo "<span class=\"text-primary\" id=\"remopro15\"> <b>".strtoupper($pat['selremopro15'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro15\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro15\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro16']))||(isset($pat['remopro16'])&&($pat['remopro16']=='false'||$pat['remopro16']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro16\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro16\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro16'])&&$pat['remopro16']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro16\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro16\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro16'])&&$pat['selremopro16']&&isset($pat['tearemopro16'])&&is_numeric($pat['tearemopro16'])) {
                          echo "<span class=\"text-primary\" id=\"remopro16\"> <b>".strtoupper($pat['selremopro16'])."</b></span>";
                        }elseif (isset($pat['selremopro16'])&&$pat['selremopro16']==''&&isset($pat['tearemopro16'])&&is_numeric($pat['tearemopro16'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro16\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro16\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro16\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro16\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Prueba en boca</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro17']))||(isset($pat['remopro17'])&&($pat['remopro17']=='false'||$pat['remopro17']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro17\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro17\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro17'])&&$pat['remopro17']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro17\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro17\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro17'])&&$pat['selremopro17']&&isset($pat['tearemopro17'])&&is_numeric($pat['tearemopro17'])) {
                          echo "<span class=\"text-primary\" id=\"remopro17\"> <b>".strtoupper($pat['selremopro17'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro17\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro17\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro18']))||(isset($pat['remopro18'])&&($pat['remopro18']=='false'||$pat['remopro18']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro18\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro18\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro18'])&&$pat['remopro18']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro18\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro18\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro18'])&&$pat['selremopro18']&&isset($pat['tearemopro18'])&&is_numeric($pat['tearemopro18'])) {
                          echo "<span class=\"text-primary\" id=\"remopro18\"> <b>".strtoupper($pat['selremopro18'])."</b></span>";
                        }elseif (isset($pat['selremopro18'])&&$pat['selremopro18']==''&&isset($pat['tearemopro18'])&&is_numeric($pat['tearemopro18'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro18\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro18\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro18\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro18\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Acrilizado y pulido</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro19']))||(isset($pat['remopro19'])&&($pat['remopro19']=='false'||$pat['remopro19']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro19\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro19\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro19'])&&$pat['remopro19']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro19\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro19\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro19'])&&$pat['selremopro19']&&isset($pat['tearemopro19'])&&is_numeric($pat['tearemopro19'])) {
                          echo "<span class=\"text-primary\" id=\"remopro19\"> <b>".strtoupper($pat['selremopro19'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro19\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro19\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro20']))||(isset($pat['remopro20'])&&($pat['remopro20']=='false'||$pat['remopro20']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro20\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro20\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro20'])&&$pat['remopro20']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro20\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro20\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro20'])&&$pat['selremopro20']&&isset($pat['tearemopro20'])&&is_numeric($pat['tearemopro20'])) {
                          echo "<span class=\"text-primary\" id=\"remopro20\"> <b>".strtoupper($pat['selremopro20'])."</b></span>";
                        }elseif (isset($pat['selremopro20'])&&$pat['selremopro20']==''&&isset($pat['tearemopro20'])&&is_numeric($pat['tearemopro20'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro20\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro20\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro20\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro20\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Instalación inicial</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro21']))||(isset($pat['remopro21'])&&($pat['remopro21']=='false'||$pat['remopro21']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro21\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro21\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro21'])&&$pat['remopro21']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro21\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro21\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro21'])&&$pat['selremopro21']&&isset($pat['tearemopro21'])&&is_numeric($pat['tearemopro21'])) {
                          echo "<span class=\"text-primary\" id=\"remopro21\"> <b>".strtoupper($pat['selremopro21'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro21\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro21\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro22']))||(isset($pat['remopro22'])&&($pat['remopro22']=='false'||$pat['remopro22']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro22\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro22\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro22'])&&$pat['remopro22']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro22\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro22\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro22'])&&$pat['selremopro22']&&isset($pat['tearemopro22'])&&is_numeric($pat['tearemopro22'])) {
                          echo "<span class=\"text-primary\" id=\"remopro22\"> <b>".strtoupper($pat['selremopro22'])."</b></span>";
                        }elseif (isset($pat['selremopro22'])&&$pat['selremopro22']==''&&isset($pat['tearemopro22'])&&is_numeric($pat['tearemopro22'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro22\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro22\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro22\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro22\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td>Controles mediatos</td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro23']))||(isset($pat['remopro23'])&&($pat['remopro23']=='false'||$pat['remopro23']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro23\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro23\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro23'])&&$pat['remopro23']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro23\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro23\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro23'])&&$pat['selremopro23']&&isset($pat['tearemopro23'])&&is_numeric($pat['tearemopro23'])) {
                          echo "<span class=\"text-primary\" id=\"remopro23\"> <b>".strtoupper($pat['selremopro23'])."</b></span>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro23\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro23\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border py-2 pr-2">
                        <?php
                        if ((!isset($pat['remopro24']))||(isset($pat['remopro24'])&&($pat['remopro24']=='false'||$pat['remopro24']==''))) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro24\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro24\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['remopro24'])&&$pat['remopro24']=='true') {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro24\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro24\">solicitar Vo.Bo.</label>";
                        }elseif (isset($pat['selremopro24'])&&$pat['selremopro24']&&isset($pat['tearemopro24'])&&is_numeric($pat['tearemopro24'])) {
                          echo "<span class=\"text-primary\" id=\"remopro24\"> <b>".strtoupper($pat['selremopro24'])."</b></span>";
                        }elseif (isset($pat['selremopro24'])&&$pat['selremopro24']==''&&isset($pat['tearemopro24'])&&is_numeric($pat['tearemopro24'])) {
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro24\" value=\"option1\" checked>".
                          "<label class=\"form-check-label\" for=\"remopro24\">solicitar Vo.Bo.</label>";
                        }else{
                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"remopro24\" value=\"option1\">".
                          "<label class=\"form-check-label\" for=\"remopro24\">solicitar Vo.Bo.</label>";
                        }
                        ?>
                      </div>
                    </td>
                  </tr>

                </tbody>
              </table>
              <br>
              <div class="row">
                <div class="col-12">
                  <label for="">Observaciones: </label><br>
                  <span id="obstrabajo" class="text-danger"><?php if(isset($pat["obstrabajo"])) echo $pat["obstrabajo"];  ?></span>
                </div>
                <div class="col-6">
                  <label for="">Nota final:</label><br>
                  <span id="notatrabajo" class="text-primary"><?php if(isset($pat["notatrabajo"])) echo $pat["notatrabajo"];  ?></span>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline border py-2 pr-2">
                    <?php
                    if ((!isset($pat['firmtrabajo']))||(isset($pat['firmtrabajo'])&&($pat['firmtrabajo']=='false'||$pat['firmtrabajo']==''))) {
                      echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"firmtrabajo\" value=\"option1\">".
                      "<label class=\"form-check-label\" for=\"firmtrabajo\">solicitar</label>";
                    }elseif (isset($pat['firmtrabajo'])&&$pat['firmtrabajo']=='true') {
                      echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"firmtrabajo\" value=\"option1\" checked>".
                      "<label class=\"form-check-label\" for=\"firmtrabajo\">solicitar</label>";
                    }elseif (isset($pat['firmtrabajo'])&&is_numeric($pat['firmtrabajo'])) {
                      echo "<span class=\"text-primary\" id=\"firmtrabajo\"> Firmado</span>";
                    }else{
                      echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"firmtrabajo\" value=\"option1\">".
                      "<label class=\"form-check-label\" for=\"firmtrabajo\">solicitar</label>";
                    }
                    ?>
                    <br><span>Firma del Docente</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <?php
              if((isset($pat['removablestatus'])&&$pat['removablestatus']!='fail'&&
               $pat['removablestatus']!='canceled'&&$pat['removablestatus']!='end') || !isset($pat['observationaccepted'])){
                echo "<button type=\"button\" class=\"btn btn-success\" id=\"btn_procedimiento\">Guardar</button>";
              }
              ?>

            </div>
          </div>
        </div>
      </div>
      <!--modal de datos fin-->
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-12" align="center">
      <b>PLAN DE TRATAMIENTO</b>
    </div>
  </div>

  <!--INICIO PARA GRAFICO-->

  <div class="row">
    <div class="col-12">
      <!--script para cargar al inicio-->
      <?php
      $srcgram='../images/protesis_nueva.png';
      if(isset($pat['removableodontogram'])&& $pat['removableodontogram']!=''){
        $srcgram=$pat['removableodontogram'];
      }
      ?>
      <script language="javascript">

      function cargaContextoCanvas(idCanvas){
         var elemento = document.getElementById(idCanvas);
         if(elemento && elemento.getContext){
            var contexto = elemento.getContext('2d');
            if(contexto){
               return contexto;
            }
         }
         return FALSE;
      }
      window.onload = function(){
         //Recibimos el elemento canvas
         var ctx = cargaContextoCanvas('canvas');
         if(ctx){
            //Creo una imagen conun objeto Image de Javascript
            var img = new Image();
            //indico la URL de la imagen

            img.src = `<?php echo $srcgram; ?>`;//'../images/ortodonciagram.png';//o desde db
            //defino el evento onload del objeto imagen
            img.onload = function(){
               //incluyo la imagen en el canvas
               ctx.drawImage(img, 0, 0);//10 10
            }
         }
      }

      </script>
      <!--grafico inicio-->
      <div  class="row border border-warning mx-1">
        <div class="col-lg-2 col-md-2 col-sm-4 col-6">
          <div class="form-check" id="azul">
            <input class="form-check-input" title="Metal colado" type="radio" name="options" id="options1" onchange="ChangeColor();" checked>
            <label class="form-check-label" for="options1">
              <span class="text-primary" title="Metal colado"><b>Azul</b></span>
            </label>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-6" >
          <div class="form-check" id="rojo">
            <input class="form-check-input" title="Base de resina y alambre labrado" type="radio" name="options" id="options2" onchange="ChangeColor();">
            <label class="form-check-label" for="options2">
              <span class="text-danger" title="Base de resina y alambre labrado"><b>Rojo</b></span>
            </label>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-6">
          <div class="form-check" id="verde">
            <input class="form-check-input" title="Áreas a contornear" type="radio" name="options" id="options3" onchange="ChangeColor();">
            <label class="form-check-label" for="options3">
              <span class="text-success" title="Áreas a contornear"><b>Verde</b></span>
            </label>
          </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-4 col-6">
          <div class="form-check" id="negro">
            <input class="form-check-input" title="Dientes artificiales" type="radio" name="options" id="options4" onchange="ChangeColor();">
            <label class="form-check-label" title="Dientes artificiales" for="options4">
              <span><b>Negro</b></span>
            </label>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-6">
          <div class="row">
            <div class="col-9">
              <input type="range" class="form-range" id="dinamicrange" value="20" onchange="dinamicrange();">
            </div>
            <div class="col-3">
              <label for="dinamicrange" class="form-label"><span id="dinamicrangetext">20</span></label>
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <!-- creamos el camvas -->
          <canvas id='canvas' width="400" height="533" style='border: 1px solid #CCC;'>
              <p>Tu navegador no soporta canvas</p>
          </canvas>
          <!-- creamos el form para el envio -->
          <form id='formCanvas' method='post' action='#' ENCTYPE='multipart/form-data'>
              <button type='button' onclick='LimpiarTrazado()'>Borrar</button>
              <!--<button type='button' onclick='GuardarTrazado()'>Guardar</button>-->
              <?php
              if(((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') &&
               (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&
               isset($pat['removablestatus'])&&$pat['removablestatus']!='fail'&&
               $pat['removablestatus']!='canceled') || !isset($pat['observationaccepted'])){
                echo "<button type=\"button\" name=\"gram_button\" id=\"gram_button\">Guardar</button>";
              }
              ?>
              <button type='button' onclick='DescargarTrazado()'>Descargar</button>
              <input type='hidden' name='imagen' id='imagen' />
              <input type="file" id="seleccionArchivos" accept="image/*">
          </form>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <span>ESPECIFICACIONES DEL PLAN</span><br>
          <label for="apoyos">1. APOYOS</label>
          <input type="text" class="form-control" name="apoyos" id="apoyos" value="<?php if(isset($pat["apoyos"])) echo $pat["apoyos"]; ?>">
          <label for="retencion">2. RETENCIÓN</label>
          <input type="text" class="form-control" name="retencion" id="retencion" value="<?php if(isset($pat["retencion"])) echo $pat["retencion"]; ?>">
          <label for="reciprocidad">3. RECIPROCIDAD</label>
          <input type="text" class="form-control" name="reciprocidad" id="reciprocidad" value="<?php if(isset($pat["reciprocidad"])) echo $pat["reciprocidad"]; ?>">

          <label for="conector">4. CONECTOR MAYOR</label>
          <select name="conector" id="conector" class="form-select" aria-label="Default select example">
            <option <?php if(!isset($pat['conector']) || $pat["conector"] == '') echo "selected"; ?> value="">--</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'barra_lingual') echo "selected"; ?> value="barra_lingual">Barra Lingual</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'placa_lingual') echo "selected"; ?> value="placa_lingual">Placa Lingual</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'barra_sublingual') echo "selected"; ?> value="barra_sublingual">Barra Sublingual</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'placa_palatina') echo "selected"; ?> value="placa_palatina">Placa Palatina</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'barra_palatina') echo "selected"; ?> value="barra_palatina">Barra Palatina</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'en_herradura') echo "selected"; ?> value="en_herradura">En Herradura</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'placa_palatina_mixta') echo "selected"; ?> value="placa_palatina_mixta">Placa Palatina Mixta</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'banda_palatina') echo "selected"; ?> value="banda_palatina">Banda Palatina</option>
            <option <?php if(isset($pat['conector']) && $pat["conector"] == 'doble_banda') echo "selected"; ?> value="doble_banda">Doble Banda</option>
          </select>
          <label for="indirecta">5. RETENCIÓN INDIRECTA</label>
          <input type="text" class="form-control" name="indirecta" id="indirecta" value="<?php if(isset($pat["indirecta"])) echo $pat["indirecta"]; ?>">
          <label for="planos">6. PLANOS GUÍA</label>
          <input type="text" class="form-control" name="planos" id="planos" value="<?php if(isset($pat["planos"])) echo $pat["planos"]; ?>">
          <label for="base">7. RETENCIÓN PARA LA BASE</label>
          <select name="base" id="base" class="form-select" aria-label="Default select example">
            <option <?php if(!isset($pat['base']) || $pat["base"] == '') echo "selected"; ?> value="">--</option>
            <option <?php if(isset($pat['base']) && $pat["base"] == 'base1') echo "selected"; ?> value="base1">A malla c....</option>
            <option <?php if(isset($pat['base']) && $pat["base"] == 'base2') echo "selected"; ?> value="base2">Cabeza de cloro</option>
            <option <?php if(isset($pat['base']) && $pat["base"] == 'base3') echo "selected"; ?> value="base3">Rejilla</option>
          </select>
          <label for="contornear">8. ÁREA DE MODIFICAR O CONTORNEAR</label>
          <input type="text" class="form-control" name="contornear" id="contornear" value="<?php if(isset($pat["contornear"])) echo $pat["contornear"]; ?>">

        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="form-check form-check-inline border py-2 pr-2">
            <?php
            if ((!isset($pat['protesis']))||(isset($pat['protesis'])&&($pat['protesis']=='false'||$pat['protesis']==''))) {
              echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"protesis\" value=\"option1\">".
              "<label class=\"form-check-label\" for=\"protesis\">solicitar aprobación para realizar la prótesis</label>";
            }elseif (isset($pat['protesis'])&&$pat['protesis']=='true') {
              echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"protesis\" value=\"option1\" checked>".
              "<label class=\"form-check-label\" for=\"protesis\">solicitar aprobación para realizar la prótesis</label>";
            }elseif (isset($pat['protesis'])&&is_numeric($pat['protesis'])) {
              $docent=DBUserInfo($pat['protesis']);
              $docent=$docent['userfullname'];
              echo "<span class=\"text-primary\" id=\"protesis\"> Aprobación para la realizar prótesis: por Dr(a). $docent </span>";
            }else{
              echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"protesis\" value=\"option1\">".
              "<label class=\"form-check-label\" for=\"protesis\">solicitar aprobación para realizar la prótesis</label>";
            }
            ?>
          </div>
          <span>Fecha.:
          <?php
          if(isset($pat['protesisfecha'])){
            echo $pat['protesisfecha'];
          }
          ?>
          </span>
        </div>
      </div>

      <!--grafico fin-->
      <!--script en la final-->
      <script type="text/javascript">

          /* Variables de Configuracion */
          var idCanvas='canvas';
          var idForm='formCanvas';
          var inputImagen='imagen';
          var estiloDelCursor='crosshair';
          var colorDelTrazo='#0000FF';//555
          var colorDeFondo='#fff';
          var grosorDelTrazo=4;

          /* Variables necesarias */
          var contexto=null;
          var valX=0;
          var valY=0;
          var flag=false;
          var imagen=document.getElementById(inputImagen);
          var anchoCanvas=document.getElementById(idCanvas).offsetWidth;
          var altoCanvas=document.getElementById(idCanvas).offsetHeight;
          var pizarraCanvas=document.getElementById(idCanvas);

          var type=true;
          /* Esperamos el evento load */
          window.addEventListener('load',IniciarDibujo,false);

          function dinamicrange () {
             var valor=document.getElementById('dinamicrange').value;
             document.getElementById('dinamicrangetext').innerText=valor;
             valor=Number(valor)/5;
             //alert(valor);
             grosorDelTrazo=valor;
             contexto=pizarraCanvas.getContext('2d');
             contexto.lineWidth=grosorDelTrazo;
          }

          function ChangeColor(){
            let opcion1 = document.querySelector('#options1');
            let opcion2 = document.querySelector('#options2');
            let opcion3 = document.querySelector('#options3');
            let opcion4 = document.querySelector('#options4');
            if (opcion1.checked){
              colorDelTrazo='#0000FF';
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
            }else if(opcion2.checked){
              colorDelTrazo='#ff0000';//555 0000FF
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
              type=true;
              //estiloDelCursor='default';//'crosshair';
              //pizarraCanvas.style.cursor=estiloDelCursor;
            }else if(opcion3.checked){//#008000
              colorDelTrazo='#008000';
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
            }else if(opcion4.checked){
              colorDelTrazo='#000000';
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
            }

            //selectElement = document.querySelector('[name=options]');
            //error corrigir para mañana y terminar.....
            //selectElement = document.getElementsByName('option');
            //alert(selectElement);
            /*if(selectElement==1){
              colorDelTrazo='#ff0000';//555 0000FF
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
              type=true;
              estiloDelCursor='default';//'crosshair';
              pizarraCanvas.style.cursor=estiloDelCursor;
              //
              //IniciarDibujo();
            }
            if(selectElement==2){
              colorDelTrazo='#0000FF';
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
              estiloDelCursor='default';
              pizarraCanvas.style.cursor=estiloDelCursor;
              type=true;
            }
            if(selectElement==3){
              colorDelTrazo='#00ff0080';
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
              estiloDelCursor='default';
              pizarraCanvas.style.cursor=estiloDelCursor;
              type=false;

            }*/
            //alert(selectElement);
          }

          function IniciarDibujo(){

            /* Creamos la pizarra */
            pizarraCanvas.style.cursor=estiloDelCursor;
            contexto=pizarraCanvas.getContext('2d');
            contexto.fillStyle=colorDeFondo;
            contexto.fillRect(0,0,anchoCanvas,altoCanvas);
            contexto.strokeStyle=colorDelTrazo;
            contexto.lineWidth=grosorDelTrazo;
            contexto.lineJoin='round';
            contexto.lineCap='round';
            /* Capturamos los diferentes eventos */
            pizarraCanvas.addEventListener('mousedown',MouseDown,false);// Click pc
            pizarraCanvas.addEventListener('mouseup',MouseUp,false);// fin click pc
            pizarraCanvas.addEventListener('mousemove',MouseMove,false);// arrastrar pc

            pizarraCanvas.addEventListener('touchstart',TouchStart,false);// tocar pantalla tactil
            pizarraCanvas.addEventListener('touchmove',TouchMove,false);// arrastras pantalla tactil
            pizarraCanvas.addEventListener('touchend',TouchEnd,false);// fin tocar pantalla dentro de la pizarra
            pizarraCanvas.addEventListener('touchleave',TouchEnd,false);// fin tocar pantalla fuera de la pizarra
          }

          function MouseDown(e){
            flag=true;
            contexto.beginPath();
            valX=e.pageX-posicionX(pizarraCanvas); valY=e.pageY-posicionY(pizarraCanvas);
            contexto.moveTo(valX,valY);
          }

          function MouseUp(e){
            contexto.closePath();
            flag=false;

          }

          function MouseMove(e){
            if(flag){
              if(type){
                contexto.beginPath();
                contexto.moveTo(valX,valY);
                valX=e.pageX-posicionX(pizarraCanvas); valY=e.pageY-posicionY(pizarraCanvas);

                contexto.lineTo(valX,valY);
                contexto.closePath();
                contexto.stroke();
              }else{
                contexto.moveTo(valX,valY);
                valX=e.pageX-posicionX(pizarraCanvas); valY=e.pageY-posicionY(pizarraCanvas);

                contexto.clearRect(valX, valY, 2, 2)
              }

            }
          }

          function TouchMove(e){
            e.preventDefault();
            if (e.targetTouches.length == 1) {
              var touch = e.targetTouches[0];
              MouseMove(touch);
            }
          }

          function TouchStart(e){
            if (e.targetTouches.length == 1) {
              var touch = e.targetTouches[0];
              MouseDown(touch);
            }
          }

          function TouchEnd(e){
            if (e.targetTouches.length == 1) {
              var touch = e.targetTouches[0];
              MouseUp(touch);
            }
          }

          function posicionY(obj) {
            var valor = obj.offsetTop;
            if (obj.offsetParent) valor += posicionY(obj.offsetParent);
            return valor;
          }

          function posicionX(obj) {
            var valor = obj.offsetLeft;
            if (obj.offsetParent) valor += posicionX(obj.offsetParent);
            return valor;
          }

          /* Limpiar pizarra */
          function LimpiarTrazado(){
            contexto=document.getElementById(idCanvas).getContext('2d');

            contexto.fillStyle=colorDeFondo;
            //para imagen
            var ctx = cargaContextoCanvas('canvas');
            if(ctx){
               //Creo una imagen conun objeto Image de Javascript
               var img = new Image();
               //indico la URL de la imagen
               img.src = '../images/protesis_nueva.png';
               //defino el evento onload del objeto imagen
               img.onload = function(){
                  //incluyo la imagen en el canvas
                  ctx.drawImage(img, 10, 10);
               }
            }

            contexto.fillRect(0,0,anchoCanvas,altoCanvas);

          }
          function DescargarTrazado(){
            var source = document.getElementById(idCanvas).toDataURL('image/png');//var source = '../images/archivo.png';
            var a = document.createElement('a');
            a.download = 'grafico';//true;
            a.target = '_blank';
            a.href= source;
            a.click();
          }
          /* Enviar el trazado */
          function GuardarTrazado(){
            imagen.value=document.getElementById(idCanvas).toDataURL('image/png');
            document.forms[idForm].submit();

          }
          // Obtener referencia al input y a la imagen
          const $seleccionArchivos = document.querySelector("#seleccionArchivos");
          // Escuchar cuando cambie
          $seleccionArchivos.addEventListener("change", () => {
            // Los archivos seleccionados, pueden ser muchos o uno
            const archivos = $seleccionArchivos.files;
            // Si no hay archivos salimos de la función y quitamos la imagen
            if (!archivos || !archivos.length) {
              return;
            }
            // Ahora tomamos el primer archivo, el cual vamos a previsualizar
            const primerArchivo = archivos[0];
            // Lo convertimos a un objeto de tipo objectURL
            const objectURL = URL.createObjectURL(primerArchivo);
            // Y a la fuente de la imagen le ponemos el objectURL
            contexto=document.getElementById(idCanvas).getContext('2d');
            contexto.fillStyle=colorDeFondo;
            //para imagen
            var ctx = cargaContextoCanvas('canvas');
            if(ctx){
               //Creo una imagen conun objeto Image de Javascript
               var img = new Image();
               //indico la URL de la imagen
               img.src = objectURL;//'../images/ortodonciagram.png';
               //defino el evento onload del objeto imagen
               img.onload = function(){
                  //incluyo la imagen en el canvas
                  ctx.drawImage(img, 10, 10);
               }
            }
            contexto.fillRect(0,0,anchoCanvas,altoCanvas);
          });
      </script>
      <?php
      // comprovamos si se envió la imagen
      if (isset($_POST['imagen'])) {

          // mostrar la imagen
          echo '<img src="'.$_POST['imagen'].'" border="1">';

          // funcion para gusrfdar la imagen base64 en el servidor
          // el nombre debe tener la extension
          function uploadImgBase64 ($base64, $name){
              // decodificamos el base64
              $datosBase64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
              // definimos la ruta donde se guardara en el server
              $path= $_SERVER['DOCUMENT_ROOT'].'/src/images/'.$name;
              // guardamos la imagen en el server
              if(!file_put_contents($path, $datosBase64)){
                  // retorno si falla
                  return false;
              }
              else{
                  // retorno si todo fue bien
                  return true;
              }
          }

          // llamamos a la funcion uploadImgBase64( img_base64, nombre_fina.png)
          uploadImgBase64($_POST['imagen'], 'mi_imagen_'.date('d_m_Y_H_i_s').'.png' );

      }
      ?>


    </div>
  </div>

  <!--FIN PARA GRAFICO-->








</div>
<hr>
<div class="border rounded border-primary px-3">

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
    <div class="col-12 border border-success rounded">
      <br>

      <button type="button" class="btn btn-warning" data-toggle="modal"data-target="#subfile" name="file_button">Subir Trabajo Concluido en .pdf</button>
      <span> <i>Nota. Debe subir el documento culminado.</i>  </span>
      <!--<input type="file" class="form-control" id="endfile" name="endfile" size="40" onclick="Arquivo()">-->
      <br>
      <br>
    </div>
    <!--MODAL INICIO-->
    <div class="modal fade" role="dialog" id="subfile">
      <div class="modal-dialog">
          <div class="modal-content">

        <form name="form_submit" id="form_submit" enctype="multipart/form-data" method="post">
            <div class="modal-header">

                 <h3 class="modal-title" id="tituloes">Documento Culminado</h3>

                 <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
            </div>

              <div class="modal-body">

                  <input type="hidden"  name="idfile" id="idfile" value="<?php echo $_GET['id']; ?>">
                  <br>
                  <br>
                  <div class="from-group">
                    <label for="probleminput">Subir Ficha Clínica Culminado en .pdf</label>
                    <input type="file" name="finalinput" accept=".pdf" id="finalinput" class="form-control" value="">
                  </div>
                  <br>
                  <div class="from-group">
                      <?php
                      if ($pat["removableinputfile"] != null) {
                            $tx = $pat["removableinputfilehash"];
                            echo "  <a href=\"../filedownload.php?" . filedownload($pat["removableinputfile"] ,$pat["removableinputfilename"]) ."\">" .
                                  $pat["removableinputfilename"] . "</a> <a href=\"#\" class=\"btn btn-primary btn-sm\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".filedownload($pat["removableinputfile"], $pat["removableinputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\">Ver Ficha Clínica</a>" .
                                 //"<img title=\"hash: $tx\" alt=\"$tx\" width=\"25\" src=\"../images/bigballoontransp-hash.png\" />" .
                                   "\n";
                       }
                       else
                            echo "  <span class=\"text-warning\">Aun no subiste el documento culminado</span>\n";
                      ?>

                  </div>
                  <br>

              </div>

                <div class="modal-footer">

                    <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel">Cancel</button>
                    <?php
                    if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && isset($pat['removablestatus'])&&$pat['removablestatus']!='fail'&&$pat['removablestatus']!='canceled'){
                      echo "<button type=\"button\" class=\"btn btn-success\" id=\"Submit3\" name=\"Submit3\">Enviar</button>";
                    }

                    ?>


                </div>
              </form>
          </div>

      </div>
  </div>
    <!--MODAL FIN-->
  </div>
  <br>
  <div class="row">
    <?php

    if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['removablestatus'])&&$pat['removablestatus']!='fail'&&$pat['removablestatus']!='canceled'){
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
  $('#gram_button').click(function(){
    GuardarImg();
  });
 //guardar grafico
 function GuardarImg(sw=true){
     //imagen.value=document.getElementById(idCanvas).toDataURL('image/png');
     //document.forms[idForm].submit();
     var ficha=$('#ficha').val();
     var imggram=document.getElementById(idCanvas).toDataURL('image/png');

     $.ajax({

        url:"../include/i_prosthodontics.php",
        method:"POST",
        data: {ficha:ficha, imggram:imggram},

        success:function(data)
        {
          if(data=='yes'){
            if(sw==true){
              alert('Se guardó el grafico de ficha clinica');
            }
          }else{
            alert(data);
            console.log(data);
          }
        }
     });
   }

      //cancel cancel_button
     $('#cancel_button').click(function(){
        location.reload();
     });

     //funcion para registrar los datos de la ficha clinica de odontopediatria I
     function registerpatient(){

      var ficha=$('#ficha').val();
      var patientid = $('#patientid').val();

      var hereditary=$('#hereditary').val();
      var personal=$('#personal').val();
      var psychological=$('select[name=psychological]').val();
      var toothless=$('#toothless').val();
      //var kenedy=$('select[name=kenedy]').val();
      var kenedysc=$('select[name=kenedysc]').val();
      var kenedysm=$('select[name=kenedysm]').val();
      var kenedyic=$('select[name=kenedyic]').val();
      var kenedyim=$('select[name=kenedyim]').val();
      var diagnosticobucal=$('select[name=diagnosticobucal]').val();
      var diagnosticodeque=$('#diagnosticodeque').val();
      var diagnosticoduracion=$('#diagnosticoduracion').val();
      var diagnosticoresultado=$('#diagnosticoresultado').val();
      var diagnosticoproblema=$('#diagnosticoproblema').val();
      var diagnosticodiente=$('select[name=diagnosticodiente]').val();
      var hygiene=$('select[name=hygiene]').val();
      var cavities=$('select[name=cavities]').val();
      var central=$('select[name=central]').val();
      var bracesoption=$('select[name=bracesoption]').val();
      var bracesobs=$('#bracesobs').val();
      var salivaoption=$('select[name=salivaoption]').val();
      var salivaobs=$('#salivaobs').val();
      var milohoideadesc=$('#milohoideadesc').val();
      var milohoideaobs=$('#milohoideaobs').val();
      var alveolaresdesc=$('#alveolaresdesc').val();
      var alveolaresobs=$('#alveolaresobs').val();
      var tuberosidaddesc=$('#tuberosidaddesc').val();
      var tuberosidadobs=$('#tuberosidadobs').val();
      var alveolardesc=$('#alveolardesc').val();
      var alveolarobs=$('#alveolarobs').val();
      var palateoption=$('select[name=palateoption]').val();
      var palateobs=$('#palateobs').val();
      var residual=$('#residual').val();
      var faces=$('select[name=faces]').val();
      var tez=$('select[name=tez]').val();
      var profile=$('select[name=profile]').val();
      var prosthesis=$('select[name=prosthesis]').val();
      var interocclusal=$('select[name=interocclusal]').val();
      var planeocclusal=$('select[name=planeocclusal]').val();
      var anomaliesoption=$('select[name=anomaliesoption]').val();
      var anomaliesobs=$('#anomaliesobs').val();
      var parpilar1=$('#parpilar1').val();
      var parpilar2=$('#parpilar2').val();
      var parpilar3=$('#parpilar3').val();
      var parpilar4=$('#parpilar4').val();
      var parotros=$('#parotros').val();
      var parfavorable=$('select[name=parfavorable]').val();
      var parprobables=$('select[name=parprobables]').val();
      var paralteraciones=$('select[name=paralteraciones]').val();
      var parobs=$('#parobs').val();
      var radpilar1=$('#radpilar1').val();
      var radpilar2=$('#radpilar2').val();
      var radpilar3=$('#radpilar3').val();
      var radpilar4=$('#radpilar4').val();
      var radhueso=$('select[name=radhueso]').val();
      //especificaciones
      var apoyos=$('#apoyos').val();
      var retencion=$('#retencion').val();
      var reciprocidad=$('#reciprocidad').val();
      var conector=$('select[name=conector]').val();
      var indirecta=$('#indirecta').val();
      var planos=$('#planos').val();
      var base=$('select[name=base]').val();
      var contornear=$('#contornear').val();

      var protesis = $('#protesis').prop('checked');

           $.ajax({

              url:"../include/i_prosthodontics.php",
              method:"POST",
              data: {ficha:ficha, patientid:patientid,
                hereditary:hereditary, personal:personal, psychological:psychological, toothless:toothless,
                kenedysc:kenedysc, kenedysm:kenedysm, kenedyic:kenedyic, kenedyim:kenedyim, diagnosticobucal:diagnosticobucal, diagnosticodeque:diagnosticodeque,
                diagnosticoduracion:diagnosticoduracion, diagnosticoresultado:diagnosticoresultado,
                diagnosticoproblema:diagnosticoproblema, diagnosticodiente:diagnosticodiente, hygiene:hygiene,
                cavities:cavities, central:central, bracesoption:bracesoption, bracesobs:bracesobs,
                salivaoption:salivaoption, salivaobs:salivaobs, milohoideadesc:milohoideadesc,
                milohoideaobs:milohoideaobs, alveolaresdesc:alveolaresdesc, alveolaresobs:alveolaresobs,
                tuberosidaddesc:tuberosidaddesc, tuberosidadobs:tuberosidadobs, alveolardesc:alveolardesc,
                alveolarobs:alveolarobs, palateoption:palateoption, palateobs:palateobs, residual:residual,
                faces:faces, tez:tez, profile:profile, prosthesis:prosthesis, interocclusal:interocclusal,
                planeocclusal:planeocclusal, anomaliesoption:anomaliesoption, anomaliesobs:anomaliesobs,
                parpilar1:parpilar1, parpilar2:parpilar2, parpilar3:parpilar3, parpilar4:parpilar4, parotros:parotros,
                parfavorable:parfavorable, parprobables:parprobables, paralteraciones:paralteraciones, parobs:parobs,
                radpilar1:radpilar1, radpilar2:radpilar2, radpilar3:radpilar3, radpilar4:radpilar4, radhueso:radhueso,
                apoyos:apoyos, retencion:retencion, reciprocidad:reciprocidad, conector:conector,
                indirecta:indirecta, planos:planos, base:base, contornear:contornear, protesis:protesis},
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

     //
     $('#patientregister_button').click(function(){
       //if (confirm("Enviar los datos de ficha clinica?")) {
         registerpatient();
         GuardarImg(false);
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
     //registrar documentos
     $('#btn_procedimiento').click(function(){
       var ficha=$('#ficha').val();
       var valortrabajo=$('#valortrabajo').val();
       var trabajo=$('#trabajo').val();

       var remopro1 = $('#remopro1').prop('checked');
       var remopro2 = $('#remopro2').prop('checked');
       var remopro3 = $('#remopro3').prop('checked');
       var remopro4 = $('#remopro4').prop('checked');
       var remopro5 = $('#remopro5').prop('checked');
       var remopro6 = $('#remopro6').prop('checked');
       var remopro7 = $('#remopro7').prop('checked');
       var remopro8 = $('#remopro8').prop('checked');
       var remopro9 = $('#remopro9').prop('checked');
       var remopro10 = $('#remopro10').prop('checked');
       var remopro11 = $('#remopro11').prop('checked');
       var remopro12 = $('#remopro12').prop('checked');
       var remopro13 = $('#remopro13').prop('checked');
       var remopro14 = $('#remopro14').prop('checked');
       var remopro15 = $('#remopro15').prop('checked');
       var remopro16 = $('#remopro16').prop('checked');
       var remopro17 = $('#remopro17').prop('checked');
       var remopro18 = $('#remopro18').prop('checked');
       var remopro19 = $('#remopro19').prop('checked');
       var remopro20 = $('#remopro20').prop('checked');
       var remopro21 = $('#remopro21').prop('checked');
       var remopro22 = $('#remopro22').prop('checked');
       var remopro23 = $('#remopro23').prop('checked');
       var remopro24 = $('#remopro24').prop('checked');

       var firmtrabajo = $('#firmtrabajo').prop('checked');
       if(confirm('Quieres guardar los cambios en tabla de procedimientos?')){
         $.ajax({
              url:"../include/i_prosthodontics.php",
              method:"POST",
              data: {ficha:ficha, valortrabajo:valortrabajo, trabajo:trabajo, remopro1:remopro1,
       remopro2:remopro2,
       remopro3:remopro3, remopro4:remopro4, remopro5:remopro5, remopro6:remopro6, remopro7:remopro7,
       remopro8:remopro8,remopro9:remopro9,
       remopro10:remopro10, remopro11:remopro11, remopro12:remopro12, remopro13:remopro13,
       remopro14:remopro14, remopro15:remopro15, remopro16:remopro16, remopro17:remopro17,
       remopro18:remopro18, remopro19:remopro19, remopro20:remopro20, remopro21:remopro21,
       remopro22:remopro22, remopro23:remopro23, remopro24:remopro24,
       firmtrabajo:firmtrabajo},
              success:function(data){

                if(data=='yes'){
                  alert('Se guardó los cambios');
                  $('#exampleModalCenter').hide();///.......
                  if ($('.modal-backdrop').is(':visible')) {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                  };
                }else{
                    alert(data);
                }

              }
         });
       }
     });
     //para subir documento culminado
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
    				  url:"../include/i_prosthodontics.php",
    				  type:"POST",
    				  contentType: false,
    				  processData: false,
    				  success:function(data)
    				  {
    					  if(data == "Yes"){
    						  alert(".:YES:.");
    						  $('#subproblem').hide();
    						  location.reload();
    					  }else {
    					  	   if(data == "No"){
    							   alert("Error al subir");
    							   $('#subproblem').hide();
    							   location.reload();
    						   }else {
    						   	   alert(data);
    							   $('#subproblem').hide();
    							   location.reload();
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


});

</script>
