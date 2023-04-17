<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  if(($pat=DBPatientRemissionInfo($id))==null){
    ForceLoad("admission.php");
  }
}
if (isset($_GET["limit"]) && is_numeric($_GET['limit']) && $_GET["limit"]>0)
  $limit = myhtmlspecialchars($_GET["limit"]);
else $limit = 50;

?>


            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>

                    <div class="container-fluid px-2">
<!--tabla para pacientes remitidos inicio-->
<br>
<a class="btn btn-primary btn-sm" href="admission.php#patient">Remitir Paciente</a>
<a class="" href="report.php">Descargar Plantilla</a>
<br>
<div class="text-center text-success">
  <u><b>REGISTRO DE PACIENTES REMITIDOS</b></u>
</div>
<div class="row">
  <div class="col-lg-1 col-md-1 col-sm-2 col-2">
    <label for="listar" class="text-primary"><u><b>Listar:</b></u></label>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-5 col-5">
    <select name="listar" id="listar" onchange="ListLog()" class="form-select" aria-label="Default select example">
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']<=50) echo "selected"; ?> value="50">50 registros</option>
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>50&&$_GET['limit']<=100) echo "selected"; ?> value="100">100 registros</option>
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>100&&$_GET['limit']<=500) echo "selected"; ?> value="500">500 registros</option>
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>500) echo "selected"; ?> value="1000000">Sin limite</option>
    </select>
    <script>
      function ListLog() {
        var number=document.getElementById("listar").value;
        location.href="admission.php?limit="+number;
      }
    </script>
  </div>
</div>
<table class="table table-responsive table-sm table-hover" id="table_admission">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Paciente</th>
            <th scope="col">Consulta</th>
            <th scope="col">Diagnostico</th>
            <th scope="col">Remision</th>
            <th scope="col">Examinado Por</th>
            <th scope="col">Fecha</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>


<?php
//$usr = DBAllUserInfo();

$pr = DBAllPatientRemissionInfo();
//$pr = DBAllRemissionInfo(null, false, $limit);
$size=count($pr);
for ($i=0; $i < $size; $i++) {
      echo " <tr>\n";
      echo "   <td>" . ($size-$i) . "</td>";
      echo "   <td>" . $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</td>";
      echo "   <td>" . $pr[$i]["motconsult"] . "</td>";
      echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";
      echo "   <td></td>";
      echo "   <td></td>";
      echo "   <td>" . datetimeconv($pr[$i]["updatetime"]) ."</td>";
      echo "   <td><div class=\"btn-group\"><a href=\"admission.php?id=" .
        $pr[$i]["patientadmissionid"] . "#patient\" class=\"btn btn-primary btn-sm\" name=\"\" >Actualizar</a><a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Imprimir</a></div></td>";

      echo "</tr>";
}
echo "</tbody></table>\n";

?>


<!--tabla para pacientes remitidos fin-->




<a id="patient"></a>
<br>
<br>
<br>
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
<input type="hidden" name="padmissionid" id="padmissionid" value="<?php if(isset($pat["patientadmissionid"])) echo $pat["patientadmissionid"];  ?>">
<div class="from-group">


    <div class="row">
      <div class="col-6">
        <font size="2"><span class="text-danger">Todos los campos con * son requeridos</span></font>
      </div>
      <div class="col-6">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            Fecha Hora de registro:
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="datetime-local" id="meeting-time"
       name="meeting-time" value="<?php  if(isset($pat['updatetime'])&&is_numeric($pat['updatetime'])){
         echo datetimeconv($pat['updatetime'],true); }else{echo datetimeconv(time(),true);}?>"
       min="2000-01-01T00:00" max="2100-01-01T00:00" class="form-control">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <label for="patientfullname">Nombres y Apellidos</label><span class="text-danger">*</span>
        <!--<input type="text" name="patientfullname" class="form-control" id="patientfullname" value="<?php //echo $a["username"]; ?>"> readonly="readonly"-->
        <div class="input-group">
          <div class="input-group-prepend">
            <label for="patientname" class="input-group-text">Nombres</label>
            <label for="patientfirstname" class="input-group-text">A. Paterno</label>
            <label for="patientlastname" class="input-group-text">A. Materno</label>
          </div>
          <input type="text" class="form-control" id="patientname" name="patientname" value="<?php if(isset($pat["patientname"])) echo $pat["patientname"];  ?>">
          <input type="text" class="form-control" id="patientfirstname" name="patientfirstname" value="<?php if(isset($pat["patientfirstname"])) echo $pat["patientfirstname"];  ?>">
          <input type="text" class="form-control" id="patientlastname" name="patientlastname" value="<?php if(isset($pat["patientlastname"])) echo $pat["patientlastname"];  ?>">
        </div>
        <div class="dropdown">

          <input type="text" class="dropdown-toggle form-control" name="patientfullname" id="patientfullname" autocomplete="off" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php if(isset($pat["patientfullname"])) echo "readonly onmousedown=\"return false;\""; ?>value="<?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?>"  >

          <div class="dropdown-menu" aria-labelledby="search" id="result">

          </div>

        </div>
      </div>
      <!--modo de registro inicio-->
      <?php
      if(isset($pat)){
      ?>
      <div class="col">
        <br>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="mod" id="modoa" value="update" checked>
          <label class="form-check-label text-primary" for="modoa">
            <b>Actualizar</b>
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="mod" id="modon" value="new">
          <label class="form-check-label text-success" for="modon">
            <b>Nuevo</b>
          </label>
        </div>
      </div>
      <!--modo de registro fin-->
    <?php }?>
    </div>

