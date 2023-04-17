<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBOrthodonticsInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=8&&$pat["clinicalid"]!=16)
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
                        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==16){
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica de Ortodoncia II</h2>";
                        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==8) {
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica de Ortodoncia I</h2>";
                        }else{
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica de Ortodoncia</h2>";
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['orthodonticsstatus'])&&$pat['orthodonticsstatus']!='fail'){
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['orthodonticsstatus'])&&$pat['orthodonticsstatus']=='fail'){
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
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==16){
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;5to. Año</label> </label>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==8) {
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;4to. Año</label> </label>";
        }else{
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">..................</label> </label>";
        }
        ?>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for=""><b>Gestión:</b></label>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-8 col-8">
            <select name="year" class="form-select" aria-label="Default select example">
              <?php
              $Year = date("Y");
              $ac='';
              $nyes=true;
              $ac.= "<option";
              if(!isset($pat["pediatricsiyear"]) || $pat["pediatricsiyear"] == '' || $pat['pediatricsiyear']==$Year){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".$Year."\">".$Year."</option>\n";
              $ac.= "<option";
              if(isset($pat["pediatricsiyear"]) && $pat["pediatricsiyear"] == $Year-1){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-1)."\">".($Year-1)."</option>\n";
              $ac.= "<option";
              if(isset($pat["pediatricsiyear"]) && $pat["pediatricsiyear"] == $Year-2){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-2)."\">".($Year-2)."</option>\n";


              if($nyes&& isset($pat['pediatricsiyear'])&&$pat['pediatricsiyear']!=''){
                $ac.="<option selected value=\"".$pat['pediatricsiyear']."\">".$pat['pediatricsiyear']."</option>\n";
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
      <label for="patientfullname"><b>Paciente:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?></label><br>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientage"><b>Edad:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-4 col-6">
        <label for="patientgender"><b>Género:</b>&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
          if(!isset($pat) || $pat["patientgender"] == '--') echo "indefinido";
          if(isset($pat) && $pat["patientgender"] == 'masculino') echo "Masculino";
          if(isset($pat) && $pat["patientgender"] == 'femenino') echo "Femenino";
          ?>
        </label>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientattorney"><b>Apoderado:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientattorney"])) echo $pat["patientattorney"];  ?></label>
      </div>

    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientdirection"><b>Dirección:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"];  ?></label>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientphone"><b>Teléfono:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientphone"])) echo $pat["patientphone"];  ?></label>
      </div>
    </div>
    <div class="" align="center">
      <b><u>ANAMNESIS</u></b>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <label for=""><b>Motivo de la Consulta</b></label>
        <textarea class="form-control" name="motconsult" id="motconsult"rows="4"><?php if(isset($pat["orthodonticsmotconsult"])&& $pat["orthodonticsmotconsult"]!=''){ echo $pat["orthodonticsmotconsult"];}else{echo $pat["motconsult"];}  ?></textarea>

      </div>
      <div class="col-lg-5 col-md-5 col-sm-12 col-12">
        <br>
        <select name="alteration" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["orthodonticsalterations"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat) && $pat["orthodonticsalterations"] == 'esthetic') echo "selected"; ?> value="esthetic">Alteraciones de la estética dentofacial</option>
          <option <?php if(isset($pat) && $pat["orthodonticsalterations"] == 'functional') echo "selected"; ?> value="functional">Alteraciones Funcionales</option>

        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12 col-12">
        <label for="patientdatebirth"><b>Antecedentes Hereditarios:</b></label>
        <input type="text" class="form-control" name="hereditary" id="hereditary" value="<?php if(isset($pat["orthodonticshereditary"])) echo $pat["orthodonticshereditary"];  ?>">

      </div>
    </div>
    <div class="">
      <u> <b>ANTECENTES PERSONALES.</b> </u>
    </div>
    <br>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12 col-12">
        <label for=""><b>Estado Nutricional</b></label>
        <input type="text" class="form-control" name="nutritional" id="nutritional" value="<?php if(isset($pat["orthodonticsnutritional"])) echo $pat["orthodonticsnutritional"];  ?>">
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <label for="patientdatebirth"><b>Lactancia:</b></label>
          <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-6">
              <select name="tipolactancia" class="form-select" aria-label="Default select example">
                <option <?php if(!isset($pat["tipolactancia"]) || $pat["tipolactancia"] == '') echo "selected"; ?> value="">--</option>
                <option <?php if(isset($pat["tipolactancia"]) && $pat["tipolactancia"] == 'seno') echo "selected"; ?> value="seno">Seno materno</option>
                <option <?php if(isset($pat["tipolactancia"]) && $pat["tipolactancia"] == 'biberon') echo "selected"; ?> value="biberon">Biberón</option>
              </select>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-6">
              <input type="text" class="form-control" name="duracionlactancia" placeholder="duración lactancia" id="duracionlactancia" value="<?php if(isset($pat["duracionlactancia"])) echo $pat["duracionlactancia"];  ?>">
            </div>
          </div>

      </div>
      <div class="col-lg-3 col-md-3 col-sm-12 col-12">
          <label for=""><b>Enfermedades Infecciosas</b></label>
          <input type="text" class="form-control" name="diseases" id="diseases" value="<?php if(isset($pat["orthodonticsdiseases"])) echo $pat["orthodonticsdiseases"];  ?>">
      </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <label for=""><b>Tratamientos Farmacológicos:</b></label>
          <input type="text" class="form-control" name="treatments" id="treatments" value="<?php if(isset($pat["orthodonticstreatments"])) echo $pat["orthodonticstreatments"];  ?>">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <label for=""><b>Antecedentes Odontológicos de Importacia:</b></label>
          <input type="text" class="form-control" name="importance" id="importance" value="<?php if(isset($pat["orthodonticsimportance"])) echo $pat["orthodonticsimportance"];  ?>">

        </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for=""><b>Malos Hábitos:</b></label>
        <input type="text" class="form-control" name="badhabits" id="badhabits" value="<?php if(isset($pat["orthodonticsbadhabits"])) echo $pat["orthodonticsbadhabits"];  ?>">

      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for=""><b>Traumatismo:</b></label>
        <input type="text" class="form-control" name="trauma" id="trauma" value="<?php if(isset($pat["orthodonticstrauma"])) echo $pat["orthodonticstrauma"];  ?>">
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for=""><b>Tipo de Respirador:</b></label>
        <select name="respirator" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["orthodonticsrespirator"]) || $pat["orthodonticsrespirator"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["orthodonticsrespirator"]) && $pat["orthodonticsrespirator"] == 'nasal') echo "selected"; ?> value="nasal">Nasal</option>
          <option <?php if(isset($pat["orthodonticsrespirator"]) && $pat["orthodonticsrespirator"] == 'bucal') echo "selected"; ?> value="bucal">Bucal</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for=""><b>Erupción de la Dentición:</b></label>
        <select name="eruption" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["orthodonticseruption"]) || $pat["orthodonticseruption"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["orthodonticseruption"]) && $pat["orthodonticseruption"] == 'normal') echo "selected"; ?> value="normal">Normal</option>
          <option <?php if(isset($pat["orthodonticseruption"]) && $pat["orthodonticseruption"] == 'precoz') echo "selected"; ?> value="bucal">Precoz</option>
          <option <?php if(isset($pat["orthodonticseruption"]) && $pat["orthodonticseruption"] == 'tardia') echo "selected"; ?> value="tardia">Tardía</option>
        </select>
      </div>
    </div>
    <br>
    <div class="" align="center" >
      <u><b>EXAMEN CLÍNICO</b></u>
    </div>
    <br>
    <div class="">
      <b>EXAMEN FACIAL:</b>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="" class="d-block">FRONTAL</label>
        <select name="faces" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalfaces"] == 'simetrico') echo "selected"; ?> value="simetrico">Simétrico</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'asimetrico') echo "selected"; ?> value="asimetrico">Asimétrico</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="profile">Perfil</label>
        <select name="profile" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalprofile"] == 'recto') echo "selected"; ?> value="recto">Recto</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'concavo') echo "selected"; ?> value="concavo">Cóncavo</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'convexo') echo "selected"; ?> value="convexo">Cónvexo</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="liprelation">Relación Labial</label>
        <select name="liprelation" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["dentallips"]) || $pat["dentallips"] == 'aceptable') echo "selected"; ?> value="aceptable">Aceptable</option>
          <option <?php if(isset($pat["dentallips"]) && $pat["dentallips"] == 'prominente') echo "selected"; ?> value="prominente">Prominente</option>
          <option <?php if(isset($pat["dentallips"]) && $pat["dentallips"] == 'retraido') echo "selected"; ?> value="retraido">Retraido</option>
        </select>
      </div>
    </div>
    <br>
    <div class="">
      <b>EXAMEN INTRA BUCAL:</b>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <label for="mucosa">Mucosa</label>
        <select name="mucosa" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalmucosa"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalmucosa"] == 'alteracion') echo "selected"; ?> value="alteracion">Con Alteración</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <label for="encias">Encias</label>
        <select name="encias" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalencias"] == 'difusa') echo "selected"; ?> value="difusa">Gingivitis Difusa</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'aguda') echo "selected"; ?> value="aguda">Gingivitis Aguda</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'gingivitis') echo "selected"; ?> value="gingivitis">Gingivitis cronoca no complicada</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'papilar') echo "selected"; ?> value="papilar">Papilar</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'guna') echo "selected"; ?> value="guna">G.U.N.A</option>
          <option <?php if(isset($pat) && $pat["dentalencias"] == 'hiperplasia') echo "selected"; ?> value="hiperplasia">Hiperplasia gingival</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 col-12">
        <label for="">Inserción y Forma de Frenillos</label>
        <input type="text" class="form-control" name="braces" id="braces" value="<?php if(isset($pat["dentalbraces"])) echo $pat["dentalbraces"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="palatine">Bóveda Palatina</label>
        <select name="palatine" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["dentalpalatine"]) || $pat["dentalpalatine"] == 'normal') echo "selected"; ?> value="normal">Normal</option>
          <option <?php if(isset($pat["dentalpalatine"]) && $pat["dentalpalatine"] == 'profundo') echo "selected"; ?> value="profunda">Profunda</option>
          <option <?php if(isset($pat["dentalpalatine"]) && $pat["dentalpalatine"] == 'plana') echo "selected"; ?> value="plana">Plana</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="tongue">Lengua</label>
        <select id="tongue" name="tongue" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentaltongue"] == 'fisurada') echo "selected"; ?> value="fisurada">Fisurada</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'saburra') echo "selected"; ?> value="saburra">Saburra</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'geografica') echo "selected"; ?> value="geografica">Geográfica</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
        </select>
      </div>

    </div>

    <br>
    <div class="">
      <b>ARCADA:</b>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="forma">Forma:</label>
        <input type="text" class="form-control" name="forma" id="forma" value="<?php if(isset($pat["forma"])) echo $pat["forma"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="tamano">Tamaño:</label>
        <input type="text" class="form-control" name="tamano" id="tamano" value="<?php if(isset($pat["tamano"])) echo $pat["tamano"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="forma">Simetría:</label>
        <input type="text" class="form-control" name="simetria" id="simetria" value="<?php if(isset($pat["simetria"])) echo $pat["simetria"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="dentition">Tipo de Dentición</label>
        <select id="dentition" name="dentition" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["orthodonticsdentition"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat) && $pat["orthodonticsdentition"] == 'temporaria') echo "selected"; ?> value="temporaria">Temporaria</option>
          <option <?php if(isset($pat) && $pat["orthodonticsdentition"] == 'permanente') echo "selected"; ?> value="permanente">Permanente</option>
          <option <?php if(isset($pat) && $pat["orthodonticsdentition"] == 'mixta') echo "selected"; ?> value="mixta">Mixta</option>
        </select>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="tipoausente">Piezas Aucentes por:</label>
        <br>
        <select id="tipoausente" name="tipoausente" style="width:45%;" class="form-select d-inline" aria-label="Default select example">
          <option <?php if(!isset($pat["tipoausente"]) || $pat["tipoausente"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat["tipoausente"]) && $pat["tipoausente"] == 'avulsion') echo "selected"; ?> value="avulsion">Avulsión</option>
          <option <?php if(isset($pat["tipoausente"]) && $pat["tipoausente"] == 'aplasia') echo "selected"; ?> value="aplasia">Aplasia</option>
        </select>
        <input type="text" class="form-control d-inline" name="piezaausente" style="width:50%;" id="piezaausente" value="<?php if(isset($pat["piezaausente"])) echo $pat["piezaausente"]; ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="cavities">Piezas con Caries</label>
        <input type="text" class="form-control" name="cavities" id="cavities" value="<?php if(isset($pat["orthodonticscavities"])) echo $pat["orthodonticscavities"]; ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="included">Dientes Incluidos</label>
        <input type="text" class="form-control" name="included" id="included" value="<?php if(isset($pat["orthodonticsincluded"])) echo $pat["orthodonticsincluded"]; ?>">

      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="retained">Dientes Retenidos</label>
        <input type="text" class="form-control" name="retained" id="retained" value="<?php if(isset($pat["orthodonticsretained"])) echo $pat["orthodonticsretained"]; ?>">

      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="numerous">Dientes Súpernumerarios</label>
        <input type="text" class="form-control" name="numerous" id="numerous" value="<?php if(isset($pat["orthodonticsnumerous"])) echo $pat["orthodonticsnumerous"]; ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="sealed">Dientes Obturados</label>
        <input type="text" class="form-control" name="sealed" id="sealed" value="<?php if(isset($pat["orthodonticssealed"])) echo $pat["orthodonticssealed"]; ?>">

      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="rebuilt">Dientes Reconstruidos</label>
        <input type="text" class="form-control" name="rebuilt" id="rebuilt" value="<?php if(isset($pat["orthodonticsrebuilt"])) echo $pat["orthodonticsrebuilt"]; ?>">

      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="endodontics">Dientes Con Endodoncia</label>
        <input type="text" class="form-control" name="endodontics" id="endodontics" value="<?php if(isset($pat["orthodonticsendodontics"])) echo $pat["orthodonticsendodontics"]; ?>">

      </div>
    </div>
    <br>
  <!--</div>-->
