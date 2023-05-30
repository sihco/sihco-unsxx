<?php
require('header.php');
$fill=false;
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBPatientRemissionSurgeryiiInfo($id);
  //$r=DBSurgeryiiInfo($id);
  if($r==null){
    ForceLoad("clinicalhistory.php");
  }
  if($r["clinicalid"]!=6)
    ForceLoad("clinicalhistory.php");

}else{
  ForceLoad("clinicalhistory.php");
}
$pat=$r;
?>
            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-4">

                        <h2 align="center" class="mt-4">
                          Ficha Clinica de Cirugia Bucal II
                        </h2>

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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['surgeryiistatus'])&&$pat['surgeryiistatus']!='fail'&&$pat['surgeryiistatus']!='canceled'){
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['surgeryiistatus'])&&$pat['surgeryiistatus']=='canceled'){
                          echo "<div class=\"alert alert-dark alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica se anuló.".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }

                        ?>

                        <!--notificaciones fin-->
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button id="fabians7" class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Datos Personales O Filiacion
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show sierra" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
<!--formulario para paciente inicio-->
<!--id para paciente-->
<input type="hidden" name="patientid" id="patientid" value="<?php if(isset($pat["patientid"])) echo $pat["patientid"];  ?>">
<div class="from-group">

    <?php if($fill==true){ ?>
    <div class="row">
      <div class="col-3">
        <u>Fecha hora de registro:</u>
      </div>
      <div class="col-3">
        <input type="datetime-local" id="meeting-time"
   name="meeting-time" value="<?php  if(isset($pat['updatetime'])&&is_numeric($pat['updatetime'])){
     echo datetimeconv($pat['updatetime'],true); }else{echo datetimeconv(time(),true);}?>"
   min="2000-01-01T00:00" max="2100-01-01T00:00" class="form-control">
      </div>
      <div class="col-2">
        <u>Docente Autorizador:</u>
      </div>
      <div class="col-4">
        <select name="teacher" class="form-select" aria-label="Default select example">
          <?php
          $tuser=DBTeachersInfo(5, true);
          $size=count($tuser);
          echo "<option selected value=''>--</option>\n";
          for ($i=0; $i < $size; $i++) {
            echo "<option value='".$tuser[$i]['teacherid']."'>".ucwords($tuser[$i]['teachername'])."</option>\n";
          }
          ?>
        </select>
      </div>
    </div>
   <?php } ?>
    <div class="row">
      <div class="col">
        <label for="patientfullname">Nombres y Apellidos:</label>
        <!--<input type="text" name="patientfullname" class="form-control" id="patientfullname" value="<?php //echo $a["username"]; ?>"> readonly="readonly"-->

        <div class="dropdown">

          <input type="text" class="dropdown-toggle form-control" name="patientfullname" id="patientfullname" autocomplete="off" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php if(isset($pat["patientfullname"])) echo "readonly onmousedown=\"return false;\""; ?>value="<?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?>"  >

          <div class="dropdown-menu" aria-labelledby="search" id="result">

          </div>

        </div>
      </div>

    </div>

</div>

<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientdirection">Direccion</label>
      <input type="text" name="patientdirection" class="form-control" id="patientdirection" readonly onmousedown="return false;" value="<?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientlocation">Localidad</label>
      <input type="text" name="patientlocation" class="form-control" id="patientlocation" readonly onmousedown="return false;" value="<?php if(isset($pat["patientlocation"])) echo $pat["patientlocation"];  ?>">
    </div>
  </div>

</div>
<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientage">Edad</label>
      <input type="text" name="patientage" class="form-control" id="patientage" readonly onmousedown="return false;" value="<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientprovenance">Procedencia</label>
      <input type="text" name="patientprovenance" class="form-control" id="patientprovenance" readonly onmousedown="return false;" value="<?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"];  ?>">
    </div>
  </div>

</div>
<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientphone">Tel.</label>
      <input type="text" name="patientphone" class="form-control" id="patientphone" readonly onmousedown="return false;" maxlength="9" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?php if(isset($pat["patientphone"])) echo $pat["patientphone"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientgender">Genero</label>
      <select name="patientgender" disabled=true class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["patientgender"] == '--') echo "selected"; ?> value="--">--</option>
        <option <?php if(isset($pat) && $pat["patientgender"] == 'masculino') echo "selected"; ?> value="masculino">Masculino</option>
        <option <?php if(isset($pat) && $pat["patientgender"] == 'femenino') echo "selected"; ?> value="femenino">Femenino</option>
      </select>


      <!--
      <input type="text" name="patientgender" class="form-control" id="patientgender" value="<?php //if(isset($pat["patientgender"])) echo $pat["patientgender"];  ?>">
    -->
    </div>
  </div>