</div>

<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientdirection">Direccion</label><span class="text-danger">*</span>
      <input type="text" name="patientdirection" class="form-control" id="patientdirection" value="<?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientlocation">Localidad</label><span class="text-danger">*</span>
      <input type="text" name="patientlocation" class="form-control" id="patientlocation" value="<?php if(isset($pat["patientlocation"])) echo $pat["patientlocation"];  ?>">
    </div>
  </div>

</div>
<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientage">Edad</label><span class="text-danger">*</span>
      <input type="text" name="patientage" class="form-control" id="patientage" value="<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientprovenance">Procedencia</label><span class="text-danger">*</span>
      <input type="text" name="patientprovenance" class="form-control" id="patientprovenance" value="<?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"];  ?>">
    </div>
  </div>

</div>
<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientphone">Tel.</label><span class="text-danger">*</span>
      <input type="text" name="patientphone" class="form-control" id="patientphone" maxlength="9" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" value="<?php if(isset($pat["patientphone"])) echo $pat["patientphone"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientgender">Genero</label><span class="text-danger">*</span>
      <select name="patientgender" class="form-select" aria-label="Default select example">
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
      <label for="patientcivilstatus">Estado Civil</label><span class="text-danger">*</span>
      <input type="text" name="patientcivilstatus" class="form-control" id="patientcivilstatus" value="<?php if(isset($pat["patientcivilstatus"])) echo $pat["patientcivilstatus"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientoccupation">Ocupacion</label><span class="text-danger">*</span>
      <input type="text" name="patientoccupation" class="form-control" id="patientoccupation" value="<?php if(isset($pat["patientoccupation"])) echo $pat["patientoccupation"];  ?>">
    </div>
  </div>

</div>
<br>
<div class="from-group">

  <div class="row">
    <div class="col-6">
      <label for="patientnationality">Nacionalidad</label><span class="text-danger">*</span>
      <input type="text" name="patientnationality" class="form-control" id="patientnationality" value="<?php if(isset($pat["patientnationality"])) echo $pat["patientnationality"];  ?>">
    </div>
    <div class="col-6">
      <label for="patientschool">Grado de escolaridad</label><span class="text-danger">*</span>
      <input type="text" name="patientschool" class="form-control" id="patientschool" value="<?php if(isset($pat["patientschool"])) echo $pat["patientschool"];  ?>">
    </div>
  </div>

</div>

<div class="from-group">

  <label for="patientattorney">Apoderado</label>
  <input type="text" name="patientattorney" class="form-control" id="patientattorney" value="<?php if(isset($pat["patientattorney"])) echo $pat["patientattorney"];  ?>">

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
    'Habitos / vicios', 'Otros');

$st=false;
if(isset($pat["patientgmh"])){
    $p=cleanpatientgmh($pat["patientgmh"]);
    $st=true;
}
for ($i=0; $i <count($a) ; $i++) {
  echo "<div class=\"row\">".
       "  <div class=\"col-5\">".
       "    <label class=\"form-check-label\" for=\"yesno$i\">".$a[$i]."</label>".
       "  </div>";

  echo "<div class=\"col-2\">".
       "  <div class=\"form-check form-switch\">";
  //$tt=$p[$i]["status"];
  if($st){
    if ($p[$i]["status"]=="true") {
        echo "    <input class=\"form-check-input\" type=\"checkbox\" id=\"yesno$i\" checked>";
    }else{
        echo "    <input class=\"form-check-input\" type=\"checkbox\" id=\"yesno$i\">";
    }
  }else{
    if (true) {
        echo "    <input class=\"form-check-input\" type=\"checkbox\" id=\"yesno$i\" checked>";
    }else{
        echo "    <input class=\"form-check-input\" type=\"checkbox\" id=\"yesno$i\">";
    }
  }


  echo "  </div>";
  echo "</div>";

  echo "  <div class=\"col-5\">";
  if($st){
    echo "    <input type=\"text\" name=\"obs$i\" class=\"form-control\" id=\"obs$i\" value=\"".$p[$i]["obs"]."\">";
  }else{
    echo "    <input type=\"text\" name=\"obs$i\" class=\"form-control\" id=\"obs$i\" value=\"\">";
  }


       echo "  </div>".
       "</div>";
}