</div>
<hr>

<div class="border border-primary rounded"><!--container-->
  <div class="row" align="center">
    <b> <u>Gráfico</u> </b>

  </div>
  <div class="row">
    <div class="col-12">
      <!--script para cargar al inicio-->
      <?php
      $srcgram='../images/ortodonciagram.png';
      if(isset($pat['orthodonticsgram'])&& $pat['orthodonticsgram']!=''){
        $srcgram=$pat['orthodonticsgram'];
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
            <input class="form-check-input" title="Azul" type="radio" name="options" id="options1" onchange="ChangeColor();" checked>
            <label class="form-check-label" for="options1">
              <span class="text-primary" title="Azul"><b>Azul</b></span>
            </label>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-6" >
          <div class="form-check" id="rojo">
            <input class="form-check-input" title="Rojo" type="radio" name="options" id="options2" onchange="ChangeColor();">
            <label class="form-check-label" for="options2">
              <span class="text-danger" title="Rojo"><b>Rojo</b></span>
            </label>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-6">
          <div class="form-check" id="verde">
            <input class="form-check-input" title="Verde" type="radio" name="options" id="options3" onchange="ChangeColor();">
            <label class="form-check-label" for="options3">
              <span class="text-success" title="Verde"><b>Verde</b></span>
            </label>
          </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-4 col-6">
          <div class="form-check" id="negro">
            <input class="form-check-input" title="Negro" type="radio" name="options" id="options4" onchange="ChangeColor();">
            <label class="form-check-label" title="Negro" for="options4">
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
        <div class="col-12">
          <!-- creamos el camvas -->
          <canvas id='canvas' width="950" class="img-fluid" height="450" style='border: 1px solid #CCC;'>
              <p>Tu navegador no soporta canvas</p>
          </canvas>
          <!-- creamos el form para el envio -->
          <form id='formCanvas' method='post' action='#' ENCTYPE='multipart/form-data'>
              <button type='button' onclick='LimpiarTrazado()'>Borrar</button>
              <!--<button type='button' onclick='GuardarTrazado()'>Guardar</button>-->
              <?php

              if(((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') &&
               (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&
               isset($pat['orthodonticsstatus'])&&$pat['orthodonticsstatus']!='fail'&&
               $pat['orthodonticsstatus']!='canceled') || !isset($pat['observationaccepted'])){
                echo "<button type=\"button\" name=\"gram_button\" id=\"gram_button\">Guardar</button>";
              }
              ?>
              <button type='button' onclick='DescargarTrazado()'>Descargar</button>
              <input type='hidden' name='imagen' id='imagen' />
              <input type="file" id="seleccionArchivos" accept="image/*">
              <button type='button' style="display: none;" id="tomarfoto" data-toggle="modal" data-target="#modaltomarfoto">Tomar Foto</button>

          </form>

          <!--para sacar foto modal inicio-->
          <!-- Large modal -->

          <!-- Large modal -->
          <div class="modal fade" id="modaltomarfoto" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Foto Gram</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <style>
                    @media only screen and (max-width: 700px) {
                      video {
                        max-width: 100%;
                      }
                    }
                  </style>
                  <h1>Tomar foto con JavaScript v3.0</h1>
                  <h1>Selecciona un dispositivo</h1>
                  <div>
                    <select name="listaDeDispositivos" id="listaDeDispositivos"></select>
                    <button id="boton">Tomar foto</button>
                    <p id="estado"></p>
                  </div>
                  <br>
                  <video muted="muted" id="video"></video><!--width="950" class="img-fluid" height="450"-->
                  <!--<canvas id="canvas" style="display: none;"></canvas>-->
                  <script>
                  const $tomarfoto = document.querySelector("#tomarfoto");
                  $tomarfoto.addEventListener("click", function () {

                  function tieneSoporteUserMedia() {
                    return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
                  }
                  function _getUserMedia() {
                    return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
                  }

                  // Declaramos elementos del DOM
                  const $video = document.querySelector("#video"),
                  $canvas = document.querySelector("#canvas"),
                  $boton = document.querySelector("#boton"),
                  $estado = document.querySelector("#estado"),
                  $listaDeDispositivos = document.querySelector("#listaDeDispositivos");

                  // La función que es llamada después de que ya se dieron los permisos
                  // Lo que hace es llenar el select con los dispositivos obtenidos
                  const llenarSelectConDispositivosDisponibles = () => {

                  navigator
                    .mediaDevices
                    .enumerateDevices()
                    .then(function (dispositivos) {
                      const dispositivosDeVideo = [];
                      dispositivos.forEach(function (dispositivo) {
                        const tipo = dispositivo.kind;
                        if (tipo === "videoinput") {
                          dispositivosDeVideo.push(dispositivo);
                        }
                      });

                      // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                      if (dispositivosDeVideo.length > 0) {
                        // Llenar el select
                        dispositivosDeVideo.forEach(dispositivo => {
                          const option = document.createElement('option');
                          option.value = dispositivo.deviceId;
                          option.text = dispositivo.label;
                          $listaDeDispositivos.appendChild(option);
                          console.log("$listaDeDispositivos => ", $listaDeDispositivos)
                        });
                      }
                    });
                  }

                  (function () {
                  // Comenzamos viendo si tiene soporte, si no, nos detenemos
                  if (!tieneSoporteUserMedia()) {
                    alert("Lo siento. Tu navegador no soporta esta característica");
                    $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
                    return;
                  }
                  //Aquí guardaremos el stream globalmente
                  let stream;


                  // Comenzamos pidiendo los dispositivos
                  navigator
                    .mediaDevices
                    .enumerateDevices()
                    .then(function (dispositivos) {
                      // Vamos a filtrarlos y guardar aquí los de vídeo
                      const dispositivosDeVideo = [];

                      // Recorrer y filtrar
                      dispositivos.forEach(function (dispositivo) {
                        const tipo = dispositivo.kind;
                        if (tipo === "videoinput") {
                          dispositivosDeVideo.push(dispositivo);
                        }
                      });

                      // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                      // y le pasamos el id de dispositivo
                      if (dispositivosDeVideo.length > 0) {
                        // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                        mostrarStream(dispositivosDeVideo[0].deviceId);
                      }
                    });



                  const mostrarStream = idDeDispositivo => {
                    _getUserMedia(
                      {
                        video: {
                          // Justo aquí indicamos cuál dispositivo usar
                          deviceId: idDeDispositivo,
                        }
                      },
                      function (streamObtenido) {
                        // Aquí ya tenemos permisos, ahora sí llenamos el select,
                        // pues si no, no nos daría el nombre de los dispositivos
                        llenarSelectConDispositivosDisponibles();

                        // Escuchar cuando seleccionen otra opción y entonces llamar a esta función
                        $listaDeDispositivos.onchange = () => {
                          // Detener el stream
                          if (stream) {
                            stream.getTracks().forEach(function (track) {
                              track.stop();
                            });
                          }
                          // Mostrar el nuevo stream con el dispositivo seleccionado
                          mostrarStream($listaDeDispositivos.value);
                        }

                        // Simple asignación
                        stream = streamObtenido;

                        // Mandamos el stream de la cámara al elemento de vídeo
                        //$video.videoWidth="900";
                        //$video.videoHeight="600";
                        $video.srcObject = stream;
                        $video.play();
                        console.log($video.videoWidth);
                        console.log($video.videoHeight);
                        //Escuchar el click del botón para tomar la foto
                        $boton.addEventListener("click", function () {

                          //Pausar reproducción
                          $video.pause();

                          //Obtener contexto del canvas y dibujar sobre él
                          let contexto = $canvas.getContext("2d");
                          $canvas.width = "950";//$video.videoWidth;
                          $canvas.height = "450";//$video.videoHeight;
                          contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                          /*let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
                          $estado.innerHTML = "Enviando foto. Por favor, espera...";
                          fetch("./guardar_foto.php", {
                            method: "POST",
                            body: encodeURIComponent(foto),
                            headers: {
                              "Content-type": "application/x-www-form-urlencoded",
                            }
                          })
                            .then(resultado => {
                              // A los datos los decodificamos como texto plano
                              return resultado.text()
                            })
                            .then(nombreDeLaFoto => {
                              // nombreDeLaFoto trae el nombre de la imagen que le dio PHP
                              console.log("La foto fue enviada correctamente");
                              $estado.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./${nombreDeLaFoto}'> aquí</a>`;
                            })*/

                          //Reanudar reproducción
                          $video.play();
                          //$video.stop();
                        });
                      }, function (error) {
                        console.log("Permiso denegado o error: ", error);
                        $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
                      });
                  }
                  })();

                  });
                  </script>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Send message</button>
                </div>
              </div>
            </div>
          </div>
          <!--para sacar foto modal fin-->
        </div>
      </div>

      <!--grafico fin-->
      <!--script en la final-->
      <script type="text/javascript">
          /* Variables de Configuracion */
          var idCanvas='canvas';
          var idForm='formCanvas';
          var inputImagen='imagen';
          var estiloDelCursor='default';//'crosshair';
          var colorDelTrazo='#0000ff';//555
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
              type=true;
              estiloDelCursor='default';//'crosshair';
              pizarraCanvas.style.cursor=estiloDelCursor;
            }else if(opcion2.checked){
              colorDelTrazo='#ff0000';//555 0000FF
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
              type=true;
              estiloDelCursor='default';//'crosshair';
              pizarraCanvas.style.cursor=estiloDelCursor;
            }else if(opcion3.checked){//#008000
              colorDelTrazo='#008000';
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
              type=true;
              estiloDelCursor='default';//'crosshair';
              pizarraCanvas.style.cursor=estiloDelCursor;
            }else if(opcion4.checked){
              colorDelTrazo='#000000';
              contexto=pizarraCanvas.getContext('2d');
              contexto.strokeStyle=colorDelTrazo;
              type=true;
              estiloDelCursor='default';//'crosshair';
              pizarraCanvas.style.cursor=estiloDelCursor;
            }
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
               img.src = '../images/ortodonciagram.png';
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
  <br>

</div>
<hr>

<div class="border border-primary rounded px-3">
  <label for=""><u><b>EXÁMENES COMPLEMENTARIOS</b></u></label>

  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <label for="tipoausente">Fotos:</label>
      <select id="photo" name="photo" class="form-select d-inline" aria-label="Default select example">
        <option <?php if(!isset($pat["orthodonticsphoto"]) || $pat["orthodonticsphoto"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat["orthodonticsphoto"]) && $pat["orthodonticsphoto"] == 'frente') echo "selected"; ?> value="frente">Frente</option>
        <option <?php if(isset($pat["orthodonticsphoto"]) && $pat["orthodonticsphoto"] == 'perfil') echo "selected"; ?> value="perfil">Perfil(Derecho/Izquierdo)</option>
        <option <?php if(isset($pat["orthodonticsphoto"]) && $pat["orthodonticsphoto"] == 'cavidad') echo "selected"; ?> value="cavidad">Cavidad Oral</option>
      </select>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <label for="tipoausente">Análisis de Modelos:</label>

      <select id="model" name="model" class="form-select d-inline" aria-label="Default select example">
        <option <?php if(!isset($pat["orthodonticsmodel"]) || $pat["orthodonticsmodel"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat["orthodonticsmodel"]) && $pat["orthodonticsmodel"] == 'estudio') echo "selected"; ?> value="estudio">Mod. Estudio</option>
        <option <?php if(isset($pat["orthodonticsmodel"]) && $pat["orthodonticsmodel"] == 'trabajo') echo "selected"; ?> value="trabajo">Mod. Trabajo</option>
      </select>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <label for="radiographic">Examen Radiográfico</label>
      <input class="form-control" type="text" name="radiographic" id="radiographic" value="<?php if(isset($pat["orthodonticsradiographic"])) echo $pat["orthodonticsradiographic"];  ?>">
    </div>
  </div>
  <div class="" align="center">
    <b> <u>DIAGNOSTICO</u> </b>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <label for="diagnosispreg">Presuntivo</label>
      <textarea name="diagnosispreg" id="diagnosispreg" rows="5" class="form-control"><?php if(isset($pat['orthodonticsdiagnosispre'])) echo $pat['orthodonticsdiagnosispre'];?></textarea>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <label for="diagnosisdef">Definitivo</label>
      <textarea name="diagnosisdef" id="diagnosisdef" rows="5" class="form-control"><?php if(isset($pat['orthodonticsdiagnosisdef'])) echo $pat['orthodonticsdiagnosisdef'];?></textarea>

    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <label for="treatmentplan">Plan de Tratamiento</label>
      <input class="form-control" type="text" name="treatmentplan" id="treatmentplan" value="<?php if(isset($pat["orthodonticstreatmentplan"])) echo $pat["orthodonticstreatmentplan"];  ?>">

    </div>
  </div>
  <div class="row">
    <div class="col-3 col-lg-3 col-md-3 col-sm-12 col-12">
        <label for="">Toma de Impresiones:</label>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <label for="" class="d-block"><b>Estudio:</b></label>
      <?php
      $sms="<div class=\"pl-3\">";
      if(isset($pat["orthodonticsstudy"]) && $pat["orthodonticsstudy"]==''){

        $sms.="   <input class=\"form-check-input\" name=\"study\" id=\"study\" type=\"checkbox\">".
        "   <div>".
        "     <label class=\"form-check-label\" for=\"study\">Solicitar Firma</label>".
        "   </div>";
      }else{
        if($pat["orthodonticsstudy"]=='t'){
          $sms.=" <div> <span class=\"text-success\" name=\"study\" id=\"study\">Firmado</span></div>";

        }else{
          $sms.="   <input class=\"form-check-input\" name=\"study\" id=\"study\" type=\"checkbox\" checked>".
          "   <div>".
          "     <label class=\"form-check-label\" for=\"study\">Solicitar Firma</label>".
          "   </div>";
        }
      }
      $sms.="</div>";
      echo $sms;
      ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <label for="" class="d-block"><b>Trabajo:</b></label>
      <?php
      $sms="<div class=\"pl-3\">";
      if(isset($pat["orthodonticstreatment"]) && $pat["orthodonticstreatment"]==''){

        $sms.="   <input class=\"form-check-input\" name=\"treatment\" id=\"treatment\" type=\"checkbox\">".
        "   <div>".
        "     <label class=\"form-check-label\" for=\"treatment\">Solicitar Firma</label>".
        "   </div>";
      }else{
        if($pat["orthodonticstreatment"]=='t'){
          $sms.=" <div> <span class=\"text-success\" name=\"treatment\" id=\"treatment\">Firmado</span></div>";

        }else{
          $sms.="   <input class=\"form-check-input\" name=\"treatment\" id=\"treatment\" type=\"checkbox\" checked>".
          "   <div>".
          "     <label class=\"form-check-label\" for=\"treatment\">Solicitar Firma</label>".
          "   </div>";
        }
      }
      $sms.="</div>";
      echo $sms;
      ?>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <label for="" class="d-block"><b>Diseño:</b></label>
      <?php
      $sms="<div class=\"pl-3\">";
      if(isset($pat["orthodonticsdesign"]) && $pat["orthodonticsdesign"]==''){

        $sms.="   <input class=\"form-check-input\" name=\"design\" id=\"design\" type=\"checkbox\">".
        "   <div>".
        "     <label class=\"form-check-label\" for=\"design\">Solicitar Firma</label>".
        "   </div>";
      }else{
        if($pat["orthodonticsdesign"]=='t'){
          $sms.="<span class=\"text-success\" name=\"design\" id=\"design\">Firmado</span>";

        }else{
          $sms.="   <input class=\"form-check-input\" name=\"design\" id=\"design\" type=\"checkbox\" checked>".
          "   <div>".
          "     <label class=\"form-check-label\" for=\"design\">Solicitar Firma</label>".
          "   </div>";
        }
      }
      $sms.="</div>";
      echo $sms;
      ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <label for="" class="d-block"><b>Labrado de Alambre:</b></label>
      <?php
      $sms="<div class=\"pl-3\">";
      if(isset($pat["orthodonticswire"]) && $pat["orthodonticswire"]==''){

        $sms.="   <input class=\"form-check-input\" name=\"wire\" id=\"wire\" type=\"checkbox\">".
        "   <div>".
        "     <label class=\"form-check-label\" for=\"wire\">Solicitar Firma</label>".
        "   </div>";
      }else{
        if($pat["orthodonticswire"]=='t'){
          $sms.=" <span class=\"text-success\" name=\"wire\" id=\"wire\">Firmado</span>";

        }else{
          $sms.="   <input class=\"form-check-input\" name=\"wire\" id=\"wire\" type=\"checkbox\" checked>".
          "   <div>".
          "     <label class=\"form-check-label\" for=\"wire\">Solicitar Firma</label>".
          "   </div>";
        }
      }
      $sms.="</div>";
      echo $sms;
      ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <label for="" class="d-block"><b>Encerado:</b></label>
      <?php
      $sms="<div class=\"pl-3\">";
      if(isset($pat["orthodonticswax"]) && $pat["orthodonticswax"]==''){

        $sms.="   <input class=\"form-check-input\" name=\"wax\" id=\"wax\" type=\"checkbox\">".
        "   <div>".
        "     <label class=\"form-check-label\" for=\"wax\">Solicitar Firma</label>".
        "   </div>";
      }else{
        if($pat["orthodonticswax"]=='t'){
          $sms.="<span class=\"text-success\" name=\"wax\" id=\"wax\">Firmado</span>";

        }else{
          $sms.="   <input class=\"form-check-input\" name=\"wax\" id=\"wax\" type=\"checkbox\" checked>".
          "   <div>".
          "     <label class=\"form-check-label\" for=\"wax\">Solicitar Firma</label>".
          "   </div>";
        }
      }
      $sms.="</div>";
      echo $sms;
      ?>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="" class="d-block"><b>Confección:</b></label>
      <?php
      $sms="<div class=\"pl-3\">";
      if(isset($pat["orthodonticsmaking"]) && $pat["orthodonticsmaking"]==''){

        $sms.="   <input class=\"form-check-input\" name=\"making\" id=\"making\" type=\"checkbox\">".
        "   <div>".
        "     <label class=\"form-check-label\" for=\"making\">Solicitar Firma</label>".
        "   </div>";
      }else{
        if($pat["orthodonticsmaking"]=='t'){
          $sms.="<span class=\"text-success\" name=\"making\" id=\"making\">Firmado</span>";

        }else{
          $sms.="   <input class=\"form-check-input\" name=\"making\" id=\"making\" type=\"checkbox\" checked>".
          "   <div>".
          "     <label class=\"form-check-label\" for=\"making\">Solicitar Firma</label>".
          "   </div>";
        }
      }
      $sms.="</div>";
      echo $sms;
      ?>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <label for="" class="d-block"><b>Autorización de Acrilizado:</b></label>
      <?php
      $sms="<div class=\"pl-3\">";
      if(isset($pat["orthodonticsacrylic"]) && $pat["orthodonticsacrylic"]==''){

        $sms.="   <input class=\"form-check-input\" name=\"acrylic\" id=\"acrylic\" type=\"checkbox\">".
        "   <div>".
        "     <label class=\"form-check-label\" for=\"acrylic\">Solicitar Firma</label>".
        "   </div>";
      }else{
        if($pat["orthodonticsacrylic"]=='t'){
          $sms.="<span class=\"text-success\" name=\"acrylic\" id=\"acrylic\">Firmado</span>";

        }else{
          $sms.="   <input class=\"form-check-input\" name=\"acrylic\" id=\"acrylic\" type=\"checkbox\" checked>".
          "   <div>".
          "     <label class=\"form-check-label\" for=\"acrylic\">Solicitar Firma</label>".
          "   </div>";
        }
      }
      $sms.="</div>";
      echo $sms;
      ?>
    </div>
    <div class="col-6">
      <label for=""> <b>Instalación de Aparato Logia</b> </label>
      <?php
      $sms="<div class=\"pl-3\">";
      if(isset($pat["orthodonticsfacility"]) && $pat["orthodonticsfacility"]==''){

        $sms.="   <input class=\"form-check-input\" name=\"facility\" id=\"facility\" type=\"checkbox\">".
        "   <div>".
        "     <label class=\"form-check-label\" for=\"facility\">Solicitar Revisión</label>".
        "   </div>";
      }else{
        if($pat["orthodonticsfacility"]=='f'){

          $sms.="   <input class=\"form-check-input\" name=\"facility\" id=\"facility\" type=\"checkbox\" checked>".
          "   <div>".
          "     <label class=\"form-check-label\" for=\"facility\">Solicitar Revisión</label>".
          "   </div>";
        }else{

          $sms.="<span class=\"text-success\" name=\"facility\" id=\"facility\"></span>";
          if(isset($pat['logiadesc']) && isset($pat['logiafirma'])&& isset($pat['logiadate'])){
            $sms.="<span class=\"text-primary\" name=\"logiadesc\" id=\"logiadesc\">".$pat['logiadesc']."</span>&nbsp; &nbsp; ";
            if($pat['logiafirma']=='' || $pat['logiafirma']=='f'){
              $sms.="<span class=\"text-primary\" name=\"logiafirma\" id=\"logiafirma\"></span>";

            }else{
              $sms.="<span class=\"text-primary\" name=\"logiafirma\" id=\"logiafirma\">Firmado</span>";
            }
            $sms.="&nbsp; &nbsp; ";
            $sms.="<span class=\"text-primary\" name=\"logiadate\" id=\"logiadate\">".$pat['logiadate']."</span>";

          }
        }
      }
      $sms.="</div>";
      echo $sms;
      ?>
    </div>
  </div>
  <div class="" align="center">
    <b> <u>EVOLUCIÓN Y CONTROLES</u> </b>
  </div>
  <div class="row">
      <div class="col-12">
        <textarea readonly onmousedown="return false;" name="controls" id="controls" rows="10" class="form-control"><?php if(isset($pat['orthodonticscontrols'])) echo $pat['orthodonticscontrols'];?></textarea>
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

    if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['orthodonticsstatus'])&&$pat['orthodonticsstatus']!='fail'&&$pat['orthodonticsstatus']!='canceled'){
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


<style media="screen">
  .dienteb{
    float: left;
    display: inline-block;
  }
  .cursor:hover {
      cursor: pointer;
  }
</style>

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

          url:"../include/i_pediatrics.php",
          method:"POST",
          data: {ficha:ficha, imggram:imggram},

          success:function(data)
          {

            if(data=='yes'){
              if(sw==true){
                alert('Se guardó el grafico de ficha clinica');
              }

              //location.href="index.php";
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

      var patientid=$('#patientid').val();
      var ficha=$('#ficha').val();

      var motconsult=$('#motconsult').val();
      var year=$('select[name=year]').val();
      var alteration=$('select[name=alteration]').val();
      var hereditary=$('#hereditary').val();
      var nutritional=$('#nutritional').val();
      var tipolactancia=$('select[name=tipolactancia]').val();
      var duracionlactancia=$('#duracionlactancia').val();
      var diseases=$('#diseases').val();
      var treatments=$('#treatments').val();
      var importance=$('#importance').val();
      var badhabits=$('#badhabits').val();
      var trauma=$('#trauma').val();
      var respirator=$('select[name=respirator]').val();
      var eruption=$('select[name=eruption]').val();
      var faces=$('select[name=faces]').val();
      var profile=$('select[name=profile]').val();
      var liprelation=$('select[name=liprelation]').val();
      var mucosa=$('select[name=mucosa]').val();
      var encias=$('select[name=encias]').val();
      var braces=$('#braces').val();
      var palatine=$('select[name=palatine]').val();
      var tongue=$('select[name=tongue]').val();
      var forma=$('#forma').val();
      var tamano=$('#tamano').val();
      var simetria=$('#simetria').val();
      var dentition=$('select[name=dentition]').val();
      var tipoausente=$('select[name=tipoausente]').val();
      var piezaausente=$('#piezaausente').val();

      var cavities=$('#cavities').val();
      var included=$('#included').val();
      var retained=$('#retained').val();
      var numerous=$('#numerous').val();
      var sealed=$('#sealed').val();
      var rebuilt=$('#rebuilt').val();
      var endodontics=$('#endodontics').val();

      var photo=$('select[name=photo]').val();
      var model=$('select[name=model]').val();
      var radiographic=$('#radiographic').val();
      var diagnosispreg=$('#diagnosispreg').val();
      var diagnosisdef=$('#diagnosisdef').val();
      var treatmentplan=$('#treatmentplan').val();

      var study="";//$('#study').val();
      if($('#study').prop('checked')=== undefined){
        study='t';
      }else{
        if($('#study').prop('checked')==true){
          study='f';
        }else{
          study='';
        }
      }

      var treatment='';//$('#treatment').val();
      if($('#treatment').prop('checked')=== undefined){
        treatment='t';
      }else{
        if($('#treatment').prop('checked')==true){
          treatment='f';
        }else{
          treatment='';
        }
      }
      var design='';//$('#design').val();
      if($('#design').prop('checked')=== undefined){
        design='t';
      }else{
        if($('#design').prop('checked')==true){
          design='f';
        }else{
          design='';
        }
      }
      var wire='';//('#wire').val();
      if($('#wire').prop('checked')=== undefined){
        wire='t';
      }else{
        if($('#wire').prop('checked')==true){
          wire='f';
        }else{
          wire='';
        }
      }
      var wax='';//$('#wax').val();
      if($('#wax').prop('checked')=== undefined){
        wax='t';
      }else{
        if($('#wax').prop('checked')==true){
          wax='f';
        }else{
          wax='';
        }
      }
      var making='';//$('#making').val();
      if($('#making').prop('checked')=== undefined){
        making='t';
      }else{
        if($('#making').prop('checked')==true){
          making='f';
        }else{
          making='';
        }
      }
      var acrylic='';//$('#acrylic').val();
      if($('#acrylic').prop('checked')=== undefined){
        acrylic='t';
      }else{
        if($('#acrylic').prop('checked')==true){
          acrylic='f';
        }else{
          acrylic='';
        }
      }
      var facility='';//$('#facility').val();
      if($('#facility').prop('checked')=== undefined){
        facility='t';
      }else{
        if($('#facility').prop('checked')==true){
          facility='f';
        }else{
          facility='';
        }
      }

      var controls=$('#controls').val();



           $.ajax({

              url:"../include/i_pediatrics.php",
              method:"POST",
              data: {patientid:patientid, ficha:ficha, motconsult:motconsult, alteration:alteration,
                hereditary:hereditary, nutritional:nutritional, tipolactancia:tipolactancia,
                duracionlactancia:duracionlactancia, diseases:diseases, treatments:treatments,
                importance:importance, badhabits:badhabits, trauma:trauma, respirator:respirator,
                eruption:eruption, faces:faces, profile:profile, liprelation:liprelation, mucosa:mucosa,
                encias:encias, braces:braces, palatine:palatine, tongue:tongue, forma:forma,
                tamano:tamano, simetria:simetria, dentition:dentition, tipoausente:tipoausente,
                piezaausente:piezaausente, cavities:cavities, included:included, retained:retained,
                numerous:numerous, sealed:sealed, rebuilt:rebuilt, endodontics:endodontics, photo:photo,
                model:model, radiographic:radiographic, diagnosispreg:diagnosispreg,
                diagnosisdef:diagnosisdef, treatmentplan:treatmentplan, study:study, treatment:treatment,
                design:design, wire:wire, wax:wax, making:making, acrylic:acrylic, facility:facility,
                controls:controls, year:year},

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

     $('#patientregister_button').click(function(){
       if (confirm("Enviar los datos de ficha clinica?")) {
         registerpatient();
         GuardarImg(false);
       }else{
           location.reload();
       }
     });

     //
     $('#periodonto_register').click(function(){
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

});

</script>