</div>
<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientcivilstatus">Estado Civil</label>
      <input type="text" name="patientcivilstatus" class="form-control" id="patientcivilstatus" readonly onmousedown="return false;" value="<?php if(isset($pat["patientcivilstatus"])) echo $pat["patientcivilstatus"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientoccupation">Ocupacion</label>
      <input type="text" name="patientoccupation" class="form-control" id="patientoccupation" readonly onmousedown="return false;" value="<?php if(isset($pat["patientoccupation"])) echo $pat["patientoccupation"];  ?>">
    </div>
  </div>

</div>
<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientnationality">Nacionalidad</label>
      <input type="text" name="patientnationality" class="form-control" id="patientnationality" readonly onmousedown="return false;" value="<?php if(isset($pat["patientnationality"])) echo $pat["patientnationality"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientschool">Grado de escolaridad</label>
      <input type="text" name="patientschool" class="form-control" id="patientschool" readonly onmousedown="return false;" value="<?php if(isset($pat["patientschool"])) echo $pat["patientschool"];  ?>">
    </div>
  </div>

</div>

<div class="from-group">

  <label for="patientattorney">Apoderado</label>
  <input type="text" name="patientattorney" class="form-control" id="patientattorney" readonly onmousedown="return false;" value="<?php if(isset($pat["patientattorney"])) echo $pat["patientattorney"];  ?>">

</div>

<!--formulario para paciente fin-->
      </div>
    </div>

  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Antecedente Médico General
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
<!--formulario para antecedentes medico general-->

  <div class="row">
    <div class="col-5">
      <b><u>ENFERMEDAD</u></b>
    </div>
    <div class="col-2">
      <b><u>SI NO</u></b>
    </div>
    <div class="col-5">
      <b><u>OBSERVACIONES</u></b>
    </div>
  </div>
<?php
$a = array('Cardiopatías', 'Fiebre Reumática', 'Artritis', 'Tuberculosis', 'Silicosis',
    'Epilepsia', 'Hepatitis', 'Diabetes', 'Hipertension Arterial', 'Alergias', 'Asma', 'Embarazo',
    'Habitos / vicios', 'Recibe tratamiento Medico');

$st=false;
if(isset($pat["patientgmh"])){
    $p=cleanpatientgmh($pat["patientgmh"]);
    $st=true;
}
for ($i=0; $i <count($a) ; $i++) {
  echo "<div class=\"row\">".
       "  <div class=\"col-5\">".
       "    <label class=\"form-check-label\" rfor=\"yesno$i\">".$a[$i]."</label>".
       "  </div>";

  echo "<div class=\"col-2\">".
       "  <div class=\"form-check form-switch\">";
  //$tt=$p[$i]["status"];
  if($st){
    if ($p[$i]["status"]=="true") {
        echo "    <input class=\"form-check-input\" disabled=true type=\"checkbox\" id=\"yesno$i\" checked>";
    }else{
        echo "    <input class=\"form-check-input\" disabled=true type=\"checkbox\" id=\"yesno$i\">";
    }
  }else{
    if (true) {
        echo "    <input class=\"form-check-input\" disabled=true type=\"checkbox\" id=\"yesno$i\" checked>";
    }else{
        echo "    <input class=\"form-check-input\" disabled=true type=\"checkbox\" id=\"yesno$i\">";
    }
  }


  echo "  </div>";
  echo "</div>";

  echo "  <div class=\"col-5\">";
  if($st){
    echo "    <input type=\"text\" name=\"obs$i\" class=\"form-control\" readonly onmousedown=\"return false;\" id=\"obs$i\" value=\"".$p[$i]["obs"]."\">";
  }else{
    echo "    <input type=\"text\" name=\"obs$i\" class=\"form-control\" readonly onmousedown=\"return false;\" id=\"obs$i\" value=\"\">";
  }


       echo "  </div>".
       "</div>";
}

?>

