<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBSurgeryiiInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=13)
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

                        <h2 align="center" class="mt-4">Ficha Clinica Cirugia Bucal III</h2>
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['surgeryiistatus'])&&$pat['surgeryiistatus']!='fail'){
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['surgeryiistatus'])&&$pat['surgeryiistatus']=='fail'){
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

<div class="border rounded border-primary">
  <div class="px-3">
    <br>
    <div class="row">
      <div class="col-12">
        <b>A. DATOS CIVILES</b>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-5 col-md-5 col-sm-12 col-12">
        <label for="">APELLIDOS Y NOMBRE:&nbsp;&nbsp;&nbsp;&nbsp; <span><?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?></span> </label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <label for="patientage">EDAD:&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <label for="patientgender">SEXO:&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
          if(!isset($pat) || $pat["patientgender"] == '--') echo "indefinido";
          if(isset($pat) && $pat["patientgender"] == 'masculino') echo "Masculino";
          if(isset($pat) && $pat["patientgender"] == 'femenino') echo "Femenino";
          ?>
        </label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-4 col-4">
        <label for="">ESTADO CIVIL:&nbsp;&nbsp;&nbsp;&nbsp; <span><?php  if(isset($pat["patientcivilstatus"])) echo $pat['patientcivilstatus'];?></span> </label>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientdirection">DOMICILIO:&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"]; ?></label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientoccupation">OCUPACIÓN:&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientoccupation"])) echo $pat["patientoccupation"]; ?></label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientprovenance">PROCEDENCIA:&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"]; ?></label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientphone">FONO.:&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientphone"])&&$pat['patientphone']!=0) echo $pat["patientphone"]; ?></label>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <span>PRACTICA N.:&nbsp;&nbsp;&nbsp;&nbsp;</span>
        <input type="text" class="form-control d-inline" style="width:50%;"  name="practice" id="practice" value="<?php if(isset($pat["surgeryiipractice"])) echo $pat["surgeryiipractice"];  ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <?php
        $msg="SUPERVISADO POR DOCENTE:&nbsp;&nbsp;&nbsp;&nbsp;";
        if($pat['teacher']!=0){
          $teacherinfo=DBUserInfo($pat['teacher']);
          $msg.=$teacherinfo['userfullname'];
        }
        echo $msg;
        ?>
      </div>
      <div class="col-lg-8 col-md-8 col-sm-12 col-12">
        <?php
        $userinfo=DBUserInfo($pat['student']);
        ?>
        <label for="">RECEPCIONADO POR UNIV.:&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["userfullname"])) echo $pat["userfullname"];  ?></label>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-12">
        <b>B. <u>ANAMNESIS</u></b>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        B1. ANAMNESIS PRÓXIMA PERSONAL
      </div>
    </div>
    <div class="row">
        <div class="col-12">
          <label for="">MOTIVO DE LA CONSULTA</label>
          <input type="text" class="form-control" name="motconsult" id="motconsult" value="<?php if(isset($pat["surgeryiimotconsult"])&&$pat['surgeryiimotconsult']){echo $pat["surgeryiimotconsult"];}else{if(isset($pat["motconsult"])&&$pat['motconsult']){echo $pat['motconsult'];}}?>">
        </div>
        <div class="col-12">
          <label for="">HISTORIA DEL MOTIVO DE LA CONSULTA</label>
          <textarea class="form-control" name="historiaconsulta" id="historiaconsulta" rows="4"><?php if(isset($pat["historiaconsulta"])) echo $pat["historiaconsulta"];  ?></textarea>
          <label for="">ANAMNESIS FAMILIAR</label>
          <input type="text" class="form-control" name="anamnesisfamiliar" id="anamnesisfamiliar" value="<?php if(isset($pat["anamnesisfamiliar"])&&$pat['anamnesisfamiliar']) echo $pat["anamnesisfamiliar"]; ?>">
        </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        B2. ANAMNESIS REMOTA PERSONAL
      </div>
    </div>
    <div class="row">
      <script type="text/javascript">
        function remota(s){
          var b = document.querySelector("#obs"+s);
          var selection = document.getElementById(s);
          var value=selection.options[selection.selectedIndex].value;
          if(value=='si'){
            b.setAttribute("type", "text");
          }else{
            b.setAttribute("type", "hidden");
          }
        }
      </script>
      <label for="">Selecione todas las preguntas en Si o No y rellene los campos de texto en caso de ser Si.</label>
      <div class="col-4">
        <label for="">1.- ¿Está siendo atendido por un médico?</label>
        <br>
        <select name="remota1" id="remota1" class="form-select" onchange="remota('remota1')" aria-label="Default select example">
          <option <?php if(!isset($pat['remota1']) || $pat["remota1"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota1']) && $pat["remota1"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota1']) && $pat["remota1"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
        <br>
        <input type="hidden" class="form-control" name="obsremota1" id="obsremota1" placeholder="¿de qué está siendo tratado?" value="<?php if(isset($pat["obsremota1"])&&$pat['obsremota1']) echo $pat["obsremota1"]; ?>">
      </div>
      <div class="col-4">
        <label for="">2.- ¿Ha estado hospitalizado en los últimos cinco años?</label>
        <select name="remota2" id="remota2" class="form-select" onchange="remota('remota2')" aria-label="Default select example">
          <option <?php if(!isset($pat['remota2']) || $pat["remota2"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota2']) && $pat["remota2"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota2']) && $pat["remota2"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
        <br>
        <input type="hidden" class="form-control" name="obsremota2" id="obsremota2" placeholder="¿Cuál es la enfermedad o el tipo de intervención?" value="<?php if(isset($pat["obsremota2"])&&$pat['obsremota2']) echo $pat["obsremota2"]; ?>">

      </div>
      <div class="col-4">
        <label for="">3.- ¿Ha estado hospitalizado en los últimos cinco años?</label>
        <select name="remota3" id="remota3" class="form-select" onchange="remota('remota3')" aria-label="Default select example">
          <option <?php if(!isset($pat['remota3']) || $pat["remota3"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota3']) && $pat["remota3"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota3']) && $pat["remota3"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
        <br>
        <input type="hidden" class="form-control" name="obsremota3" id="obsremota3" placeholder="¿Cuál fue el motivo?" value="<?php if(isset($pat["obsremota3"])&&$pat['obsremota3']) echo $pat["obsremota3"]; ?>">
        <script type="text/javascript">
          remota('remota1');
          remota('remota2');
          remota('remota3');
        </script>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        4.- ¿Ud. padece o ha padecido alguna de las siguientes enfermedades?
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <label for="">a.- Fiebre reumática o enfermedad cardiaca reumática.</label>
        <select name="remota4a" id="remota4a" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4a']) || $pat["remota4a"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4a']) && $pat["remota4a"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4a']) && $pat["remota4a"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-8">
        <label for="">b.- Enfermedades cardiovasculares (problemas cardiacos, infarto al corazón, angina de pecho, ictus, hipertensión arterial, soplo cardiaco, oclusión coronaria, ateroesclerosis)</label>

        <div class="row">
          <div class="col-6">
            <label for="">¿siente presión o dolor en el pecho al hacer ejercicios?</label>
            <select name="remota4b1" id="remota4b1" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota4b1']) || $pat["remota4b1"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota4b1']) && $pat["remota4b1"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota4b1']) && $pat["remota4b1"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-6">
            <label for="">¿alguna vez le falta el aire al hacer un ejercicio leve?</label>
            <select name="remota4b2" id="remota4b2" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota4b2']) || $pat["remota4b2"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota4b2']) && $pat["remota4b2"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota4b2']) && $pat["remota4b2"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-6">
            <label for="">¿se le hinchan los tobillos?</label>
            <select name="remota4b3" id="remota4b3" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota4b3']) || $pat["remota4b3"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota4b3']) && $pat["remota4b3"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota4b3']) && $pat["remota4b3"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-6">
            <label for="">¿se queda sin aliento cuando se acuesta o precisa varias almohadas para dormir?</label>
            <select name="remota4b4" id="remota4b4" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota4b4']) || $pat["remota4b4"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota4b4']) && $pat["remota4b4"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota4b4']) && $pat["remota4b4"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-6">
            <label for="">¿le han dicho alguna vez que tiene soplo cardíaco?</label>
            <select name="remota4b5" id="remota4b5" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota4b5']) || $pat["remota4b5"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota4b5']) && $pat["remota4b5"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota4b5']) && $pat["remota4b5"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-4">
        <label for="">c.- Asma o fiebre del heno</label>
        <select name="remota4c" id="remota4c" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4c']) || $pat["remota4c"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4c']) && $pat["remota4c"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4c']) && $pat["remota4c"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">d.- Eczema o reacción cutánea</label>
        <select name="remota4d" id="remota4d" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4d']) || $pat["remota4d"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4d']) && $pat["remota4d"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4d']) && $pat["remota4d"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">e.- Desmayos o convulsiones</label>
        <select name="remota4e" id="remota4e" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4e']) || $pat["remota4e"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4e']) && $pat["remota4e"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4e']) && $pat["remota4e"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">f.- Diabetes</label>
        <div class="row">
          <div class="col-12">
            <label for="">¿tiene que orinar más de 6 veces al día?</label>
            <select name="remota4f1" id="remota4f1" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota4f1']) || $pat["remota4f1"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota4f1']) && $pat["remota4f1"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota4f1']) && $pat["remota4f1"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-12">
            <label for="">¿tiene sed casi siempre?</label>
            <select name="remota4f2" id="remota4f2" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota4f2']) || $pat["remota4f2"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota4f2']) && $pat["remota4f2"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota4f2']) && $pat["remota4f2"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-12">
            <label for="">¿siente seca la boca con frecuencia?</label>
            <select name="remota4f3" id="remota4f3" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota4f3']) || $pat["remota4f3"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota4f3']) && $pat["remota4f3"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota4f3']) && $pat["remota4f3"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-4">
        <label for="">g.- Hepatitis, ictericia o enfermedad hepática</label>
        <select name="remota4g" id="remota4g" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4g']) || $pat["remota4g"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4g']) && $pat["remota4g"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4g']) && $pat["remota4g"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">h.- Artritis u otras enfermedades articulares</label>
        <select name="remota4h" id="remota4h" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4h']) || $pat["remota4h"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4h']) && $pat["remota4h"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4h']) && $pat["remota4h"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">i.- Úlcera de estómago</label>
        <select name="remota4i" id="remota4i" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4i']) || $pat["remota4i"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4i']) && $pat["remota4i"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4i']) && $pat["remota4i"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">j.- Problemas renales</label>
        <select name="remota4j" id="remota4j" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4j']) || $pat["remota4j"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4j']) && $pat["remota4j"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4j']) && $pat["remota4j"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">k.- Tuberculosis</label>
        <select name="remota4k" id="remota4k" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4k']) || $pat["remota4k"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4k']) && $pat["remota4k"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4k']) && $pat["remota4k"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">l.- Covid 19</label>
        <select name="remota4l" id="remota4l" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4l']) || $pat["remota4l"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4l']) && $pat["remota4l"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4l']) && $pat["remota4l"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">m.- Enfermedad venérea</label>
        <select name="remota4m" id="remota4m" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4m']) || $pat["remota4m"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4m']) && $pat["remota4m"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4m']) && $pat["remota4m"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">n.- Otras</label>
        <select name="remota4n" id="remota4n" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota4n']) || $pat["remota4n"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota4n']) && $pat["remota4n"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota4n']) && $pat["remota4n"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <label for="">5.-¿Ha tenido sangrado anormal en relación con extracciones dentarias, operaciones o traumas?</label>
        <div class="row">
          <div class="col-4">
            <select name="remota51" id="remota51" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota51']) || $pat["remota51"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota51']) && $pat["remota51"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota51']) && $pat["remota51"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-4">
        <label for="">¿Se le forman moretones con facilidad?</label>
        <select name="remota52" id="remota52" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota52']) || $pat["remota52"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota52']) && $pat["remota52"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota52']) && $pat["remota52"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">¿Ha recibido trasfuciones de sangre?</label>
        <select name="remota53" id="remota53" class="form-select" onchange="remota('remota53')" aria-label="Default select example">
          <option <?php if(!isset($pat['remota53']) || $pat["remota53"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota53']) && $pat["remota53"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota53']) && $pat["remota53"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
        <br>
        <input type="hidden" class="form-control" name="obsremota53" id="obsremota53" placeholder="¿explique las circunstancias?" value="<?php if(isset($pat["obsremota53"])&&$pat['obsremota53']) echo $pat["obsremota53"]; ?>">
        <script type="text/javascript">
          remota('remota53');
        </script>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-4">
        <label for="">6.- ¿Tiene alguna enfermedad sanguínea como anemia, trasfornos de la coagulación u otras?</label>
        <select name="remota6" id="remota6" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota6']) || $pat["remota6"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota6']) && $pat["remota6"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota6']) && $pat["remota6"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-4">
        <label for="">7.- ¿Ha precisado cirugía o tratamiento con radioterapia por un tumor, cáncer u otra patología de cabeza y cuello?</label>
        <select name="remota7" id="remota7" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota7']) || $pat["remota7"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota7']) && $pat["remota7"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota7']) && $pat["remota7"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>

    </div>
    <div class="row">
      <div class="col-12">
        <label for="">8.- ¿Está tomando alguno de los siguientes medicamentos?</label>
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Antibióticos</label>
            <select name="remota81" id="remota81" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota81']) || $pat["remota81"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota81']) && $pat["remota81"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota81']) && $pat["remota81"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Anticoagulantes</label>
            <select name="remota82" id="remota82" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota82']) || $pat["remota82"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota82']) && $pat["remota82"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota82']) && $pat["remota82"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Fármacos parar controlar la presión arterial</label>
            <select name="remota83" id="remota83" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota83']) || $pat["remota83"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota83']) && $pat["remota83"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota83']) && $pat["remota83"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Antidiabéticos</label>
            <select name="remota84" id="remota84" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota84']) || $pat["remota84"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota84']) && $pat["remota84"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota84']) && $pat["remota84"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Tranquilizantes</label>
            <select name="remota85" id="remota85" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota85']) || $pat["remota85"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota85']) && $pat["remota85"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota85']) && $pat["remota85"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Cortisona</label>
            <select name="remota86" id="remota86" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota86']) || $pat["remota86"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota86']) && $pat["remota86"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota86']) && $pat["remota86"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Hormonas</label>
            <select name="remota87" id="remota87" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota87']) || $pat["remota87"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota87']) && $pat["remota87"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota87']) && $pat["remota87"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Aspirina</label>
            <select name="remota88" id="remota88" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota88']) || $pat["remota88"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota88']) && $pat["remota88"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota88']) && $pat["remota88"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Fármacos para controlar el corazón</label>
            <select name="remota89" id="remota89" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota89']) || $pat["remota89"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota89']) && $pat["remota89"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota89']) && $pat["remota89"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Fármacos para la osteoporosis</label>
            <select name="remota810" id="remota810" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota810']) || $pat["remota810"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota810']) && $pat["remota810"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota810']) && $pat["remota810"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Anticonceptivos orales</label>
            <select name="remota811" id="remota811" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota811']) || $pat["remota811"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota811']) && $pat["remota811"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota811']) && $pat["remota811"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for="">Otros (incluye medicación tradicional)</label>
            <select name="remota812" id="remota812" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota812']) || $pat["remota812"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota812']) && $pat["remota812"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota812']) && $pat["remota812"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-4">
        <label for="">9.- ¿Tiene alergia a algún medicamento?</label>
        <select name="remota9" id="remota9" class="form-select" onchange="remota('remota9')" aria-label="Default select example">
          <option <?php if(!isset($pat['remota9']) || $pat["remota9"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota9']) && $pat["remota9"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota9']) && $pat["remota9"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
        <br>
        <input type="hidden" class="form-control" name="obsremota9" id="obsremota9" placeholder="Indique el nombre del medicamento" value="<?php if(isset($pat["obsremota9"])&&$pat['obsremota9']) echo $pat["obsremota9"]; ?>">
        <script type="text/javascript">
          remota('remota9');
        </script>
      </div>
      <div class="col-4">
        <label for="">10.- ¿Tuvo alguna reacción por la administración de anestésicos locales?</label>
        <select name="remota10" id="remota10" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat['remota10']) || $pat["remota10"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota10']) && $pat["remota10"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota10']) && $pat["remota10"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <?php
      if(isset($pat['patientgender'])&&$pat['patientgender']=='femenino'){
      ?>
      <div class="col-4">
        <label for="">11.- ¿En caso de ser mujer?</label>
        <div class="row">
          <div class="col-12">
            <label for="">¿Está embarazada o ha tenido un retraso reciente en su periodo menstrual?</label>
            <select name="remota111" id="remota111" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota111']) || $pat["remota111"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota111']) && $pat["remota111"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota111']) && $pat["remota111"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
          <div class="col-12">
            <label for="">¿Está dando de lactar?</label>
            <select name="remota112" id="remota112" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat['remota112']) || $pat["remota112"] == '') echo "selected"; ?> value="">--</option>
              <option <?php if(isset($pat['remota112']) && $pat["remota112"] == 'si') echo "selected"; ?> value="si">Si</option>
              <option <?php if(isset($pat['remota112']) && $pat["remota112"] == 'no') echo "selected"; ?> value="no">No</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-4">
        <label for="">12.- ¿Padece alguna enfermedad que cree que deba saber?</label>
        <select name="remota12" id="remota12" class="form-select" onchange="remota('remota12')" aria-label="Default select example">
          <option <?php if(!isset($pat['remota12']) || $pat["remota12"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota12']) && $pat["remota12"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota12']) && $pat["remota12"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
        <br>
        <input type="hidden" class="form-control" name="obsremota12" id="obsremota12" placeholder="Incluye enfermedades confidenciales" value="<?php if(isset($pat["obsremota12"])&&$pat['obsremota12']) echo $pat["obsremota12"]; ?>">

      </div>
    <?php }else{ ?>
      <div class="col-4">
        <label for="">11.- ¿Padece alguna enfermedad que cree que deba saber?</label>
        <select name="remota12" id="remota12" class="form-select" onchange="remota('remota12')" aria-label="Default select example">
          <option <?php if(!isset($pat['remota12']) || $pat["remota12"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['remota12']) && $pat["remota12"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['remota12']) && $pat["remota12"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
        <br>
        <input type="hidden" class="form-control" name="obsremota12" id="obsremota12" placeholder="Incluya enfermedades confidenciales" value="<?php if(isset($pat["obsremota12"])&&$pat['obsremota12']) echo $pat["obsremota12"]; ?>">
      </div>
    <?php } ?>
    </div>
    <!--row-->
    <script type="text/javascript">
      remota('remota12');
    </script>
    <br>
  </div>
</div>
<hr>
<div class="border border-primary rounded px-3">
  <div class="row">
    <div class="col-12">
      <u>C.- HISTORIA ODONTOLÓGICA</u>
    </div>
  </div>
  <div class="row">
    <div class="col-4">
      <label for="">1.- ¿Visita regularmente a su dentista?</label>
      <select name="historia1" id="historia1" class="form-select" onchange="remota('historia1')" aria-label="Default select example">
        <option <?php if(!isset($pat['historia1']) || $pat["historia1"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['historia1']) && $pat["historia1"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['historia1']) && $pat["historia1"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>
      <br>
      <input type="hidden" class="form-control" name="obshistoria1" id="obshistoria1" placeholder="¿Cuándo fue la última vez?" value="<?php if(isset($pat["obshistoria1"])&&$pat['obshistoria1']) echo $pat["obshistoria1"]; ?>">
      <script type="text/javascript">
        remota('historia1');
      </script>
    </div>
    <div class="col-4">
      <label for="">2.- ¿Cuántas veces al día se cepilla los dientes?</label>
      <select name="historia2" id="historia2" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['historia2']) || $pat["historia2"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['historia2']) && $pat["historia2"] == '1') echo "selected"; ?> value="1">1 vez</option>
        <option <?php if(isset($pat['historia2']) && $pat["historia2"] == '2') echo "selected"; ?> value="2">2 veces</option>
        <option <?php if(isset($pat['historia2']) && $pat["historia2"] == '3') echo "selected"; ?> value="3">3 veces</option>
        <option <?php if(isset($pat['historia2']) && $pat["historia2"] == '4') echo "selected"; ?> value="4">4 veces</option>
      </select>
    </div>
    <div class="col-4">
      <label for="">3.- ¿Siente dolor cuando mastica?</label>
      <select name="historia3" id="historia3" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['historia3']) || $pat["historia3"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['historia3']) && $pat["historia3"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['historia3']) && $pat["historia3"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>
    </div>
    <div class="col-4">
      <label for="">4.- ¿Siente la encía irritada o adolorida?</label>
      <select name="historia4" id="historia4" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['historia4']) || $pat["historia4"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['historia4']) && $pat["historia4"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['historia4']) && $pat["historia4"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>
    </div>
    <div class="col-4">
      <label for="">5.- ¿Ya ha sido sometido a tratamiento quirúrgico en la boca?</label>
      <select name="historia5" id="historia5" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['historia5']) || $pat["historia5"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['historia5']) && $pat["historia5"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['historia5']) && $pat["historia5"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>
    </div>
    <div class="col-4">
      <label for="">6.- ¿Tiene dificultad de abrir la boca excesivamente?</label>
      <select name="historia6" id="historia6" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['historia6']) || $pat["historia6"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['historia6']) && $pat["historia6"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['historia6']) && $pat["historia6"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>
    </div>
    <div class="col-4">
      <label for="">7.- ¿Relación de oclusión de primeros molares:?</label>
      <select name="historia7" id="historia7" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['historia7']) || $pat["historia7"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['historia7']) && $pat["historia7"] == 'normooclusion') echo "selected"; ?> value="normooclusion">normooclusión</option>
        <option <?php if(isset($pat['historia7']) && $pat["historia7"] == 'mesiooclusion') echo "selected"; ?> value="mesiooclusion">mesiooclusión</option>
        <option <?php if(isset($pat['historia7']) && $pat["historia7"] == 'distooclusion') echo "selected"; ?> value="distooclusion">distooclusión</option>
      </select>
    </div>
    <div class="col-4">
      <label for="">8.- ¿Tuvo alguna mala experiencia durante o después de una atención odontológica?</label>
      <select name="historia8" id="historia8" class="form-select" onchange="remota('historia8')" aria-label="Default select example">
        <option <?php if(!isset($pat['historia8']) || $pat["historia8"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['historia8']) && $pat["historia8"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['historia8']) && $pat["historia8"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>
      <br>
      <input type="hidden" class="form-control" name="obshistoria8" id="obshistoria8" placeholder="Explíquelo" value="<?php if(isset($pat["obshistoria8"])&&$pat['obshistoria8']) echo $pat["obshistoria8"]; ?>">
      <script type="text/javascript">
        remota('historia8');
      </script>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-12">
      <u>D.- EXAMEN FÍSICO</u>
    </div>
  </div>
  <div class="row">
    <label for="">SIGNOS VITALES</label>
    <label for="">D.1.- GENERAL</label>
    <div class="col-12">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
          <label for="">-Presíon Arterial:</label>
          <input type="text" class="form-control" name="arterial" id="arterial" value="<?php if(isset($pat["arterial"])) echo $pat["arterial"]; ?>">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
          <label for="">-Frecuencia Cardiaca:</label>
          <input type="text" class="form-control" name="cardiaca" id="cardiaca" value="<?php if(isset($pat["cardiaca"])) echo $pat["cardiaca"]; ?>">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
          <label for="">-Frecuencia respiratoria:</label>
          <input type="text" class="form-control" name="respiratoria" id="respiratoria" value="<?php if(isset($pat["respiratoria"])) echo $pat["respiratoria"]; ?>">
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">TÓRAX</label>
      <input type="text" class="form-control" name="torax" id="torax" value="<?php if(isset($pat["torax"])) echo $pat["torax"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">ABDOMEN</label>
      <input type="text" class="form-control" name="abdomen" id="abdomen" value="<?php if(isset($pat["abdomen"])) echo $pat["abdomen"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">EXTREMIDADES</label>
      <input type="text" class="form-control" name="extremidades" id="extremidades" value="<?php if(isset($pat["extremidades"])) echo $pat["extremidades"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">PIEL Y FANERAS</label>
      <input type="text" class="form-control" name="faneras" id="faneras" value="<?php if(isset($pat["faneras"])) echo $pat["faneras"]; ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">EXAMEN NEUROLÓGICO</label>
      <input type="text" class="form-control" name="neurologico" id="neurologico" value="<?php if(isset($pat["neurologico"])) echo $pat["neurologico"]; ?>">
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-12">
      <label for="">D.2.- SEGMENTARIO</label>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">CUELLO</label>
      <input type="text" class="form-control" name="cuello" id="cuello" value="<?php if(isset($pat["cuello"])) echo $pat["cuello"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">CRÁNEO</label>
      <input type="text" class="form-control" name="craneo" id="craneo" value="<?php if(isset($pat["craneo"])) echo $pat["craneo"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">CARA</label>
      <input type="text" class="form-control" name="cara" id="cara" value="<?php if(isset($pat["cara"])) echo $pat["cara"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">MÚSCULOS</label>
      <input type="text" class="form-control" name="musculos" id="musculos" value="<?php if(isset($pat["musculos"])) echo $pat["musculos"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">GANGLIOS LINFATICOS</label>
      <input type="text" class="form-control" name="linfaticos" id="linfaticos" value="<?php if(isset($pat["linfaticos"])) echo $pat["linfaticos"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">A.T.M</label>
      <input type="text" class="form-control" name="atm" id="atm" value="<?php if(isset($pat["atm"])) echo $pat["atm"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">GLANDULAS SALIVALES</label>
      <input type="text" class="form-control" name="salivales" id="salivales" value="<?php if(isset($pat["salivales"])) echo $pat["salivales"]; ?>">
    </div>
  </div>
  <div class="" align="center">
    EXAMEN INTRAORAL
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">VESTÍBULO BUCAL</label>
      <input type="text" class="form-control" name="vestibulo" id="vestibulo" value="<?php if(isset($pat["vestibulo"])) echo $pat["vestibulo"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">PARED ANTERIOR</label>
      <input type="text" class="form-control" name="anterior" id="anterior" value="<?php if(isset($pat["anterior"])) echo $pat["anterior"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">PARED SUPERIOR</label>
      <input type="text" class="form-control" name="superior" id="superior" value="<?php if(isset($pat["superior"])) echo $pat["superior"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">PARED POSTERIOR</label>
      <input type="text" class="form-control" name="posterior" id="posterior" value="<?php if(isset($pat["posterior"])) echo $pat["posterior"]; ?>">
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="">PARED INFERIOR</label>
      <input type="text" class="form-control" name="inferior" id="inferior" value="<?php if(isset($pat["inferior"])) echo $pat["inferior"]; ?>">
    </div>
    <div class="col-6">
      <label for="">PARED LATERALES</label>
      <input type="text" class="form-control" name="laterales" id="laterales" value="<?php if(isset($pat["laterales"])) echo $pat["laterales"]; ?>">
    </div>
    <div class="col-6">
      <label for="">LENGUA</label>
      <input type="text" class="form-control" name="language" id="language" value="<?php if(isset($pat["language"])) echo $pat["language"]; ?>">
    </div>
    <div class="col-12">
      <label for="">ENCIAS</label>
      <input type="text" class="form-control" name="encias" id="encias" value="<?php if(isset($pat["encias"])) echo $pat["encias"]; ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">PIEZAS DENTARIAS</label>
    </div>
  </div>
  <div class="" align="center">
    <b> <u>ODONTOGRAMA</u> </b>
  </div>
  <div  class="row border border-warning mx-3">
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="red">
        <input class="form-check-input" type="radio" name="options" id="options1"  checked>
        <label class="form-check-label" for="options1">
          Diente Roja
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6" >
      <div class="form-check" id="bio">
        <input class="form-check-input" type="radio" name="options" id="options2">
        <label class="form-check-label" for="options2">
          Raiz Roja
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="tachados">
        <input class="form-check-input" type="radio" name="options" id="options3">
        <label class="form-check-label" for="options3">
          Diente Tachado
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

  </div>
  <!--odontograma inicio-->
  <!--inicio wrapper-->
  <div id="wrapper">
  <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat['surgeryiiodontogram'])) echo $pat['surgeryiiodontogram']; ?>">

  <table id="tabla-superior" class="img-fluid">
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


  <br>
