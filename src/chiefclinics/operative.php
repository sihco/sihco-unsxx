<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBOperativeInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=3&&$pat["clinicalid"]!=11)
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
                        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==11){
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Operatoria Dental III</h2>";
                        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==3) {
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Operatoria Dental II</h2>";
                        }else{
                          echo "<h2 align=\"center\" class=\"mt-4\">Ficha Clinica Operatoria Dental</h2>";
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['operativestatus'])&&$pat['operativestatus']!='fail'){
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['operativestatus'])&&$pat['operativestatus']=='fail'){
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
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==11){
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;5to. Año</label> </label>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==3) {
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">&nbsp;&nbsp;&nbsp;&nbsp;4to. Año</label> </label>";
        }else{
          echo "<label for=\"\"><b>Curso:</b> <label for=\"\">....................</label> </label>";
        }
        ?>
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
              if(!isset($pat["operativeyear"]) || $pat["operativeyear"] == '' || $pat['operativeyear']==$Year){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"$Year\">".$Year."</option>\n";
              $ac.= "<option";
              if(isset($pat["operativeyear"]) && $pat["operativeyear"] == $Year-1){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-1)."\">".($Year-1)."</option>\n";
              $ac.= "<option";
              if(isset($pat["operativeyear"]) && $pat["operativeyear"] == $Year-2){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-2)."\">".($Year-2)."</option>\n";
              $ac.= "<option";
              if(isset($pat["operativeyear"]) && $pat["operativeyear"] == $Year-3){
                $ac.=" selected";
                $nyes=false;
              }
              $ac.=" value=\"".($Year-3)."\">".($Year-3)."</option>\n";

              if($nyes&& isset($pat['operativeyear'])&&$pat['operativeyear']!=''){
                $ac.="<option selected value=\"".$pat['operativeyear']."\">".$pat['operativeyear']."</option>\n";
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
            Obturación de amalgama
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input jobs" type="checkbox" value="" name="jobs" id="trabajo2" <?php if(isset($pat["trabajo2"])&&$pat["trabajo2"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="trabajo2">
            Obturación de resina
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input jobs" type="checkbox" value="" name="jobs" id="trabajo3" <?php if(isset($pat["trabajo3"])&&$pat["trabajo3"]=='t') echo "checked";  ?>>
          <label class="form-check-label" for="trabajo3">
            Incrustaciones
          </label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <?php
        $name="Autorizado por: Dr(a). ";
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
                              <th>Pieza</th>
                              <th>Clase</th>
                              <th>Caries</th>
                              <th>Fecha de Inicio</th>
                              <th>Vo.Bo. Preparación</th>
                              <th>Vo.Bo. base cavitaria</th>
                              <th>Obturación</th>
                              <th>Pulido</th>
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
                              $content.="<td> <input type=\"text\" name=\"caries[]\" class=\"form-control\" value=\"".$pat['tableprocedures']['caries'][$i]."\"></td>";
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
                            $content.="<td> <input type=\"text\" name=\"caries[]\" class=\"form-control\" value=\"\"></td>";
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

          if((isset($pat['operativestatus']) && $pat['operativestatus']!='fail'&&
          $pat['operativestatus']!='canceled'&&$pat['operativestatus']!='end') &&
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
      <div class="form-check" id="red">
        <input class="form-check-input" type="radio" name="options" id="options1"  checked>
        <label class="form-check-label" for="options1">
          Rojo
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6" >
      <div class="form-check" id="blue">
        <input class="form-check-input" type="radio" name="options" id="options2">
        <label class="form-check-label" for="options2">
          Azul
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="yellow">
        <input class="form-check-input" type="radio" name="options" id="options3">
        <label class="form-check-label" for="options3">
          Amarillo
        </label>
      </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-4 col-6">
      <div class="form-check" id="not">
        <input class="form-check-input" type="radio" name="options" id="options4">
        <label class="form-check-label" for="options4">
          No Existe
        </label>
      </div>
    </div>

  </div>
  <!--inicio odontograma fabian-->
  <!--inicio wrapper-->
  <div id="wrapper">
  <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat['operativeodontogram'])) echo $pat['operativeodontogram']; ?>">

  <table id="" width=99%><!--tabla-superior class="table-responsive" class="img-fluid" -->
    <tbody>
      <tr><td colspan="2"><table id="separador"><tbody><tr><td>ODONTOGRAMA INICIAL</td></tr></tbody></table></td><td></td></tr>
      <tr style="background-color:#FF0080;">
        <td>
          <div id="trr">
            <div data-name="value" id="sdiente18" class="dientepp">
                <div id="st18" class="cuadro click"></div>
                <div id="sl18" class="cuadro izquierdo click"></div>
                <div id="sb18" class="cuadro debajo click"></div>
                <div id="sr18" class="cuadro derecha click click"></div>
                <div id="sc18" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente17" class="dientep">
                <div id="st17" class="cuadro click"></div>
                <div id="sl17" class="cuadro izquierdo click"></div>
                <div id="sb17" class="cuadro debajo click"></div>
                <div id="sr17" class="cuadro derecha click click"></div>
                <div id="sc17" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente16" class="dientep">
                <div id="st16" class="cuadro click"></div>
                <div id="sl16" class="cuadro izquierdo click"></div>
                <div id="sb16" class="cuadro debajo click"></div>
                <div id="sr16" class="cuadro derecha click click"></div>
                <div id="sc16" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente15" class="dientep">
                <div id="st15" class="cuadro click"></div>
                <div id="sl15" class="cuadro izquierdo click"></div>
                <div id="sb15" class="cuadro debajo click"></div>
                <div id="sr15" class="cuadro derecha click click"></div>
                <div id="sc15" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente14" class="dientep">
                <div id="st14" class="cuadro click"></div>
                <div id="sl14" class="cuadro izquierdo click"></div>
                <div id="sb14" class="cuadro debajo click"></div>
                <div id="sr14" class="cuadro derecha click click"></div>
                <div id="sc14" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente13" class="dientep">
                <div id="st13" class="cuadro click"></div>
                <div id="sl13" class="cuadro izquierdo click"></div>
                <div id="sb13" class="cuadro debajo click"></div>
                <div id="sr13" class="cuadro derecha click click"></div>
                <div id="sc13" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente12" class="dientep">
                <div id="st12" class="cuadro click"></div>
                <div id="sl12" class="cuadro izquierdo click"></div>
                <div id="sb12" class="cuadro debajo click"></div>
                <div id="sr12" class="cuadro derecha click click"></div>
                <div id="sc12" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente11" class="dientep">
                <div id="st11" class="cuadro click"></div>
                <div id="sl11" class="cuadro izquierdo click"></div>
                <div id="sb11" class="cuadro debajo click"></div>
                <div id="sr11" class="cuadro derecha click click"></div>
                <div id="sc11" class="centro click"></div>
            </div>

          </div>
        </td>
        <td>
          <div id="tff">
            <div data-name="value" id="sdiente21" class="dientep">
                <div id="st21" class="cuadropp click"></div>
                <div id="sl21" class="cuadropp izquierdopp click"></div>
                <div id="sb21" class="cuadropp debajopp click"></div>
                <div id="sr21" class="cuadropp derechapp click click"></div>
                <div id="sc21" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente22" class="dientep">
                <div id="st22" class="cuadropp click"></div>
                <div id="sl22" class="cuadropp izquierdopp click"></div>
                <div id="sb22" class="cuadropp debajopp click"></div>
                <div id="sr22" class="cuadropp derechapp click click"></div>
                <div id="sc22" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente23" class="dientep">
                <div id="st23" class="cuadropp click"></div>
                <div id="sl23" class="cuadropp izquierdopp click"></div>
                <div id="sb23" class="cuadropp debajopp click"></div>
                <div id="sr23" class="cuadropp derechapp click click"></div>
                <div id="sc23" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente24" class="dientep">
                <div id="st24" class="cuadropp click"></div>
                <div id="sl24" class="cuadropp izquierdopp click"></div>
                <div id="sb24" class="cuadropp debajopp click"></div>
                <div id="sr24" class="cuadropp derechapp click click"></div>
                <div id="sc24" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente25" class="dientep">
                <div id="st25" class="cuadropp click"></div>
                <div id="sl25" class="cuadropp izquierdopp click"></div>
                <div id="sb25" class="cuadropp debajopp click"></div>
                <div id="sr25" class="cuadropp derechapp click click"></div>
                <div id="sc25" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente26" class="dientep">
                <div id="st26" class="cuadropp click"></div>
                <div id="sl26" class="cuadropp izquierdopp click"></div>
                <div id="sb26" class="cuadropp debajopp click"></div>
                <div id="sr26" class="cuadropp derechapp click click"></div>
                <div id="sc26" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente27" class="dientep">
                <div id="st27" class="cuadropp click"></div>
                <div id="sl27" class="cuadropp izquierdopp click"></div>
                <div id="sb27" class="cuadropp debajopp click"></div>
                <div id="sr27" class="cuadropp derechapp click click"></div>
                <div id="sc27" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente28" class="dientep">
                <div id="st28" class="cuadropp click"></div>
                <div id="sl28" class="cuadropp izquierdopp click"></div>
                <div id="sb28" class="cuadropp debajopp click"></div>
                <div id="sr28" class="cuadropp derechapp click click"></div>
                <div id="sc28" class="centropp click"></div>
            </div>

          </div>
        </td>
      </tr>

      <tr style="background-color:#FF0080;">
        <td>
          <div id="trr">
            <div data-name="value" id="sdiente48" class="dientepp">
                <div id="st48" class="cuadro click"></div>
                <div id="sl48" class="cuadro izquierdo click"></div>
                <div id="sb48" class="cuadro debajo click"></div>
                <div id="sr48" class="cuadro derecha click click"></div>
                <div id="sc48" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente47" class="dientep">
                <div id="st47" class="cuadro click"></div>
                <div id="sl47" class="cuadro izquierdo click"></div>
                <div id="sb47" class="cuadro debajo click"></div>
                <div id="sr47" class="cuadro derecha click click"></div>
                <div id="sc47" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente46" class="dientep">
                <div id="st46" class="cuadro click"></div>
                <div id="sl46" class="cuadro izquierdo click"></div>
                <div id="sb46" class="cuadro debajo click"></div>
                <div id="sr46" class="cuadro derecha click click"></div>
                <div id="sc46" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente45" class="dientep">
                <div id="st45" class="cuadro click"></div>
                <div id="sl45" class="cuadro izquierdo click"></div>
                <div id="sb45" class="cuadro debajo click"></div>
                <div id="sr45" class="cuadro derecha click click"></div>
                <div id="sc45" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente44" class="dientep">
                <div id="st44" class="cuadro click"></div>
                <div id="sl44" class="cuadro izquierdo click"></div>
                <div id="sb44" class="cuadro debajo click"></div>
                <div id="sr44" class="cuadro derecha click click"></div>
                <div id="sc44" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente43" class="dientep">
                <div id="st43" class="cuadro click"></div>
                <div id="sl43" class="cuadro izquierdo click"></div>
                <div id="sb43" class="cuadro debajo click"></div>
                <div id="sr43" class="cuadro derecha click click"></div>
                <div id="sc43" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente42" class="dientep">
                <div id="st42" class="cuadro click"></div>
                <div id="sl42" class="cuadro izquierdo click"></div>
                <div id="sb42" class="cuadro debajo click"></div>
                <div id="sr42" class="cuadro derecha click click"></div>
                <div id="sc42" class="centro click"></div>
            </div>
            <div data-name="value" id="sdiente41" class="dientep">
                <div id="st41" class="cuadro click"></div>
                <div id="sl41" class="cuadro izquierdo click"></div>
                <div id="sb41" class="cuadro debajo click"></div>
                <div id="sr41" class="cuadro derecha click click"></div>
                <div id="sc41" class="centro click"></div>
            </div>

          </div>
        </td>
        <td>
          <div id="tff" >
            <div data-name="value" id="sdiente31" class="dientep">
                <div id="st31" class="cuadropp click"></div>
                <div id="sl31" class="cuadropp izquierdopp click"></div>
                <div id="sb31" class="cuadropp debajopp click"></div>
                <div id="sr31" class="cuadropp derechapp click click"></div>
                <div id="sc31" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente32" class="dientep">
                <div id="st32" class="cuadropp click"></div>
                <div id="sl32" class="cuadropp izquierdopp click"></div>
                <div id="sb32" class="cuadropp debajopp click"></div>
                <div id="sr32" class="cuadropp derechapp click click"></div>
                <div id="sc32" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente33" class="dientep">
                <div id="st33" class="cuadropp click"></div>
                <div id="sl33" class="cuadropp izquierdopp click"></div>
                <div id="sb33" class="cuadropp debajopp click"></div>
                <div id="sr33" class="cuadropp derechapp click click"></div>
                <div id="sc33" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente34" class="dientep">
                <div id="st34" class="cuadropp click"></div>
                <div id="sl34" class="cuadropp izquierdopp click"></div>
                <div id="sb34" class="cuadropp debajopp click"></div>
                <div id="sr34" class="cuadropp derechapp click click"></div>
                <div id="sc34" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente35" class="dientep">
                <div id="st35" class="cuadropp click"></div>
                <div id="sl35" class="cuadropp izquierdopp click"></div>
                <div id="sb35" class="cuadropp debajopp click"></div>
                <div id="sr35" class="cuadropp derechapp click click"></div>
                <div id="sc35" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente36" class="dientep">
                <div id="st36" class="cuadropp click"></div>
                <div id="sl36" class="cuadropp izquierdopp click"></div>
                <div id="sb36" class="cuadropp debajopp click"></div>
                <div id="sr36" class="cuadropp derechapp click click"></div>
                <div id="sc36" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente37" class="dientep">
                <div id="st37" class="cuadropp click"></div>
                <div id="sl37" class="cuadropp izquierdopp click"></div>
                <div id="sb37" class="cuadropp debajopp click"></div>
                <div id="sr37" class="cuadropp derechapp click click"></div>
                <div id="sc37" class="centropp click"></div>
            </div>
            <div data-name="value" id="sdiente38" class="dientep">
                <div id="st38" class="cuadropp click"></div>
                <div id="sl38" class="cuadropp izquierdopp click"></div>
                <div id="sb38" class="cuadropp debajopp click"></div>
                <div id="sr38" class="cuadropp derechapp click click"></div>
                <div id="sc38" class="centropp click"></div>
            </div>
          </div>
        </td>
      </tr>
      <tr><td colspan="2"><table id="separador"><tbody><tr><td>ODONTOGRAMA FINAL</td></tr></tbody></table></td><td></td></tr>
      <tr style="background-color:#FF0080;">
        <td>
          <div id="trr">
            <div data-name="value" id="ediente18" class="dientepp">
                <div id="et18" class="cuadro click"></div>
                <div id="el18" class="cuadro izquierdo click"></div>
                <div id="eb18" class="cuadro debajo click"></div>
                <div id="er18" class="cuadro derecha click click"></div>
                <div id="ec18" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente17" class="dientep">
                <div id="et17" class="cuadro click"></div>
                <div id="el17" class="cuadro izquierdo click"></div>
                <div id="eb17" class="cuadro debajo click"></div>
                <div id="er17" class="cuadro derecha click click"></div>
                <div id="ec17" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente16" class="dientep">
                <div id="et16" class="cuadro click"></div>
                <div id="el16" class="cuadro izquierdo click"></div>
                <div id="eb16" class="cuadro debajo click"></div>
                <div id="er16" class="cuadro derecha click click"></div>
                <div id="ec16" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente15" class="dientep">
                <div id="et15" class="cuadro click"></div>
                <div id="el15" class="cuadro izquierdo click"></div>
                <div id="eb15" class="cuadro debajo click"></div>
                <div id="er15" class="cuadro derecha click click"></div>
                <div id="ec15" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente14" class="dientep">
                <div id="et14" class="cuadro click"></div>
                <div id="el14" class="cuadro izquierdo click"></div>
                <div id="eb14" class="cuadro debajo click"></div>
                <div id="er14" class="cuadro derecha click click"></div>
                <div id="ec14" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente13" class="dientep">
                <div id="et13" class="cuadro click"></div>
                <div id="el13" class="cuadro izquierdo click"></div>
                <div id="eb13" class="cuadro debajo click"></div>
                <div id="er13" class="cuadro derecha click click"></div>
                <div id="ec13" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente12" class="dientep">
                <div id="et12" class="cuadro click"></div>
                <div id="el12" class="cuadro izquierdo click"></div>
                <div id="eb12" class="cuadro debajo click"></div>
                <div id="er12" class="cuadro derecha click click"></div>
                <div id="ec12" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente11" class="dientep">
                <div id="et11" class="cuadro click"></div>
                <div id="el11" class="cuadro izquierdo click"></div>
                <div id="eb11" class="cuadro debajo click"></div>
                <div id="er11" class="cuadro derecha click click"></div>
                <div id="ec11" class="centro click"></div>
            </div>

          </div>
        </td>
        <td>
          <div id="tff">
            <div data-name="value" id="ediente21" class="dientep">
                <div id="et21" class="cuadropp click"></div>
                <div id="el21" class="cuadropp izquierdopp click"></div>
                <div id="eb21" class="cuadropp debajopp click"></div>
                <div id="er21" class="cuadropp derechapp click click"></div>
                <div id="ec21" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente22" class="dientep">
                <div id="et22" class="cuadropp click"></div>
                <div id="el22" class="cuadropp izquierdopp click"></div>
                <div id="eb22" class="cuadropp debajopp click"></div>
                <div id="er22" class="cuadropp derechapp click click"></div>
                <div id="ec22" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente23" class="dientep">
                <div id="et23" class="cuadropp click"></div>
                <div id="el23" class="cuadropp izquierdopp click"></div>
                <div id="eb23" class="cuadropp debajopp click"></div>
                <div id="er23" class="cuadropp derechapp click click"></div>
                <div id="ec23" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente24" class="dientep">
                <div id="et24" class="cuadropp click"></div>
                <div id="el24" class="cuadropp izquierdopp click"></div>
                <div id="eb24" class="cuadropp debajopp click"></div>
                <div id="er24" class="cuadropp derechapp click click"></div>
                <div id="ec24" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente25" class="dientep">
                <div id="et25" class="cuadropp click"></div>
                <div id="el25" class="cuadropp izquierdopp click"></div>
                <div id="eb25" class="cuadropp debajopp click"></div>
                <div id="er25" class="cuadropp derechapp click click"></div>
                <div id="ec25" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente26" class="dientep">
                <div id="et26" class="cuadropp click"></div>
                <div id="el26" class="cuadropp izquierdopp click"></div>
                <div id="eb26" class="cuadropp debajopp click"></div>
                <div id="er26" class="cuadropp derechapp click click"></div>
                <div id="ec26" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente27" class="dientep">
                <div id="et27" class="cuadropp click"></div>
                <div id="el27" class="cuadropp izquierdopp click"></div>
                <div id="eb27" class="cuadropp debajopp click"></div>
                <div id="er27" class="cuadropp derechapp click click"></div>
                <div id="ec27" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente28" class="dientep">
                <div id="et28" class="cuadropp click"></div>
                <div id="el28" class="cuadropp izquierdopp click"></div>
                <div id="eb28" class="cuadropp debajopp click"></div>
                <div id="er28" class="cuadropp derechapp click click"></div>
                <div id="ec28" class="centropp click"></div>
            </div>

          </div>
        </td>
      </tr>

      <tr style="background-color:#FF0080;">
        <td>
          <div id="trr">
            <div data-name="value" id="ediente48" class="dientepp">
                <div id="et48" class="cuadro click"></div>
                <div id="el48" class="cuadro izquierdo click"></div>
                <div id="eb48" class="cuadro debajo click"></div>
                <div id="er48" class="cuadro derecha click click"></div>
                <div id="ec48" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente47" class="dientep">
                <div id="et47" class="cuadro click"></div>
                <div id="el47" class="cuadro izquierdo click"></div>
                <div id="eb47" class="cuadro debajo click"></div>
                <div id="er47" class="cuadro derecha click click"></div>
                <div id="ec47" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente46" class="dientep">
                <div id="et46" class="cuadro click"></div>
                <div id="el46" class="cuadro izquierdo click"></div>
                <div id="eb46" class="cuadro debajo click"></div>
                <div id="er46" class="cuadro derecha click click"></div>
                <div id="ec46" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente45" class="dientep">
                <div id="et45" class="cuadro click"></div>
                <div id="el45" class="cuadro izquierdo click"></div>
                <div id="eb45" class="cuadro debajo click"></div>
                <div id="er45" class="cuadro derecha click click"></div>
                <div id="ec45" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente44" class="dientep">
                <div id="et44" class="cuadro click"></div>
                <div id="el44" class="cuadro izquierdo click"></div>
                <div id="eb44" class="cuadro debajo click"></div>
                <div id="er44" class="cuadro derecha click click"></div>
                <div id="ec44" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente43" class="dientep">
                <div id="et43" class="cuadro click"></div>
                <div id="el43" class="cuadro izquierdo click"></div>
                <div id="eb43" class="cuadro debajo click"></div>
                <div id="er43" class="cuadro derecha click click"></div>
                <div id="ec43" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente42" class="dientep">
                <div id="et42" class="cuadro click"></div>
                <div id="el42" class="cuadro izquierdo click"></div>
                <div id="eb42" class="cuadro debajo click"></div>
                <div id="er42" class="cuadro derecha click click"></div>
                <div id="ec42" class="centro click"></div>
            </div>
            <div data-name="value" id="ediente41" class="dientep">
                <div id="et41" class="cuadro click"></div>
                <div id="el41" class="cuadro izquierdo click"></div>
                <div id="eb41" class="cuadro debajo click"></div>
                <div id="er41" class="cuadro derecha click click"></div>
                <div id="ec41" class="centro click"></div>
            </div>

          </div>
        </td>
        <td>
          <div id="tff" >
            <div data-name="value" id="ediente31" class="dientep">
                <div id="et31" class="cuadropp click"></div>
                <div id="el31" class="cuadropp izquierdopp click"></div>
                <div id="eb31" class="cuadropp debajopp click"></div>
                <div id="er31" class="cuadropp derechapp click click"></div>
                <div id="ec31" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente32" class="dientep">
                <div id="et32" class="cuadropp click"></div>
                <div id="el32" class="cuadropp izquierdopp click"></div>
                <div id="eb32" class="cuadropp debajopp click"></div>
                <div id="er32" class="cuadropp derechapp click click"></div>
                <div id="ec32" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente33" class="dientep">
                <div id="et33" class="cuadropp click"></div>
                <div id="el33" class="cuadropp izquierdopp click"></div>
                <div id="eb33" class="cuadropp debajopp click"></div>
                <div id="er33" class="cuadropp derechapp click click"></div>
                <div id="ec33" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente34" class="dientep">
                <div id="et34" class="cuadropp click"></div>
                <div id="el34" class="cuadropp izquierdopp click"></div>
                <div id="eb34" class="cuadropp debajopp click"></div>
                <div id="er34" class="cuadropp derechapp click click"></div>
                <div id="ec34" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente35" class="dientep">
                <div id="et35" class="cuadropp click"></div>
                <div id="el35" class="cuadropp izquierdopp click"></div>
                <div id="eb35" class="cuadropp debajopp click"></div>
                <div id="er35" class="cuadropp derechapp click click"></div>
                <div id="ec35" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente36" class="dientep">
                <div id="et36" class="cuadropp click"></div>
                <div id="el36" class="cuadropp izquierdopp click"></div>
                <div id="eb36" class="cuadropp debajopp click"></div>
                <div id="er36" class="cuadropp derechapp click click"></div>
                <div id="ec36" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente37" class="dientep">
                <div id="et37" class="cuadropp click"></div>
                <div id="el37" class="cuadropp izquierdopp click"></div>
                <div id="eb37" class="cuadropp debajopp click"></div>
                <div id="er37" class="cuadropp derechapp click click"></div>
                <div id="ec37" class="centropp click"></div>
            </div>
            <div data-name="value" id="ediente38" class="dientep">
                <div id="et38" class="cuadropp click"></div>
                <div id="el38" class="cuadropp izquierdopp click"></div>
                <div id="eb38" class="cuadropp debajopp click"></div>
                <div id="er38" class="cuadropp derechapp click click"></div>
                <div id="ec38" class="centropp click"></div>
            </div>
          </div>
        </td>
      </tr>
  </tbody>
</table>
  </div>
  <!--fin wrapper-->
  <!--fin odontograma fabian-->
  <br>
  <div class="">
    <b>MATERIALES</b>
  </div>
  <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <textarea readonly onmousedown="return false;" name="materiales" id="materiales" rows="6" class="form-control"><?php if(isset($pat['operativematerial'])) echo $pat['operativematerial'];?></textarea>
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

    if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['operativestatus'])&&$pat['operativestatus']!='fail'&&$pat['operativestatus']!='canceled'){
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
  a['st18']='';a['sl18']='';a['sb18']='';a['sr18']='';a['sc18']='';
  a['st17']='';a['sl17']='';a['sb17']='';a['sr17']='';a['sc17']='';
  a['st16']='';a['sl16']='';a['sb16']='';a['sr16']='';a['sc16']='';
  a['st15']='';a['sl15']='';a['sb15']='';a['sr15']='';a['sc15']='';
  a['st14']='';a['sl14']='';a['sb14']='';a['sr14']='';a['sc14']='';
  a['st13']='';a['sl13']='';a['sb13']='';a['sr13']='';a['sc13']='';
  a['st12']='';a['sl12']='';a['sb12']='';a['sr12']='';a['sc12']='';
  a['st11']='';a['sl11']='';a['sb11']='';a['sr11']='';a['sc11']='';

  a['st21']='';a['sl21']='';a['sb21']='';a['sr21']='';a['sc21']='';
  a['st22']='';a['sl22']='';a['sb22']='';a['sr22']='';a['sc22']='';
  a['st23']='';a['sl23']='';a['sb23']='';a['sr23']='';a['sc23']='';
  a['st24']='';a['sl24']='';a['sb24']='';a['sr24']='';a['sc24']='';
  a['st25']='';a['sl25']='';a['sb25']='';a['sr25']='';a['sc25']='';
  a['st26']='';a['sl26']='';a['sb26']='';a['sr26']='';a['sc26']='';
  a['st27']='';a['sl27']='';a['sb27']='';a['sr27']='';a['sc27']='';
  a['st28']='';a['sl28']='';a['sb28']='';a['sr28']='';a['sc28']='';

  a['st48']='';a['sl48']='';a['sb48']='';a['sr48']='';a['sc48']='';
  a['st47']='';a['sl47']='';a['sb47']='';a['sr47']='';a['sc47']='';
  a['st46']='';a['sl46']='';a['sb46']='';a['sr46']='';a['sc46']='';
  a['st45']='';a['sl45']='';a['sb45']='';a['sr45']='';a['sc45']='';
  a['st44']='';a['sl44']='';a['sb44']='';a['sr44']='';a['sc44']='';
  a['st43']='';a['sl43']='';a['sb43']='';a['sr43']='';a['sc43']='';
  a['st42']='';a['sl42']='';a['sb42']='';a['sr42']='';a['sc42']='';
  a['st41']='';a['sl41']='';a['sb41']='';a['sr41']='';a['sc41']='';

  a['st31']='';a['sl31']='';a['sb31']='';a['sr31']='';a['sc31']='';
  a['st32']='';a['sl32']='';a['sb32']='';a['sr32']='';a['sc32']='';
  a['st33']='';a['sl33']='';a['sb33']='';a['sr33']='';a['sc33']='';
  a['st34']='';a['sl34']='';a['sb34']='';a['sr34']='';a['sc34']='';
  a['st35']='';a['sl35']='';a['sb35']='';a['sr35']='';a['sc35']='';
  a['st36']='';a['sl36']='';a['sb36']='';a['sr36']='';a['sc36']='';
  a['st37']='';a['sl37']='';a['sb37']='';a['sr37']='';a['sc37']='';
  a['st38']='';a['sl38']='';a['sb38']='';a['sr38']='';a['sc38']='';



  a['et18']='';a['el18']='';a['eb18']='';a['er18']='';a['ec18']='';
  a['et17']='';a['el17']='';a['eb17']='';a['er17']='';a['ec17']='';
  a['et16']='';a['el16']='';a['eb16']='';a['er16']='';a['ec16']='';
  a['et15']='';a['el15']='';a['eb15']='';a['er15']='';a['ec15']='';
  a['et14']='';a['el14']='';a['eb14']='';a['er14']='';a['ec14']='';
  a['et13']='';a['el13']='';a['eb13']='';a['er13']='';a['ec13']='';
  a['et12']='';a['el12']='';a['eb12']='';a['er12']='';a['ec12']='';
  a['et11']='';a['el11']='';a['eb11']='';a['er11']='';a['ec11']='';

  a['et21']='';a['el21']='';a['eb21']='';a['er21']='';a['ec21']='';
  a['et22']='';a['el22']='';a['eb22']='';a['er22']='';a['ec22']='';
  a['et23']='';a['el23']='';a['eb23']='';a['er23']='';a['ec23']='';
  a['et24']='';a['el24']='';a['eb24']='';a['er24']='';a['ec24']='';
  a['et25']='';a['el25']='';a['eb25']='';a['er25']='';a['ec25']='';
  a['et26']='';a['el26']='';a['eb26']='';a['er26']='';a['ec26']='';
  a['et27']='';a['el27']='';a['eb27']='';a['er27']='';a['ec27']='';
  a['et28']='';a['el28']='';a['eb28']='';a['er28']='';a['ec28']='';

  a['et48']='';a['el48']='';a['eb48']='';a['er48']='';a['ec48']='';
  a['et47']='';a['el47']='';a['eb47']='';a['er47']='';a['ec47']='';
  a['et46']='';a['el46']='';a['eb46']='';a['er46']='';a['ec46']='';
  a['et45']='';a['el45']='';a['eb45']='';a['er45']='';a['ec45']='';
  a['et44']='';a['el44']='';a['eb44']='';a['er44']='';a['ec44']='';
  a['et43']='';a['el43']='';a['eb43']='';a['er43']='';a['ec43']='';
  a['et42']='';a['el42']='';a['eb42']='';a['er42']='';a['ec42']='';
  a['et41']='';a['el41']='';a['eb41']='';a['er41']='';a['ec41']='';

  a['et31']='';a['el31']='';a['eb31']='';a['er31']='';a['ec31']='';
  a['et32']='';a['el32']='';a['eb32']='';a['er32']='';a['ec32']='';
  a['et33']='';a['el33']='';a['eb33']='';a['er33']='';a['ec33']='';
  a['et34']='';a['el34']='';a['eb34']='';a['er34']='';a['ec34']='';
  a['et35']='';a['el35']='';a['eb35']='';a['er35']='';a['ec35']='';
  a['et36']='';a['el36']='';a['eb36']='';a['er36']='';a['ec36']='';
  a['et37']='';a['el37']='';a['eb37']='';a['er37']='';a['ec37']='';
  a['et38']='';a['el38']='';a['eb38']='';a['er38']='';a['ec38']='';

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
      a[c[0]]=c[1];
      if(c[1]=='click-red'||c[1]=='click-blue'||c[1]=='click-yellow'){
        $('#'+c[0]).addClass(c[1]);
      }
      if(c[1]=='gra'){
        if(c[0].charAt(2)==2||c[0].charAt(2)==3){
          $('#'+c[0]).parent().append('<i style="color:black;" class="fa fa-times fa-3x fa-fw"></i>');
          $('#'+c[0]).parent().children("i").css({
              "position": "absolute",
              "top": "23%",
              "left": "-0.5ex"
          });
        }else{
          $('#'+c[0]).parent().append('<i style="color:black;" class="fa fa-times fa-3x fa-fw"></i>');
          $('#'+c[0]).parent().children("i").css({
              "position": "absolute",
              "top": "23%",
              "left": "1.1ex"
          });
        }
      }
    }
  }
  descript(`<?php echo trim($pat["operativeodontogram"]); ?>`);
  $(".click").click(function(event) {
    var control = $('input:radio[name=options]:checked').parent().attr('id');
    var desc=$(this).attr('id');//que es una X
    if(control!='not'){
      var color='';
      if(control=='red')
        color="click-red";
      if(control=='blue')
        color="click-blue";
      if(control=='yellow')
        color="click-yellow";
      if(color=='')
        return false;
      if ($(this).hasClass(color)) {
          $(this).removeClass(color);
          a[desc]='';
      } else {
         $(this).addClass(color);
         a[desc]=color;
      }
    }else{
      var cont=0;
      $(this).parent().children().each(function(index, el) {
          console.log(index);
          cont++;
      });
      if(cont>=5){
        if(cont==5){
          if(desc.charAt(2)==2||desc.charAt(2)==3){
            $(this).parent().append('<i style="color:black;" class="fa fa-times fa-3x fa-fw"></i>');
            $(this).parent().children("i").css({
                "position": "absolute",
                "top": "23%",
                "left": "-0.5ex"
            });
            a[desc]='gra';
          }else{
            $(this).parent().append('<i style="color:black;" class="fa fa-times fa-3x fa-fw"></i>');
            $(this).parent().children("i").css({
                "position": "absolute",
                "top": "23%",
                "left": "1.1ex"
            });
            a[desc]='gra';
          }
        }else{
          $(this).parent().children("svg").remove();
          a[desc]='';
          var com1=desc.charAt(0)+'t'+desc.charAt(2)+desc.charAt(3);
          var com2=desc.charAt(0)+'l'+desc.charAt(2)+desc.charAt(3);
          var com3=desc.charAt(0)+'r'+desc.charAt(2)+desc.charAt(3);
          var com4=desc.charAt(0)+'b'+desc.charAt(2)+desc.charAt(3);
          var com5=desc.charAt(0)+'c'+desc.charAt(2)+desc.charAt(3);
          if(a[com1]=='gra')
            a[com1]='';
          if(a[com2]=='gra')
            a[com2]='';
          if(a[com3]=='gra')
            a[com3]='';
          if(a[com4]=='gra')
            a[com4]='';
          if(a[com5]=='gra')
            a[com5]='';
        }

      }
    }
    encript();
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

              url:"../include/i_operative.php",
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
       contenido+='<td><input type="text" name="caries[]" class="form-control" value=""></td>';
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
          url:"../include/i_operative.php",
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