<!--formulario para entecedentes medico general fin-->
        <hr>
        <div class="row">
          <input type="hidden" name="dental" id="dental" value="<?php if(isset($pat["dentalid"])) echo $pat["dentalid"];  ?>">
          <u><b>CONSULTAS:</b></u>
          <br>
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="lastconsultation"><u><b>Ultima Consulta</b></u></label>
            <input type="text" name="lastconsultation" class="form-control" id="lastconsultation" value="<?php if(isset($pat["lastconsult"])) echo $pat["lastconsult"];  ?>">

          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="consultation"><u><b>Motivo de Consulta</b></u></label>
            <input type="text" name="consultation" class="form-control" id="consultation" value="<?php if(isset($pat["motconsult"])) echo $pat["motconsult"];  ?>">

          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="generalstatus"><u><b>Estado General</b></u></label>
            <input type="text" name="generalstatus" class="form-control" id="generalstatus" value="<?php if(isset($pat["generalstatus"])) echo $pat["generalstatus"];  ?>">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingFour">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Examen Clinico
        </button>
      </h2>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">

<!--examen bucodental inicio-->
<div class="from-group">
  <div class="row">
    <br>
  <u><b>EXATRA ORAL</u></b>
  <br><br>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="faces">Facies</label>
        <select name="faces" id="faces" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalfaces"] == 'simetrico') echo "selected"; ?> value="simetrico">Simétrico</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'asimetrico') echo "selected"; ?> value="asimetrico">Asimétrico</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="profile">Perfil</label>
        <select name="profile" id="profile" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalprofile"] == 'recto') echo "selected"; ?> value="recto">Recto</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'concavo') echo "selected"; ?> value="concavo">Cóncavo</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'convexo') echo "selected"; ?> value="convexo">Cónvexo</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="scars">Cicatrices</label>
        <input type="text" name="scars" class="form-control" id="scars" value="<?php if(isset($pat["dentalscars"]) && $pat['dentalscars']!="") echo $pat["dentalscars"]; else echo "Ninguno"; ?>">

      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="atm">A.T.M</label>
        <select name="atm" id="atm" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalatm"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'dolor') echo "selected"; ?> value="dolor">Dolor</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'chasquidos') echo "selected"; ?> value="chasquidos">Chasquidos</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'crujidos') echo "selected"; ?> value="crujidos">Crujidos</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'dtm') echo "selected"; ?> value="dtm">D.T.M</option>
          <option <?php if(isset($pat) && $pat["dentalatm"] == 'trismus') echo "selected"; ?> value="trismus">Trismus</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="ganglia">Ganglios</label>
        <select name="ganglia" id="ganglia" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalganglia"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalganglia"] == 'inflamados') echo "selected"; ?> value="inflamados">Inflamados</option>
          <option <?php if(isset($pat) && $pat["dentalganglia"] == 'adenitis') echo "selected"; ?> value="adenitis">Adenitis</option>

        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="lips">Labios</label>
        <select name="lips" id="lips" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentallips"] == 'medianos') echo "selected"; ?> value="medianos">Medianos</option>
          <option <?php if(isset($pat) && $pat["dentallips"] == 'delgados') echo "selected"; ?> value="delgados">Delgados</option>
          <option <?php if(isset($pat) && $pat["dentallips"] == 'gruesos') echo "selected"; ?> value="gruesos">Gruesos</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="ulcerations">Ulceraciones</label>
        <select name="ulcerations" id="ulcerations" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalulcerations"] == 'no') echo "selected"; ?> value="no">No</option>
          <option <?php if(isset($pat) && $pat["dentalulcerations"] == 'si') echo "selected"; ?> value="si">Si</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="cheilitis">Queilitis</label>
        <select name="cheilitis" id="cheilitis" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalcheilitis"] == 'no') echo "selected"; ?> value="no">No</option>
          <option <?php if(isset($pat) && $pat["dentalcheilitis"] == 'si') echo "selected"; ?> value="si">Si</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="commissures">Comisuras</label>
        <select name="commissures" id="commissures" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalcommissures"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalcommissures"] == 'presenta') echo "selected"; ?> value="presenta">Presenta queilitis</option>
        </select>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <u><b>INTRA ORAL</u></b>
    <br><br>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="tongue">Lengua</label>
      <select name="tongue" id="tongue" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentaltongue"] == 'saburra') echo "selected"; ?> value="saburra">Saburral</option>
        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'fisurada') echo "selected"; ?> value="fisurada">Fisurada</option>
        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'geografica') echo "selected"; ?> value="geografica">Geográfica</option>
        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
      </select>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="piso">Piso de la boca</label>
      <select name="piso" id="piso" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentalpiso"] == 'aparentemente') echo "selected"; ?> value="aparentemente">Aparentemente Normal</option>
        <option <?php if(isset($pat) && $pat["dentalpiso"] == 'toruslingua') echo "selected"; ?> value="toruslingua">Torus Lingua</option>
        <option <?php if(isset($pat) && $pat["dentalpiso"] == 'ranula') echo "selected"; ?> value="ranula">Ránula</option>
        <option <?php if(isset($pat) && $pat["dentalpiso"] == 'frenillo') echo "selected"; ?> value="frenillo">Frenillo lingual Alto</option>
        <option <?php if(isset($pat) && $pat["dentalpiso"] == 'mucocele') echo "selected"; ?> value="mucocele">Mucocele</option>
      </select>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="encias">Encias</label>
      <select name="encias" id="encias" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentalencias"] == 'difusa') echo "selected"; ?> value="difusa">Gingivitis Difusa</option>
        <option <?php if(isset($pat) && $pat["dentalencias"] == 'aguda') echo "selected"; ?> value="aguda">Gingivitis Aguda</option>
        <option <?php if(isset($pat) && $pat["dentalencias"] == 'gingivitis') echo "selected"; ?> value="gingivitis">Gingivitis cronoca no complicada</option>
        <option <?php if(isset($pat) && $pat["dentalencias"] == 'papilar') echo "selected"; ?> value="papilar">Papilar</option>
        <option <?php if(isset($pat) && $pat["dentalencias"] == 'guna') echo "selected"; ?> value="guna">G.U.N.A</option>
        <option <?php if(isset($pat) && $pat["dentalencias"] == 'hiperplasia') echo "selected"; ?> value="hiperplasia">Hiperplasia gingival</option>
      </select>
    </div>


  </div>
  <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="mucosa">Mucosa Bucal</label>
      <select name="mucosa" id="mucosa" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentalmucosa"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
        <option <?php if(isset($pat) && $pat["dentalmucosa"] == 'alteracion') echo "selected"; ?> value="alteracion">Con Alteración</option>
      </select>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="occlusion">Tipo de Oclusion</label>
      <select name="occlusion" id="occlusion" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentaltypeo"] == 'normo') echo "selected"; ?> value="normo">Normo oclusion</option>
        <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'disto') echo "selected"; ?> value="disto">Disto oclusion</option>
        <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'mesio') echo "selected"; ?> value="mesio">Mesio oclusion</option>
        <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'abierta') echo "selected"; ?> value="abierta">Mordida Abierta anterior</option>
      </select>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="prosthesis">Tipo de Protesis</label>
      <select name="prosthesis" id="prosthesis" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentaltypep"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'removible') echo "selected"; ?> value="removible">Removible</option>
        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'fija') echo "selected"; ?> value="fija">Fija</option>
        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'total') echo "selected"; ?> value="total">Total</option>
      </select>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="hygiene">Higiene Bucal</label>
      <select name="hygiene" id="hygiene" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentalhygiene"] == 'regular') echo "selected"; ?> value="regular">Regular</option>
        <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'buena') echo "selected"; ?> value="buena">Buena</option>
        <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'mala') echo "selected"; ?> value="mala">Mala</option>
      </select>
    </div>

  </div>