</div>
<hr>
<div class="border border-primary rounded px-3">
  <div class="row">
    <div class="col-4">
      <label for="">CLASIFICACIÓN DEL ESTADO FÍSICO</label>

      <select name="asa" id="asa" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['surgeryiiasa']) || $pat["surgeryiiasa"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['surgeryiiasa']) && $pat["surgeryiiasa"] == 'asai') echo "selected"; ?> value="asai">ASA I</option>
        <option <?php if(isset($pat['surgeryiiasa']) && $pat["surgeryiiasa"] == 'asaii') echo "selected"; ?> value="asaii">ASA II</option>
        <option <?php if(isset($pat['surgeryiiasa']) && $pat["surgeryiiasa"] == 'asaiii') echo "selected"; ?> value="asaiii">ASA III</option>
      </select>
    </div>
    <div class="col-4">
      <br>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
        ASA :Ayuda
      </button>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Clasificación del estado físico</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-bordered table-responsive">
                <thead>
                  <tr align="center">
                    <th colspan="3">SISTEMA DE CLASIFICACIÓN A.S.A.</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>CATEGORÍA</th>
                    <th>ESTADO DE SALUD PREOPERATORIO</th>
                    <th>CARACTERÍSTICAS/EJEMPLOS</th>
                  </tr>
                  <tr>
                    <td>ASA I</td>
                    <td>PACIENTE NORMAL Y SALUDABLE</td>
                    <td>EL PACIENTE TIENE CAPACIDAD PARA SUBIR UN TRAMO DE ESCALERAS SIN PRESENTAR
                       MOLESTIAS; ANSIEDAD BAJA O NULA; RIESGO BAJO O NULO</td>
                  </tr>
                  <tr>
                    <td>ASA II</td>
                    <td>PACIENTE CON ENFERMEDAD SISTÉMICA LEVE</td>
                    <td>EL PACIENTE ES CAPAZ DE SUBIR UN TRAMO DE ESCALERAS,
                      PERO NECESITA DETENERSE AL TERMINAR EL EJERCICIO DEBIDO A
                      QUE PRESENTA MALESTAR; ANTECEDENTE DE ESTADOS PATOLÓGICOS
                      BIEN CONTROLADOS QUE INCLUYEN DIABETES NO DEPENDIENTE DE INSULINA,
                      PREHIPERTENSION, EPILEPSIA, ASMA O ENFERMEDADES TIROIDEAS</td>
                  </tr>
                  <tr>
                    <td>ASA III</td>
                    <td>PACIENTE CON ENFERMEDAD SISTÉMICA GRAVE</td>
                    <td>EL PACIENTE ES CAPAZ DE SUBIR UN TRAMO DE ESCALERAS, PERO NECESITA DETENERSE
                       AL TERMINAR EL EJERCICIO DEBIDO A QUE PRESENTA MALESTAR; ANTECEDENTE DE ANGINA
                        DE PECHO, INFARTO DE MIOCARDIO; ENFERMEDAD CEREBROVASCULAR; INSUFICIENCIA
                         CARDIACA HACE MAS DE SEIS MESES.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Entedido</button>
            </div>
          </div>
        </div>
      </div>
      <!--modal de datos fin-->
    </div>
  </div>
  <div class="row">
    <div class="col-5">
      <label for="">NIVEL DE ANSIEDAD:</label>
      <b>&nbsp;&nbsp;&nbsp;<span class="text-primary" id="nivelansiedad"></span></b>
    </div>
    <div class="col-7">
      <!--inicion anexso 2-->
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ansiedad">
         Determinar Ansiedad
      </button>
      <!-- Modal -->
      <div class="modal fade" id="ansiedad" tabindex="-1" role="dialog" aria-labelledby="ansiedad" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" >DETERMINACIÓN DE LA ESCALA DE ANSIEDAD DENTAL(modificado de CORAH)</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-6">
                  <label for="">Si tuviera que asistir a la clínica odontológica mañana, ¿cómo se sentiria?</label>
                  <select name="nivelansiedad1" id="nivelansiedad1" onchange="nivelasiedad()" class="form-select" aria-label="Default select example">
                    <option <?php if(!isset($pat['nivelansiedad1']) || $pat["nivelansiedad1"] == '1') echo "selected"; ?> value="1">Bien, no me importaría</option>
                    <option <?php if(isset($pat['nivelansiedad1']) && $pat["nivelansiedad1"] == '2') echo "selected"; ?> value="2">Estaría un poco preocupado</option>
                    <option <?php if(isset($pat['nivelansiedad1']) && $pat["nivelansiedad1"] == '3') echo "selected"; ?> value="3">Estaría muy preocupado</option>
                    <option <?php if(isset($pat['nivelansiedad1']) && $pat["nivelansiedad1"] == '4') echo "selected"; ?> value="4">Estaría con miedo a lo que podría ocurrir</option>
                    <option <?php if(isset($pat['nivelansiedad1']) && $pat["nivelansiedad1"] == '5') echo "selected"; ?> value="5">No podria dormir</option>
                  </select>
                </div>
                <div class="col-6">
                  <label for="">Cuando usted está en la sala de espera de la clínica, esperando que el estudiante le llame ¿Cómo se sentiría?</label>
                  <select name="nivelansiedad2" id="nivelansiedad2" onchange="nivelasiedad()" class="form-select" aria-label="Default select example">
                    <option <?php if(!isset($pat['nivelansiedad2']) || $pat["nivelansiedad2"] == '1') echo "selected"; ?> value="1">Tranquilo</option>
                    <option <?php if(isset($pat['nivelansiedad2']) && $pat["nivelansiedad2"] == '2') echo "selected"; ?> value="2">Intranquilo</option>
                    <option <?php if(isset($pat['nivelansiedad2']) && $pat["nivelansiedad2"] == '3') echo "selected"; ?> value="3">Tenso</option>
                    <option <?php if(isset($pat['nivelansiedad2']) && $pat["nivelansiedad2"] == '4') echo "selected"; ?> value="4">Ansioso, con miedo</option>
                    <option <?php if(isset($pat['nivelansiedad2']) && $pat["nivelansiedad2"] == '5') echo "selected"; ?> value="5">Tan ansioso que empiezo a sudar y sentirme mal</option>
                  </select>
                </div>
                <div class="col-6">
                  <label for="">Si usted está sentado en el sillón dental, esperando que el estudiante prepare el material e instrumental para realizar la anestesia ¿cómo se siente?</label>
                  <select name="nivelansiedad3" id="nivelansiedad3" onchange="nivelasiedad()" class="form-select" aria-label="Default select example">
                    <option <?php if(!isset($pat['nivelansiedad3']) || $pat["nivelansiedad3"] == '1') echo "selected"; ?> value="1">Tranquilo</option>
                    <option <?php if(isset($pat['nivelansiedad3']) && $pat["nivelansiedad3"] == '2') echo "selected"; ?> value="2">Intranquilo</option>
                    <option <?php if(isset($pat['nivelansiedad3']) && $pat["nivelansiedad3"] == '3') echo "selected"; ?> value="3">Tenso</option>
                    <option <?php if(isset($pat['nivelansiedad3']) && $pat["nivelansiedad3"] == '4') echo "selected"; ?> value="4">Ansioso, con miedo</option>
                    <option <?php if(isset($pat['nivelansiedad3']) && $pat["nivelansiedad3"] == '5') echo "selected"; ?> value="5">Tan ansioso que empiezo a sudar y sentirme mal</option>
                  </select>
                </div>
                <div class="col-6">
                  <label for="">Si usted está ya sentado en el sillón dental, observando que el estudiante toma los instrumentos para comenzar el procedimiento ¿cómo se siente?</label>
                  <select name="nivelansiedad4" id="nivelansiedad4" onchange="nivelasiedad()" class="form-select" aria-label="Default select example">
                    <option <?php if(!isset($pat['nivelansiedad4']) || $pat["nivelansiedad4"] == '1') echo "selected"; ?> value="1">Tranquilo</option>
                    <option <?php if(isset($pat['nivelansiedad4']) && $pat["nivelansiedad4"] == '2') echo "selected"; ?> value="2">Intranquilo</option>
                    <option <?php if(isset($pat['nivelansiedad4']) && $pat["nivelansiedad4"] == '3') echo "selected"; ?> value="3">Tenso</option>
                    <option <?php if(isset($pat['nivelansiedad4']) && $pat["nivelansiedad4"] == '4') echo "selected"; ?> value="4">Ansioso, con miedo</option>
                    <option <?php if(isset($pat['nivelansiedad4']) && $pat["nivelansiedad4"] == '5') echo "selected"; ?> value="5">Tan ansioso que empiezo a sudar y sentirme mal</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                TOTAL:&nbsp;&nbsp;&nbsp;<b><span id="asiedadtotal"></span></b>
              </div>
              <div class="col-8">
                <label for="">Valoración:</label>&nbsp;&nbsp;&nbsp;<b><span class="text-primary" id="nivelansiedaddata"></span></b>
                <div class="row">
                  <div class="col-4">
                    Hasta 5 puntos: <br>
                    De 6 a 10 puntos: <br>
                    De 11 a 15 puntos: <br>
                    De 16 a 20 puntos: <br>
                  </div>
                  <div class="col-8">
                    muy poco ansioso <br>
                    ansiedad leve <br>
                    ansiedad moderada <br>
                    ansiedad extrema <br>
                  </div>
                </div>
              </div>
            </div>

            <script type="text/javascript">
              function nivelasiedad(){
                var selection = document.getElementById('nivelansiedad1');
                var nivel1=selection.options[selection.selectedIndex].value;
                selection = document.getElementById('nivelansiedad2');
                var nivel2=selection.options[selection.selectedIndex].value;
                selection = document.getElementById('nivelansiedad3');
                var nivel3=selection.options[selection.selectedIndex].value;
                selection = document.getElementById('nivelansiedad4');
                var nivel4=selection.options[selection.selectedIndex].value;
                var nivel=Number(nivel1)+Number(nivel2)+Number(nivel3)+Number(nivel4);
                var msg='';
                if(nivel<=5){
                  msg='muy poco ansioso';
                }else if (nivel<=10) {
                  msg='ansiedad leve';
                }else if (nivel<=15) {
                  msg='ansiedad moderada';
                }else if (nivel<=20) {
                  msg='ansiedad extrema';
                }else{
                  msg='ansiedad extrema';
                }
                document.getElementById("asiedadtotal").textContent=nivel;
                document.getElementById("nivelansiedaddata").textContent=msg;
                document.getElementById("nivelansiedad").textContent=msg;
              }
              nivelasiedad();
            </script>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <!--modal de datos fin-->
      <!--fin anexso 2-->
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">HIPOTESIS DIAGNÓSTICA</label>
      <textarea class="form-control" name="hipotesisdiagnostica" id="hipotesisdiagnostica" rows="4"><?php if(isset($pat["surgeryiidiagnosishypothesis"])) echo $pat["surgeryiidiagnosishypothesis"];  ?></textarea>

    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">F. EXAMENES COMPLEMENTARIOS</label>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <span>EXAMEN DE LABORATORIO:</span>
    </div>
    <div class="col-12">
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['laboratorio1']))||(isset($pat['laboratorio1'])&&($pat['laboratorio1']=='false'||$pat['laboratorio1']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"laboratorio1\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio1'])&&$pat['laboratorio1']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio1\" value=\"option1\" checked>".
          "<label class=\"form-check-label\" for=\"laboratorio1\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio1'])&&is_numeric($pat['laboratorio1'])) {
          echo "<span class=\"text-primary\" id=\"laboratorio1\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"laboratorio1\">solicitar firma</label>";
        }
        ?>
        <br><span>hemograma</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['laboratorio2']))||(isset($pat['laboratorio2'])&&($pat['laboratorio2']=='false'||$pat['laboratorio2']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"laboratorio2\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio2'])&&$pat['laboratorio2']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio2\" value=\"option2\" checked>".
          "<label class=\"form-check-label\" for=\"laboratorio2\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio2'])&&is_numeric($pat['laboratorio2'])) {
          echo "<span class=\"text-primary\" id=\"laboratorio2\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"laboratorio2\">solicitar firma</label>";
        }
        ?>
        <br><span>cuagulograma</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['laboratorio3']))||(isset($pat['laboratorio3'])&&($pat['laboratorio3']=='false'||$pat['laboratorio3']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio3\" value=\"option3\">".
          "<label class=\"form-check-label\" for=\"laboratorio3\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio3'])&&$pat['laboratorio3']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio3\" value=\"option3\" checked>".
          "<label class=\"form-check-label\" for=\"laboratorio3\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio3'])&&is_numeric($pat['laboratorio3'])) {
          echo "<span class=\"text-primary\" id=\"laboratorio3\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio3\" value=\"option3\">".
          "<label class=\"form-check-label\" for=\"laboratorio3\">solicitar firma</label>";
        }
        ?>
        <br><span>glicemia</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['laboratorio4']))||(isset($pat['laboratorio4'])&&($pat['laboratorio4']=='false'||$pat['laboratorio4']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio4\" value=\"option4\">".
          "<label class=\"form-check-label\" for=\"laboratorio4\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio4'])&&$pat['laboratorio4']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio4\" value=\"option4\" checked>".
          "<label class=\"form-check-label\" for=\"laboratorio4\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio4'])&&is_numeric($pat['laboratorio4'])) {
          echo "<span class=\"text-primary\" id=\"laboratorio4\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio4\" value=\"option4\">".
          "<label class=\"form-check-label\" for=\"laboratorio4\">solicitar firma</label>";
        }
        ?>
        <br><span>creatinina</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['laboratorio5']))||(isset($pat['laboratorio5'])&&($pat['laboratorio5']=='false'||$pat['laboratorio5']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio5\" value=\"option5\">".
          "<label class=\"form-check-label\" for=\"laboratorio5\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio5'])&&$pat['laboratorio5']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio5\" value=\"option5\" checked>".
          "<label class=\"form-check-label\" for=\"laboratorio5\">solicitar firma</label>";
        }elseif (isset($pat['laboratorio5'])&&is_numeric($pat['laboratorio5'])) {
          echo "<span class=\"text-primary\" id=\"laboratorio5\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"laboratorio5\" value=\"option5\">".
          "<label class=\"form-check-label\" for=\"laboratorio5\">solicitar firma</label>";
        }
        ?>
        <br><span>otros</span>
      </div>
    </div>
    <div class="col-12">
      <span>ESTUDIO HISTOPATOLÓGICO:</span>
    </div>
    <div class="col-12">
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['histopatologico1']))||(isset($pat['histopatologico1'])&&($pat['histopatologico1']=='false'||$pat['histopatologico1']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"histopatologico1\">solicitar firma</label>";
        }elseif (isset($pat['histopatologico1'])&&$pat['histopatologico1']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico1\" value=\"option1\" checked>".
          "<label class=\"form-check-label\" for=\"histopatologico1\">solicitar firma</label>";
        }elseif (isset($pat['histopatologico1'])&&is_numeric($pat['histopatologico1'])) {
          echo "<span class=\"text-primary\" id=\"histopatologico1\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"histopatologico1\">solicitar firma</label>";
        }
        ?>
        <br><span>citología</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['histopatologico2']))||(isset($pat['histopatologico2'])&&($pat['histopatologico2']=='false'||$pat['histopatologico2']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"histopatologico2\">solicitar firma</label>";
        }elseif (isset($pat['histopatologico2'])&&$pat['histopatologico2']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico2\" value=\"option2\" checked>".
          "<label class=\"form-check-label\" for=\"histopatologico2\">solicitar firma</label>";
        }elseif (isset($pat['histopatologico2'])&&is_numeric($pat['histopatologico2'])) {
          echo "<span class=\"text-primary\" id=\"histopatologico2\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"histopatologico2\">solicitar firma</label>";
        }
        ?>
        <br><span>biopsia escisional</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['histopatologico3']))||(isset($pat['histopatologico3'])&&($pat['histopatologico3']=='false'||$pat['histopatologico3']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico3\" value=\"option3\">".
          "<label class=\"form-check-label\" for=\"histopatologico3\">solicitar firma</label>";
        }elseif (isset($pat['histopatologico3'])&&$pat['histopatologico3']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico3\" value=\"option3\" checked>".
          "<label class=\"form-check-label\" for=\"histopatologico3\">solicitar firma</label>";
        }elseif (isset($pat['histopatologico3'])&&is_numeric($pat['histopatologico3'])) {
          echo "<span class=\"text-primary\" id=\"histopatologico3\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico3\" value=\"option3\">".
          "<label class=\"form-check-label\" for=\"histopatologico3\">solicitar firma</label>";
        }
        ?>
        <br><span>biopsia incisional</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['histopatologico4']))||(isset($pat['histopatologico4'])&&($pat['histopatologico4']=='false'||$pat['histopatologico4']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico4\" value=\"option4\">".
          "<label class=\"form-check-label\" for=\"histopatologico4\">solicitar firma</label>";
        }elseif (isset($pat['histopatologico4'])&&$pat['histopatologico4']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico4\" value=\"option4\" checked>".
          "<label class=\"form-check-label\" for=\"histopatologico4\">solicitar firma</label>";
        }elseif (isset($pat['histopatologico4'])&&is_numeric($pat['histopatologico4'])) {
          echo "<span class=\"text-primary\" id=\"histopatologico4\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"histopatologico4\" value=\"option4\">".
          "<label class=\"form-check-label\" for=\"histopatologico4\">solicitar firma</label>";
        }
        ?>
        <br><span>biopsia aspiración</span>
      </div>
    </div>
    <div class="col-12">
      <span>IMAGENOLOGÍA:</span>
    </div>
    <div class="col-12">
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['diagenologia1']))||(isset($pat['diagenologia1'])&&($pat['diagenologia1']=='false'||$pat['diagenologia1']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"diagenologia1\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia1'])&&$pat['diagenologia1']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia1\" value=\"option1\" checked>".
          "<label class=\"form-check-label\" for=\"diagenologia1\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia1'])&&is_numeric($pat['diagenologia1'])) {
          echo "<span class=\"text-primary\" id=\"diagenologia1\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"diagenologia1\">solicitar firma</label>";
        }
        ?>
        <br><span>periapical</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['diagenologia2']))||(isset($pat['diagenologia2'])&&($pat['diagenologia2']=='false'||$pat['diagenologia2']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"diagenologia2\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia2'])&&$pat['diagenologia2']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia2\" value=\"option2\" checked>".
          "<label class=\"form-check-label\" for=\"diagenologia2\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia2'])&&is_numeric($pat['diagenologia2'])) {
          echo "<span class=\"text-primary\" id=\"diagenologia2\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"diagenologia2\">solicitar firma</label>";
        }
        ?>
        <br><span>oclusal</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['diagenologia3']))||(isset($pat['diagenologia3'])&&($pat['diagenologia3']=='false'||$pat['diagenologia3']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia3\" value=\"option3\">".
          "<label class=\"form-check-label\" for=\"diagenologia3\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia3'])&&$pat['diagenologia3']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia3\" value=\"option3\" checked>".
          "<label class=\"form-check-label\" for=\"diagenologia3\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia3'])&&is_numeric($pat['diagenologia3'])) {
          echo "<span class=\"text-primary\" id=\"diagenologia3\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia3\" value=\"option3\">".
          "<label class=\"form-check-label\" for=\"diagenologia3\">solicitar firma</label>";
        }
        ?>
        <br><span>ortopantomografía</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['diagenologia4']))||(isset($pat['diagenologia4'])&&($pat['diagenologia4']=='false'||$pat['diagenologia4']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia4\" value=\"option4\">".
          "<label class=\"form-check-label\" for=\"diagenologia4\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia4'])&&$pat['diagenologia4']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia4\" value=\"option4\" checked>".
          "<label class=\"form-check-label\" for=\"diagenologia4\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia4'])&&is_numeric($pat['diagenologia4'])) {
          echo "<span class=\"text-primary\" id=\"diagenologia4\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia4\" value=\"option4\">".
          "<label class=\"form-check-label\" for=\"diagenologia4\">solicitar firma</label>";
        }
        ?>
        <br><span>lateral de cráneo</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['diagenologia5']))||(isset($pat['diagenologia5'])&&($pat['diagenologia5']=='false'||$pat['diagenologia5']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia5\" value=\"option5\">".
          "<label class=\"form-check-label\" for=\"diagenologia5\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia5'])&&$pat['diagenologia5']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia5\" value=\"option5\" checked>".
          "<label class=\"form-check-label\" for=\"diagenologia5\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia5'])&&is_numeric($pat['diagenologia5'])) {
          echo "<span class=\"text-primary\" id=\"diagenologia5\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia5\" value=\"option5\">".
          "<label class=\"form-check-label\" for=\"diagenologia5\">solicitar firma</label>";
        }
        ?>
        <br><span>tomografía</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['diagenologia6']))||(isset($pat['diagenologia6'])&&($pat['diagenologia6']=='false'||$pat['diagenologia6']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia6\" value=\"option6\">".
          "<label class=\"form-check-label\" for=\"diagenologia6\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia6'])&&$pat['diagenologia6']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia6\" value=\"option6\" checked>".
          "<label class=\"form-check-label\" for=\"diagenologia6\">solicitar firma</label>";
        }elseif (isset($pat['diagenologia6'])&&is_numeric($pat['diagenologia6'])) {
          echo "<span class=\"text-primary\" id=\"diagenologia6\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"diagenologia6\" value=\"option6\">".
          "<label class=\"form-check-label\" for=\"diagenologia6\">solicitar firma</label>";
        }
        ?>
        <br><span>otros</span>
      </div>
    </div>
    <div class="col-12">
      <span>FOTOGRAFÍA ODONTOLÓGICA:</span>
    </div>
    <div class="col-12">
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['fotografia1']))||(isset($pat['fotografia1'])&&($pat['fotografia1']=='false'||$pat['fotografia1']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"fotografia1\">solicitar firma</label>";
        }elseif (isset($pat['fotografia1'])&&$pat['fotografia1']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia1\" value=\"option1\" checked>".
          "<label class=\"form-check-label\" for=\"fotografia1\">solicitar firma</label>";
        }elseif (isset($pat['fotografia1'])&&is_numeric($pat['fotografia1'])) {
          echo "<span class=\"text-primary\" id=\"fotografia1\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"fotografia1\">solicitar firma</label>";
        }
        ?>
        <br><span>de frente</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['fotografia2']))||(isset($pat['fotografia2'])&&($pat['fotografia2']=='false'||$pat['fotografia2']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"fotografia2\">solicitar firma</label>";
        }elseif (isset($pat['fotografia2'])&&$pat['fotografia2']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia2\" value=\"option2\" checked>".
          "<label class=\"form-check-label\" for=\"fotografia2\">solicitar firma</label>";
        }elseif (isset($pat['fotografia2'])&&is_numeric($pat['fotografia2'])) {
          echo "<span class=\"text-primary\" id=\"fotografia2\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"fotografia2\">solicitar firma</label>";
        }
        ?>
        <br><span>de perfil</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['fotografia3']))||(isset($pat['fotografia3'])&&($pat['fotografia3']=='false'||$pat['fotografia3']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia3\" value=\"option3\">".
          "<label class=\"form-check-label\" for=\"fotografia3\">solicitar firma</label>";
        }elseif (isset($pat['fotografia3'])&&$pat['fotografia3']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia3\" value=\"option3\" checked>".
          "<label class=\"form-check-label\" for=\"fotografia3\">solicitar firma</label>";
        }elseif (isset($pat['fotografia3'])&&is_numeric($pat['fotografia3'])) {
          echo "<span class=\"text-primary\" id=\"fotografia3\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia3\" value=\"option3\">".
          "<label class=\"form-check-label\" for=\"fotografia3\">solicitar firma</label>";
        }
        ?>
        <br><span>maxilar intrabucal</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['fotografia4']))||(isset($pat['fotografia4'])&&($pat['fotografia4']=='false'||$pat['fotografia4']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia4\" value=\"option4\">".
          "<label class=\"form-check-label\" for=\"fotografia4\">solicitar firma</label>";
        }elseif (isset($pat['fotografia4'])&&$pat['fotografia4']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia4\" value=\"option4\" checked>".
          "<label class=\"form-check-label\" for=\"fotografia4\">solicitar firma</label>";
        }elseif (isset($pat['fotografia4'])&&is_numeric($pat['fotografia4'])) {
          echo "<span class=\"text-primary\" id=\"fotografia4\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia4\" value=\"option4\">".
          "<label class=\"form-check-label\" for=\"fotografia4\">solicitar firma</label>";
        }
        ?>
        <br><span>mandibular intrabucal</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['fotografia5']))||(isset($pat['fotografia5'])&&($pat['fotografia5']=='false'||$pat['fotografia5']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia5\" value=\"option5\">".
          "<label class=\"form-check-label\" for=\"fotografia5\">solicitar firma</label>";
        }elseif (isset($pat['fotografia5'])&&$pat['fotografia5']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia5\" value=\"option5\" checked>".
          "<label class=\"form-check-label\" for=\"fotografia5\">solicitar firma</label>";
        }elseif (isset($pat['fotografia5'])&&is_numeric($pat['fotografia5'])) {
          echo "<span class=\"text-primary\" id=\"fotografia5\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"fotografia5\" value=\"option5\">".
          "<label class=\"form-check-label\" for=\"fotografia5\">solicitar firma</label>";
        }
        ?>
        <br><span>en oclusión</span>
      </div>
    </div>
    <div class="col-12">
      <span>IMPRESIONES:</span>
    </div>
    <div class="col-12">
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['impresiones1']))||(isset($pat['impresiones1'])&&($pat['impresiones1']=='false'||$pat['impresiones1']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"impresiones1\">solicitar firma</label>";
        }elseif (isset($pat['impresiones1'])&&$pat['impresiones1']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones1\" value=\"option1\" checked>".
          "<label class=\"form-check-label\" for=\"impresiones1\">solicitar firma</label>";
        }elseif (isset($pat['impresiones1'])&&is_numeric($pat['impresiones1'])) {
          echo "<span class=\"text-primary\" id=\"impresiones1\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones1\" value=\"option1\">".
          "<label class=\"form-check-label\" for=\"impresiones1\">solicitar firma</label>";
        }
        ?>
        <br><span>parcial</span>
      </div>
      <div class="form-check form-check-inline border py-2 pr-2">
        <?php
        if ((!isset($pat['impresiones2']))||(isset($pat['impresiones2'])&&($pat['impresiones2']=='false'||$pat['impresiones2']==''))) {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"impresiones2\">solicitar firma</label>";
        }elseif (isset($pat['impresiones2'])&&$pat['impresiones2']=='true') {
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones2\" value=\"option2\" checked>".
          "<label class=\"form-check-label\" for=\"impresiones2\">solicitar firma</label>";
        }elseif (isset($pat['impresiones2'])&&is_numeric($pat['impresiones2'])) {
          echo "<span class=\"text-primary\" id=\"impresiones2\"> Firmado</span>";
        }else{
          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"impresiones2\" value=\"option2\">".
          "<label class=\"form-check-label\" for=\"impresiones2\">solicitar firma</label>";
        }
        ?>
        <br><span>total</span>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-12">
      <label for=""><u>G.- DIAGNOSTICO FINAL</u></label>
      <textarea class="form-control" name="finaldiagnostica" id="finaldiagnostica" rows="3"><?php if(isset($pat["surgeryiidiagnosis"])) echo $pat["surgeryiidiagnosis"];  ?></textarea>
    </div>
  </div>
  <!--row inicio-->
  <div class="row">
    <div class="col-7">
      <label for="">GRADO DE DIFICULTAD QUIRÚRGICA (cordales inferiores):</label>
      <b>&nbsp;&nbsp;&nbsp;<span class="text-primary" id="gradodificultadtxt"></span></b>
    </div>
    <div class="col-5">
      <!--inicion anexso 2-->
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#dificultadquirurgica">
         Obtener grado dificultad
      </button>
      <!-- Modal -->
      <div class="modal fade" id="dificultadquirurgica" tabindex="-1" role="dialog" aria-labelledby="dificultadquirurgica" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" >DETERMINACIÓN DEL GRADO DE DIFICULTAD QUIRÚRGICA DE LA EXODONCIA DE CORDALES INFERIORES</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <table class="table table-bordered table-responsive">
                    <thead>
                      <tr align="center">
                        <th colspan="2">CLASIFICACIÓN DE WINTER - PELL Y GREGORY</th>
                        <th>VALOR</th>
                        <th>VALOR ASIGNADO</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td rowspan="4">RELACIÓN DE LOS EJES MAYORES DEL 2. Y 3. MOLAR</td>
                        <td>ANGULO ABIERTO HACIA ATRÁS Y ABAJO</td>
                        <td>1</td>
                        <td rowspan="4">
                          <select name="gradodificultad1" id="gradodificultad1" onchange="gradodificultad()" class="form-select" aria-label="Default select example">
                            <option <?php if(!isset($pat['gradodificultad1']) || $pat["gradodificultad1"] == '1') echo "selected"; ?> value="1">1</option>
                            <option <?php if(isset($pat['gradodificultad1']) && $pat["gradodificultad1"] == '2') echo "selected"; ?> value="2">2</option>
                            <option <?php if(isset($pat['gradodificultad1']) && $pat["gradodificultad1"] == '3') echo "selected"; ?> value="3">3</option>
                            <option <?php if(isset($pat['gradodificultad1']) && $pat["gradodificultad1"] == '4') echo "selected"; ?> value="4">4</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>PERPENDICULAR</td>
                        <td>2</td>
                      </tr>
                      <tr>
                        <td>PARALELOS</td>
                        <td>3</td>
                      </tr>
                      <tr>
                        <td>ANGULO ABIERTO HACIA ATRÁS Y ARRIBA</td>
                        <td>4</td>
                      </tr>
                      <!--SEGUNDO-->
                      <tr>
                        <td rowspan="3">PROFUNDIDAD VERTICAL</td>
                        <td>BORDE OCLUSAL ENTRE EL CUELLO ANATÓMICO Y EL BORDE OCLUSAL DEL 2. MOLAR</td>
                        <td>1</td>
                        <td rowspan="3">
                          <select name="gradodificultad2" id="gradodificultad2" onchange="gradodificultad()" class="form-select" aria-label="Default select example">
                            <option <?php if(!isset($pat['gradodificultad2']) || $pat["gradodificultad2"] == '1') echo "selected"; ?> value="1">1</option>
                            <option <?php if(isset($pat['gradodificultad2']) && $pat["gradodificultad2"] == '2') echo "selected"; ?> value="2">2</option>
                            <option <?php if(isset($pat['gradodificultad2']) && $pat["gradodificultad2"] == '3') echo "selected"; ?> value="3">3</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>BORDE OCLUSAL ENTRE EL CUELLO ANATÓMICO Y EL BORDE OCLUSAL DEL 2. MOLAR</td>
                        <td>2</td>
                      </tr>
                      <tr>
                        <td>BORDE OCLUSAL POR DEBAJO DEL CUELLO ANATÓMICO DEL 2. MOLAR</td>
                        <td>3</td>
                      </tr>
                      <!--TERCER-->
                      <tr>
                        <td rowspan="3">PROFUNDIDAD ANTEROPOSTERIOR</td>
                        <td>LA CORONA NO ESTA CUBIERTA POR LA RAMA</td>
                        <td>1</td>
                        <td rowspan="3">
                          <select name="gradodificultad3" id="gradodificultad3" onchange="gradodificultad()" class="form-select" aria-label="Default select example">
                            <option <?php if(!isset($pat['gradodificultad3']) || $pat["gradodificultad3"] == '1') echo "selected"; ?> value="1">1</option>
                            <option <?php if(isset($pat['gradodificultad3']) && $pat["gradodificultad3"] == '2') echo "selected"; ?> value="2">2</option>
                            <option <?php if(isset($pat['gradodificultad3']) && $pat["gradodificultad3"] == '3') echo "selected"; ?> value="3">3</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>LA MITAD DISTAL DEL DIÁMETRO MESIODISTAL DE LA CORONA ESTA CUBIERTO POR LA RAMA</td>
                        <td>2</td>
                      </tr>
                      <tr>
                        <td>TODO EL DIÁMETRO MESIODISTAL DE LA CORONA ESTA CUBIERTO POR LA RAMA</td>
                        <td>3</td>
                      </tr>
                      <tr>
                        <td colspan="3">TOTAL OBTENIDO</td>
                        <td> <b><span id="gradodificultadtotal"></span></b> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-12">
                  <span>ESCALA DE PUNTUACIÓN</span>
                </div>
                <div class="col-2">
                  leve <br>
                  moderada <br>
                  grave <br>
                </div>
                <div class="col-2">
                  3 a 4 <br>
                  5 a 7 <br>
                  7 a 10 <br>
                </div>
                <br>
                <div class="col-6">
                  <b><span class="txt-primary" id="gradodificultadtxt2"></span></b>
                </div>
              </div>
            <script type="text/javascript">
              function gradodificultad(){
                var selection = document.getElementById('gradodificultad1');
                var nivel1=selection.options[selection.selectedIndex].value;
                selection = document.getElementById('gradodificultad2');
                var nivel2=selection.options[selection.selectedIndex].value;
                selection = document.getElementById('gradodificultad3');
                var nivel3=selection.options[selection.selectedIndex].value;
                var nivel=Number(nivel1)+Number(nivel2)+Number(nivel3);
                var msg='';
                if(nivel<=4){
                  msg='Leve';
                }else if (nivel<=7) {
                  msg='Moderada';
                }else if (nivel<=10) {
                  msg='Grave';
                }else{
                  msg='Grave';
                }
                document.getElementById("gradodificultadtotal").textContent=nivel;
                document.getElementById("gradodificultadtxt").textContent=msg;
                document.getElementById("gradodificultadtxt2").textContent=msg;
              }
              gradodificultad();
            </script>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <!--modal de datos fin-->
      <!--fin anexso 2-->
    </div>
  </div>
  <!--row fin-->
  <div class="row">
    <div class="col-5">
        <u>H.- CONSENTIMIENTO DEL PACIENTE</u>
    </div>
    <div class="col-7">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#consentimiento">
        Ver Consentimiento
      </button>
      <!-- Modal -->
      <div class="modal fade" id="consentimiento" tabindex="-1" role="dialog" aria-labelledby="consentimiento" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">CONSENTIMIENTO DEL PACIENTE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  El presente anexo, debe ser firmado por el paciente que será sometido a la intervención.<br>
                  Nuestra explicación de los procedimientos, su propósito, beneficios, complicaciones y alternativas de tratamiento, fueron discutidos con usted
                  durante el examen clínico. Su consentimiento verbal para llevar a cabo el tratamiento es realmente todo lo requerido. Sin embargo, a fin de
                  evitar situaciones de tipo legal, le solicitamos que lea los párrafos siguientes y si está de acuerdo, estampe su firma al final. Gracias<br>
                  Posibles complicaciones a presentarse:<br>
                  1.- Se me ha informado y entiendo que ocasionalmente, durante y después de la cirugía, podrían presentarse las siguientes situaciones:<br>
                  Dolor, infeccíon, hinchazón, sangrado, alteración del color del labio y/o cara, adormecimiento y hormigueo en la lengua y labios, mentón, encias,
                  mejillas y dientes, tromboflebitis por la inyección accidental de la anestesia en una vena, situación casi imposible debido a la técnica depurada a utilizarse.<br>
                  2.- Mantener la boca abierta durante mucho tiempo, puede provocar molestias en la articulación temporomandibular, por lo tanto podria manifestar cierto grado de
                  dificultad al abrir o cerrar la boca. Se podrían presentarse lesiones accidentales de dientes adyacentes o en restauraciones de otros dientes, dolor posoperatorio referido
                  hacia el oído, cuello y cabeza. Podría padecer náuseas, vómitos o reacciones alérgicas debido a la medicación indicada.<br>
                  3.- El hecho de aplicar fuerza sobre los dientes y huesos, podría provocarme fracturas, contusiones, complicaciones en los senos maxilares,
                  fistulas y aperturas del antro nasal. Los medicamentos como los sedantes y anestésicos pueden causarme somnolencia, falta de lucidez y de coordinación, todo lo cual puede acentuarse por consumo de alcohol o de otras drogas.
                  Por lo tanto, no podré conducir ningún vehículo o manejar dispositivos peligrosos mientras tome tales medicamentos o esté bajo sus efectos.<br>
                  4.- Accedo a que se me administre anestesia local, sedación o analgesia según el juicio del odontólogo encargado.<br>
                  5.- Se me ha indicado por escrito, tomar antes y después de la intervención, medicamentos (antibióticos, analgésicos, antiinflamatorios) con sus respectivas dosis, frecuencias e ingesta. Es de suma importancia que las indicaciones se cumplan al
                  de la letra, de lo contrario aumenta la posibilidad de generar resistencia de los microorganismo a los antibióticos, lo que es altamente peligroso para mi salud.<br>
                  6.- Se me ha explicado y entiendo, que no hay ninguna garantía en cuanto al resultado o la curación, dibido a que, aun habiendo tomado todas las precauciones del caso, cada persona tiene su propia forma de reaccionar frente a una misma acción quirúrgica.<br>
                  Por lo tanto, otorgo mi consentimiento para que el Univ.: <?php echo $userinfo['userfullname']; ?> realice el procedimiento quirúrgico que me ha propuesto de la menera que me explico previamente y cualquier otro procedimiento que se considere necesario o aconsejable como corolario de la operación proyectada.<br>
                  <br>
                  FIRMA DEL PACIENTE:


                  <!--inicio de firma digital-->
                  <style media="screen">
                  .signature-pad {
                    position: relative;
                   display: -webkit-box;
                   display: -ms-flexbox;
                   display: flex;
                   -webkit-box-orient: vertical;
                   -webkit-box-direction: normal;
                       -ms-flex-direction: column;
                           flex-direction: column;
                   font-size: 10px;
                   width: 100%;
                   height: 100%;/*30*/
                   max-width: 600px;
                   max-height: 460px;
                   border: 1px solid #e8e8e8;
                   background-color: #fff;
                   box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
                   border-radius: 4px;
                   padding: 16px;
                  }

                  .signature-pad1 {
                    position: relative;
                   display: -webkit-box;
                   display: -ms-flexbox;
                   display: flex;
                   -webkit-box-orient: vertical;
                   -webkit-box-direction: normal;
                       -ms-flex-direction: column;
                           flex-direction: column;
                   font-size: 10px;
                   width: 100%;
                   height: 30%;
                   max-width: 700px;
                   max-height: 460px;
                   border: 1px solid #e8e8e8;
                   background-color: #fff;
                   box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
                   border-radius: 4px;
                   padding: 16px;
                  }

                  .signature-pad1::before,
                  .signature-pad1::after {
                  position: absolute;
                  z-index: -1;
                  content: "";
                  width: 40%;
                  height: 10px;
                  bottom: 10px;
                  background: transparent;
                  box-shadow: 0 8px 12px rgba(0, 0, 0, 0.4);
                  }

                  .signature-pad--body {
                    position: relative;
                    -webkit-box-flex: 1;
                        -ms-flex: 1;
                            flex: 1;
                    border: 1px solid #f4f4f4;
                  }

                  .signature-pad--body1 {
                    position: relative;
                    -webkit-box-flex: 1;
                        -ms-flex: 1;
                            flex: 1;
                    border: 1px solid #f4f4f4;
                  }
                  </style>
                  <div class="row">
                    <div class="col-12">
                      <?php
                      if(isset($pat['surgeryiiconsent'])&&$pat['surgeryiiconsent']){
                        echo '<img src="'.$pat['surgeryiiconsent'].'" border="1">';
                      }else{
                      ?>
                      <div id="signature-pad" class="signature-pad">
                                  <div class="signature-pad--body">
                                      <canvas id="canvas" width="565" height="120"></canvas>
                                  </div>
                                  <div class="signature-pad--footer">
                                      <div class="signature-pad--actions" style="margin-top: 10px;">
                                          <div>
                                              <button type='button' class="btn btn-sm btn-secondary" onclick='LimpiarTrazado()'>Limpiar</button>
                                          </div>
                                      </div>
                                  </div>
                      </div>
                      <script type="text/javascript">
                      var idCanvas='canvas';
                      var colorDeFondo='#fff';
                      var anchoCanvas=document.getElementById(idCanvas).offsetWidth;
                      var altoCanvas=document.getElementById(idCanvas).offsetHeight;

                      var canvas = document.querySelector("canvas");
                      var signaturePad = new SignaturePad(canvas);
                      function LimpiarTrazado(){
                        signaturePad.clear();
                      }
                      </script>
                    <?php } ?>
                    </div>
                  </div>

                  <!--fin de firma digital-->
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <?php if(isset($pat['surgeryiiconsent'])&&$pat['surgeryiiconsent']==null){ ?>
              <button type="button" class="btn btn-success" id="btn_firma">Guardar Firma</button>
            <?php } ?>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!--modal de datos fin-->
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <!--ficha operatoria inicial-->
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#operatoria">
        Llenar Datos de PRE INTRA POST (OPERATORIO)
      </button>
      <!-- Modal -->
      <div class="modal fade" id="operatoria" tabindex="-1" role="dialog" aria-labelledby="operatoria" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">PRE INTRA POST (OPERATORIO)</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="enlaceprueba"></div>
              <input type="hidden" name="token" id="token" value="">
              <div class="row">
                <div class="col-12">
                  <b><span class="text-primary" id="title_surgery">NUEVO REGISTRO</span></b>
                </div>
              </div>
              <div class="row">
                <div align="center" class="col-12">
                  <u>PREOPERATORIO</u>
                </div>
                <div class="col-12">
                  <label for="">Zona a intervenir:</label>
                  <br>
                  <div class="form-check form-check-inline ml-4">
                    <input class="form-check-input" type="checkbox" id="preoperatorio1" value="option1">
                    <label class="form-check-label" for="preoperatorio1">maxiliar anterior</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="preoperatorio2" value="option2">
                    <label class="form-check-label" for="preoperatorio2">maxiliar posterior</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="preoperatorio3" value="option3">
                    <label class="form-check-label" for="preoperatorio3">mandíbula anterior</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="preoperatorio4" value="option4">
                    <label class="form-check-label" for="preoperatorio4">mandíbula posterior</label>
                  </div>
                </div>

                <div class="col-12">
                  <label for="">Diagnostico quirúrgico</label>
                  <input type="text" class="form-control" name="diagnosisquirurjico" id="diagnosisquirurjico" value="">
                </div>
                <div class="col-12">
                  <label for="">Premedicación:</label>
                  <br>
                  <div class="form-check form-check-inline ml-4">
                    <input class="form-check-input" type="checkbox" id="premedication1" value="option1">
                    <label class="form-check-label" for="premedication1">Antibióticos</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="premedication2" value="option2">
                    <label class="form-check-label" for="premedication2">Antiinflamatorios</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="premedication3" value="option3">
                    <label class="form-check-label" for="premedication3">Analgésicos</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="premedication4" value="option4">
                    <label class="form-check-label" for="premedication4">Ansiolíticos</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row">
                    <div class="col-2">
                      Dosis:
                    </div>
                    <div class="col-4">
                      <input type="text" class="form-control" name="dosis" id="dosis" value="">
                    </div>
                  </div>
                </div>
                <div align="center" class="col-12">
                  <u>INTRAOPERATORIO</u>
                </div>

                <div class="col-12">
                  <div class="row">
                    <div class="col-4">
                      <label for="intrafecha">Fecha:</label>
                      <input type="date" class="form-control" id="intrafecha" name="intrafecha" value="" min="2015-01-01" max="2099-01-01">
                    </div>
                    <div class="col-4">
                      <label for="">Hora inicio:</label>
                      <input type="time" class="form-control" name="intrahora1" id="intrahora1">
                    </div>
                    <div class="col-4">
                        <label for="">Hora final:</label>
                        <input type="time" class="form-control" name="intrahora2" id="intrahora2">
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row">
                    <div class="col-4">
                      <label for="">Cirujano: <?php echo $userinfo['userfullname']; ?></label>
                    </div>
                    <div class="col-8">
                      <div class="row">
                        <div class="col-5">
                          <label for="">Asistente/Instrumentista</label>
                        </div>
                        <div class="col-7">
                          <input type="text" class="form-control" name="asistente" id="asistente" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row">
                    <div class="col-6">
                      <label for="">Medicamento anestésico</label>
                      <input type="text" class="form-control" name="anestesico" id="anestesico" value="">
                    </div>
                    <div class="col-6">
                      <label for="">Técnica</label>
                      <input type="text" class="form-control" name="tecnica" id="tecnica" value="">
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <br>
                  <div class="row">
                    <div class="col-4">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="autorizacion" value="option4">
                        <label class="form-check-label" for="autorizacion">Firma de autorización</label>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="seguimiento" value="option4">
                        <label class="form-check-label" for="seguimiento">Firma de seguimiento</label>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="finalizacion" value="option4">
                        <label class="form-check-label" for="finalizacion">Firma de finalización</label>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <label for="">Observaciones/recomendaciones del profesor</label>
                    <input type="text" class="form-control" name="obsintra" id="obsintra" value="" readonly="readonly">
                  </div>
                </div>
                <div align="center" class="col-12">
                  <u>POSTOPERATORIO</u>
                </div>
                <div class="col-12">
                  <label for="">Sensibilidad:</label>
                  <br>
                  <div class="form-check form-check-inline ml-4">
                    <input class="form-check-input" type="checkbox" id="sensibilidad1" value="option1">
                    <label class="form-check-label" for="sensibilidad1">normal</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="sensibilidad2" value="option2">
                    <label class="form-check-label" for="sensibilidad2">parestesia</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="sensibilidad3" value="option3">
                    <label class="form-check-label" for="sensibilidad3">anestesia</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="sensibilidad4" value="option4">
                    <label class="form-check-label" for="sensibilidad4">disestesia</label>
                  </div>
                </div>
                <div class="col-12">
                  <label for="">Edema:</label>
                  <br>
                  <div class="form-check form-check-inline ml-4">
                    <input class="form-check-input" type="checkbox" id="edema1" value="option1">
                    <label class="form-check-label" for="edema1">ausente</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="edema2" value="option2">
                    <label class="form-check-label" for="edema2">leve</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="edema3" value="option3">
                    <label class="form-check-label" for="edema3">moderado</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="edema4" value="option4">
                    <label class="form-check-label" for="edema4">agudo</label>
                  </div>
                </div>
                <div class="col-12">
                  <label for="">Mucosa bucal:</label>
                  <br>
                  <div class="form-check form-check-inline ml-4">
                    <input class="form-check-input" type="checkbox" id="buccalmucosa1" value="option1">
                    <label class="form-check-label" for="buccalmucosa1">normal</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="buccalmucosa2" value="option2">
                    <label class="form-check-label" for="buccalmucosa2">alterada</label>
                  </div>
                </div>
                <div class="col-12">
                  <label for="obspost">Observaciones/recomendaciones del profesor</label>
                  <input type="text" class="form-control" name="obspost" id="obspost" value="" readonly="readonly">
                </div>
                <div class="col-12">
                  <br>
                  <button type="button" class="btn btn-success" id="btn_surgery" >Guardar Datos</button>
                  <button type="button" class="btn btn-danger" id="btn_surgery_cancel" >Cancelar</button>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-12">
                  <table class="table table-sm table-dark table-striped table-hover">
                    <thead>
                      <th>Zona a intervenir</th>
                      <th>Diagnostico</th>
                      <th>Fecha</th>
                      <th>Acciones</th>
                    </thead>
                    <tbody id="tbodytable">
                    </tbody>
                  </table>
                  <?php
                  $tbodytable=DBAllSurgeryTokenInfo($_GET['id'], true );
                  ?>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <!--ficha operatoria final-->
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      I.- PLAN DE TRATAMIENTO
    </div>
    <div class="col-12">
      <label for="">INMEDIATO</label>
      <input type="text" class="form-control" name="inmediato" id="inmediato" value="<?php if(isset($pat['inmediato'])&&$pat['inmediato']) echo $pat['inmediato'];?>">
    </div>
    <div class="col-12">
      <label for="">MEDIATO</label>
      <input type="text" class="form-control" name="mediato" id="mediato" value="<?php if(isset($pat['mediato'])&&$pat['mediato']) echo $pat['mediato'];?>">
    </div>
  </div>
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

    if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['surgeryiistatus'])&&$pat['surgeryiistatus']!='fail'&&$pat['surgeryiistatus']!='canceled'){
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
//funcion para limpiar los datos
function clearsurgerytoken(){
  $(document).ready(function(){
    $('#token').val('');
    $('#preoperatorio1').prop('checked',false);
    $('#preoperatorio2').prop('checked',false);
    $('#preoperatorio3').prop('checked',false);
    $('#preoperatorio4').prop('checked',false);
    $('#diagnosisquirurjico').val('');
    $('#premedication1').prop('checked',false);
    $('#premedication2').prop('checked',false);
    $('#premedication3').prop('checked',false);
    $('#premedication4').prop('checked',false);
    $('#dosis').val('');
    $('#intrafecha').val('');
    $('#intrahora1').val('');
    $('#intrahora2').val('');

    $('#asistente').val('');
    $('#anestesico').val('');
    $('#tecnica').val('');
    autonot='<div class="form-check form-check-inline">'+
      '<input class="form-check-input" type="checkbox" id="autorizacion" value="option4">'+
      '<label class="form-check-label" for="autorizacion">Firma de autorización</label>'+
    '</div>';
    if($('#autorizacion').prop('checked')===undefined){
      $('#autorizacion').replaceWith(autonot);
    }else{
      $('#autorizacion').prop('checked',false);
    }
    autonot='<div class="form-check form-check-inline">'+
      '<input class="form-check-input" type="checkbox" id="seguimiento" value="option4">'+
      '<label class="form-check-label" for="seguimiento">Firma de seguimiento</label>'+
    '</div>';
    if($('#seguimiento').prop('checked')===undefined){
      $('#seguimiento').replaceWith(autonot);
    }else{
      $('#seguimiento').prop('checked',false);
    }
    autonot='<div class="form-check form-check-inline">'+
      '<input class="form-check-input" type="checkbox" id="finalizacion" value="option4">'+
      '<label class="form-check-label" for="finalizacion">Firma de finalización</label>'+
    '</div>';
    if($('#finalizacion').prop('checked')===undefined){
      $('#finalizacion').replaceWith(autonot);
    }else{
      $('#finalizacion').prop('checked',false);
    }

    $('#obsintra').val('');

    $('#sensibilidad1').prop('checked',false);
    $('#sensibilidad2').prop('checked',false);
    $('#sensibilidad3').prop('checked',false);
    $('#sensibilidad4').prop('checked',false);
    $('#edema1').prop('checked',false);
    $('#edema2').prop('checked',false);
    $('#edema3').prop('checked',false);
    $('#edema4').prop('checked',false);
    $('#buccalmucosa1').prop('checked',false);
    $('#buccalmucosa2').prop('checked',false);
    $('#obspost').val('');
  });
}
//funcion para actualizar un registrio tbody js
function tdataupdate(s){
  $(document).ready(function(){
    $.ajax({

       url:"../include/i_surgeryiii.php",
       method:"POST",
       data: {idupdate:s},
       dataType: "json",
       success:function(data)
       {
         $('#token').val(data.token);
         $('#preoperatorio1').prop('checked',data.preoperatorio1);
         $('#preoperatorio2').prop('checked',data.preoperatorio2);
         $('#preoperatorio3').prop('checked',data.preoperatorio3);
         $('#preoperatorio4').prop('checked',data.preoperatorio4);
         $('#diagnosisquirurjico').val(data.diagnosis);
         $('#premedication1').prop('checked',data.preoperatorio1);
         $('#premedication2').prop('checked',data.preoperatorio2);
         $('#premedication3').prop('checked',data.preoperatorio3);
         $('#premedication4').prop('checked',data.preoperatorio4);
         $('#dosis').val(data.dose);
         $('#intrafecha').val(data.date);
         $('#intrahora1').val(data.hourstart);
         $('#intrahora2').val(data.hourend);

         $('#asistente').val(data.attendee);
         $('#anestesico').val(data.anesthetic);
         $('#tecnica').val(data.technique);
         var autoyes='<div class="form-check form-check-inline">'+
           '<input class="form-check-input" type="checkbox" id="autorizacion" value="option4" checked>'+
           '<label class="form-check-label" for="autorizacion">Firma de autorización</label>'+
         '</div>';
         var autonot='<div class="form-check form-check-inline">'+
           '<input class="form-check-input" type="checkbox" id="autorizacion" value="option4">'+
           '<label class="form-check-label" for="autorizacion">Firma de autorización</label>'+
         '</div>';

         if($('#autorizacion').prop('checked')===undefined){
           if(data.authorization=='true'){
             $('#autorizacion').replaceWith(autoyes);
           }else if(data.authorization=='false'||data.authorization==''){
             $('#autorizacion').replaceWith(autonot);
           }else if(!isNaN(data.authorization)){
             $('#autorizacion').replaceWith('<span id="autorizacion" class="text-primary">Firmado<br><span>Autorización</span></span>');
           }
         }else{
           if(data.authorization=='true'){
             $('#autorizacion').prop('checked',true);
           }else if(data.authorization=='false'||data.authorization==''){
             $('#autorizacion').prop('checked',false);
           }else if(!isNaN(data.authorization)){
             $('#autorizacion').parent().after('<span id="autorizacion" class="text-primary">Firmado<br><span>Autorización</span></span>');
             $('#autorizacion').parent().remove();
           }
         }
         autoyes='<div class="form-check form-check-inline">'+
           '<input class="form-check-input" type="checkbox" id="seguimiento" value="option4" checked>'+
           '<label class="form-check-label" for="seguimiento">Firma de seguimiento</label>'+
         '</div>';
         autonot='<div class="form-check form-check-inline">'+
           '<input class="form-check-input" type="checkbox" id="seguimiento" value="option4">'+
           '<label class="form-check-label" for="seguimiento">Firma de seguimiento</label>'+
         '</div>';
         if($('#seguimiento').prop('checked')===undefined){
           if(data.tracing=='true'){
             $('#seguimiento').replaceWith(autoyes);
           }else if(data.tracing=='false'||data.tracing==''){
             $('#seguimiento').replaceWith(autonot);
           }else if(!isNaN(data.tracing)){
             $('#seguimiento').replaceWith('<span id="seguimiento" class="text-primary">Firmado<br><span>Seguimiento</span></span>');
           }
         }else{
           if(data.tracing=='true'){
             $('#seguimiento').prop('checked',true);
           }else if(data.tracing=='false'||data.tracing==''){
             $('#seguimiento').prop('checked',false);
           }else if(!isNaN(data.tracing)){
             $('#seguimiento').parent().after('<span id="seguimiento" class="text-primary">Firmado<br><span>Seguimiento</span></span>');
             $('#seguimiento').parent().remove();
           }
         }

         autoyes='<div class="form-check form-check-inline">'+
           '<input class="form-check-input" type="checkbox" id="finalizacion" value="option4" checked>'+
           '<label class="form-check-label" for="finalizacion">Firma de seguimiento</label>'+
         '</div>';
         autonot='<div class="form-check form-check-inline">'+
           '<input class="form-check-input" type="checkbox" id="finalizacion" value="option4">'+
           '<label class="form-check-label" for="finalizacion">Firma de seguimiento</label>'+
         '</div>';
         if($('#finalizacion').prop('checked')===undefined){
           if(data.ending=='true'){
             $('#finalizacion').replaceWith(autoyes);
           }else if(data.ending=='false'||data.ending==''){
             $('#finalizacion').replaceWith(autonot);
           }else if(!isNaN(data.ending)){
             $('#finalizacion').replaceWith('<span id="finalizacion" class="text-primary">Firmado<br><span>Finalización</span></span>');
           }
         }else{
           if(data.ending=='true'){
             $('#finalizacion').prop('checked',true);
           }else if(data.ending=='false'||data.ending==''){
             $('#finalizacion').prop('checked',false);
           }else if(!isNaN(data.ending)){
             $('#finalizacion').parent().after('<span id="finalizacion" class="text-primary">Firmado<br><span>Finalización</span></span>');
             $('#finalizacion').parent().remove();
           }
         }
         $('#obsintra').val(data.obsintra);
         $('#sensibilidad1').prop('checked',data.sensibilidad1);
         $('#sensibilidad2').prop('checked',data.sensibilidad2);
         $('#sensibilidad3').prop('checked',data.sensibilidad3);
         $('#sensibilidad4').prop('checked',data.sensibilidad4);

         $('#edema1').prop('checked',data.edema1);
         $('#edema2').prop('checked',data.edema2);
         $('#edema3').prop('checked',data.edema3);
         $('#edema4').prop('checked',data.edema4);
         $('#buccalmucosa1').prop('checked',data.buccalmucosa1);
         $('#buccalmucosa2').prop('checked',data.buccalmucosa2);
         $('#obspost').val(data.obspost);

         $('#title_surgery').text('ACTUALIZAR REGISTRO');
         $(location).attr('href','#enlaceprueba');
       }
    });
  });
}
//funcion para eliminar un registro de tbody js
function tdatadelete(s){
  $(document).ready(function(){
    $.ajax({

       url:"../include/i_surgeryiii.php",
       method:"POST",
       data: {id:s},
       success:function(data)
       {
         if(data=='No'){
           alert('Error al eliminar registro');
         }else{
           $("#tbodytable tr").remove();
           $("#tbodytable").append(data);
           alert('Se eliminó El registro de la fila');
         }

       }
    });
  });
}
$(document).ready(function(){
  //para modal table tr
  var tbodytable=`<?php echo $tbodytable; ?>`;
  $("#tbodytable").append(tbodytable);

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
  descript(`<?php echo trim($pat["surgeryiiodontogram"]); ?>`);

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
     //para registrar datos del paciente para ficha clinica
     function registerpatient(){
        var ficha=$('#ficha').val();
        var practice = $('#practice').val();
        var motconsult = $('#motconsult').val();
        var historiaconsulta = $('#historiaconsulta').val();
        var anamnesisfamiliar = $('#anamnesisfamiliar').val();
        var remota1 = $('select[name=remota1]').val()
        var obsremota1 = $('#obsremota1').val();
        var remota2 = $('select[name=remota2]').val()
        var obsremota2 = $('#obsremota2').val();
        var remota3 = $('select[name=remota3]').val()
        var obsremota3 = $('#obsremota3').val();
        var remota4a = $('select[name=remota4a]').val();
        var remota4b1 = $('select[name=remota4b1]').val();
        var remota4b2 = $('select[name=remota4b2]').val();
        var remota4b3 = $('select[name=remota4b3]').val();
        var remota4b4 = $('select[name=remota4b4]').val();
        var remota4b5 = $('select[name=remota4b5]').val();

        var remota4c = $('select[name=remota4c]').val();
        var remota4d = $('select[name=remota4d]').val();
        var remota4e = $('select[name=remota4e]').val();
        var remota4f1 = $('select[name=remota4f1]').val();
        var remota4f2 = $('select[name=remota4f2]').val();
        var remota4f3 = $('select[name=remota4f3]').val();
        var remota4g = $('select[name=remota4g]').val();
        var remota4h = $('select[name=remota4h]').val();
        var remota4i = $('select[name=remota4i]').val();
        var remota4j = $('select[name=remota4j]').val();
        var remota4k = $('select[name=remota4k]').val();
        var remota4l = $('select[name=remota4l]').val();
        var remota4m = $('select[name=remota4m]').val();
        var remota4n = $('select[name=remota4n]').val();

        var remota51 = $('select[name=remota51]').val();
        var remota52 = $('select[name=remota52]').val();
        var remota53 = $('select[name=remota53]').val();
        var obsremota53 = $('#obsremota53').val();
        var remota6 = $('select[name=remota6]').val();
        var remota7 = $('select[name=remota7]').val();
        var remota81 = $('select[name=remota81]').val();
        var remota82 = $('select[name=remota82]').val();
        var remota83 = $('select[name=remota83]').val();
        var remota84 = $('select[name=remota84]').val();
        var remota85 = $('select[name=remota85]').val();
        var remota86 = $('select[name=remota86]').val();
        var remota87 = $('select[name=remota87]').val();
        var remota88 = $('select[name=remota88]').val();
        var remota89 = $('select[name=remota89]').val();
        var remota810 = $('select[name=remota810]').val();
        var remota811 = $('select[name=remota811]').val();
        var remota812 = $('select[name=remota812]').val();
        var remota9 = $('select[name=remota9]').val();
        var obsremota9 = $('#obsremota9').val();
        var remota10 = $('#remota10').val();
        //$pat['patientgender']
        var remota111 = $('select[name=remota111]').val();
        var remota112 = $('select[name=remota112]').val();

        var remota12 = $('select[name=remota12]').val();
        var obsremota12 = $('#obsremota12').val();

        var historia1 = $('select[name=historia1]').val();
        var obshistoria1 = $('#obshistoria1').val();
        var historia2 = $('select[name=historia2]').val();
        var historia3 = $('select[name=historia3]').val();
        var historia4 = $('select[name=historia4]').val();
        var historia5 = $('select[name=historia5]').val();
        var historia6 = $('select[name=historia6]').val();
        var historia7 = $('select[name=historia7]').val();
        var historia8 = $('select[name=historia8]').val();
        var obshistoria8 = $('#obshistoria8').val();
        var arterial = $('#arterial').val();
        var cardiaca = $('#cardiaca').val();
        var respiratoria = $('#respiratoria').val();
        var torax = $('#torax').val();
        var abdomen = $('#abdomen').val();
        var extremidades = $('#extremidades').val();
        var faneras = $('#faneras').val();
        var neurologico = $('#neurologico').val();
        var cuello = $('#cuello').val();
        var craneo = $('#craneo').val();
        var cara = $('#cara').val();
        var musculos = $('#musculos').val();
        var linfaticos = $('#linfaticos').val();
        var atm = $('#atm').val();
        var salivales = $('#salivales').val();
        var vestibulo = $('#vestibulo').val();
        var anterior = $('#anterior').val();
        var superior = $('#superior').val();
        var posterior = $('#posterior').val();
        var inferior = $('#inferior').val();
        var laterales = $('#laterales').val();
        var encias = $('#encias').val();
        var language = $('#language').val();
        var draw = $('#draw').val();
        var asa = $('select[name=asa]').val();
        var nivelansiedad1 = $('select[name=nivelansiedad1]').val();
        var nivelansiedad2 = $('select[name=nivelansiedad2]').val();
        var nivelansiedad3 = $('select[name=nivelansiedad3]').val();
        var nivelansiedad4 = $('select[name=nivelansiedad4]').val();
        var hipotesisdiagnostica = $('#hipotesisdiagnostica').val();

        var laboratorio1 = $('#laboratorio1').prop('checked');
        var laboratorio2 = $('#laboratorio2').prop('checked');
        var laboratorio3 = $('#laboratorio3').prop('checked');
        var laboratorio4 = $('#laboratorio4').prop('checked');
        var laboratorio5 = $('#laboratorio5').prop('checked');
        var histopatologico1 = $('#histopatologico1').prop('checked');
        var histopatologico2 = $('#histopatologico2').prop('checked');
        var histopatologico3 = $('#histopatologico3').prop('checked');
        var histopatologico4 = $('#histopatologico4').prop('checked');
        var diagenologia1 = $('#diagenologia1').prop('checked');
        var diagenologia2 = $('#diagenologia2').prop('checked');
        var diagenologia3 = $('#diagenologia3').prop('checked');
        var diagenologia4 = $('#diagenologia4').prop('checked');
        var diagenologia5 = $('#diagenologia5').prop('checked');
        var diagenologia6 = $('#diagenologia6').prop('checked');
        var fotografia1 = $('#fotografia1').prop('checked');
        var fotografia2 = $('#fotografia2').prop('checked');
        var fotografia3 = $('#fotografia3').prop('checked');
        var fotografia4 = $('#fotografia4').prop('checked');
        var fotografia5 = $('#fotografia5').prop('checked');
        var impresiones1 = $('#impresiones1').prop('checked');
        var impresiones2 = $('#impresiones2').prop('checked');
        var finaldiagnostica = $('#finaldiagnostica').val();
        var gradodificultad1 = $('select[name=gradodificultad1]').val();
        var gradodificultad2 = $('select[name=gradodificultad2]').val();
        var gradodificultad3 = $('select[name=gradodificultad3]').val();
        var inmediato = $('#inmediato').val();
        var mediato = $('#mediato').val();

        $.ajax({

             url:"../include/i_surgery.php",
             method:"POST",
             data: {
               ficha:ficha, practice:practice, motconsult:motconsult, historiaconsulta:historiaconsulta,
               anamnesisfamiliar:anamnesisfamiliar, remota1:remota1, obsremota1:obsremota1, remota2:remota2,
               obsremota2:obsremota2, remota3:remota3, obsremota3:obsremota3, remota4a:remota4a, remota4b1:remota4b1,
               remota4b2:remota4b2, remota4b3:remota4b3, remota4b4:remota4b4, remota4b5:remota4b5, remota4c:remota4c,
               remota4d:remota4d, remota4e:remota4e, remota4f1:remota4f1, remota4f2:remota4f2, remota4f3:remota4f3,
               remota4g:remota4g, remota4h:remota4h, remota4i:remota4i, remota4j:remota4j, remota4k:remota4k,
               remota4l:remota4l, remota4m:remota4m, remota4n:remota4n, remota51:remota51, remota52:remota52,
               remota53:remota53, obsremota53:obsremota53, remota6:remota6, remota7:remota7, remota81:remota81,
               remota82:remota82, remota83:remota83, remota84:remota84, remota85:remota85, remota86:remota86,
               remota87:remota87, remota88:remota88, remota89:remota89, remota810:remota810, remota811:remota811,
               remota812:remota812, remota9:remota9, obsremota9:obsremota9, remota10:remota10, remota111:remota111,
               remota112:remota112, remota12:remota12, obsremota12:obsremota12, historia1:historia1,
               obshistoria1:obshistoria1, historia2:historia2, historia3:historia3, historia4:historia4,
               historia5:historia5, historia6:historia6, historia7:historia7, historia8:historia8,
               obshistoria8:obshistoria8, arterial:arterial, cardiaca:cardiaca, respiratoria:respiratoria,
               torax:torax, abdomen:abdomen, extremidades:extremidades, faneras:faneras, neurologico:neurologico,
               cuello:cuello, craneo:craneo, cara:cara, musculos:musculos, linfaticos:linfaticos, atm:atm,
               salivales:salivales, vestibulo:vestibulo, anterior:anterior, superior:superior,
               posterior:posterior, inferior:inferior, laterales:laterales, language:language, encias:encias, draw:draw,
               asa:asa, nivelansiedad1:nivelansiedad1, nivelansiedad2:nivelansiedad2, nivelansiedad3:nivelansiedad3, nivelansiedad4:nivelansiedad4,
               hipotesisdiagnostica:hipotesisdiagnostica, laboratorio1:laboratorio1, laboratorio2:laboratorio2,
               laboratorio3:laboratorio3, laboratorio4:laboratorio4, laboratorio5:laboratorio5,
               histopatologico1:histopatologico1, histopatologico2:histopatologico2, histopatologico3:histopatologico3,
               histopatologico4:histopatologico4, diagenologia1:diagenologia1, diagenologia2:diagenologia2,
               diagenologia3:diagenologia3, diagenologia4:diagenologia4, diagenologia5:diagenologia5,
               diagenologia6:diagenologia6, fotografia1:fotografia1, fotografia2:fotografia2, fotografia3:fotografia3,
               fotografia4:fotografia4, fotografia5:fotografia5, impresiones1:impresiones1, impresiones2:impresiones2,
               finaldiagnostica:finaldiagnostica, gradodificultad1:gradodificultad1, gradodificultad2:gradodificultad2,
               gradodificultad3:gradodificultad3, inmediato:inmediato, mediato:mediato
             },
             success:function(data){
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
     $('#patientregister_button').click(function(){

         registerpatient();

     });
     $('#btn_firma').click(function(){
       var fichafirma=$('#ficha').val();
       var firma=document.getElementById(idCanvas).toDataURL('image/png');
       if(confirm('Quieres guardar la firma no se podrá modificar')){
         $.ajax({
              url:"../include/i_surgery.php",
              method:"POST",
              data: {fichafirma:fichafirma, firma:firma},
              success:function(data){
                if(data=='yes'){
                  alert('Se guardo la firma');
                  $('#consentimiento').hide();
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
     $('#btn_surgery_cancel').click(function(){
       clearsurgerytoken();
       $('#title_surgery').text('NUEVO REGISTRO');
       $(location).attr('href','#enlaceprueba');
     });
     //ficha de cirugia

     $('#btn_surgery').click(function(){
        var ficha=$('#ficha').val();
        var token=$('#token').val();
        var preoperatorio1 = $('#preoperatorio1').prop('checked');
        var preoperatorio2 = $('#preoperatorio2').prop('checked');
        var preoperatorio3 = $('#preoperatorio3').prop('checked');
        var preoperatorio4 = $('#preoperatorio4').prop('checked');

        var diagnosisquirurjico = $('#diagnosisquirurjico').val();
        var premedication1 = $('#premedication1').prop('checked');
        var premedication2 = $('#premedication2').prop('checked');
        var premedication3 = $('#premedication3').prop('checked');
        var premedication4 = $('#premedication4').prop('checked');
        var dosis = $('#dosis').val();

        var intrafecha = $('#intrafecha').val();
        var intrahora1 = $('#intrahora1').val();
        var intrahora2 = $('#intrahora2').val();

        var asistente = $('#asistente').val();
        var anestesico = $('#anestesico').val();
        var tecnica = $('#tecnica').val();
        var autorizacion = $('#autorizacion').prop('checked');
        var seguimiento = $('#seguimiento').prop('checked');
        var finalizacion = $('#finalizacion').prop('checked');
        var obsintra = $('#obsintra').val();

        var sensibilidad1 = $('#sensibilidad1').prop('checked');
        var sensibilidad2 = $('#sensibilidad2').prop('checked');
        var sensibilidad3 = $('#sensibilidad3').prop('checked');
        var sensibilidad4 = $('#sensibilidad4').prop('checked');
        var edema1 = $('#edema1').prop('checked');
        var edema2 = $('#edema2').prop('checked');
        var edema3 = $('#edema3').prop('checked');
        var edema4 = $('#edema4').prop('checked');
        var buccalmucosa1 = $('#buccalmucosa1').prop('checked');
        var buccalmucosa2 = $('#buccalmucosa2').prop('checked');
        var obspost = $('#obspost').val();
        $.ajax({

             url:"../include/i_surgery.php",
             method:"POST",
             data: {ficha:ficha, token:token, preoperatorio1:preoperatorio1, preoperatorio2:preoperatorio2, preoperatorio3:preoperatorio3,
                preoperatorio4:preoperatorio4, diagnosisquirurjico:diagnosisquirurjico, premedication1:premedication1,
                premedication2:premedication2, premedication3:premedication3, premedication4:premedication4,
                dosis:dosis, intrafecha:intrafecha, intrahora1:intrahora1, intrahora2:intrahora2, asistente:asistente,
                anestesico:anestesico, tecnica:tecnica, autorizacion:autorizacion, seguimiento:seguimiento,
                finalizacion:finalizacion, obsintra:obsintra, sensibilidad1:sensibilidad1, sensibilidad2:sensibilidad2,
                sensibilidad3:sensibilidad3, sensibilidad4:sensibilidad4, edema1:edema1, edema2:edema2, edema3:edema3,
                edema4:edema4, buccalmucosa1:buccalmucosa1, buccalmucosa2:buccalmucosa2,
                obspost:obspost},
             success:function(data){
                if(data!='No'){
                  $("#tbodytable tr").remove();
                  $("#tbodytable").append(data);
                  clearsurgerytoken();
                  alert('Se guardó los datos');
                  $('#title_surgery').text('NUEVO REGISTRO');
                }else{
                  alert('Error al guardar datos');
                }
                //console.log(data);
             }
        });
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
