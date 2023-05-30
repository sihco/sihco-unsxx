<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBEndodonticsInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=4&&$pat["clinicalid"]!=12)
    ForceLoad("index.php");
}else{
  ForceLoad("index.php");
}
$pat2=$r;
$pat=array_merge($pat, $pat2);
?>
<a id="personales"></a>
            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->

                <main>

                    <div class="container-fluid px-4">
                      <?php
                      if($pat['clinicalid']==12){
                          echo "  <h2 align=\"center\" class=\"mt-4\">Ficha Clinica Endodoncia III</h2>";
                      }else{
                          echo " <h2 align=\"center\" class=\"mt-4\">Ficha Clinica Endodoncia II</h2>";
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['endodonticsstatus'])&&$pat['endodonticsstatus']!='fail'){
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['endodonticsstatus'])&&$pat['endodonticsstatus']=='fail'){
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
        <label for=""><b>Universitario:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["userfullname"])) echo $pat["userfullname"];  ?></label>

      </div>
      <div class="col-lg-2 col-md-2 col-sm-6 col-6">
        <label for="">
          <b>Curso:</b>
          <?php
          if($pat['clinicalid']==12){
            echo "<label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;5to. Año</label>";
          }else{
            echo "<label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;4to. Año</label>";
          }
          ?>

        </label>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-4 col-4">
            <label for=""><b>Gestión:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-8 col-8">
            <select name="year" class="form-select" aria-label="Default select example">
              <?php
              $Year = date("Y");
              $ac='';
              $nyes=true;
              $ac.= "<option";
              if(!isset($pat["endodonticsyear"]) || $pat["endodonticsyear"] == '' || $pat['endodonticsyear']==$Year){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"$Year\">".$Year."</option>\n";
              $ac.= "<option";
              if(isset($pat["endodonticsyear"]) && $pat["endodonticsyear"] == $Year-1){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-1)."\">".($Year-1)."</option>\n";
              $ac.= "<option";
              if(isset($pat["endodonticsyear"]) && $pat["endodonticsyear"] == $Year-2){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-2)."\">".($Year-2)."</option>\n";
              $ac.= "<option";
              if(isset($pat["endodonticsyear"]) && $pat["endodonticsyear"] == $Year-3){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-3)."\">".($Year-3)."</option>\n";

              if($nyes&& isset($pat['endodonticsyear'])&&$pat['endodonticsyear']!=''){
                $ac.="<option selected value=\"".$pat['endodonticsyear']."\">".$pat['endodonticsyear']."</option>\n";
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
        <label for="patientage"><b>Sexo:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientgender"])) echo ucfirst($pat["patientgender"]);  ?></label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientprovince"><b>Procedencia:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientprovince"])) echo $pat["patientprovince"]; ?></label><br>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientoccupation"><b>Ocupacion:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientoccupation"]) && $pat['patientoccupation']!=0) echo $pat["patientoccupation"]; ?></label><br>
      </div>
      <div class="col-6">
        <label for="patientdirection"><b>Domicilio:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"]; ?></label><br>

      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <label for="patientphone"><b>Telf.:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientphone"]) && $pat['patientphone']!=0) echo $pat["patientphone"]; ?></label><br>
      </div>
    </div>


    <br>
    <div class="row">
      <div class="col-lg-2 col-md-2 col-sm-3 col-3">
        <label for="patientdatebirth"><b>Trabajos:</b></label>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-9 col-9">
        <br>
        <div class="form-check">
          <input class="form-check-input jobs" type="checkbox" value="" name="jobs" id="trabajo1" <?php if(isset($pat["trabajo1"])&&$pat["trabajo1"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="trabajo1">
            Unirradicular
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input jobs" type="checkbox" value="" name="jobs" id="trabajo2" <?php if(isset($pat["trabajo2"])&&$pat["trabajo2"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="trabajo2">
            Birradicular
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input jobs" type="checkbox" value="" name="jobs" id="trabajo3" <?php if(isset($pat["trabajo3"])&&$pat["trabajo3"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="trabajo3">
            Multiradicular
          </label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <?php
        $name="Autorizado Dr(a). ";
        if(isset($pat['teacher'])&&$pat['teacher']!=0){
          $d=DBUserInfo($pat['teacher']);
          $name.=$d['userfullname'];
        }
        echo $name;
        ?>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <?php
        $name="Fecha de Inicio: ";
        if(isset($pat['startdatetime'])&&is_numeric($pat['startdatetime'])&&$pat['startdatetime']!=-1){
          $name.=datetimeconv($pat['startdatetime']);
        }
        echo $name;
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="container">
        <a class="btn btn-success" href="" data-toggle="modal" data-target="#procedimiento">Tabla de Tratamiento</a>

      </div>
    </div>

    <style media="screen">

    .modal2{
     padding: 0 !important;
    }
    .modal-dialog2 {
      max-width: 100% !important;
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
            <div class="mx-3">
              <br>
              <div class="row">
                <div class="col-12 table-responsive">
                  <!--formulario de envio-->
                  <form name="form_treatment" id="form_treatment" method="post">
                  <input type="hidden" name="idficha" id="idficha" value="<?php echo $_GET['id']; ?>">
                  <table id="procedurestable" class="table table-sm table-bordered ">
                      <thead>

                          <tr>
                              <th>Número de pieza</th>
                              <th>Diagnostico</th>
                              <th>Rx Pre-operatoria</th>
                              <th>Fecha de Inicio</th>
                              <th>Vo.Bo. Apertura</th>
                              <th>Rx Conductometría</th>
                              <th>Obturación</th><!--texto-->
                              <th>Rx Post-operatoria</th>
                              <th>Accion</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          $isEmpty=true;
                          if(isset($pat['tableprocedures'])&&isset($pat['tableprocedures']['pieza'])&&$pat['tableprocedures']){
                            $size=count($pat['tableprocedures']['pieza']);
                            $content="";
                            for ($i=0; $i < $size; $i++) {
                              $content.="<tr>";
                              $content.="<td> <input type=\"text\" name=\"pieza[]\" class=\"form-control\" value=\"".$pat['tableprocedures']['pieza'][$i]."\"></td>";
                              $content.="<td> <input type=\"text\" name=\"clase[]\" class=\"form-control\" value=\"".$pat['tableprocedures']['clase'][$i]."\"></td>";
                              if($pat['tableprocedures']["caries"][$i]==''){
                                $content.="<td>".
                                "  <input class=\"form-check-input ml-1\" name=\"caries[]\" type=\"checkbox\" value=\"$i\">".
                                "  <div class=\"ml-4\">".
                                "     <label class=\"form-check-label\">Solicitar</label>".
                                "  </div>".
                                "</td>";
                              }else{
                                $log=explode('=',$pat['tableprocedures']['caries'][$i]);
                                if($log[0]=='t'){
                                  $content.="<td><span class=\"text-success\" name=\"caries[]\" >Firmado</span><br>";
                                  if(isset($log[1])&&is_numeric($log[1])){
                                    $content.="<span>".datetimeconv($log[1])."</span>";
                                  }
                                  $content.="</td>";
                                }else{
                                  $content.="<td>".
                                  "  <input type=\"checkbox\"class=\"form-check-input ml-1\" name=\"caries[]\"  value=\"$i\" checked>".
                                  "  <div class=\"ml-4\">".
                                  "     <label class=\"form-check-label\">Solicitar</label>".
                                  "  </div>".
                                  "</td>";
                                }
                              }
                              if($pat['tableprocedures']["inicio"][$i]==''){
                                $content.="<td>".
                                "  <input class=\"form-check-input ml-1\" name=\"inicio[]\" type=\"checkbox\" value=\"$i\">".
                                "  <div class=\"ml-4\">".
                                "     <label class=\"form-check-label\">Solicitar</label>".
                                "  </div>".
                                "</td>";
                              }else{
                                $log=explode('=',$pat['tableprocedures']['inicio'][$i]);
                                if($log[0]=='t'){
                                  $content.="<td><span class=\"text-success\" name=\"inicio[]\" >Firmado</span><br>";
                                  if(isset($log[1])&&is_numeric($log[1])){
                                    $content.="<span>".datetimeconv($log[1])."</span>";
                                  }
                                  $content.="</td>";
                                }else{
                                  $content.="<td>".
                                  "  <input type=\"checkbox\"class=\"form-check-input ml-1\" name=\"inicio[]\"  value=\"$i\" checked>".
                                  "  <div class=\"ml-4\">".
                                  "     <label class=\"form-check-label\">Solicitar</label>".
                                  "  </div>".
                                  "</td>";
                                }
                              }
                              if($pat['tableprocedures']["preparacion"][$i]==''){
                                $content.="<td>".
                                "  <input type=\"checkbox\" class=\"form-check-input ml-1\" name=\"preparacion[]\" value=\"$i\">".
                                "  <div class=\"ml-4\">".
                                "     <label class=\"form-check-label\">Solicitar</label>".
                                "  </div>".
                                "</td>";
                              }else{
                                $log=explode('=',$pat['tableprocedures']['preparacion'][$i]);
                                if($log[0]=='t'){
                                  $content.="<td><span class=\"text-success\" name=\"preparacion[]\" >Firmado</span><br>";
                                  if(isset($log[1])&&is_numeric($log[1])){
                                    $content.="<span>".datetimeconv($log[1])."</span>";
                                  }
                                  $content.="</td>";
                                }else{
                                  $content.="<td>".
                                  "  <input type=\"checkbox\" class=\"form-check-input ml-1\" name=\"preparacion[]\"  value=\"$i\" checked>".
                                  "  <div class=\"ml-4\">".
                                  "     <label class=\"form-check-label\">Solicitar</label>".
                                  "  </div>".
                                  "</td>";
                                }
                              }
                              if($pat['tableprocedures']["cavitaria"][$i]==''){
                                $content.="<td>".
                                "  <input class=\"form-check-input ml-1\" name=\"cavitaria[]\" type=\"checkbox\" value=\"$i\">".
                                "  <div class=\"ml-4\">".
                                "     <label class=\"form-check-label\">Solicitar</label>".
                                "  </div>".
                                "</td>";
                              }else{
                                $log=explode('=',$pat['tableprocedures']['cavitaria'][$i]);
                                if($log[0]=='t'){
                                  $content.="<td><span class=\"text-success\" name=\"cavitaria[]\" >Firmado</span><br>";
                                  if(isset($log[1])&&is_numeric($log[1])){
                                    $content.="<span>".datetimeconv($log[1])."</span>";
                                  }
                                  $content.="</td>";
                                }else{
                                  $content.="<td>".
                                  "  <input class=\"form-check-input ml-1\" name=\"cavitaria[]\" type=\"checkbox\" value=\"$i\" checked>".
                                  "  <div class=\"ml-4\">".
                                  "     <label class=\"form-check-label\">Solicitar</label>".
                                  "  </div>".
                                  "</td>";
                                }
                              }
                              $content.="<td><span class=\"text-success\" name=\"obturacion[]\" >".$pat['tableprocedures']['obturacion'][$i]."</span></td>";
                              if($pat['tableprocedures']["pulido"][$i]==''){
                                $content.="<td>".
                                "  <input class=\"form-check-input ml-1\" name=\"pulido[]\" type=\"checkbox\" value=\"$i\">".
                                "  <div class=\"ml-4\">".
                                "     <label class=\"form-check-label\">Solicitar</label>".
                                "  </div>".
                                "</td>";
                              }else{
                                $log=explode('=',$pat['tableprocedures']['pulido'][$i]);
                                if($log[0]=='t'){
                                  $content.="<td><span class=\"text-success\" name=\"pulido[]\" >Firmado</span><br>";
                                  if(isset($log[1])&&is_numeric($log[1])){
                                    $content.="<span>".datetimeconv($log[1])."</span>";
                                  }
                                  $content.="</td>";
                                }else{
                                  $content.="<td>".
                                  "  <input class=\"form-check-input ml-1\" name=\"pulido[]\" type=\"checkbox\" value=\"$i\" checked>".
                                  "  <div class=\"ml-4\">".
                                  "     <label class=\"form-check-label\">Solicitar</label>".
                                  "  </div>".
                                  "</td>";
                                }
                              }

                              $content.="<td><input type=\"button\" class=\"borrar btn btn-sm btn-danger\" value=\"Eliminar\" /></td>";
                              $content.="</tr>";
                            }
                            if($content!=""){
                              echo $content;
                              $isEmpty=false;
                            }
                          }
                          if($isEmpty){
                            $content="<tr>";
                            $content.="<td> <input type=\"text\" name=\"pieza[]\" class=\"form-control\" value=\"\"></td>";
                            $content.="<td> <input type=\"text\" name=\"clase[]\" class=\"form-control\" value=\"\"></td>";
                            $content.="<td>".
                            "  <input type=\"checkbox\" name=\"caries[]\" class=\"form-check-input ml-1\" value=\"0\">".
                            "  <div class=\"ml-4\">".
                            "     <label class=\"form-check-label\">Solicitar</label>".
                            "  </div>".
                            "</td>";
                            $content.="<td>".
                            "  <input type=\"checkbox\" name=\"inicio[]\" class=\"form-check-input ml-1\" value=\"0\">".
                            "  <div class=\"ml-4\">".
                            "     <label class=\"form-check-label\">Solicitar</label>".
                            "  </div>".
                            "</td>";

                            $content.="<td>".
                            "  <input type=\"checkbox\" name=\"preparacion[]\" class=\"form-check-input ml-1\" value=\"0\">".
                            "  <div class=\"ml-4\">".
                            "     <label class=\"form-check-label\">Solicitar</label>".
                            "  </div>".
                            "</td>";

                            $content.="<td>".
                            "  <input class=\"form-check-input ml-1\" name=\"cavitaria[]\" type=\"checkbox\" value=\"0\">".
                            "  <div class=\"ml-4\">".
                            "     <label class=\"form-check-label\">Solicitar</label>".
                            "  </div>".
                            "</td>";

                            $content.="<td><span class=\"text-success\" name=\"obturacion[]\" ></span></td>";
                            $content.="<td>".
                            "  <input class=\"form-check-input ml-1\" name=\"pulido[]\" type=\"checkbox\" value=\"0\">".
                            "  <div class=\"ml-4\">".
                            "     <label class=\"form-check-label\">Solicitar</label>".
                            "  </div>".
                            "</td>";

                            $content.="<td><input type=\"button\" class=\"borrar btn btn-sm btn-danger\" value=\"Eliminar\" /></td>";
                            $content.="</tr>";
                            echo $content;
                          }
                          ?>
                      </tbody>
                  </table>
                  </form>
                </div>
                <div class="row">
                  <div class="col-12">
                    <button type="button" class="btn btn-success btn-sm m-3" id="addtratamiento" name=""> + Agregar Mas</button>

                  </div>

                </div>
                <div class="row">
                  <div class="col-6">
                    Tratamientos(s) concluidos(s): <span class="text-primary"><?php if(isset($pat['treatmentdesc'])) echo $pat['treatmentdesc']; ?></span>
                  </div>
                  <div class="col-2">
                    Fecha: <span class="text-primary"><?php if(isset($pat['treatmentdate'])) echo $pat['treatmentdate']; ?></span>
                  </div>
                  <div class="col-4">
                    Firma del docente: <?php if(isset($pat['treatmentfirm'])&&$pat['treatmentfirm']=='t') echo '<span class=\'text-success\'>Firmado</span>'; ?></span>
                  </div>
                </div>
              </div>

            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
          <?php

          if((isset($pat['endodonticsstatus']) && $pat['endodonticsstatus']!='fail'&&
          $pat['endodonticsstatus']!='canceled'&&$pat['endodonticsstatus']!='end') &&
          ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
          (!isset($pat['observationaccepted'])) )){
              echo "<button type=\"submit\" class=\"btn btn-success\" id=\"tratamiento_button\" name=\"tratamiento_button\">Enviar</button>";
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
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="bio">
        <input class="form-check-input" type="radio" name="options" id="options1"  checked>
        <label class="form-check-label" for="options1">
          Bio
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6" >
      <div class="form-check" id="jacket">
        <input class="form-check-input" type="radio" name="options" id="options2">
        <label class="form-check-label" for="options2">
          Foto polimerizado
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="necro">
        <input class="form-check-input" type="radio" name="options" id="options3">
        <label class="form-check-label" for="options3">
          Necro
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="azul">
        <input class="form-check-input" type="radio" name="options" id="options4">
        <label class="form-check-label" for="options4">
          Raiz Azul
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
  <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat['endodonticsodontogram'])) echo $pat['endodonticsodontogram']; ?>">

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
  <br>
  <div class="">
    <b>MATERIALES</b>
  </div>
  <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <textarea readonly onmousedown="return false;" name="materiales" id="materiales" rows="4" class="form-control"><?php if(isset($pat['endodonticsmaterial'])) echo $pat['endodonticsmaterial'];?></textarea>
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

    if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['endodonticsstatus'])&&$pat['endodonticsstatus']!='fail'&&$pat['endodonticsstatus']!='canceled'){
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
  descript(`<?php echo trim($pat["endodonticsodontogram"]); ?>`);

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
     //funcion para registrar los datos de la ficha clinica de odontopediatria I
     function registerpatient(){

      var ficha=$('#ficha').val();
      var patientid = $('#patientid').val();
      var year=$('select[name=year]').val();
      var jobs='';
      $(".jobs").each(function() {
         if($(this).prop('checked')==true){
           jobs+='[t]';//selecionado
         }else{
           jobs+='[f]';//no selecionado
         }
      });
      //console.log(treatment);
      var draw = $('#draw').val();
           $.ajax({

              url:"../include/i_endodontics.php",
              method:"POST",
              data: {ficha:ficha, patientid:patientid, year:year, jobs:jobs, draw:draw},

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
         form_treatment(false);
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
     $('#addtratamiento').click(function() {
       var r = $("#procedurestable tr").length-1;
       var contenido='<tr>';
       contenido+='<td><input type="text" name="pieza[]" class="form-control" value=""></td>';
       contenido+='<td><input type="text" name="clase[]" class="form-control" value=""></td>';
       contenido+='<td>'+
       '  <input class="form-check-input ml-1" name="caries[]" value="'+r+'" type="checkbox">'+
       '  <div class="ml-4">'+
       '     <label class="form-check-label">Solicitar</label>'+
       '  </div>'+
       '</td>';
       contenido+='<td>'+
       '  <input class="form-check-input ml-1" name="inicio[]" value="'+r+'" type="checkbox">'+
       '  <div class="ml-4">'+
       '     <label class="form-check-label">Solicitar</label>'+
       '  </div>'+
       '</td>';
       contenido+='<td>'+
       '  <input class="form-check-input ml-1" name="preparacion[]" value="'+r+'" type="checkbox">'+
       '  <div class="ml-4">'+
       '     <label class="form-check-label">Solicitar</label>'+
       '  </div>'+
       '</td>';
       contenido+='<td>'+
       '  <input class="form-check-input ml-1" name="cavitaria[]" value="'+r+'" type="checkbox">'+
       '  <div class="ml-4">'+
       '     <label class="form-check-label">Solicitar</label>'+
       '  </div>'+
       '</td>';
       contenido+='<td><span class="text-success" name="pulido[]" ></span></td>';
       contenido+='<td>'+
       '  <input class="form-check-input ml-1" name="pulido[]" value="'+r+'" type="checkbox">'+
       '  <div class="ml-4">'+
       '     <label class="form-check-label">Solicitar</label>'+
       '  </div>'+
       '</td>';
       contenido+='<td><input type="button" class="borrar btn btn-sm btn-danger" value="Eliminar" /></td>';
       contenido+='</tr>';
       $("#procedurestable>tbody").append(contenido);
     });
     $('#procedurestable tbody input[type="text"]').keyup(function() {
        //alert( "Handler for .keyup() called." );
        var valueLength = $(this).prop('value').length;

        // Para que no arroje error si el input se vacía
        if (valueLength > 0) {

          $(this).prop('size', valueLength*7);
        }
     });

     //para subir documento culminado
     function form_treatment(t=true){
       var formdata= new FormData($("#form_treatment")[0]);
       //alert(formdata);
       $.ajax({
          data: formdata,
          url:"../include/i_endodontics.php",
          type:"POST",
          contentType: false,
          processData: false,
          success:function(data)
          {
            if(data == "yes"){
              if(t){
                  alert(".:YES:.");
              }
              //location.reload();
            }else {
              alert(data);
              //$('#subproblem').hide();
              //location.reload();
            }
          }
       });
     }
     $('#tratamiento_button').click(function(){
       form_treatment();
  	});

});



$(document).on('click', '.borrar', function(event) {
  event.preventDefault();
  $(this).closest('tr').remove();
  var cont=0;//input[type="checkbox"]
  $("#procedurestable tbody tr").each(function (index, el) {
    $(this).children("td").each(function (index2, el2) {
      $(this).children('input:checkbox').val(cont);
    });
    cont++;
  });
});
</script>