</div>
<br>

<!--examen bucodental fin-->
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingFive">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
          Odontograma
        </button>
      </h2>
    </div>
    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
      <div class="card-body">
        <input type="hidden" name="odontogram" id="odontogram" value="<?php if(isset($pat["odontogramid"])) echo $pat["odontogramid"];  ?>">
<!--odontograma inicio-->
        <?php
        include("../leftodontogram.php");
        $odontogramstatus="false";
        if (isset($pat['draw'])){
          $pat=decryptOdontogram($pat);
          $odontogramstatus="true";
        }
        /*if (isset($pat)){
          $pat=decryptOdontogram($pat);

          if(isset($pat["tl"])){
            $odontogramstatus="true";
            $pat["tr"]= html_entity_decode($pat["tr"]);
            $pat["tl"]= html_entity_decode($pat["tl"]);
            $pat["tlr"]= html_entity_decode($pat["tlr"]);
            $pat["tll"]= html_entity_decode($pat["tll"]);
            $pat["bl"]= html_entity_decode($pat["bl"]);
            $pat["br"]= html_entity_decode($pat["br"]);
            $pat["bll"]= html_entity_decode($pat["bll"]);
            $pat["blr"]= html_entity_decode($pat["blr"]);

          }
        }*/

        ?>
<!--odontograma fin-->
      <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat["draw"])) echo $pat["draw"];?>">
      </div>

    </div>
  <div class="card">
    <div class="card-header" id="headingSix">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
          Examenes Complementarios
        </button>
      </h2>
    </div>

    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
      <div class="card-body">