?>

<!--formulario para entecedentes medico general fin-->
        <br>
        <div class="row">
          <u><b>Presion Arterial actual:</b></u>
          <br>
          <div class="col-12">
            <div class="row">
              <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                Sistolica:
              </div>
              <div class="col-lg-2 col-md-2 col-sm-3 col-3">
                <input type="text" class="form-control" name="sistolica" id="sistolica" value="<?php if(isset($pat["sistolica"])) echo $pat["sistolica"];  ?>">
              </div>
              <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                Diastolica:
              </div>
              <div class="col-lg-2 col-md-2 col-sm-3 col-3">
                <input type="text" class="form-control" name="diastolica" id="diastolica" value="<?php if(isset($pat["diastolica"])) echo $pat["diastolica"];  ?>">
              </div>
              <div class="col-lg-2 col-md-3 col-sm-5 col-5">
                mm de mercurio
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Triage
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
<!--contenido del triage inicio-->
<div class="from-group">

  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
      <label for="temperature">Temperatura</label>
      <input type="text" name="temperature" class="form-control" id="temperature" value="<?php  if(isset($pat["triagetemperature"])) echo $pat["triagetemperature"];?>">
    </div>
    <div class="col-lg-1 col-md-1 col-sm-4 col-4">
      <label for="headache">Cefalea</label>
      <?php
      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"headache\" value=\"t\" id=\"headacheyes\" ";
      if(isset($pat["triageheadache"]) && $pat["triageheadache"]=='t') echo "checked";
      echo ">";
      echo "  <label class=\"form-check-label\" for=\"headacheyes\">Si</label>";
      echo "</div>";
      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"headache\" value=\"f\" id=\"headacheno\" ";
      if(isset($pat["triageheadache"]) && $pat["triageheadache"]=='t') echo ">";
      else echo "checked>";
      echo "  <label class=\"form-check-label\" for=\"headacheno\">No</label>";
      echo "</div>";
      ?>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-4 col-4">
      <label for="headache">Dificultad Respiratoria</label>
      <?php
      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"respiratory\" value='t' id=\"respiratoryyes\" ";
      if(isset($pat["triagerespiratory"]) && $pat["triagerespiratory"]=='t') echo "checked";
      echo ">";
      echo "  <label class=\"form-check-label\" for=\"respiratoryyes\">Si</label>";
      echo "</div>";

      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"respiratory\" value='f' id=\"respiratoryno\" ";
      if(isset($pat["triagerespiratory"]) && $pat["triagerespiratory"]=='t') echo ">";
      else echo "checked>";
      echo "  <label class=\"form-check-label\" for=\"respiratoryno\">No</label>";
      echo "</div>";
      ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
      <label for="headache">Dolor de Garganta</label>
      <?php
      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"throat\" value=\"t\" id=\"throatyes\" ";
      if(isset($pat["triagethroat"]) && $pat["triagethroat"]=='t'){
         echo "checked";
      }
      echo ">";
      echo "  <label class=\"form-check-label\" for=\"throatyes\">Si</label>";
      echo "</div>";

      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"throat\" value=\"f\" id=\"throatno\" ";
      if(isset($pat["triagethroat"]) && $pat["triagethroat"]=='t') echo ">";
      else echo "checked>";
      echo "  <label class=\"form-check-label\" for=\"throatno\">No</label>";

      echo "</div>";
      ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
      <label for="headache">Malestar General</label>
      <?php
      //MSGError($pat['triagegeneral']);
      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"general\" value=\"t\" id=\"generalyes\" ";
      if(isset($pat["triagegeneral"]) && $pat["triagegeneral"]=='t'){
          echo "checked";
      }
      echo ">";
      echo "  <label class=\"form-check-label\" for=\"generalyes\">Si</label>";
      echo "</div>";
      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"general\" value=\"f\" id=\"generalno\" ";
      if(isset($pat["triagegeneral"]) && $pat["triagegeneral"]=='t') echo ">";
      else echo "checked>";
      echo "  <label class=\"form-check-label\" for=\"generalno\">No</label>";
      echo "</div>";
      ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
      <label for="headache">Vacuna</label>
      <?php
      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"vaccine\" value=\"1\" id=\"vaccine1\" ";
      if(isset($pat["triagevaccine"]) && $pat["triagevaccine"]=='1') echo "checked";
      echo ">";
      echo "  <label class=\"form-check-label\" for=\"vaccine1\">1ra.</label>";
      echo "</div>";

      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"vaccine\" value=\"2\" id=\"vaccine2\" ";
      if(isset($pat["triagevaccine"]) && $pat["triagevaccine"]=='2') echo "checked";
      echo ">";
      echo "  <label class=\"form-check-label\" for=\"vaccine2\">2da.</label>";
      echo "</div>";

      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"vaccine\" value=\"3\" id=\"vaccine3\" ";
      if(isset($pat["triagevaccine"]) && $pat["triagevaccine"]=='3') echo "checked";
      echo ">";
      echo "  <label class=\"form-check-label\" for=\"vaccine3\">3ra.</label>";
      echo "</div>";

      echo "<div class=\"form-check\">";
      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"vaccine\" value=\"n\" id=\"vaccinen\" ";
      if(isset($pat["triagevaccine"]) && $pat["triagevaccine"]=='n') echo "checked";
      if(!isset($pat["triagevaccine"])) echo "checked";
      echo ">";
      echo "  <label class=\"form-check-label\" for=\"vaccinen\">Ninguna</label>";
      echo "</div>";
      ?>
    </div>
  </div>

