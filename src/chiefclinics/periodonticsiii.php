<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBPeriodonticsiiInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=14)
    ForceLoad("index.php");
}else{
  ForceLoad("index.php");
}
$pat2=$r;
$pat=array_merge($pat, $pat2);
$s=DBSessionPeriodonticsiiInfo($_GET['id']);
?>
<a id="personales"></a>
            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->

                <main>

                    <div class="container-fluid px-4">
                        <h2 align="center" class="mt-4">Ficha Clinica de Periodoncia III</h2>
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']!='fail'){
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']=='fail'){
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
  <!--INICIO DE CLINICA PERIODONCIA III-->
  <input type="hidden" name="patientid" id="patientid" value="<?php if(isset($pat["patientid"])) echo $pat["patientid"];  ?>">
  <input type="hidden" name="ficha" id="ficha" value="<?php echo $_GET['id']; ?>">

  <div class="border border-primary rounded p-2">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <label for="patientfullname"><b>Paciente:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?></label><br>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-6">
          <label for="patientage"><b>Edad:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-6">
          <label for="patientgender"><b>Género:</b>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            if(!isset($pat) || $pat["patientgender"] == '--') echo "indefinido";
            if(isset($pat) && $pat["patientgender"] == 'masculino') echo "Masculino";
            if(isset($pat) && $pat["patientgender"] == 'femenino') echo "Femenino";
            ?>
          </label>
        </div>
    </div>
    <div class="row">

      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientprovenance"><b>Procedencia:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"];  ?></label>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="resident"><b>Residente en:</b></label>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-12">
            <input type="text" class="form-control" name="resident" id="resident" value="<?php if(isset($pat["patientresident"])) echo $pat["patientresident"];  ?>">
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-2 col-md-2 col-sm-12 col-12">
            <label for="patientstreet"><b>Calle:</b></label>
          </div>
          <div class="col-lg-10 col-md-10 col-sm-12 col-12">
            <input type="text" class="form-control" name="patientstreet" id="patientstreet" value="<?php if(isset($pat["patientstreet"])) echo $pat["patientstreet"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientphone"><b>Número de Celular:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientphone"])&&$pat["patientphone"]!=0) echo $pat["patientphone"];  ?></label>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="rotation"><b>Rotación:</b></label>
        <input type="text" class="form-control d-inline" style="width:50%;" name="rotation" id="rotation" value="<?php if(isset($pat["periodonticsiirotation"])) echo $pat["periodonticsiirotation"];  ?>">
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <label for="motconsult"><b><u>Motivo De La Consulta</u></b></label>
        <input type="text" class="form-control" name="motconsult" id="motconsult" value="<?php if(isset($pat["periodonticsiimotconsult"])&&$pat['periodonticsiimotconsult']){echo $pat["periodonticsiimotconsult"];}else{if(isset($pat["motconsult"])&&$pat['motconsult']){echo $pat['motconsult'];}}?>">
      </div>

    </div>
    <hr>
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
    <font SIZE=3>
    <div class="row">
      <div class="col-8">
        ¿Ha sufrido o sufre de las siguientes alteraciones o enfermedades?
      </div>
      <div class="col-4">
        Especificar
      </div>
      <div class="col-12">
        <br>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">1) Enfermedades del aparato respiratorio</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question1" id="question1" class="form-select input-sm" onchange="remota('question1')" aria-label="Default select example">
          <option <?php if(!isset($pat['question1']) || $pat["question1"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question1']) && $pat["question1"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question1']) && $pat["question1"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion1" id="obsquestion1" placeholder="" value="<?php if(isset($pat["obsquestion1"])&&$pat['obsquestion1']) echo $pat["obsquestion1"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">2) Enfermedades del corazón</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question2" id="question2" class="form-select input-sm" onchange="remota('question2')" aria-label="Default select example">
          <option <?php if(!isset($pat['question2']) || $pat["question2"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question2']) && $pat["question2"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question2']) && $pat["question2"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion2" id="obsquestion2" placeholder="" value="<?php if(isset($pat["obsquestion2"])&&$pat['obsquestion2']) echo $pat["obsquestion2"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">3) Enfermedades del aparato digestivo</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question3" id="question3" class="form-select input-sm" onchange="remota('question3')" aria-label="Default select example">
          <option <?php if(!isset($pat['question3']) || $pat["question3"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question3']) && $pat["question3"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question3']) && $pat["question3"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion3" id="obsquestion3" placeholder="" value="<?php if(isset($pat["obsquestion3"])&&$pat['obsquestion3']) echo $pat["obsquestion3"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">4) Enfermedades del aparato genito urinario</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question4" id="question4" class="form-select input-sm" onchange="remota('question4')" aria-label="Default select example">
          <option <?php if(!isset($pat['question4']) || $pat["question4"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question4']) && $pat["question4"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question4']) && $pat["question4"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion4" id="obsquestion4" placeholder="" value="<?php if(isset($pat["obsquestion4"])&&$pat['obsquestion4']) echo $pat["obsquestion4"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">5) Diabetes</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question5" id="question5" class="form-select input-sm" onchange="remota('question5')" aria-label="Default select example">
          <option <?php if(!isset($pat['question5']) || $pat["question5"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question5']) && $pat["question5"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question5']) && $pat["question5"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion5" id="obsquestion5" placeholder="" value="<?php if(isset($pat["obsquestion5"])&&$pat['obsquestion5']) echo $pat["obsquestion5"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">6) hemorragias</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question6" id="question6" class="form-select input-sm" onchange="remota('question6')" aria-label="Default select example">
          <option <?php if(!isset($pat['question6']) || $pat["question6"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question6']) && $pat["question6"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question6']) && $pat["question6"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion6" id="obsquestion6" placeholder="" value="<?php if(isset($pat["obsquestion6"])&&$pat['obsquestion6']) echo $pat["obsquestion6"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">7) Enfermedades alérgicas</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question7" id="question7" class="form-select input-sm" onchange="remota('question7')" aria-label="Default select example">
          <option <?php if(!isset($pat['question7']) || $pat["question7"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question7']) && $pat["question7"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question7']) && $pat["question7"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion7" id="obsquestion7" placeholder="" value="<?php if(isset($pat["obsquestion7"])&&$pat['obsquestion7']) echo $pat["obsquestion7"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">8) Hepatitis</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question8" id="question8" class="form-select input-sm" onchange="remota('question8')" aria-label="Default select example">
          <option <?php if(!isset($pat['question8']) || $pat["question8"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question8']) && $pat["question8"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question8']) && $pat["question8"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion8" id="obsquestion8" placeholder="" value="<?php if(isset($pat["obsquestion8"])&&$pat['obsquestion8']) echo $pat["obsquestion8"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">9) Enfermedades de sistema nervioso</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question9" id="question9" class="form-select input-sm" onchange="remota('question9')" aria-label="Default select example">
          <option <?php if(!isset($pat['question9']) || $pat["question9"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question9']) && $pat["question9"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question9']) && $pat["question9"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion9" id="obsquestion9" placeholder="" value="<?php if(isset($pat["obsquestion9"])&&$pat['obsquestion9']) echo $pat["obsquestion9"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">10) Enfermedades psiquiatricas (excitamiento nervioso, etc.)</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question10" id="question10" class="form-select input-sm" onchange="remota('question10')" aria-label="Default select example">
          <option <?php if(!isset($pat['question10']) || $pat["question10"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question10']) && $pat["question10"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question10']) && $pat["question10"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion10" id="obsquestion10" placeholder="" value="<?php if(isset($pat["obsquestion10"])&&$pat['obsquestion10']) echo $pat["obsquestion10"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">11) Accidentes en el curso de la anestesia</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question11" id="question11" class="form-select input-sm" onchange="remota('question11')" aria-label="Default select example">
          <option <?php if(!isset($pat['question11']) || $pat["question11"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question11']) && $pat["question11"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question11']) && $pat["question11"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion11" id="obsquestion11" placeholder="" value="<?php if(isset($pat["obsquestion11"])&&$pat['obsquestion11']) echo $pat["obsquestion11"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">12) Valores de la presión aterial</label>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <input type="text" class="form-control input-sm" name="question12" id="question12" value="<?php if(isset($pat["question12"])&&$pat['question12']) echo $pat["question12"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">13) ¿Que fármacos está tomando?</label>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <input type="text" class="form-control input-sm" name="question13" id="question13" value="<?php if(isset($pat["question13"])&&$pat['question13']) echo $pat["question13"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">14) ¿Está embarazada?</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question14" id="question14" class="form-select input-sm" onchange="remota('question14')" aria-label="Default select example">
          <option <?php if(!isset($pat['question14']) || $pat["question14"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question14']) && $pat["question14"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question14']) && $pat["question14"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion14" id="obsquestion14" placeholder="" value="<?php if(isset($pat["obsquestion14"])&&$pat['obsquestion14']) echo $pat["obsquestion14"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">15) ¿Fuma?</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question15" id="question15" class="form-select input-sm" onchange="remota('question15')" aria-label="Default select example">
          <option <?php if(!isset($pat['question15']) || $pat["question15"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question15']) && $pat["question15"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question15']) && $pat["question15"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion15" id="obsquestion15" placeholder="" value="<?php if(isset($pat["obsquestion15"])&&$pat['obsquestion15']) echo $pat["obsquestion15"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">16) ¿Toma alcohol?</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question16" id="question16" class="form-select input-sm" onchange="remota('question16')" aria-label="Default select example">
          <option <?php if(!isset($pat['question16']) || $pat["question16"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question16']) && $pat["question16"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question16']) && $pat["question16"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion16" id="obsquestion16" placeholder="" value="<?php if(isset($pat["obsquestion16"])&&$pat['obsquestion16']) echo $pat["obsquestion16"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">17) ¿Consume drogas?</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question17" id="question17" class="form-select input-sm" onchange="remota('question17')" aria-label="Default select example">
          <option <?php if(!isset($pat['question17']) || $pat["question17"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question17']) && $pat["question17"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question17']) && $pat["question17"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion17" id="obsquestion17" placeholder="" value="<?php if(isset($pat["obsquestion17"])&&$pat['obsquestion17']) echo $pat["obsquestion17"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">18) Hábitos de alimentación</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question18" id="question18" class="form-select input-sm" onchange="remota('question18')" aria-label="Default select example">
          <option <?php if(!isset($pat['question18']) || $pat["question18"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question18']) && $pat["question18"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question18']) && $pat["question18"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion18" id="obsquestion18" placeholder="" value="<?php if(isset($pat["obsquestion18"])&&$pat['obsquestion18']) echo $pat["obsquestion18"]; ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for="">19) Higiene bucal</label>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-4">
        <select name="question19" id="question19" class="form-select input-sm" onchange="remota('question19')" aria-label="Default select example">
          <option <?php if(!isset($pat['question19']) || $pat["question19"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat['question19']) && $pat["question19"] == 'si') echo "selected"; ?> value="si">Si</option>
          <option <?php if(isset($pat['question19']) && $pat["question19"] == 'no') echo "selected"; ?> value="no">No</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-8 col-8">
        <input type="hidden" class="form-control input-sm" name="obsquestion19" id="obsquestion19" placeholder="" value="<?php if(isset($pat["obsquestion19"])&&$pat['obsquestion19']) echo $pat["obsquestion19"]; ?>">
      </div>
      <script type="text/javascript">
        remota('question1');
        remota('question2');
        remota('question3');
        remota('question4');
        remota('question5');
        remota('question6');
        remota('question7');
        remota('question8');
        remota('question9');
        remota('question10');
        remota('question11');
        //remota('question12');
        //remota('question13');
        remota('question14');
        remota('question15');
        remota('question16');
        remota('question17');
        remota('question18');
        remota('question19');
      </script>
    </div>
    </font>
    <br>

  </div>
  <hr>
  <!--segunda pagina-->
  <div class="border border-primary rounded px-3">

    <div class="row">
      <div class="col-sm-6 col-md-8 col-lg-8">
        <label for="diagnosis"><u><b>Diagnóstico</b></u></label>
        <textarea class="form-control" id="diagnosis" name="diagnosis" rows="4"><?php if(isset($pat["periodonticsiidiagnosis"])) echo $pat["periodonticsiidiagnosis"];  ?></textarea>
      </div>
      <div class="col-sm-6 col-md-4  col-lg-4">
        <label for="treatment">Tratamiento</label>
        <select name="treatment" id="treatment" onChange="cambiar()" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["periodonticsiitreatment"] == '--') echo "selected"; ?> value="--">--</option>
          <option <?php if(isset($pat) && $pat["periodonticsiitreatment"] == 'gingivectomia') echo "selected"; ?> value="gingivectomia">Gingivectomía</option>
          <option <?php if(isset($pat) && $pat["periodonticsiitreatment"] == 'despigmentacion') echo "selected"; ?> value="despigmentacion">Despigmentación</option>
        </select>
      </div>
    </div>
    <br>
    <!--FIN DE CLINICA PERIODONCIA III-->
    <div class="row">

      <div id='caja_gingivectomia'class="col-4"></div>
      <div id="caja_despigmentacion" class="col-4"></div>
      <script type="text/javascript">
        function cambiar(){
          var cod = document.getElementById("treatment").value;
          if(cod=='gingivectomia'){
            removeAllChilds('caja_gingivectomia');
            removeAllChilds('caja_despigmentacion');
            document.getElementById("caja_gingivectomia").innerHTML = '<a class="btn btn-primary" href="" data-toggle="modal" data-target="#gingivectomia">Gingivectomía</a>';
          }
          if(cod=='despigmentacion'){
            removeAllChilds('caja_despigmentacion');
            removeAllChilds('caja_gingivectomia');
            document.getElementById("caja_despigmentacion").innerHTML = '<a class="btn btn-primary" href="" data-toggle="modal" data-target="#despigmentacion">Despigmentación</a>';
          }
          if(cod=='--'){
              removeAllChilds('caja_despigmentacion');
              removeAllChilds('caja_gingivectomia');
          }
        }
        cambiar();
        function removeAllChilds(a){
         var a=document.getElementById(a);
         while(a.hasChildNodes())
        	a.removeChild(a.firstChild);
       }
      </script>
      <!--inicio modal sesion profilaxis-->
      <div class="modal fade" role="dialog" id="gingivectomia">
      <?php $a=DBUserInfo($_SESSION["usertable"]["usernumber"]);?>
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h3 class="modal-title">Gingivectomía</h3>

            <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
          </div>

          <div class="modal-body">
            <input type="hidden" name="namecontrol1" id="namecontrol1" value="gingivectomia">
            <div class="from-group border border-primary rounded">
              <div class="container">
                <label for="">Inicio de sesión:</label>
                <input type="date" id="session1date0" class="form-control"  name="sesion1date0" value="<?php if(isset($pat["session1date0"])) echo $pat["session1date0"];  ?>" min="2015-01-01" max="2099-01-01">
                <input type="hidden" id="session1evalued0" class="form-control"  name="session1evalued0" value="<?php if(isset($pat["session1evalued0"])) echo $pat["session1evalued0"];  ?>">
                <?php
                if(isset($pat['session1evalued0'])&&$pat['session1date0']!=''){
                  if($pat['session1evalued0']=='--' || $pat['session1evalued0']==''){
                    echo "<br>Aun no verificado por Docente<br>";
                  }elseif ($pat['session1evalued0']=='incorrecto') {
                    echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
                  }elseif ($pat['session1evalued0']=='correcto') {
                    echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
                  }
                }else{
                  echo "<br><br><br>";
                }
                ?>
              </div>
            </div>
            <br>
            <div class="from-group border border-primary rounded">
              <div class="container">
                <label for="">1. Control:</label>
                <input type="date" id="session1date1" class="form-control"  name="sesion1date1" value="<?php if(isset($pat["session1date1"])) echo $pat["session1date1"];  ?>" min="2015-01-01" max="2099-01-01">
                <input type="hidden" id="session1evalued1" class="form-control"  name="session1evalued1" value="<?php if(isset($pat["session1evalued1"])) echo $pat["session1evalued1"];  ?>">
                <?php
                if(isset($pat['session1evalued1'])&&$pat['session1date1']!=''){
                  if($pat['session1evalued1']=='--' || $pat['session1evalued1']==''){
                    echo "<br>Aun no verificado por Docente<br>";
                  }elseif ($pat['session1evalued1']=='incorrecto') {
                    echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
                  }elseif ($pat['session1evalued1']=='correcto') {
                    echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
                  }

                }else{
                  echo "<br><br><br>";
                }
                ?>
              </div>
            </div>
            <br>
            <div class="from-group border border-warning rounded">
              <div class="container">
                <label for="">2. Control:</label>
                <input type="date" id="session1date2" class="form-control"  name="sesion1date2" value="<?php if(isset($pat["session1date2"])) echo $pat["session1date2"];  ?>" min="2015-01-01" max="2099-01-01">
                <input type="hidden" id="session1evalued2" class="form-control"  name="session1evalued2" value="<?php if(isset($pat["session1evalued2"])) echo $pat["session1evalued2"];  ?>">

                <?php
                if(isset($pat['session1evalued2'])&&$pat['session1date2']!=''){
                  if($pat['session1evalued2']=='--' || $pat['session1evalued2']==''){
                    echo "<br>Aun no verificado por Docente<br>";
                  }elseif ($pat['session1evalued2']=='incorrecto') {
                    echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
                  }elseif ($pat['session1evalued2']=='correcto') {
                    echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
                  }

                }else{
                  echo "<br><br><br>";
                }
                ?>
              </div>
            </div>
            <br>
            <div class="from-group border border-success rounded">
              <div class="container">
                <label for="">3. Control:</label>
                <input type="date" id="session1date3" class="form-control"  name="sesion1date3" value="<?php if(isset($pat["session1date3"])) echo $pat["session1date3"];  ?>" min="2015-01-01" max="2099-01-01">
                <input type="hidden" id="session1evalued3" class="form-control"  name="session1evalued3" value="<?php if(isset($pat["session1evalued3"])) echo $pat["session1evalued3"];  ?>">

                <?php
                if(isset($pat['session1evalued3'])&&$pat['session1date3']!=''){
                  if($pat['session1evalued3']=='--' || $pat['session1evalued3']==''){
                    echo "<br>Aun no verificado por Docente<br>";
                  }elseif ($pat['session1evalued3']=='incorrecto') {
                    echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
                  }elseif ($pat['session1evalued3']=='correcto') {
                    echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
                  }

                }else{
                  echo "<br><br><br>";
                }
                ?>
              </div>
            </div>
            <br>
            <div class="text-danger">

              <?php
              if(isset($s['sessiondesc'])&& $s['sessiondesc']!=''){
                echo $s['sessiondesc'];
              }
              ?>
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
            <?php
            if(isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']!='fail'&&$pat['periodonticsiistatus']!='canceled'&&$pat['periodonticsiistatus']!='end'){
              echo "<button type=\"submit\" class=\"btn btn-success\" id=\"profilaxis_button\" name=\"profilaxis_button\">Enviar Sesion</button>";
            }
            ?>
          </div>

        </div>

        </div>
      </div>
      <!--fin modal profilaxis-->

      <!--inicio modal tartrectomia-->
      <div class="modal fade" role="dialog" id="despigmentacion">
      <?php $a=DBUserInfo($_SESSION["usertable"]["usernumber"]);?>
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h3 class="modal-title">Despigmentación</h3>
            <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="namecontrol2" id="namecontrol2" value="despigmentacion">
            <div class="from-group border border-primary rounded">
              <div class="container">
                <label for="">Inicio de sesión:</label>
                <input type="date" id="session2date0" class="form-control"  name="sesion2date0" value="<?php if(isset($pat["session2date0"])) echo $pat["session2date0"];  ?>" min="2015-01-01" max="2099-01-01">
                <input type="hidden" id="session2evalued0" class="form-control"  name="session2evalued0" value="<?php if(isset($pat["session2evalued0"])) echo $pat["session2evalued0"];  ?>">
                <?php
                if(isset($pat['session2evalued0'])&&$pat['session2date0']!=''){
                  if($pat['session2evalued0']=='--' || $pat['session2evalued0']==''){
                    echo "<br>Aun no verificado por Docente<br>";
                  }elseif ($pat['session2evalued0']=='incorrecto') {
                    echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
                  }elseif ($pat['session2evalued0']=='correcto') {
                    echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
                  }
                }else{
                  echo "<br><br><br>";
                }
                ?>
              </div>
            </div>
            <br>
            <div class="from-group border border-primary rounded">
              <div class="container">
                <label for="">1. Control:</label>
                <input type="date" id="session2date1" class="form-control"  name="session2date1" value="<?php if(isset($pat["session2date1"])) echo $pat["session2date1"];  ?>" min="2015-01-01" max="2099-01-01">
                <input type="hidden" id="session2evalued1" class="form-control"  name="session2evalued1" value="<?php if(isset($pat["session2evalued1"])) echo $pat["session2evalued1"];  ?>">


                <!--<label for="">Aun no verificado por Docente</label>
                <i style="color:red;" class="fa fa-times fa-3x fa-fw cursor fabians"></i>-->

                <?php
                if(isset($pat['session2evalued1'])&&$pat['session2date1']!=''){
                  if($pat['session2evalued1']=='--' || $pat['session2evalued1']==''){
                    echo "<br>Aun no verificado por Docente<br>";
                  }elseif ($pat['session2evalued1']=='incorrecto') {
                    echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
                  }elseif ($pat['session2evalued1']=='correcto') {
                    echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
                  }
                }else{
                  echo "<br><br><br>";
                }
                ?>

              </div>
            </div>
            <br>
            <div class="from-group border border-warning rounded">
              <div class="container">
                <label for="">2. Control:</label>
                <input type="date" id="session2date2" class="form-control"  name="sesion2date2" value="<?php if(isset($pat["session2date2"])) echo $pat["session2date2"];  ?>" min="2015-01-01" max="2099-01-01">
                <input type="hidden" id="session2evalued2" class="form-control"  name="session2evalued2" value="<?php if(isset($pat["session2evalued2"])) echo $pat["session2evalued2"];  ?>">
                <?php
                if(isset($pat['session2evalued2'])&&$pat['session2date2']!=''){
                  if($pat['session2evalued2']=='--' || $pat['session2evalued2']==''){
                    echo "<br>Aun no verificado por Docente<br>";
                  }elseif ($pat['session2evalued2']=='incorrecto') {
                    echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
                  }elseif ($pat['session2evalued2']=='correcto') {
                    echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
                  }
                }else{
                  echo "<br><br><br>";
                }
                ?>
              </div>
            </div>
            <br>
            <div class="from-group border border-success rounded">
              <div class="container">
                <label for="">3. Control:</label>
                <input type="date" id="session2date3" class="form-control"  name="sesion2date3" value="<?php if(isset($pat["session2date3"])) echo $pat["session2date3"];  ?>" min="2015-01-01" max="2099-01-01">
                <input type="hidden" id="session2evalued3" class="form-control"  name="session2evalued3" value="<?php if(isset($pat["session2evalued3"])) echo $pat["session2evalued3"];  ?>">
                <?php
                if(isset($pat['session2evalued3'])&&$pat['session2date3']!=''){
                  if($pat['session2evalued3']=='--' || $pat['session2evalued3']==''){
                    echo "<br>Aun no verificado por Docente<br>";
                  }elseif ($pat['session2evalued3']=='incorrecto') {
                    echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
                  }elseif ($pat['session2evalued3']=='correcto') {
                    echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
                  }
                }else{
                  echo "<br><br><br>";
                }
                ?>
              </div>
            </div>
            <div class="text-danger">
              <?php
              if(isset($s['sessiondesc'])&& $s['sessiondesc']!=''){
                echo $s['sessiondesc'];
              }
              ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
            <?php
            if(isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']!='fail'&&$pat['periodonticsiistatus']!='canceled'&&$pat['periodonticsiistatus']!='end'){
              echo "<button type=\"submit\" class=\"btn btn-success\" id=\"tartrectomia_button\" name=\"tartrectomia_button\">Enviar Session</button>";
            }
            ?>
          </div>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6 col-md-8 col-lg-8">
          <label for="medicine"><u><b>Medicamentos Prescritos</b></u></label>
          <textarea class="form-control" id="medicine" name="medicine" rows="3"><?php if(isset($pat["periodonticsiimedicine"])) echo $pat["periodonticsiimedicine"];  ?></textarea>
        </div>
      </div>
      <!--fin modal tartrectomia-->
      <div class="row m-2">
        <?php
        if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']!='fail'&&$pat['periodonticsiistatus']!='canceled'){
          echo "<button id=\"oleary_register\" class=\"btn btn-success\" type=\"button\" name=\"oleary_register\">Enviar Datos</button>";
        }
        if(!isset($pat['observationaccepted'])){
          echo "<button id=\"oleary_register\" class=\"btn btn-success\" type=\"button\" name=\"oleary_register\">Enviar Datos</button>";
        }
        ?>
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


      //cancel cancel_button
     $('#cancel_button').click(function(){
        location.reload();
     });

     function registerperiodonto(){
       var patientid = $('#patientid').val();
       //var patientplacebirth = $('#patientplacebirth').val();
       //var patientdatebirth = $('#patientdatebirth').val();
       var patientresident = $('#resident').val();
       //var patientprovince = $('#patientprovince').val();
       var patientstreet = $('#patientstreet').val();
       var rotation = $('#rotation').val();
       var motconsult = $('#motconsult').val();

       var question1 = $('select[name=question1]').val();
       var obsquestion1 = $('#obsquestion1').val();
       var question2 = $('select[name=question2]').val();
       var obsquestion2 = $('#obsquestion2').val();
       var question3 = $('select[name=question3]').val();
       var obsquestion3 = $('#obsquestion3').val();
       var question4 = $('select[name=question4]').val();
       var obsquestion4 = $('#obsquestion4').val();
       var question5 = $('select[name=question5]').val();
       var obsquestion5 = $('#obsquestion5').val();
       var question6 = $('select[name=question6]').val();
       var obsquestion6 = $('#obsquestion6').val();
       var question7 = $('select[name=question7]').val();
       var obsquestion7 = $('#obsquestion7').val();
       var question8 = $('select[name=question8]').val();
       var obsquestion8 = $('#obsquestion8').val();
       var question9 = $('select[name=question9]').val();
       var obsquestion9 = $('#obsquestion9').val();
       var question10 = $('select[name=question10]').val();
       var obsquestion10 = $('#obsquestion10').val();
       var question11 = $('select[name=question11]').val();
       var obsquestion11 = $('#obsquestion11').val();
       var question12 = $('#question12').val();
       //var obsquestion12 = $('#obsquestion12').val();
       var question13 = $('#question13').val();
       //var obsquestion13 = $('#obsquestion13').val();
       var question14 = $('select[name=question14]').val();
       var obsquestion14 = $('#obsquestion14').val();
       var question15 = $('select[name=question15]').val();
       var obsquestion15 = $('#obsquestion15').val();
       var question16 = $('select[name=question16]').val();
       var obsquestion16 = $('#obsquestion16').val();
       var question17 = $('select[name=question17]').val();
       var obsquestion17 = $('#obsquestion17').val();
       var question18 = $('select[name=question18]').val();
       var obsquestion18 = $('#obsquestion18').val();
       var question19 = $('select[name=question19]').val();
       var obsquestion19 = $('#obsquestion19').val();

       var periodraw = $('#draw').val();

       var diagnostico = $('#diagnosis').val();
       var medicine = $('#medicine').val();

       var treatment = $('select[name=treatment]').val();

       var ficha = $('#ficha').val();
           $.ajax({
              url:"../include/i_surgery.php",
              method:"POST",
              data: {patientid:patientid,
                patientresident:patientresident,
                patientstreet:patientstreet, rotation:rotation, motconsult:motconsult,
                question1:question1, obsquestion1:obsquestion1, question2:question2,
                obsquestion2:obsquestion2, question3:question3, obsquestion3:obsquestion3,
                question4:question4, obsquestion4:obsquestion4, question5:question5,
                obsquestion5:obsquestion5, question6:question6, obsquestion6:obsquestion6,
                question7:question7, obsquestion7:obsquestion7, question8:question8,
                obsquestion8:obsquestion8, question9:question9, obsquestion9:obsquestion9,
                question10:question10, obsquestion10:obsquestion10, question11:question11,
                obsquestion11:obsquestion11, question12:question12,
                question13:question13, question14:question14,
                obsquestion14:obsquestion14, question15:question15, obsquestion15:obsquestion15,
                question16:question16, obsquestion16:obsquestion16, question17:question17,
                obsquestion17:obsquestion17, question18:question18, obsquestion18:obsquestion18,
                question19:question19, obsquestion19:obsquestion19,
                periodraw:periodraw, medicine:medicine, diagnostico:diagnostico, treatment:treatment,
                ficha:ficha},

              success:function(data)
              {

                if(data=='yes'){
                  alert('Se envio los datos de la ficha clinica');
                  location.reload();
                  //location.href="index.php";
                }else{
                  alert(data);
                  console.log(data);
                }
              }
           });
     }
     $('#oleary_register').click(function(){
       if (confirm("Enviar los datos de ficha clinica?")) {
           registerperiodonto();
       }else{
           location.reload();
       }
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
     //profilaxis register
     function registersesionp(){
       //alert('se envio no juego');
       if (confirm("Guardar Sesion?")) {
         var ficha = $('#ficha').val();
         var namecontrol1 = $('#namecontrol1').val();
         var s1date0 = $('#session1date0').val();
         var s1date1 = $('#session1date1').val();
         var s1date2 = $('#session1date2').val();
         var s1date3 = $('#session1date3').val();
         var treatment = $('select[name=treatment]').val();

         var s1evalued0 = $('#session1evalued0').val();
         var s1evalued1 = $('#session1evalued1').val();
         var s1evalued2 = $('#session1evalued2').val();
         var s1evalued3 = $('#session1evalued3').val();
         $.ajax({

						  url:"../include/i_session.php",
						  method:"POST",
						  data: {namecontrol1:namecontrol1, s1evalued0:s1evalued0 ,s1evalued1:s1evalued1 ,s1evalued2:s1evalued2 ,s1evalued3:s1evalued3 ,treatment:treatment, ficha:ficha, s1date0:s1date0, s1date1:s1date1, s1date2:s1date2, s1date3:s1date3},

						  success:function(data)
						  {
                alert(data);
              }
				 });
       }
     }
     function registersesiont(){
       //alert('se envio no juego');
       if (confirm("Guardar Sesion?")) {
         var ficha = $('#ficha').val();
         var namecontrol2 = $('#namecontrol2').val();
         var s2date0 = $('#session2date0').val();
         var s2date1 = $('#session2date1').val();
         var s2date2 = $('#session2date2').val();
         var s2date3 = $('#session2date3').val();
         var s2evalued0 = $('#session2evalued0').val();
         var s2evalued1 = $('#session2evalued1').val();
         var s2evalued2 = $('#session2evalued2').val();
         var s2evalued3 = $('#session2evalued3').val();

         var treatment = $('select[name=treatment]').val();

         $.ajax({

						  url:"../include/i_session.php",
						  method:"POST",
						  data: {namecontrol2:namecontrol2, s2evalued0:s2evalued0, s2evalued1:s2evalued1, s2evalued2:s2evalued2, s2evalued3:s2evalued3, treatment:treatment, ficha:ficha, s2date0:s2date0, s2date1:s2date1, s2date2:s2date2, s2date3:s2date3},

						  success:function(data)
						  {
                alert(data);
              }
				 });
       }
     }
     $('#profilaxis_button').click(function(){
       registersesionp();
       location.reload();
     });
     $('#tartrectomia_button').click(function(){
       registersesiont();
       location.reload();
     });
});

</script>