<!--inicio finalizacion-->
        <div class="row">
          <div class="col-4 col-lg-4 col-md-4 col-sm-12 col-12">

            <label for="disease">Historia de la Enfermedad Actual:</label>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-12">
            <input type="text" name="disease" class="form-control" id="disease" value="<?php if(isset($pat['surgeryiidisease'])) echo $pat['surgeryiidisease'];?>">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-8 col-8">
            <label for="exam"><u><b>Examenes Complementarios</b></u></label>

            <select name="exam" id="exam" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat["exam"]) || $pat["exam"] == '--') echo "selected"; ?> value="--">--</option>
              <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'periapical') echo "selected"; ?> value="periapical">RX PERIAPICAL</option>
              <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'oclusal') echo "selected"; ?> value="oclusal">RX OCLUSAL</option>
              <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'panoramico') echo "selected"; ?> value="panoramico">RX PANORAMICO</option>
              <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
            </select>
          </div>
          <div class="col-lg-1 col-md-2 col-sm-4 col-4">
            <label for="pieza">Pieza</label>
            <input type="text" name="pieza" class="form-control" id="pieza" value="<?php if(isset($pat['pieza'])) echo $pat['pieza'] ?>">
          </div>

          <br><br><br>
          <div class="col-lg-8 col-md-7 col-sm-12 col-12">
            <label for="diagnostico"><u><b>Diagnostico</b></u></label>
            <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="4"><?php if(isset($pat["surgeryiidiagnosis"])) echo $pat["surgeryiidiagnosis"];  ?></textarea>

          </div>
        </div>

        <hr>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="treatment"><u><b>Tratamiento</b></u></label>
            <select name="treatment" id="treatment" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat["treatment"]) || $pat["treatment"] == '--') echo "selected"; ?> value="--">--</option>
              <option <?php if(isset($pat["treatment"]) && $pat["treatment"] == 'sintomatico') echo "selected"; ?> value="sintomatico">SINTOMATICO</option>
              <option <?php if(isset($pat["treatment"]) && $pat["treatment"] == 'etiologica') echo "selected"; ?> value="etiologica">ETIOLOGICA</option>
              <option <?php if(isset($pat["treatment"]) && $pat["treatment"] == 'quirurgico') echo "selected"; ?> value="quirurgico">QUIRURGICO</option>
              <option <?php if(isset($pat["treatment"]) && $pat["treatment"] == 'medico farmacologico') echo "selected"; ?> value="medico farmacologico">MEDICO FARMACOLOGICO</option>

            </select>
            <!--
              <label for="sintomatico">SINTOMATICO:</label>
              <input type="text" name="sintomatico" class="form-control" id="sintomatico" value="<?php// if(isset($pat['sintomatico'])) echo $pat['sintomatico'];?>">
              <label for="etiologica">ETIOLOGICA:</label>
              <input type="text" name="etiologica" class="form-control" id="etiologica" value="<?php //if(isset($pat['etiologica'])) echo $pat['etiologica'];?>">
              <label for="quirurgico">QUIRURGICO:</label>
              <input type="text" name="quirurgico" class="form-control" id="quirurgico" value="<?php //if(isset($pat['quirurgico'])) echo $pat['quirurgico'];?>">
              <label for="farmacologico">MEDIO FARMACOLOGICO:</label>
              <input type="text" name="farmacologico" class="form-control" id="farmacologico" value="<?php //f(isset($pat['farmacologico'])) echo $pat['farmacologico'];?>">
            -->
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="anestesia"><u><b>Anestesias</b></u></label>
            <select name="anestesia" id="anestesia" class="form-select" aria-label="Default select example">
              <option <?php if(!isset($pat["anestesia"]) || $pat["anestesia"] == '--') echo "selected"; ?> value="--">--</option>
              <option <?php if(isset($pat["anestesia"]) && $pat["anestesia"] == 'spix') echo "selected"; ?> value="spix">SPIX</option>
              <option <?php if(isset($pat["anestesia"]) && $pat["anestesia"] == 'mentoniana') echo "selected"; ?> value="mentoniana">MENTONIANA</option>
              <option <?php if(isset($pat["anestesia"]) && $pat["anestesia"] == 'local') echo "selected"; ?> value="local">LOCAL</option>
              <option <?php if(isset($pat["anestesia"]) && $pat["anestesia"] == 'infraorbitaria') echo "selected"; ?> value="infraorbitaria">INFRAORBITARIA</option>
              <option <?php if(isset($pat["anestesia"]) && $pat["anestesia"] == 'tuberositoria') echo "selected"; ?> value="tuberositoria">TUBEROSITARIA</option>
              <option <?php if(isset($pat["anestesia"]) && $pat["anestesia"] == 'carrea') echo "selected"; ?> value="carrea">CARREA</option>
              <option <?php if(isset($pat["anestesia"]) && $pat["anestesia"] == 'general') echo "selected"; ?> value="general">GENERAL</option>
            </select>
          </div>
        </div>