</div>
<br>

<!--contenido del triage fin-->
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingFour">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Examen Bucodental
        </button>
      </h2>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">

<!--examen bucodental inicio-->
<div class="from-group">

  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
      <label for="patientgender">Lengua</label>
      <select name="tongue" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentaltongue"] == 'saburra') echo "selected"; ?> value="saburra">Saburral</option>
        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'fisurada') echo "selected"; ?> value="fisurada">Fisurada</option>
        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'geografica') echo "selected"; ?> value="geografica">Geográfica</option>
        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
      </select>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
      <label for="patientgender">Piso de la boca</label>
      <select name="piso" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentalpiso"] == 'toruslingua') echo "selected"; ?> value="toruslingua">Torus Lingua</option>
        <option <?php if(isset($pat) && $pat["dentalpiso"] == 'aparentemente') echo "selected"; ?> value="aparentemente">Aparentemente Normal</option>
      </select>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="encias">Encias</label>
      <select name="encias" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentalencias"] == 'difusa') echo "selected"; ?> value="difusa">Difusa</option>
        <option <?php if(isset($pat) && $pat["dentalencias"] == 'gingivitis') echo "selected"; ?> value="gingivitis">Gingivitis cronoca no complicada</option>
        <option <?php if(isset($pat) && $pat["dentalencias"] == 'papilar') echo "selected"; ?> value="papilar">Papilar</option>
      </select>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="mucosa">Mucosa Bucal</label>
      <select name="mucosa" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentalmucosa"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
        <option <?php if(isset($pat) && $pat["dentalmucosa"] == 'alteracion') echo "selected"; ?> value="alteracion">Con Alteración</option>
      </select>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="occlusion">Tipo de Oclusion</label>
      <select name="occlusion" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentaltypeo"] == 'normo') echo "selected"; ?> value="normo">Normo oclusion</option>
        <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'disto') echo "selected"; ?> value="disto">Disto oclusion</option>
        <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'mesio') echo "selected"; ?> value="mesio">Mesio oclusion</option>
        <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'abierta') echo "selected"; ?> value="abierta">Abierta anterior</option>
      </select>
    </div>
  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
      <label for="occlusion">Tipo de Protesis</label>
      <select name="prosthesis" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentaltypep"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'removible') echo "selected"; ?> value="removible">Removible</option>
        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'fija') echo "selected"; ?> value="fija">Fija</option>
        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'total') echo "selected"; ?> value="total">Total</option>
      </select>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
      <label for="occlusion">Higiene Bucal</label>
      <select name="hygiene" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat) || $pat["dentalhygiene"] == 'regular') echo "selected"; ?> value="regular">Regular</option>
        <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'buena') echo "selected"; ?> value="buena">Buena</option>
        <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'mala') echo "selected"; ?> value="mala">Mala</option>
      </select>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <br><br>
      <label for="lastconsultation"><u><b>Ultima Consulta</b></u></label>
      <input type="text" name="lastconsultation" class="form-control" id="lastconsultation" value="<?php if(isset($pat["lastconsult"])) echo $pat["lastconsult"];  ?>">
      <!--<input type="date" id="lastconsultation" class="form-control"  name="lastconsultation" value="<?php //if(isset($pat["lastconsult"])) echo $pat["lastconsult"];  ?>" min="2015-01-01" max="2099-01-01">-->
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <br><br>
      <label for="consultation"><u><b>Motivo de Consulta</b></u></label>
      <input type="text" name="consultation" class="form-control" id="consultation" value="<?php if(isset($pat["motconsult"])) echo $pat["motconsult"];  ?>">
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

