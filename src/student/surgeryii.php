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

                    <div class="container-fluid px-4">

                        <h2 align="center" class="mt-4">
                          Ficha Clinica de Cirugia Bucal II
                        </h2>


                        <!--notificaciones inicio-->
                        <?php

                        if(isset($pat['surgeryiiid'])&& $pat['surgeryiiid']!=null&& is_numeric($pat['surgeryiiid'])){
                          if($pat['reviewstatus']=='f'){
                            echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">".
                              "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clínica aun no esta revisado.".
                              "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                              "  <span aria-hidden=\"true\">&times;</span>".
                              "</button>".
                              "</div>";
                          }
                          if($pat['reviewstatus']=='t'&& $pat['status']=='process'&& $pat['authorized']=='t'&& $pat['reviewteacher']!=''){
                              echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">".
                              "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica tiene observaciones: <b>";

                              echo "&nbsp; <button type=\"button\"".
                              "ch=\"".$pat['remissionid']."\" class=\"detail_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
                              "data-bs-target=\"#detail\"><i class=\"fa fa-2x fa-solid fa-info\"></i></button>&nbsp; &nbsp; ";

                              if(isset($pat['areviewteacher'])){
                                $size=count($pat['areviewteacher']);
                                $it=DBUserInfo($pat['areviewteacher'][$size-1]['teacher']);
                                echo ucfirst($r['areviewteacher'][$size-1]['obsdesc']);
                                echo "</b><hr>";
                                echo "<div class=\"row\"><div class=\"col-6\">Revisado por: <u>Dr(a). ".$it['userfullname']."</u></div> ";
                                echo "<div class=\"col-6\">En fecha hora: <u>".dateconv($pat['areviewteacher'][$size-1]['time'])."</u></div></div>";
                              }
                              echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                              "  <span aria-hidden=\"true\">&times;</span>".
                              "</button>".
                              "</div>";
                          }
                          if($pat['reviewstatus']=='t'&& $pat['status']=='fail'&& $pat['authorized']=='t'&& $pat['reviewteacher']!=''){
                              echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">".
                              "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica está en un estado de Abandono. <b>";

                              echo "&nbsp; <button type=\"button\"".
                              "ch=\"".$pat['remissionid']."\" class=\"detail_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
                              "data-bs-target=\"#detail\"><i class=\"fa fa-2x fa-solid fa-info\"></i></button>&nbsp; &nbsp; ";

                              if(isset($pat['areviewteacher'])){
                                $size=count($pat['areviewteacher']);
                                $it=DBUserInfo($pat['areviewteacher'][$size-1]['teacher']);
                                echo ucfirst($r['areviewteacher'][$size-1]['obsdesc']);
                                echo "</b><hr>";
                                echo "<div class=\"row\"><div class=\"col-6\">Revisado por: <u>Dr(a). ".$it['userfullname']."</u></div> ";
                                echo "<div class=\"col-6\">En fecha hora: <u>".dateconv($pat['areviewteacher'][$size-1]['time'])."</u></div></div>";
                              }
                              echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                              "  <span aria-hidden=\"true\">&times;</span>".
                              "</button>".
                              "</div>";
                          }
                          if($pat['reviewstatus']=='t'&& $pat['status']=='canceled'&& $pat['authorized']=='t'&& $pat['reviewteacher']!=''){
                              echo "<div class=\"alert alert-dark alert-dismissible fade show\" role=\"alert\">".
                              "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica se anuló.. <b>";

                              echo "&nbsp; <button type=\"button\"".
                              "ch=\"".$pat['remissionid']."\" class=\"detail_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
                              "data-bs-target=\"#detail\"><i class=\"fa fa-2x fa-solid fa-info\"></i></button>&nbsp; &nbsp; ";

                              if(isset($pat['areviewteacher'])){
                                $size=count($pat['areviewteacher']);
                                $it=DBUserInfo($pat['areviewteacher'][$size-1]['teacher']);
                                echo ucfirst($r['areviewteacher'][$size-1]['obsdesc']);
                                echo "</b><hr>";
                                echo "<div class=\"row\"><div class=\"col-6\">Revisado por: <u>Dr(a). ".$it['userfullname']."</u></div> ";
                                echo "<div class=\"col-6\">En fecha hora: <u>".dateconv($pat['areviewteacher'][$size-1]['time'])."</u></div></div>";
                              }
                              echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                              "  <span aria-hidden=\"true\">&times;</span>".
                              "</button>".
                              "</div>";
                          }

                          if($pat['reviewstatus']=='t'&& $pat['status']=='end'&& $pat['authorized']=='t'&& $pat['reviewteacher']!=''&& $pat['endatetime']!=-1){
                              echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">".
                              "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Se concluyó tu ficha clínica<b>";
                              echo "&nbsp;<a href=\"reportsurgeryii.php?id=" . $pat["remissionid"] . "\" class=\"btn btn-success btn-sm\">Imprimir Ficha</a>";
                              echo "&nbsp; <button type=\"button\"".
                              "ch=\"".$pat['remissionid']."\" class=\"detail_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
                              "data-bs-target=\"#detail\"><i class=\"fa fa-2x fa-solid fa-info\"></i></button>&nbsp; &nbsp; ";

                              if(isset($pat['areviewteacher'])){
                                $size=count($pat['areviewteacher']);
                                $it=DBUserInfo($pat['areviewteacher'][$size-1]['teacher']);
                                echo ucfirst($r['areviewteacher'][$size-1]['obsdesc']);
                                echo "</b><hr>";
                                echo "<div class=\"row\"><div class=\"col-6\">Revisado por: <u>Dr(a). ".$it['userfullname']."</u></div> ";
                                echo "<div class=\"col-6\">En fecha hora: <u>".dateconv($pat['areviewteacher'][$size-1]['time'])."</u></div></div>";
                              }
                              echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                              "  <span aria-hidden=\"true\">&times;</span>".
                              "</button>".
                              "</div>";
                          }

                      }


                      ?>

                        <!--notificaciones fin-->
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
<div class="card p-3 shadow rounded text-half">
  <div class="fixed-bottom mb-3" align="center">
    <button type="button" class="btn btn-success">

      Guardar Datos
    </button>
  </div>
  <div class="row">
    <div class="col-8">
      <label for="patientfullname"><b>Nombre del paciente:</b></label>&nbsp;&nbsp;&nbsp;
      <span class="text-secondary">
      <?php
      if(isset($pat["patientname"])){
        echo $pat["patientname"]." ".$pat["patientfirstname"]." ".$pat["patientlastname"];
      }
      ?></span>
    </div>
    <div class="col-2">
      <label for="patientage"><b>Edad:</b></label>&nbsp;&nbsp;&nbsp;
      <span class="text-secondary"><?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></span>
    </div>
    <div class="col-2">
      <span style="cursor: pointer;"class="text-primary fst-italic btn-link" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">mas info</span>
    </div>
  </div>
  <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
    <div class="accordion-body">
      <div class="row">
        <div class="col-4">
          <label for="patientdirection">Dirección:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"> <?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"];  ?></span>
        </div>
        <div class="col-4">
          <label for="patientlocation">Localidad:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"><?php if(isset($pat["patientlocation"])) echo $pat["patientlocation"];  ?></span>
        </div>
        <div class="col-4">
          <label for="patientprovenance">Procedencia:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"><?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"];  ?></span>
        </div>
        <div class="col-4">
          <label for="patientphone">Tel.&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"><?php if(isset($pat["patientphone"])) echo $pat["patientphone"];  ?></span>
        </div>
        <div class="col-4">
          <label for="patientgender">Genero:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary">
          <?php
          if (isset($pat["patientgender"])&& trim($pat["patientgender"])!='') {
            echo ucfirst($pat["patientgender"]);
          }
          ?>
          </span>
        </div>
        <div class="col-4">
          <label for="patientcivilstatus">Estado Civil:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"><?php if(isset($pat["patientcivilstatus"])) echo ucfirst($pat["patientcivilstatus"]);  ?></span>
        </div>
        <div class="col-4">
          <label for="patientoccupation">Ocupacion:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"><?php if(isset($pat["patientoccupation"])) echo $pat["patientoccupation"];  ?></span>
        </div>
        <div class="col-4">
          <label for="patientnationality">Nacionalidad:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"><?php if(isset($pat["patientnationality"])) echo ucfirst($pat["patientnationality"]);  ?></span>
        </div>
        <div class="col-4">
          <label for="patientschool">Grado de escolaridad:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"><?php if(isset($pat["patientschool"])) echo ucfirst($pat["patientschool"]);  ?></span>
        </div>
        <div class="col-4">
          <label for="patientattorney">Apoderado:&nbsp;&nbsp;&nbsp;</label>
          <span class="text-secondary"><?php if(isset($pat["patientattorney"])) echo $pat["patientattorney"];  ?></span>
        </div>
      </div>
      <!--formulario para paciente fin-->
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <div class="input-group input-group-sm mb-3">
        <label class="input-group-text" for="generalstatus">Estado general del paciente</label>
        <input type="text" class="form-control" name="generalstatus" id="generalstatus" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php if(isset($pat["generalstatus"])) echo $pat["generalstatus"];  ?>">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <div class="input-group input-group-sm mb-3">
        <label class="input-group-text" for="generalstatus">Antecedentes psicotraumáticos del paciente</label>
        <input type="text" class="form-control" name="generalstatus" id="generalstatus" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="<?php if(isset($pat["generalstatus"])) echo $pat["generalstatus"];  ?>">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <b>I. Examen Clínico</b><br>
      <u><b>Extraoral</u></b>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="faces">Facies</label>
        <select name="faces" id="faces" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalfaces"] == 'simetrico') echo "selected"; ?> value="simetrico">Simétrico</option>
          <option <?php if(isset($pat) && $pat["dentalfaces"] == 'asimetrico') echo "selected"; ?> value="asimetrico">Asimétrico</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="profile">Perfil</label>
        <select name="profile" id="profile" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalprofile"] == 'recto') echo "selected"; ?> value="recto">Recto</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'concavo') echo "selected"; ?> value="concavo">Cóncavo</option>
          <option <?php if(isset($pat) && $pat["dentalprofile"] == 'convexo') echo "selected"; ?> value="convexo">Cónvexo</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="scars">Cicatrices</label>
        <input type="text" name="scars" class="form-control" id="scars" value="<?php if(isset($pat["dentalscars"]) && $pat['dentalscars']!="") echo $pat["dentalscars"]; else echo "Ninguno"; ?>">
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="atm">A.T.M</label>
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
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="ganglia">Ganglios</label>
        <select name="ganglia" id="ganglia" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalganglia"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalganglia"] == 'inflamados') echo "selected"; ?> value="inflamados">Inflamados</option>
          <option <?php if(isset($pat) && $pat["dentalganglia"] == 'adenitis') echo "selected"; ?> value="adenitis">Adenitis</option>

        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="lips">Labios</label>
        <select name="lips" id="lips" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentallips"] == 'medianos') echo "selected"; ?> value="medianos">Medianos</option>
          <option <?php if(isset($pat) && $pat["dentallips"] == 'delgados') echo "selected"; ?> value="delgados">Delgados</option>
          <option <?php if(isset($pat) && $pat["dentallips"] == 'gruesos') echo "selected"; ?> value="gruesos">Gruesos</option>
        </select>
      </div>
    </div>


  </div>
  <div class="row mb-2">
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="lips">Labios</label>
        <select name="lips" id="lips" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentallips"] == 'medianos') echo "selected"; ?> value="medianos">Medianos</option>
          <option <?php if(isset($pat) && $pat["dentallips"] == 'delgados') echo "selected"; ?> value="delgados">Delgados</option>
          <option <?php if(isset($pat) && $pat["dentallips"] == 'gruesos') echo "selected"; ?> value="gruesos">Gruesos</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="ulcerations">Ulceraciones</label>
        <select name="ulcerations" id="ulcerations" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalulcerations"] == 'no') echo "selected"; ?> value="no">No</option>
          <option <?php if(isset($pat) && $pat["dentalulcerations"] == 'si') echo "selected"; ?> value="si">Si</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="cheilitis">Queilitis</label>
        <select name="cheilitis" id="cheilitis" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalcheilitis"] == 'no') echo "selected"; ?> value="no">No</option>
          <option <?php if(isset($pat) && $pat["dentalcheilitis"] == 'si') echo "selected"; ?> value="si">Si</option>
        </select>
      </div>
    </div>

  </div>
  <div class="row mb-3">
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="commissures">Comisuras</label>
        <select name="commissures" id="commissures" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalcommissures"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalcommissures"] == 'presenta') echo "selected"; ?> value="presenta">Presenta queilitis</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <u><b>Intraoral</u></b>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="tongue">Lengua</label>
        <select name="tongue" id="tongue" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentaltongue"] == 'saburra') echo "selected"; ?> value="saburra">Saburral</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'fisurada') echo "selected"; ?> value="fisurada">Fisurada</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'geografica') echo "selected"; ?> value="geografica">Geográfica</option>
          <option <?php if(isset($pat) && $pat["dentaltongue"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="piso">Piso de la boca</label>
        <select name="piso" id="piso" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalpiso"] == 'aparentemente') echo "selected"; ?> value="aparentemente">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalpiso"] == 'toruslingua') echo "selected"; ?> value="toruslingua">Torus Lingua</option>
          <option <?php if(isset($pat) && $pat["dentalpiso"] == 'ranula') echo "selected"; ?> value="ranula">Ránula</option>
          <option <?php if(isset($pat) && $pat["dentalpiso"] == 'frenillo') echo "selected"; ?> value="frenillo">Frenillo lingual Alto</option>
          <option <?php if(isset($pat) && $pat["dentalpiso"] == 'mucocele') echo "selected"; ?> value="mucocele">Mucocele</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="encias">Encias</label>
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
  </div>
  <div class="row mb-2">
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="mucosa">Mucosa Bucal</label>
        <select name="mucosa" id="mucosa" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalmucosa"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
          <option <?php if(isset($pat) && $pat["dentalmucosa"] == 'alteracion') echo "selected"; ?> value="alteracion">Con Alteración</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="occlusion">Tipo de Oclusion</label>
        <select name="occlusion" id="occlusion" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentaltypeo"] == 'normo') echo "selected"; ?> value="normo">Normo oclusion</option>
          <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'disto') echo "selected"; ?> value="disto">Disto oclusion</option>
          <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'mesio') echo "selected"; ?> value="mesio">Mesio oclusion</option>
          <option <?php if(isset($pat) && $pat["dentaltypeo"] == 'abierta') echo "selected"; ?> value="abierta">Mordida Abierta anterior</option>
        </select>
      </div>
    </div>
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="prosthesis">Tipo de Protesis</label>
        <select name="prosthesis" id="prosthesis" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentaltypep"] == '') echo "selected"; ?> value="">--</option>
          <option <?php if(isset($pat) && $pat["dentaltypep"] == 'removible') echo "selected"; ?> value="removible">Removible</option>
          <option <?php if(isset($pat) && $pat["dentaltypep"] == 'fija') echo "selected"; ?> value="fija">Fija</option>
          <option <?php if(isset($pat) && $pat["dentaltypep"] == 'total') echo "selected"; ?> value="total">Total</option>
        </select>
      </div>
    </div>

  </div>
  <div class="row mb-2">
    <div class="col-4">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="hygiene">Higiene Bucal</label>
        <select name="hygiene" id="hygiene" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat) || $pat["dentalhygiene"] == 'regular') echo "selected"; ?> value="regular">Regular</option>
          <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'buena') echo "selected"; ?> value="buena">Buena</option>
          <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'mala') echo "selected"; ?> value="mala">Mala</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <span style="cursor: pointer;"class="text-primary fst-italic btn-link" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">Odontograma</span>

      <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
        <div class="accordion-body">
          <input type="hidden" name="odontogram" id="odontogram" value="<?php if(isset($pat["odontogramid"])) echo $pat["odontogramid"];  ?>">
  <!--odontograma inicio-->
          <?php
          include("../leftodontogram.php");
          $odontogramstatus="false";
          if (isset($pat['draw'])){
            $pat=decryptOdontogram($pat);
            $odontogramstatus="true";
          }
          ?>
  <!--odontograma fin-->
        <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat["draw"])) echo $pat["draw"];?>">

        </div>
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-12">
      <b>II. Examenes Complementarios</b><br>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-8 col-8">
      <div class="input-group input-group-sm">
        <!--<label class="input-group-text" for="exam"><u><b>Examenes Complementarios</b></u></label>-->
        <select name="exam" id="exam" class="form-select" aria-label="Default select example">
          <option <?php if(!isset($pat["exam"]) || $pat["exam"] == '--') echo "selected"; ?> value="--">--</option>
          <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'periapical') echo "selected"; ?> value="periapical">RX PERIAPICAL</option>
          <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'oclusal') echo "selected"; ?> value="oclusal">RX OCLUSAL</option>
          <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'panoramico') echo "selected"; ?> value="panoramico">RX PANORAMICO</option>
          <option <?php if(isset($pat["exam"]) && $pat["exam"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
        </select>
        <label class="input-group-text" for="pieza">Pieza</label>
        <input type="text" name="pieza" class="form-control" id="pieza" value="<?php if(isset($pat['pieza'])) echo $pat['pieza'] ?>">
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-lg-6 col-md-6 col-sm-4 col-4">
      <label for="diagnostico"><u><b>III. Diagnostico</b></u></label>
      <div class="input-group input-group-sm">
        <textarea class="form-control" id="diagnostico" name="diagnostico" rows="2"><?php if(isset($pat["surgeryiidiagnosis"])) echo $pat["surgeryiidiagnosis"];  ?></textarea>
      </div>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-12">
      <label for=""><u><b>IV. Tratamiento</b></u></label>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="input-group input-group-sm">
        <label class="input-group-text" for="hygiene">Tecnicas Anestesicas</label>

        <div class="border">
          <div class="from-check form-check-inline border p-3" align="center">
            <input class="form-check-input" type="checkbox" id="spix" value="spix">
            <label for="spix">SIPX</label>
            <br>
            <div class="autorizar">
              <button type="button" class="btn btn-outline-primary btn-sm" name="button">Docente <i class="fa fa-solid fa-qrcode"></i></button>
            </div>
            <div class="mt-1 autorizar">
              <button type="button" class="btn btn-outline-success btn-sm" name="button">Enfermeria <i class="fa fa-solid fa-qrcode"></i></button>
            </div>
          </div>
          <div class="from-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="spix" value="spix">
            <label for="spix">SIPX</label>
          </div>
          <div class="from-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="spix" value="spix">
            <label for="spix">SIPX</label>
          </div>
          <div class="from-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="spix" value="spix">
            <label for="spix">SIPX</label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12">
      <label for=""><u><b>V. Prescripcion Farmacologica</b></u></label>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="prescriptions"><u>RP/</u></label>
      <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
      <textarea class="form-control" id="prescriptions" name="prescriptions" rows="3"><?php if(isset($pat["surgeryiiprescriptions"])) echo $pat["surgeryiiprescriptions"];  ?></textarea>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="indications"><u>INDICACIONES</u></label>
      <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
      <textarea class="form-control" id="indications" name="indications" rows="3"><?php if(isset($pat["surgeryiiindications"])) echo $pat["surgeryiiindications"];  ?></textarea>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="evolution"><u><b>VI. Tratamiento post operatorio y evolución</b></u></label>
      <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
      <textarea class="form-control" id="evolution" name="evolution" rows="3"><?php if(isset($pat["surgeryiievolution"])) echo $pat["surgeryiievolution"];  ?></textarea>
    </div>
    <input type="hidden" name="remissionid" id="remissionid"value="<?php if(isset($_GET['id'])) echo $_GET['id'];?>">
    <input type="hidden" name="ficha" id="ficha"value="<?php if(isset($pat["surgeryiiid"])) echo $pat["surgeryiiid"]?>">

  </div>
  <br>
  <div class="row">
    <?php
    if(!isset($pat['surgeryiiid'])||($pat['status']!='end'&& $pat['status']!='canceled'&& $pat['status']!='fail'&&
    $pat['reviewstatus']=='t')){
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


</div>
<br>
<div class="accordion" id="accordionPanelsStayOpenExample">

  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingFive">
      <button class="accordion-button collapsed btn-link text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
        Examenes Complementarios
      </button>
    </h2>
    <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive">
      <div class="accordion-body">
        <!--inicio finalizacion-->


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
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingSix">
      <button class="accordion-button collapsed btn-link text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
        Prescripciones & Tratamiento P.O. y Evolucion
      </button>
    </h2>
    <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix">
      <div class="accordion-body">
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
                  <input type="hidden" name="remissionid" id="remissionid"value="<?php if(isset($_GET['id'])) echo $_GET['id'];?>">
                  <input type="hidden" name="ficha" id="ficha"value="<?php if(isset($pat["surgeryiiid"])) echo $pat["surgeryiiid"]?>">
                </div>
                <br>
                <div class="row">
                  <?php

                  /*if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['surgeryiistatus'])&&$pat['surgeryiistatus']!='fail'&&$pat['surgeryiistatus']!='canceled'){
                    echo "
                    <div class=\"col-4\">
                      <button id=\"patientregister_button\" class=\"btn btn-success\" type=\"button\" name=\"patientregister_button\">Enviar Datos</button>
                    </div>
                    <div class=\"col-4\">
                      <button id=\"cancel_button\" class=\"btn btn-danger\" type=\"button\" name=\"cancel_button\">Cancelar</button>
                    </div>
                    ";
                  }*/
                  /*if($pat['reviewstatus']=='t'&&
                  $pat['status']=='fail'&& $pat['authorized']=='t'&&
                  $pat['reviewteacher']!=''){
                  ||
                  ($pat['status']!='end'&& $pat['status']!='canceled'&& $pat['status']!='fail'&&
                  $pat['reviewstatus']=='t')
                  */
                  if(!isset($pat['surgeryiiid'])||($pat['status']!='end'&& $pat['status']!='canceled'&& $pat['status']!='fail'&&
                  $pat['reviewstatus']=='t')){
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

<?php
require('footer.php');
?>



<?php
include("../leftodontogramjs.php");
?>
<script>

$(document).ready(function(){
      Stop();
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
      //cancel cancel_button
     $('#cancel_button').click(function(){
        location.reload();
     });
     //registrar todos de datos del paciente





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
       var remission = $('#remissionid').val();
       var ficha = $('#ficha').val();
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
                  location.href="clinicalhistory.php";
                }else{
                  alert(data);
                  console.log(data);
                }
              }
           });

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