<!--fin finalizacion-->
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingSeven">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
          Prescripciones & Tratamiento P.O. y Evolucion
        </button>
      </h2>
    </div>

    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
      <div class="card-body">
<!--inicio finalizacion-->
        <div class="row">
          <div class="col-8">
            <label for="">PRESCRIPCIONES</label>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="prescriptions"><u><b>RP/</b></u></label>
            <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
            <textarea class="form-control" id="prescriptions" name="prescriptions" rows="4"><?php if(isset($pat["surgeryiiprescriptions"])) echo $pat["surgeryiiprescriptions"];  ?></textarea>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="indications"><u><b>INDICACIONES</b></u></label>
            <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
            <textarea class="form-control" id="indications" name="indications" rows="4"><?php if(isset($pat["surgeryiiindications"])) echo $pat["surgeryiiindications"];  ?></textarea>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="evolution"><u><b>TRATAMIENTO P.O Y EVOLUCION</b></u></label>
            <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
            <textarea class="form-control" id="evolution" name="evolution" rows="4"><?php if(isset($pat["surgeryiievolution"])) echo $pat["surgeryiievolution"];  ?></textarea>
          </div>
          <input type="hidden" name="remission" id="remission"value="<?php if(isset($pat["remissionid"])) echo $pat["remissionid"]?>">
          <input type="hidden" name="ficha" id="ficha"value="<?php if(isset($pat["surgeryiiid"])) echo $pat["surgeryiiid"]?>">
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
<!--fin finalizacion-->
      </div>
    </div>
  </div>