<!--odontograma inicio-->
        <?php
        include("../leftodontogram.php");
        $odontogramstatus="false";
        if (isset($pat['draw'])){
          $odontogramstatus="true";
          $pat=decryptOdontogram($pat);
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
    <div class="card-header" id="headingSix">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
          Historial de la Patologia Actual & Remision
        </button>
      </h2>
    </div>



    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
      <div class="card-body">
<!--inicio finalizacion-->
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-6 col-6">
            <label for="diagnostico"><u><b>Diagnostico presuntivo</b></u></label>
            <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="4"><?php if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?></textarea>
          </div>

          <div class="col-lg-4 col-md-4 col-sm-6 col-6">
            <label for=""><b><u>Remision:</u></b></label>
            <!--onChange="contestch()" -->
            <select id = "clinical"name="clinical" class="form-select" aria-label="Default select example">

            <option value="" selected>--</option>
            <?php
            //DBAllClinicalInfo
            $cs = DBAllClinicalInfo();
            $isfake=true;
            if(isset($pat["clinicalid"])) $isfake=false;
            for ($i=1; $i<count($cs); $i++) {
              echo "<option value=\"" . $cs[$i]["clinicalid"] . "\" ";

              if(!$isfake){
                if ($pat["clinicalid"] == $cs[$i]["clinicalid"]) {
                  echo "selected";
                }
              }
              echo ">" . $cs[$i]["clinicalspecialty"] ."</option>\n";
            }
            ?>
            </select>

          </div>



          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="examinedid"><u><b>Examinado por</b></u></label>

            <div class="dropdown">
              <input type="hidden" name="examinedid" id="examinedid"value="">
              <input type="text" class="dropdown-toggle form-control" autocomplete="off" name="examined" id="examined" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="<?php if(isset($pat["userfullname"])) echo $pat["userfullname"];  ?>">

              <div class="dropdown-menu" aria-labelledby="examined" id="resultstudent">
                <!--<a class="dropdown-item text-primary" href="#" onclick="insert(1,'fabian')">fabian</a>
                <a class="dropdown-item text-primary" href="#" onclick="insert(2,'sierra')">sierra</a>-->
              </div>

            </div>

          </div>
          <br><br><br><br><br>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-6 col-6">
            <button id="patientregister_button" class="btn btn-success" type="button" name="patientregister_button">Enviar Datos</button>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-6">
            <button id="cancel_button" class="btn btn-danger" type="button" name="cancel_button">Cancelar</button>
          </div>
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
        <script src="../assets/graphic/jquery.dataTables.min.js"></script>

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

//examined
function insert(id, val){
    event.preventDefault();
    $('#examinedid').val(id);
    $('#examined').val(val);
}
$(document).ready(function () {
    $('#table_admission').DataTable();
});
$(document).ready(function(){
  $(".write_student").on('click', function(event){
    event.stopPropagation();
    event.stopImmediatePropagation();

    $('#examined').val('grover');
  });

  $("#clinical").change(function(){
    //capturamos valor de campo de texto
      var examined = $('#examined').val()
      var clinical = $('select[name=clinical]').val()
      if(clinical!=NULL){
        $.ajax({
          type: 'POST',
          url: '../include/search.php',
          data: {'examined': examined, 'clinical':clinical},
          beforeSend: function(){
            $('#resultstudent').html('<img src="../images/google.gif">')
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
      }
  });

  //funcion para buscar pacientes
  $('#examined').on('keyup', function(){
    //capturamos valor de campo de texto
      var examined = $('#examined').val()
      var clinical = $('select[name=clinical]').val()

      $.ajax({
        type: 'POST',
        url: '../include/search.php',
        data: {'examined': examined, 'clinical':clinical},
        beforeSend: function(){
          $('#resultstudent').html('<img src="../images/google.gif">')
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

  //shown.bs.collapse
    //para colapso  //hidden.bs.collapse
    $('#collapseOne').on('show.bs.collapse', function () {
        alert("colapso");
    })
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

     //funcion para buscar pacientes
     $('#patientfullname').on('keyup', function(){
       //capturamos valor de campo de texto
         var search = $('#patientfullname').val()

         $.ajax({
           type: 'POST',
           url: '../include/search.php',
           data: {'search': search},
           beforeSend: function(){
             $('#result').html('<img src="../images/google.gif">')
           }
         })
         .done(function(resultado){
           //div para mostrar resultado
           $('#result').html(resultado)
         })
         .fail(function(){
           //alerta para un error
           alert('Hubo un error :(')
         })

     })

     var info='';
     //funcion para registrar datos del paciente
     function registerpatient(){

       var padmissionid = $('#padmissionid').val();
       //var patientfullname = $('#patientfullname').val();
       var patientname = $('#patientname').val();
       var patientfirstname = $('#patientfirstname').val();
       var patientlastname = $('#patientlastname').val();

       var patientdirection = $('#patientdirection').val();
       var patientlocation = $('#patientlocation').val();
       var patientage = $('#patientage').val();
       var patientprovenance = $('#patientprovenance').val();
       var patientphone = $('#patientphone').val();
       var patientgender = $('select[name=patientgender]').val();//$('#patientgender').val();
       var patientcivilstatus = $('#patientcivilstatus').val();
       var patientoccupation = $('#patientoccupation').val();
       var patientnationality = $('#patientnationality').val();
       var patientschool = $('#patientschool').val();
       var patientattorney = $('#patientattorney').val();

       //variables de antecedentes medico general
       var yesno0 = $('#yesno0').prop('checked'),yesno1 = $('#yesno1').prop('checked'),yesno2 = $('#yesno2').prop('checked'),yesno3 = $('#yesno3').prop('checked');
       var yesno4 = $('#yesno4').prop('checked'),yesno5 = $('#yesno5').prop('checked'),yesno6 = $('#yesno6').prop('checked'),yesno7 = $('#yesno7').prop('checked');
       var yesno8 = $('#yesno8').prop('checked'),yesno9 = $('#yesno9').prop('checked'),yesno10 = $('#yesno10').prop('checked'),yesno11 = $('#yesno11').prop('checked');
       var yesno12 = $('#yesno12').prop('checked'),yesno13 = $('#yesno13').prop('checked');

       var obs0 = $('#obs0').val(),obs1 = $('#obs1').val(),obs2 = $('#obs2').val(),obs3 = $('#obs3').val();
       var obs4 = $('#obs4').val(),obs5 = $('#obs5').val(),obs6 = $('#obs6').val(),obs7 = $('#obs7').val();
       var obs8 = $('#obs8').val(),obs9 = $('#obs9').val(),obs10 = $('#obs10').val(),obs11 = $('#obs11').val();
       var obs12 = $('#obs12').val(),obs13 = $('#obs13').val();

       var sistolica = $('#sistolica').val();
       var diastolica = $('#diastolica').val();

       //patient triage
       var temperature = $('#temperature').val();
       var headache = $('input:radio[name=headache]:checked').val();
       var respiratory = $('input:radio[name=respiratory]:checked').val();
       var throat = $('input:radio[name=throat]:checked').val();
       var general = $('input:radio[name=general]:checked').val();
       var vaccine = $('input:radio[name=vaccine]:checked').val();

       //exam buco dental
       var tongue = $('select[name=tongue]').val();// $('select[name=tongue]').val();// $('input:radio[name=tongue]:checked').val();
       var piso = $('select[name=piso]').val();// $('input:radio[name=piso]:checked').val();
       var encias = $('select[name=encias]').val();// $('input:radio[name=encias]:checked').val();
       var mucosa = $('select[name=mucosa]').val();// $('input:radio[name=mucosa]:checked').val();
       var occlusion = $('select[name=occlusion]').val();// $('input:radio[name=occlusion]:checked').val();
       var prosthesis = $('select[name=prosthesis]').val();// $('input:radio[name=prosthesis]:checked').val();
       var hygiene = $('select[name=hygiene]').val();// $('input:radio[name=hygiene]:checked').val();

       var lastconsultation = $('#lastconsultation').val();
       var consultation = $('#consultation').val();
       //alert(tongue);

       //datos del odontograma
       var tr = $('#tr').html();
       var tl = $('#tl').html();
       var tlr = $('#tlr').html();
       var tll = $('#tll').html();
       var bl = $('#bl').html();
       var br = $('#br').html();
       var bll = $('#bll').html();
       var blr = $('#blr').html();
       //datos del examinado
       var diagnostico = $('#diagnostico').val();
       var clinical = $('select[name=clinical]').val();
       var examined = $('#examined').val();
       var examinedid = $('#examinedid').val();

       //variable para el modo de registro
       var mod = $('input:radio[name=mod]:checked').val();

       var odontodiagnostico = $('#areadiagnostico').val();
       var odontodraw = $('#draw').val();
       var meeting_time=$('#meeting-time').val();

       if(mod=== undefined)
          mod="new";
       //alert(mod);
       if(patientgender=='--'){
         alert("Debe seleccionar genero.");
         return false;
       }

       if(patientdirection.trim()==''){
         alert("Debe completar campo direccion.");
         return false;
       }

       if(patientlocation.trim()==''){
         alert("Debe completar campo localidad.");
         return false;
       }
       if(patientage.trim()==''){
         alert("Debe completar campo edad.");
         return false;
       }
       if(patientprovenance.trim()==''){
         alert("Debe completar campo procedencia.");
         return false;
       }
       if(patientphone.trim()==''){
         alert("Debe completar campo telefono.");
         return false;
       }
       if(patientoccupation.trim()==''){
         alert("Debe completar campo ocupación.");
         return false;
       }
       if(patientnationality.trim()==''){
         alert("Debe completar campo nacionalidad.");
         return false;
       }
       if(patientschool.trim()==''){
         alert("Debe completar campo grado de escolaridad.");
         return false;
       }
       if(patientcivilstatus.trim()==''){
         alert("Debe completar campo estado civil.");
         return false;
       }
       if(patientfullname != ''){
           $.ajax({
              url:"../include/i_patientadmission.php",
              method:"POST",
              data: {mod:mod, padmissionid:padmissionid, patientname:patientname,
       patientfirstname:patientfirstname, patientlastname:patientlastname, patientdirection:patientdirection, patientlocation:patientlocation, patientage:patientage, patientprovenance:patientprovenance,
                patientphone:patientphone, patientgender:patientgender, patientcivilstatus:patientcivilstatus, patientoccupation:patientoccupation, patientnationality:patientnationality,
                patientschool:patientschool, patientattorney:patientattorney, yesno0:yesno0, yesno1:yesno1, yesno2:yesno2, yesno3:yesno3, yesno4:yesno4, yesno5:yesno5, yesno6:yesno6,
                yesno7:yesno7, yesno8:yesno8, yesno9:yesno9, yesno10:yesno10, yesno11:yesno11, yesno12:yesno12, yesno13:yesno13,
                obs0:obs0, obs1:obs1, obs2:obs2, obs3:obs3, obs4:obs4, obs5:obs5, obs6:obs6, obs7:obs7, obs8:obs8, obs9:obs9, obs10:obs10, obs11:obs11, obs12:obs12, obs13:obs13, sistolica:sistolica, diastolica:diastolica,
                temperature:temperature, headache:headache, respiratory:respiratory, throat:throat, general:general, vaccine:vaccine,
                tongue:tongue, piso:piso, encias:encias, mucosa:mucosa, occlusion:occlusion,
                prosthesis:prosthesis, hygiene:hygiene, lastconsultation:lastconsultation, consultation:consultation,
                tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr,
                diagnostico:diagnostico, clinical:clinical, examined:examined, examinedid:examinedid, odontodiagnostico:odontodiagnostico, odontodraw:odontodraw, meeting_time:meeting_time},

              success:function(data)
              {

                if(data=='yes'){
                  alert('Se guardó los datos del paciente');
                  location.href="admission.php";
                }else{
                  alert(data);
                  console.log(data);
                }
              }
           });

       }else{
         alert('debe completar al menos nombres y apellidos');
       }
     }
     //register triage

     function registertriage(){

       var patientid = $('#patientid').val();
       var patientfullname = $('#patientfullname').val();


       var temperature = $('#temperature').val();
       var headache = $('input:radio[name=headache]:checked').val();
       var respiratory = $('input:radio[name=respiratory]:checked').val();
       var throat = $('input:radio[name=throat]:checked').val();
       var general = $('input:radio[name=general]:checked').val();
       var vaccine = $('input:radio[name=vaccine]:checked').val();
       if(patientfullname != ''){


           $.ajax({

              url:"../include/i_patientadmission.php",
              method:"POST",
              data: {id:patientid, fullname:patientfullname, temperature:temperature, headache:headache, respiratory:respiratory, throat:throat, general:general, vaccine:vaccine},

              success:function(data)
              {
                 //alert(data+'triage');
                 console.log(data);
              }

           });

       }else{
         alert('debe completar al menos nombres y apellidos');
       }

     }
     //dental
     function registerdental(){

       var patientid = $('#patientid').val();
       var patientfullname = $('#patientfullname').val();

       var tongue = $('input:radio[name=tongue]:checked').val();
       var piso = $('input:radio[name=piso]:checked').val();
       var encias = $('input:radio[name=encias]:checked').val();
       var mucosa = $('input:radio[name=mucosa]:checked').val();
       var occlusion = $('input:radio[name=occlusion]:checked').val();
       var prosthesis = $('input:radio[name=prosthesis]:checked').val();
       var hygiene = $('input:radio[name=hygiene]:checked').val();

       var lastconsultation = $('#lastconsultation').val();
       var consultation = $('#consultation').val();
       //alert(tongue);
       if(patientfullname != ''){
           $.ajax({

              url:"../include/i_patientadmission.php",
              method:"POST",
              data: {id:patientid, fullname:patientfullname,tongue:tongue, piso:piso, encias:encias, mucosa:mucosa, occlusion:occlusion,
                prosthesis:prosthesis, hygiene:hygiene, lastconsultation:lastconsultation, consultation:consultation},

              success:function(data)
              {
                 //alert(data+'dental');
                 console.log(data);
              }

           });

       }else{
         alert('debe completar al menos nombres y apellidos');
       }

     }
     //diagnostico
     //clinical
     function registerremision(){

       var patientid = $('#patientid').val();
       var patientfullname = $('#patientfullname').val();

       var diagnostico = $('#diagnostico').val();
       var clinical = $('select[name=clinical]').val();
       var examined = $('#examined').val();
       var examinedid = $('#examinedid').val();
       if(patientfullname != ''){
           $.ajax({

              url:"../include/i_patientadmission.php",
              method:"POST",
              data: {id:patientid, fullname:patientfullname, diagnostico:diagnostico, clinical:clinical, examined:examined, examinedid:examinedid},

              success:function(data)
              {
                if(data==''){
                  alert('Se registro de los datos del paciente');
                  location.href="admission.php";
                }else{
                  alert(data);
                  console.log(data);
                }
              }

           });

       }else{
         alert('debe completar al menos nombres y apellidos');
       }
     }
/*
function obten(){
  var x = $('#tr').html();
  alert(x);
}
*/
    function registerodontogram(){

      var patientid = $('#patientid').val();
      var patientfullname = $('#patientfullname').val();

      var tr = $('#tr').html();
      var tl = $('#tl').html();
      var tlr = $('#tlr').html();
      var tll = $('#tll').html();
      var bl = $('#bl').html();
      var br = $('#br').html();
      var bll = $('#bll').html();
      var blr = $('#blr').html();

      if(patientfullname != ''){
          $.ajax({

             url:"../include/i_patientadmission.php",
             method:"POST",
             data: {id:patientid, fullname:patientfullname, tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr},

             success:function(data)
             {
                console.log(data);
             }
          });
      }else{
        alert('debe completar al menos nombres y apellidos');
      }
    }
    //register patient
    $('#patientregister_button').click(function(){
      if (confirm("Registar todos los datos del paciente?")) {
        if ($('#patientname').val()==="" || $('#patientfirtname').val()==="" || $('#patientlastname').val()==="") {
          alert('deben completarse el nombre del paciente');
        }else{
          var clinical = $('select[name=clinical]').val();
          var examined = $('#examined').val();
          if(clinical!=""&&examined!=""){
            $.ajax({
               url:"../include/i_patientadmission.php",
               method:"POST",
               data: {designed:clinical, student:examined},
               success:function(data)
               {
                  if(data == 'yes'){
                    registerpatient();
                  }else{
                    alert(data);
                  }
               }
            });
          }else{
            registerpatient();
          }

        }
      }else{
          location.reload();
      }
    });

});
</script>


<script>
$(document).ready(function(){
    $(".btn-primary").click(function(){
        $(".fffa").collapse('toggle');
    });
    $(".btn-success").click(function(){
        $(".fffa").collapse('show');
    });
    $(".btn-warning").click(function(){
        $(".fffa").collapse('hide');
    });
    $(".fffa").on('show.bs.collapse', function(){
        alert('The collapsible content is about to be shown.');
    });
    $(".fffa").on('shown.bs.collapse', function(){
        alert('The collapsible content is now fully shown.');
    });
    $(".fffa").on('hide.bs.collapse', function(){
        alert('The collapsible content is about to be hidden.');
    });
    $(".fffa").on('hidden.bs.collapse', function(){
        alert('The collapsible content is now hidden.');
    });
    $(".sierra").on('hide.bs.collapse', function(){
        alert('The collapsible content is about to be hidden.');
    });
    $(".sierra").on('hidden.bs.collapse', function(){
        alert('The collapsible content is now hidden.');
    });
});
</script>
<!--fin collapse-->