</div>


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
<!--odontograma inicio js-->
<!-- jQuery -->
<!--<script src="../jquery-1.10.2.min.js"></script>-->
<!-- Bootstrap JavaScript -->
<!--<script src="../tools/bootstrap/bootstrap.js"></script>-->
<!--ABRIMOS JAVASCRIPT-->
<?php
include("../leftodontogramjs.php");
?>
<!--odontograma fin js-->
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
     //registrar todos de datos del paciente

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

									   //location.href="../indexs.php";
								   }else{
									   alert(data);
								   }

							   }

						  }
				 });

			 }
		 }

     });



     var info='';
     //funcion para registrar datos del paciente
     function registerpatient(){

       var patientid = $('#patientid').val();

       //exam buco dental
       var dental = $('#dental').val();
       var faces = $('select[name=faces]').val();
       var profile = $('select[name=profile]').val();
       var scars = $('#scars').val();//$('select[name=scars]').val();
       var atm = $('select[name=atm]').val();
       var ganglia = $('select[name=ganglia]').val();
       var lips = $('select[name=lips]').val();
       var ulcerations = $('select[name=ulcerations]').val();
       var cheilitis = $('select[name=cheilitis]').val();
       var commissures = $('select[name=commissures]').val();

       var tongue = $('select[name=tongue]').val();// $('select[name=tongue]').val();// $('input:radio[name=tongue]:checked').val();
       var piso = $('select[name=piso]').val();// $('input:radio[name=piso]:checked').val();
       var encias = $('select[name=encias]').val();// $('input:radio[name=encias]:checked').val();
       var mucosa = $('select[name=mucosa]').val();// $('input:radio[name=mucosa]:checked').val();
       var occlusion = $('select[name=occlusion]').val();// $('input:radio[name=occlusion]:checked').val();
       var prosthesis = $('select[name=prosthesis]').val();// $('input:radio[name=prosthesis]:checked').val();
       var hygiene = $('select[name=hygiene]').val();// $('input:radio[name=hygiene]:checked').val();

       var lastconsultation = $('#lastconsultation').val();
       var consultation = $('#consultation').val();
       var generalstatus = $('#generalstatus').val();
       //alert(tongue);

       //datos del odontograma
       var odontogram = $('#odontogram').val();
       var tr = $('#tr').html();
       var tl = $('#tl').html();
       var tlr = $('#tlr').html();
       var tll = $('#tll').html();
       var bl = $('#bl').html();
       var br = $('#br').html();
       var bll = $('#bll').html();
       var blr = $('#blr').html();

       var odontodiagnostico = $('#areadiagnostico').val();
       var odontodraw = $('#draw').val();

       //variable para el modo de registro
       var mod = 'surgeryii';
       //variables de ficha cirugia bucal ii
       //enfermedad
       var disease = $('#disease').val();
       //examen
       var exam = $('select[name=exam]').val();
       var pieza = $('#pieza').val();
       //diagnostico
       var diagnostico = $('#diagnostico').val();
       //tratameinto y anestesias
       //var sintomatico = $('#sintomatico').val();
       //var etiologica = $('#etiologica').val();
       //var quirurgico = $('#quirurgico').val();
       //var farmacologico = $('#farmacologico').val();

       var treatment = $('select[name=treatment]').val();
       var anestesia = $('select[name=anestesia]').val();
       //prescripciones
       var prescriptions = $('#prescriptions').val();
       //indicaciones
       var indications = $('#indications').val();
       //indicaciones
       var evolution = $('#evolution').val();
       var remission = $('#remission').val();
       var ficha = $('#ficha').val();
       var fill='<?php echo $fill; ?>';
       if(fill==true){
         var meeting_time=$('#meeting-time').val();
         var teacher=$('select[name=teacher]').val();
         if(teacher==''){
           alert('Debe seleccionar docente quién autoriza.');
           return;
         }
         $.ajax({

                url:"../include/i_patientadmission.php",
                method:"POST",
                data: {patientid:patientid, remission:remission, ficha:ficha, mod:mod, dental:dental, faces:faces, profile:profile, scars:scars, atm:atm, ganglia:ganglia,
                  lips:lips, ulcerations:ulcerations, cheilitis:cheilitis, commissures:commissures,
                  tongue:tongue, piso:piso, encias:encias, mucosa:mucosa, occlusion:occlusion,
                  prosthesis:prosthesis, hygiene:hygiene, lastconsultation:lastconsultation, consultation:consultation, generalstatus:generalstatus,
                  odontogram:odontogram, tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr,
                  odontodiagnostico:odontodiagnostico, odontodraw:odontodraw,
                  disease:disease, exam:exam, pieza:pieza,
                  diagnostico:diagnostico, treatment:treatment, anestesia:anestesia,
                  prescriptions:prescriptions, indications:indications, evolution:evolution, meeting_time:meeting_time, teacher:teacher},

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
       }else{
         $.ajax({

                url:"../include/i_patientadmission.php",
                method:"POST",
                data: {patientid:patientid, remission:remission, ficha:ficha, mod:mod, dental:dental, faces:faces, profile:profile, scars:scars, atm:atm, ganglia:ganglia,
                  lips:lips, ulcerations:ulcerations, cheilitis:cheilitis, commissures:commissures,
                  tongue:tongue, piso:piso, encias:encias, mucosa:mucosa, occlusion:occlusion,
                  prosthesis:prosthesis, hygiene:hygiene, lastconsultation:lastconsultation, consultation:consultation, generalstatus:generalstatus,
                  odontogram:odontogram, tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr,
                  odontodiagnostico:odontodiagnostico, odontodraw:odontodraw,
                  disease:disease, exam:exam, pieza:pieza,
                  diagnostico:diagnostico, treatment:treatment, anestesia:anestesia,
                  prescriptions:prescriptions, indications:indications, evolution:evolution},

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

     }

    //register patient
    $('#patientregister_button').click(function(){
      if (confirm("Enviar los datos de ficha clinica?")) {
        registerpatient();
      }else{
          location.reload();
      }
    });

});

</script>
