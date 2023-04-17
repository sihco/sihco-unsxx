<?php
require('header.php');
$fill=false;
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBPediatricsiInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=7&&$pat["clinicalid"]!=15)
    ForceLoad("index.php");
  if(isset($_GET["status"])){
    if($_GET['status']=='new'&&$r['pediatricsistatus']=='new'){
      $fill=true;
    }else {
      ForceLoad("register.php");
    }
  }
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

                        <h2 align="center" class="mt-4">
                          <?php
                          if($pat["clinicalid"]==7){
                            echo "Ficha Clinica de Odontopediatria I";
                          }elseif ($pat["clinicalid"]==15) {
                            echo "Ficha Clinica de Odontopediatria II";
                          }
                          ?>
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'){
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
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']=='fail'){
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
    <?php if($fill==true){ ?>
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
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12">
                          <input type="datetime-local" id="meeting-time" name="meeting-time"
                     name="meeting-time" value="<?php  if(isset($pat['updatetime'])&&is_numeric($pat['updatetime'])){
                       echo datetimeconv($pat['updatetime'],true); }else{echo datetimeconv(time(),true);}?>"
                     min="2000-01-01T00:00" max="2100-01-01T00:00" class="form-control">
                        </div>
                        <div class="col-6">
                          <u>Docente Autorizador:</u>
                        </div>
                        <div class="col-6">
                          <select name="teacher" class="form-select" aria-label="Default select example">
                            <?php
                            $cl=7;
                            if(isset($pat["clinicalid"])){
                                $cl=$pat["clinicalid"];
                            }
                            $tuser=DBTeachersInfo($cl, true);
                            $size=count($tuser);
                            echo "<option selected value=''>--</option>\n";
                            for ($i=0; $i < $size; $i++) {
                              if($pat['teacher']==$tuser[$i]['teacherid']){
                                echo "<option value='".$tuser[$i]['teacherid']."' selected>".ucwords($tuser[$i]['teachername'])."</option>\n";
                              }else{
                                echo "<option value='".$tuser[$i]['teacherid']."'>".ucwords($tuser[$i]['teachername'])."</option>\n";
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                    </div>
                    <div class="from-group">
                      <label for="probleminput">Subir Ficha Clínica Culminado en .pdf</label>
                      <input type="file" name="finalinput" accept=".pdf" id="finalinput" class="form-control" value="">
                    </div>
                    <br>
                    <div class="from-group">
                        <?php
                        if ($pat["pediatricsiinputfile"] != null) {
                              $tx = $pat["pediatricsiinputfilehash"];
                              echo "  <a href=\"../filedownload.php?" . filedownload($pat["pediatricsiinputfile"] ,$pat["pediatricsiinputfilename"]) ."\">" .
                                    $pat["pediatricsiinputfilename"] . "</a> <a href=\"#\" class=\"btn btn-primary btn-sm\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".filedownload($pat["pediatricsiinputfile"], $pat["pediatricsiinputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\">Ver Ficha Clínica</a>" .
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
                      if(isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'){
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
    <?php } ?>
    <div class="row">
      <label for="patientfullname"><b>Paciente:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?></label><br>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-7 col-7">
        <label for="patientnationality"><b>Nacionalidad:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientnationality"])) echo $pat["patientnationality"];  ?></label>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-5 col-5">
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
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="patientdatebirth"><b>Fecha de nacimiento:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="date" id="patientdatebirth" class="form-control" name="patientdatebirth" value="<?php if(isset($pat["patientdatebirth"])) echo $pat["patientdatebirth"];  ?>" min="1990-01-01" max="2099-01-01">
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="patientplacebirth"><b>Lugar de nacimiento:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="text" class="form-control" name="patientplacebirth" id="patientplacebirth" value="<?php if(isset($pat["patientplacebirth"])) echo $pat["patientplacebirth"];  ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="patientfathername"><b>Nombre del padre:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="text" class="form-control" name="patientfathername" id="patientfathername" value="<?php if(isset($pat["patientfathername"])) echo $pat["patientfathername"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="patientfatheroccupation"><b>Ocupación:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="text" class="form-control" name="patientfatheroccupation" id="patientfatheroccupation" value="<?php if(isset($pat["patientfatheroccupation"])) echo $pat["patientfatheroccupation"];  ?>">
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="patientmothername"><b>Nombre de la madre:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="text" class="form-control" name="patientmothername" id="patientmothername" value="<?php if(isset($pat["patientmothername"])) echo $pat["patientmothername"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <label for="patientmotheroccupation"><b>Ocupación:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="text" class="form-control" name="patientmotheroccupation" id="patientmotheroccupation" value="<?php if(isset($pat["patientmotheroccupation"])) echo $pat["patientmotheroccupation"];?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <label for="information"><u><b>Hermanos:</b></u></label>
      <div class="col-12">
        <?php
        //echo $pat['patientbrothers'];
        $bro=explode('#',$pat['patientbrothers']);
        $abrother=array();
        $s=count($bro);
        if($s>1){
          $names=explode(',',$bro[0]);
          $ages=explode(',',$bro[1]);
          $size=count($names);
          for ($i=0; $i < $size-1; $i++) {
              $abrother[$names[$i]]=$ages[$i];
          }
        }


        $ii=0;
        foreach ($abrother as $key => $value) {
          //echo $key.'=>'.$value.':';

          if($ii==0){
            echo "<div id=\"information\">".
              "<label for=\"name\">Nombre</label>".
              "<input type=\"text\" class=\"form-control d-inline names\" style=\"width:30%;\" name=\"name[]\" value=\"".$key."\">".
              "<label for=\"age\">Edad</label>".
              "<input type=\"text\" class=\"form-control d-inline ages\" style=\"width:30%;\" name=\"age[]\" value=\"".$value."\">".
            "</div>";
          }else{
            echo "<div>".
                "<label for=\"name\">Nombre</label>".
                "<input type=\"text\" class=\"form-control d-inline names\" style=\"width:30%;\" name=\"name[]\" value=\"".$key."\">".
                "<label for=\"age\">Edad</label>".
                "<input type=\"text\" class=\"form-control d-inline ages\" style=\"width:30%;\" name=\"age[]\" value=\"".$value."\">".
                "<button type=\"button\" class=\"btn btn-danger btn-sm m-3 remove\" name=\"\"> - Eliminar</button>".
            "</div>";
          }
          $ii++;
        }
        if($ii==0){
          echo "<div id=\"information\">".
            "<label for=\"name\">Nombre</label>".
            "<input type=\"text\" class=\"form-control d-inline names\" style=\"width:30%;\" name=\"name[]\" >".
            "<label for=\"age\">Edad</label>".
            "<input type=\"text\" class=\"form-control d-inline ages\" style=\"width:30%;\" name=\"age[]\" >".
          "</div>";
        }
        ?>



        <button type="button" class="btn btn-success btn-sm m-3" id="add" name=""> + Agregar otro Hermano</button>

      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientdirection"><b>Domicilio:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"];  ?></label>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <label for="patientlocation"><b>Localidad:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientlocation"])) echo $pat["patientlocation"];  ?></label>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="patientdatebirth"><b>Escuela:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="text" class="form-control" name="patientschools" id="patientschools" value="<?php if(isset($pat["patientschools"])) echo $pat["patientschools"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="patientschool"><b>Grado que cursa:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input type="text" class="form-control" name="patientschool" id="patientschool" value="<?php if(isset($pat["patientschool"])) echo $pat["patientschool"];  ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
            <label for="refer"><b>Quién lo Refiere:</b></label>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <input class="form-control" type="text" name="refer" id="refer" value="<?php if(isset($pat["pediatricsirefer"])) echo $pat["pediatricsirefer"];  ?>">
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <label for="reason"><b>Por que Razón:</b></label>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <textarea class="d-inline-block form-control" name="reason" id="reason" rows="4"><?php if(isset($pat["pediatricsireason"])) echo $pat["pediatricsireason"];  ?></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <label for=""><b>Signos Vitales.</b></label>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <div class="row">
          <div class="col-6">
            <label for="">Temperatura:</label>
          </div>
          <div class="col-6">
            <input class="form-control" type="text" name="temp" id="temp" value="<?php if(isset($pat["temp"])) echo $pat["temp"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <div class="row">
          <div class="col-4">
            <label for="">F.C:</label>
          </div>
          <div class="col-8">
            <input class="form-control" type="text" name="fc" id="fc" value="<?php if(isset($pat["fc"])) echo $pat["fc"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <div class="row">
          <div class="col-4">
            <label for="">F.R:</label>
          </div>
          <div class="col-8">
            <input class="form-control" type="text" name="fr" id="fr" value="<?php if(isset($pat["fr"])) echo $pat["fr"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <div class="row">
          <div class="col-6">
            <label for="">P.Art. Sist:</label>
          </div>
          <div class="col-6">
            <input class="form-control" type="text" name="pd" id="pd" value="<?php if(isset($pat["pd"])) echo $pat["pd"];  ?>">
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-lg-2 col-md-2 col-sm-6 col-6">
        <div class="row">
          <div class="col-4">
            <label for="">Talla:</label>
          </div>
          <div class="col-8">
            <input class="form-control" type="text" name="talla" id="talla" value="<?php if(isset($pat["talla"])) echo $pat["talla"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-6 col-6">
        <div class="row">
          <div class="col-4">
            <label for="">Peso:</label>
          </div>
          <div class="col-8">
            <input class="form-control" type="text" name="peso" id="peso" value="<?php if(isset($pat["peso"])) echo $pat["peso"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <div class="row">
          <div class="col-6">
            <label for="">Constitución:</label>
          </div>
          <div class="col-6">
            <input class="form-control" type="text" name="constit" id="constit" value="<?php if(isset($pat["constit"])) echo $pat["constit"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-6 col-6">
        <div class="row">
          <div class="col-4">
            <label for="">Pulso:</label>
          </div>
          <div class="col-8">
            <input class="form-control" type="text" name="pulso" id="pulso" value="<?php if(isset($pat["pulso"])) echo $pat["pulso"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-6">
        <div class="row">
          <div class="col-6">
            <label for="">P. Art. Diast:</label>
          </div>
          <div class="col-6">
            <input class="form-control" type="text" name="diast" id="diast" value="<?php if(isset($pat["diast"])) echo $pat["diast"];  ?>">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <label for=""><b>Motivo de la Consulta</b></label>
        <textarea class="form-control" name="motconsult" id="motconsult"rows="4"><?php if(isset($pat["pediatricsimotconsult"])&& $pat["pediatricsimotconsult"]){ echo $pat["pediatricsimotconsult"];}else{ if(isset($pat["motconsult"])) echo $pat["motconsult"];}  ?></textarea>
      </div>
      <div class="col-6">
        <label for=""><b>Actitud del niño y de sus padres</b></label>
        <textarea class="form-control" name="attitude" id="attitude" rows="4"><?php if(isset($pat["pediatricsiattitude"])) echo $pat["pediatricsiattitude"];  ?></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-6 col-4">
            <label for="">N. Sillón:</label>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-6">
            <input class="form-control" type="text" name="chair" id="chair" value="<?php if(isset($pat["pediatricsiarmchair"])&&$pat["pediatricsiarmchair"]!=-1) echo $pat["pediatricsiarmchair"];  ?>">
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="row">
          <div class="col-lg-5 col-md-5 col-sm-12 col-12">
              <label for="">Docente Responsable:</label>
          </div>
          <div class="col-lg-7 col-md-7 col-sm-12 col-12">
            <?php if(isset($pat["teacher"]) && $pat['teacher']!=0) {$i=DBUserInfo($pat['teacher']); echo $i['userfullname'];}?>
          </div>
        </div>
      </div>
    </div>
  <!--</div>-->

</div>
<hr>

<div class="border border-primary rounded px-3">
  <p><b>ANTECEDENTES ODONTOLOGICOS</b></p>
  <span>Del Niño</span>
  <div class="row">
    <div class="col-6">
      <label for="">Atension previa:</label>
      <input class="form-control d-inline-block" type="text" name="prior" id="prior" value="<?php if(isset($pat["pediatricsiprior"])) echo $pat["pediatricsiprior"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Fecha de la utima atención:</label>
      <input class="form-control d-inline-block" type="text" name="lastattention" id="lastattention" value="<?php if(isset($pat["pediatricsilastattention"])) echo $pat["pediatricsilastattention"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Atención periódica:</label>
      <input class="form-control d-inline-block" type="text" name="periodica" id="periodica" value="<?php if(isset($pat["periodica"])) echo $pat["periodica"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Cada cuanto?:</label>
      <input class="form-control d-inline-block" type="text" name="periodicacuales" id="periodicacuales" value="<?php if(isset($pat["periodicacuales"])) echo $pat["periodicacuales"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Mencionar experiencias traumaticas:</label>
      <input class="form-control d-inline-block" type="text" name="traumaticas" id="traumaticas" value="<?php if(isset($pat["traumaticas"])) echo $pat["traumaticas"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Cuales?:</label>

      <textarea class="form-control" name="traumaticascuales" id="traumaticascuales" rows="4"><?php if(isset($pat["traumaticascuales"])) echo $pat["traumaticascuales"];  ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">Actitud del niño frente a la odontologia:</label>
      <textarea class="form-control" name="attitudeodont" id="attitudeodont" rows="2"><?php if(isset($pat["pediatricsiodontoattitude"])) echo $pat["pediatricsiodontoattitude"];  ?></textarea>
    </div>
  </div>
  <label for=""><b>ANTECEDENTES MEDICOS DEL NIÑO</b></label>
  <div class="row">
    <div class="col-12">
      <label for="">Enfermedades del: Sistema respiratorio, circulatorio, digestivo, renal, alergias, fiebre Rematica, accidentes:</label>
      <textarea class="form-control" name="diseases" id="diseases" rows="2"><?php if(isset($pat["pediatricsidiseases"])) echo $pat["pediatricsidiseases"];  ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">Intervenciones quirurgicas:</label>
      <input class="form-control d-inline-block" type="text" name="interventions" id="interventions" value="<?php if(isset($pat["pediatricsiinterventions"])) echo $pat["pediatricsiinterventions"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Con explicaciones previas:</label>
      <input class="form-control d-inline-block" type="text" name="conexplicaciones" id="conexplicaciones" value="<?php if(isset($pat["conexplicaciones"])) echo $pat["conexplicaciones"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Sin explicaciones:</label>
      <input class="form-control d-inline-block" type="text" name="sinconexplicaciones" id="sinconexplicaciones" value="<?php if(isset($pat["sinconexplicaciones"])) echo $pat["sinconexplicaciones"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Experiencias traumaticas(Inyecciones):</label>
      <input class="form-control d-inline-block" type="text" name="experienciastraumaticas" id="experienciastraumaticas" value="<?php if(isset($pat["experienciastraumaticas"])) echo $pat["experienciastraumaticas"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Otras:</label>
      <input class="form-control d-inline-block" type="text" name="experienciastraumaticasotros" id="experienciastraumaticasotros" value="<?php if(isset($pat["experienciastraumaticasotros"])) echo $pat["experienciastraumaticasotros"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Va al medico periodicamente:</label>
      <input class="form-control d-inline-block" type="text" name="medicoperiodicamente" id="medicoperiodicamente" value="<?php if(isset($pat["medicoperiodicamente"])) echo $pat["medicoperiodicamente"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Irregularmente:</label>
      <input class="form-control d-inline-block" type="text" name="medicoirregularmente" id="medicoirregularmente" value="<?php if(isset($pat["medicoirregularmente"])) echo $pat["medicoirregularmente"];  ?>">
    </div>
  </div>
  <label for=""><b>ALIMENTACION</b></label>
  <div class="row">
    <div class="col-12">
      <label for="">Tipo y consistencia:</label>
      <textarea class="form-control"name="consistency" id="consistency" rows="2"><?php if(isset($pat["pediatricsiconsistency"])) echo $pat["pediatricsiconsistency"];  ?></textarea>
    </div>
  </div>
  <label for="">Dieta:(en relacion con el consumo de Hidratos de Carbono)</label>
  <div class="row">
    <div class="col-6">
      <label for="">Desayuno:</label>
      <input class="form-control d-inline-block" type="text" name="desayuno" id="desayuno" value="<?php if(isset($pat["desayuno"])) echo $pat["desayuno"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Entre desayuno y almuerzo:</label>
      <input class="form-control d-inline-block" type="text" name="desayunoalmuerzo" id="desayunoalmuerzo" value="<?php if(isset($pat["desayunoalmuerzo"])) echo $pat["desayunoalmuerzo"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Almuerzo:</label>
      <input class="form-control d-inline-block" type="text" name="almuerzo" id="almuerzo" value="<?php if(isset($pat["almuerzo"])) echo $pat["almuerzo"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Merienda:</label>
      <input class="form-control d-inline-block" type="text" name="merienda" id="merienda" value="<?php if(isset($pat["merienda"])) echo $pat["merienda"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Cena:</label>
      <input class="form-control d-inline-block" type="text" name="cena" id="cena" value="<?php if(isset($pat["cena"])) echo $pat["cena"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Despues de la cena, antes de acostarse:</label>
      <input class="form-control d-inline-block" type="text" name="despuescena" id="despuescena" value="<?php if(isset($pat["despuescena"])) echo $pat["despuescena"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Durante la noche si se despierta:</label>
      <input class="form-control d-inline-block" type="text" name="despierta" id="despierta" value="<?php if(isset($pat["despierta"])) echo $pat["despierta"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Número de veces que consume azucar o dulce por dia:</label>
      <input class="form-control d-inline-block" type="text" name="dulcedia" id="dulcedia" value="<?php if(isset($pat["dulcedia"])) echo $pat["dulcedia"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Riesgo de caries: Bajo(0 a 4)</label>
      <input class="form-control d-inline-block" type="text" name="riesgocaries" id="riesgocaries" value="<?php if(isset($pat["riesgocaries"])) echo $pat["riesgocaries"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Actitud del niño frente a la alimentación:</label>
      <input class="form-control d-inline-block" type="text" name="actitudalimentacion" id="actitudalimentacion" value="<?php if(isset($pat["actitudalimentacion"])) echo $pat["actitudalimentacion"];  ?>">
    </div>
  </div>
  <br>
</div>
<hr>
<div class="border border-primary rounded px-3">
  <label for=""><b>CONTROL MECANICO DE PLACA BACTERIANA</b></label>
  <div class="row">

    <div class="col-6">
      <label for="">Con técnica:</label>
      <select name="tecnicabacterial" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['tecnicabacterial']) || $pat["tecnicabacterial"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['tecnicabacterial']) && $pat["tecnicabacterial"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['tecnicabacterial']) && $pat["tecnicabacterial"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>
    </div>
    <div class="col-6">
      <label for="">Enseñada por:</label>
      <input class="form-control d-inline-block" type="text" name="ensenadopor" id="ensenadopor" value="<?php if(isset($pat["ensenadopor"])) echo $pat["ensenadopor"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <label for="">Tipo de cepillo:</label>
      <input class="form-control d-inline-block" type="text" name="tipocepillo" id="tipocepillo" value="<?php if(isset($pat["tipocepillo"])) echo $pat["tipocepillo"];  ?>">
    </div>
    <div class="col-6">
      <label for="">Dentifrico:</label>
      <select name="dentifrico" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['dentifrico']) || $pat["dentifrico"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['dentifrico']) && $pat["dentifrico"] == 'nousa') echo "selected"; ?> value="nousa">No usa</option>
        <option <?php if(isset($pat['dentifrico']) && $pat["dentifrico"] == 'unocomun') echo "selected"; ?> value="unocomun">Uno común</option>
        <option <?php if(isset($pat['dentifrico']) && $pat["dentifrico"] == 'confluoruro') echo "selected"; ?> value="confluoruro">Con fluoruro</option>
        <option <?php if(isset($pat['dentifrico']) && $pat["dentifrico"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
      </select>
    </div>
  </div>
  <label for="">TERAPIA CON FLUORUROS</label>
  <div class="row">
    <div class="col-4">
      <label for="">Fluoruros Ingesta</label>
      <select name="fluoruros" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['fluoruros']) || $pat["fluoruros"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['fluoruros']) && $pat["fluoruros"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['fluoruros']) && $pat["fluoruros"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>

    </div>
    <div class="col-4">
      <label for="">Desde que edad?:</label>
      <input class="form-control d-inline-block" type="text" name="foururoedad" id="foururoedad" value="<?php if(isset($pat["foururoedad"])) echo $pat["foururoedad"];  ?>">
    </div>
    <div class="col-4">
      <label for="">En forma continua o discontinua:</label>
      <input class="form-control d-inline-block" type="text" name="foururocontinua" id="foururocontinua" value="<?php if(isset($pat["foururocontinua"])) echo $pat["foururocontinua"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-4">
      <label for="">Fluoruros Topicos</label>
      <select name="topicos" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['topicos']) || $pat["topicos"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['topicos']) && $pat["topicos"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['topicos']) && $pat["topicos"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>

    </div>
    <div class="col-4">
      <label for="">Cada cuanto tiempo?:</label>
      <input class="form-control d-inline-block" type="text" name="topicostiempo" id="topicostiempo" value="<?php if(isset($pat["topicostiempo"])) echo $pat["topicostiempo"];  ?>">
    </div>
    <div class="col-4">
      <label for="">En forma continua o discontinua:</label>
      <input class="form-control d-inline-block" type="text" name="topicoscontinua" id="topicoscontinua" value="<?php if(isset($pat["topicoscontinua"])) echo $pat["topicoscontinua"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-4">
      <label for="">Enjuagatorios Fluorados</label>
      <select name="enjuagatorio" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['enjuagatorio']) || $pat["enjuagatorio"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['enjuagatorio']) && $pat["enjuagatorio"] == 'diarios') echo "selected"; ?> value="diarios">Diarios</option>
        <option <?php if(isset($pat['enjuagatorio']) && $pat["enjuagatorio"] == 'semanal') echo "selected"; ?> value="semanal">Semanal</option>
        <option <?php if(isset($pat['enjuagatorio']) && $pat["enjuagatorio"] == 'quincenal') echo "selected"; ?> value="quincenal">Quincenal</option>
      </select>

    </div>

    <div class="col-4">
      <label for="">En forma continua o discontinua:</label>
      <input class="form-control d-inline-block" type="text" name="enjuagatoriocontinua" id="enjuagatoriocontinua" value="<?php if(isset($pat["enjuagatoriocontinua"])) echo $pat["enjuagatoriocontinua"];  ?>">
    </div>
    <div class="col-4">
      <label for="">Selladores</label>
      <select name="sealants" class="form-select" aria-label="Default select example">
        <option <?php if(!isset($pat['pediatricsisealants']) || $pat["pediatricsisealants"] == '') echo "selected"; ?> value="">--</option>
        <option <?php if(isset($pat['pediatricsisealants']) && $pat["pediatricsisealants"] == 'si') echo "selected"; ?> value="si">Si</option>
        <option <?php if(isset($pat['pediatricsisealants']) && $pat["pediatricsisealants"] == 'no') echo "selected"; ?> value="no">No</option>
      </select>

    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">Habitos Orales:</label>
      <textarea class="form-control"name="oralhabits" id="oralhabits" rows="2"><?php if(isset($pat["pediatricsioralhabits"])) echo $pat["pediatricsioralhabits"];  ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">Resumir brevemente la actitud de los padres frente al interrogatorio:</label>
      <textarea class="form-control"name="resumefather" id="resumefather" rows="3"><?php if(isset($pat["pediatricsiresumefather"])) echo $pat["pediatricsiresumefather"];  ?></textarea>
    </div>
  </div>
  <label for=""><b>PRIMERA VISITA</b></label>
  <div class="row">
    <div class="col-4">
      <label for="">Actitud del niño</label>
      <input class="form-control d-inline-block" type="text" name="actituddelnino" id="actituddelnino" value="<?php if(isset($pat["actituddelnino"])) echo $pat["actituddelnino"];  ?>">
    </div>
    <div class="col-4">
      <label for="">Actitud de los padres:</label>
      <input class="form-control d-inline-block" type="text" name="actituddelpadre" id="actituddelpadre" value="<?php if(isset($pat["actituddelpadre"])) echo $pat["actituddelpadre"];  ?>">
    </div>
    <div class="col-4">
      <label for="">o acompañantes:</label>
      <input class="form-control d-inline-block" type="text" name="actitudacompanante" id="actitudacompanante" value="<?php if(isset($pat["actitudacompanante"])) echo $pat["actitudacompanante"];  ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <label for="">SINTESIS de la historia y de la primera visita con el objeto de orientar el tratamiento:</label>
      <textarea class="form-control"name="firstsynthesis" id="firstsynthesis" rows="3"><?php if(isset($pat["pediatricsifirstsynthesis"])) echo $pat["pediatricsifirstsynthesis"];  ?></textarea>
    </div>
  </div>
</div>
<hr>
<div class="border border-primary rounded px-3">
  <div class="row">
    <label for=""><b>ODONTOGRAMA</b></label>
    <input type="hidden" name="odontogram" id="odontogram" value="<?php if(isset($pat["odontogramid"])) echo $pat["odontogramid"];  ?>">
    <div class="col-12">
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
      <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat["draw"])) echo $pat["draw"];?>">
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <div class="row">
        <div class="col-3">
          <label for="">CPOD</label>
        </div>
        <div class="col-9">
          <input class="form-control" type="text" name="cpod" id="cpod" value="<?php if(isset($pat["cpod"])) echo $pat["cpod"];  ?>">
        </div>
        <div class="col-3">
          <label for=""> CPOS</label>
        </div>
        <div class="col-9">
          <input class="form-control" type="text" name="cpos" id="cpos" value="<?php if(isset($pat["cpos"])) echo $pat["cpos"];  ?>">
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
      <div class="row">
        <div class="col-3">
          <label for="">ceod</label>
        </div>
        <div class="col-9">
          <input class="form-control" type="text" name="ceod" id="ceod" value="<?php if(isset($pat["ceod"])) echo $pat["ceod"];  ?>">
        </div>
        <div class="col-3">
          <label for="">ceos</label>
        </div>
        <div class="col-9">
          <input class="form-control" type="text" name="ceos" id="ceos" value="<?php if(isset($pat["ceos"])) echo $pat["ceos"];  ?>">
        </div>
      </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-6 col-6">
      <label for="">Cantidad de dientes presentes</label>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <div class="row">
        <div class="col-3">
          <label for="">Pri</label>
        </div>
        <div class="col-9">
          <input class="form-control" type="text" name="pri" id="pri" value="<?php if(isset($pat["pri"])) echo $pat["pri"];  ?>">
        </div>
        <div class="col-3">
          <label for="">Per</label>
        </div>
        <div class="col-9">
          <input class="form-control" type="text" name="per" id="per" value="<?php if(isset($pat["per"])) echo $pat["per"];  ?>">
        </div>
      </div>

    </div>
  </div>
  <div class="border">
    <div class="row">
      <div class="col-2">
        <label for=""><u><b>TIPO</b></u></label>
      </div>
      <div class="col-6">
        <label for=""><u><b>DIENTE</b></u></label>
      </div>
    </div>
    <div class="row">
      <div class="col-2">
        <label for="">Activa:</label>
      </div>
      <div class="col-6">
        <input class="form-control d-inline-block" type="text" name="activa" id="activa" value="<?php if(isset($pat["activa"])) echo $pat["activa"];  ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-2">
        <label for="">Lenta:</label>
      </div>
      <div class="col-6">
        <input class="form-control d-inline-block" type="text" name="lenta" id="lenta" value="<?php if(isset($pat["lenta"])) echo $pat["lenta"];  ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-2">
        <label for="">Detenida:</label>
      </div>
      <div class="col-6">
        <input class="form-control d-inline-block" type="text" name="detenida" id="detenida" value="<?php if(isset($pat["detenida"])) echo $pat["detenida"];  ?>">
      </div>
    </div>
  </div>
  <br>
  <?php
  if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
  ?>
  <div class="border">
    <b>DIAGNOSTICO RADIOGRÁFICO</b>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="">EDAD DENTARIA:</label>
        <input class="form-control" type="text" name="dentaria" id="dentaria" value="<?php if(isset($pat["dentaria"])) echo $pat["dentaria"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="">ANQUILOSIS:</label>
        <input class="form-control" type="text" name="anquilosis" id="anquilosis" value="<?php if(isset($pat["anquilosis"])) echo $pat["anquilosis"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="">AGENESIAS:</label>
        <input class="form-control" type="text" name="agenesias" id="agenesias" value="<?php if(isset($pat["agenesias"])) echo $pat["agenesias"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="">ERUPCIÓN ECTÓPICA:</label>
        <input class="form-control" type="text" name="ectopica" id="ectopica" value="<?php if(isset($pat["ectopica"])) echo $pat["ectopica"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="">SUPERNUMERARIOS:</label>
        <input class="form-control" type="text" name="supernumerarios" id="supernumerarios" value="<?php if(isset($pat["supernumerarios"])) echo $pat["supernumerarios"];  ?>">
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-6">
        <label for="">ERUPCIÓN PRECOZ:</label>
        <input class="form-control" type="text" name="precoz" id="precoz" value="<?php if(isset($pat["precoz"])) echo $pat["precoz"];  ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <label for="">OBSERVACIONES:</label>
        <input class="form-control" type="text" name="dentariaobs" id="dentariaobs" value="<?php if(isset($pat["dentariaobs"])) echo $pat["dentariaobs"];  ?>">
      </div>
    </div>
  </div>
<?php } ?>

  <br>
  <!--añadir mas-->
</div>
<hr>
<div class="px-3 border border-success rounded">
    <br>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#tartrectomia">O'leary</a>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#plan">Plan de Tratamiento Int. Ind.</a>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#urgencias">Urgencias</a>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#inactivacion">Inactivacion</a>

    <a class="btn btn-success" href="" data-toggle="modal" data-target="#quimico">Quimico-Mecanico del Bio Fil</a>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#morfologico">Refuerzo Morfológico</a>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#estructural">Refuerzo Estructural</a>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#cirugia">Cirugia</a>

    <a class="btn btn-success" href="" data-toggle="modal" data-target="#pulpar">Tratamiento Pulpar</a>
    <a class="btn btn-success" href="" data-toggle="modal" data-target="#rehabilitacion">Rehabilitación</a>

    <br>
    <?php if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){ ?>
    <br>
    <div class="border px-4">
      <div class="row">
        <label for=""><b>ANOMALIA DENTARIAS</b></label>
        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="iniciacion" <?php echo (isset($pat['iniciacion'])&&$pat['iniciacion']=='t')?'checked':''; ?>>
            <label class="form-check-label" for="iniciacion">
              De iniciación y proliferación
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="histo" <?php echo (isset($pat['histo'])&&$pat['histo']=='t')?'checked':''; ?>>
            <label class="form-check-label" for="histo">
              De histodiferenciación
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="morfo" <?php echo (isset($pat['morfo'])&&$pat['morfo']=='t')?'checked':''; ?>>
            <label class="form-check-label" for="morfo">
              De morfo diferenciación
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="aposicion" <?php echo (isset($pat['aposicion'])&&$pat['aposicion']=='t')?'checked':''; ?>>
            <label class="form-check-label" for="aposicion">
              De aposición
            </label>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="calcificacion" <?php echo (isset($pat['calcificacion'])&&$pat['calcificacion']=='t')?'checked':''; ?>>
            <label class="form-check-label" for="calcificacion">
              Decalcificación
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="erupcion" <?php echo (isset($pat['erupcion'])&&$pat['erupcion']=='t')?'checked':''; ?>>
            <label class="form-check-label" for="erupcion">
              Deerupción
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="abrasion" <?php echo (isset($pat['abrasion'])&&$pat['abrasion']=='t')?'checked':''; ?>>
            <label class="form-check-label" for="abrasion">
              Deabrasión
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <label for="">OBSERVACIONES</label>
          <textarea name="anomaliaobs" id="anomaliaobs" rows="3" class="form-control"><?php if(isset($pat['anomaliaobs'])) echo $pat['anomaliaobs'];?></textarea>
        </div>
      </div>
    </div>
  <?php } ?>


    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for=""><b><u>Monitoreo</u></b></label>
        <textarea name="monitoreo" id="monitoreo" rows="5" class="form-control"><?php if(isset($pat['pediatricsimonitoring'])) echo $pat['pediatricsimonitoring'];?></textarea>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
        <label for=""><b><u>Comentario</u></b></label>
          <textarea name="comentario" id="comentario" rows="5" class="form-control"><?php if(isset($pat['pediatricsicomment'])) echo $pat['pediatricsicomment'];?></textarea>
      </div>
    </div>
    <br>
    <div class="row">
      <?php

      if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'){
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
<!--MODALS START-->
<!--inicio modal oleary-->
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
<div class="modal modal2 fade" role="dialog" id="tartrectomia">
<?php $a=DBUserInfo($_SESSION["usertable"]["usernumber"]);?>
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">

    <div class="modal-header">
      <h3 class="modal-title">INDICE DE O'LEARY</h3>

      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-md-4 col-sm-4 col-lg-3">
          <b>Indice de O'Leary</b>
        </div>
        <div class="col-md-4 col-sm-4 col-lg-3">
          <select class="form-select" name="option" aria-label="Default select example">
          <option value="1" selected>Pintar</option>
          <option value="2">Aucente</option>
          </select>
        </div>
      </div>

      <div class="from-group border border-primary rounded">
        <div class="container">

          <input type="hidden" name="olygram" id="olygram" value="<?php if(isset($pat['pediatricsioleary'])) echo $pat['pediatricsioleary']; ?>">
          <div class="row border">
            <div class="col-lg-6 col-md-6 col-sm-9 col-9 border">
              CONTROL N. 1
            </div>
            <div align="center" class="col-lg-2 col-md-2 col-sm-3 col-3 border">
              <!--<input type="text" name="info" id="info"value="">%-->
              <label for="" id="info">%</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 border">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                  Fecha:
                </div>
                <div class="col-lg-8 col-md-8 col-sm-9 col-9">
                  <input type="date" id="date1" class="form-control" name="date1" value="<?php if(isset($pat['date1'])){echo $pat['date1'];}else{echo date("Y-m-d");}?>" min="2015-01-01" max="2099-01-01">
                </div>
              </div>
            </div>
          </div>
          <div class="">
            <div class="bg-danger mt-2" id='oleary'></div>
            <div class="">

              <label name="evaluedoleary1" id="evaluedoleary1" ><?php if(isset($pat['evaluedoleary1'])) echo $pat['evaluedoleary1']; ?></label>
            </div>
            <div style="clear:both;"></div>

            <br>
          </div>
        </div>
      </div>
      <br>
      <div class="from-group border border-warning rounded">
        <div class="container">
          <div class="row border">
            <div class="col-lg-6 col-md-6 col-sm-9 col-9 border">
              CONTROL N. 2
            </div>
            <div align="center" class="col-lg-2 col-md-2 col-sm-3 col-3 border">
              <!--<input type="text" name="info" id="info"value="">%-->
              <label for="" id="info2">%</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 border">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                  Fecha:
                </div>
                <div class="col-lg-8 col-md-8 col-sm-9 col-9">
                  <input type="date" id="date2" class="form-control" name="date2" value="<?php if(isset($pat['date2'])) echo $pat['date2'];?>" min="2015-01-01" max="2099-01-01">
                </div>
              </div>
            </div>
          </div>
          <div class="">
            <div class="bg-danger mt-2" id='oleary2'></div>
            <div class="">
              <label name="evaluedoleary2" id="evaluedoleary2" ><?php if(isset($pat['evaluedoleary2'])) echo $pat['evaluedoleary2']; ?></label>
            </div>
            <div style="clear:both;"></div>

            <br>
          </div>
        </div>
      </div>
      <br>
      <div class="from-group border border-success rounded">
        <div class="container">
          <div class="row border">
            <div class="col-lg-6 col-md-6 col-sm-9 col-9 border">
              CONTROL N. 3
            </div>
            <div align="center" class="col-lg-2 col-md-2 col-sm-3 col-3 border">
              <!--<input type="text" name="info" id="info"value="">%-->
              <label for="" id="info3">%</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 border">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                  Fecha:
                </div>
                <div class="col-lg-8 col-md-8 col-sm-9 col-9">
                  <input type="date" id="date3" name="date3" class="form-control" value="<?php if(isset($pat['date3'])) echo $pat['date3'];?>" min="2015-01-01" max="2099-01-01">
                </div>
              </div>
            </div>
          </div>
          <div class="">
            <div class="bg-danger mt-2" id='oleary3'></div>
            <div class="">
              <label name="evaluedoleary3" id="evaluedoleary3" ><?php if(isset($pat['evaluedoleary3'])) echo $pat['evaluedoleary3']; ?></label>
            </div>
            <div style="clear:both;"></div>

            <br>
          </div>
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

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) ) && ( (isset($pat['st']) && $pat['st']=='t')||(!isset($pat['st'])) ) ){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"oleary_button\" name=\"oleary_button\">Enviar O'leary</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--fin modal oleary-->

<!--modal plan inicio-->
<div class="modal modal2 fade" role="dialog" id="plan">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">Plan de Tratamiento Integral Individualizado</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <textarea name="plantxt" id="plantxt" rows="15" class="form-control plantxt"><?php if(isset($pat['pediatricsitreatmentplan'])) echo $pat['pediatricsitreatmentplan'];?></textarea>
            </div>
          </div>

        </div>
      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) )){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"plan_button\" name=\"plan_button\">Guardar</button>";
      }

      ?>

    </div>
  </div>
  </div>
</div>
<!--modal plan de tratamiento integral individualizado fin-->


<!--modal urgencias inicio-->
<div class="modal modal2 fade" role="dialog" id="urgencias">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">URGENCIAS</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
              FECHA
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              PIEZAS
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              DIAGNOSTICO
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              TRATAMIENTO
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              FIRMA
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              CONCLUSION
            </div>
          </div>

          <?php
          $urginfo=DBAllPediatricsiControlInfo($_GET['id'], 'urgency');
          for ($i=0; $i < count($urginfo); $i++) {
            $sms='';
            if($i==0){
              $sms.= "<div id=\"informationurgencias\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"urgencias\" class=\"urgencias\" value=\"".$urginfo[$i]['controlid']."\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control urgfecha\" name=\"urgfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline urgpieza\" placeholder=\"piezas\" name=\"urgpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"urgdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline urgdiagnostico\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline urgtratamiento\" placeholder=\"tratamiento\" name=\"urgtratamiento[]\" value=\"".$urginfo[$i]['controltreatment']."\">".
                "</div>";

                $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                if($urginfo[$i]["controlstart"]==''){


                  $sms.="   <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($urginfo[$i]["controlstart"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"firmainicio text-success\" name=\"firmainicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

                $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                if($urginfo[$i]["controlend"]==''){


                  $sms.="   <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($urginfo[$i]["controlend"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"firmafin text-success\" name=\"firmafin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

              $sms.="</div>".
              "</div>";

              echo $sms;
            }else{
                $sms.= "<div>".

                "<hr>".
                "<div class=\"row\">".
                  "<input type=\"hidden\" name=\"urgencias\" class=\"urgencias\" value=\"".$urginfo[$i]['controlid']."\">".
                  "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                  "  <input type=\"date\" id=\"\" class=\"form-control urgfecha\" name=\"urgfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                  "  <input type=\"text\" class=\"form-control d-inline urgpieza\" placeholder=\"piezas\" name=\"urgpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" >".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                    "<textarea name=\"urgdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline urgdiagnostico\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "  <input type=\"text\" class=\"form-control d-inline urgtratamiento\" placeholder=\"tratamiento\" name=\"urgtratamiento[]\" value=\"".$urginfo[$i]['controltreatment']."\">".
                  "</div>";

                  $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                  if($urginfo[$i]["controlstart"]==''){


                    $sms.="   <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";

                  }else{
                    if($urginfo[$i]["controlstart"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"firmainicio text-success\" name=\"firmainicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>";

                  $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                  if($urginfo[$i]["controlend"]==''){


                    $sms.="   <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }else{
                    if($urginfo[$i]["controlend"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"firmafin text-success\" name=\"firmafin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>".

                "</div>".
                "<button type=\"button\" class=\"btn btn-danger btn-sm m-3 remove\" name=\"\"> - Eliminar</button>".

                "</div>";
                echo $sms;

            }
          }
          if($i==0){
            echo "<div id=\"informationurgencias\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"urgencias\" class=\"urgencias\" value=\"\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control urgfecha\" name=\"urgfecha[]\" value=\"\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline urgpieza\" placeholder=\"piezas\" name=\"urgpieza[]\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"urgdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline urgdiagnostico\"></textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline urgtratamiento\" placeholder=\"tratamiento\" name=\"urgtratamiento[]\" >".
                "</div>".

                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".

                "<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">".
                "  <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".


              "</div>".
            "</div>";
          }

          ?>

          <!--
          <div id="informationurgencias">
            <hr>
            <div class="row">
              <input type="hidden" name="urgencias" class="urgencias" value="">
              <div class="col-3">
                <input type="date" id="" class="form-control d-inline urgfecha" name="urgfecha[]" value="" min="2015-01-01" max="2099-01-01">
              </div>
              <div class="col-2">
                <input type="text" class="form-control d-inline urgpieza" name="urgpieza[]" value="" >
              </div>
              <div class="col-2">
                <textarea name="urgdiagnostico[]" rows="2" class="form-control d-inline urgdiagnostico"></textarea>
              </div>
              <div class="col-2">
                <input type="text" class="form-control d-inline urgtratamiento" name="urgtratamiento[]" value="">
              </div>
            </div>
          </div>-->

          <button type="button" class="btn btn-success btn-sm m-3" id="addurgencias" name=""> + Agregar Urgencias</button>

        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) ) ){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"urgencias_button\" name=\"urgencias_button\">Enviar Urgencias</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--modal urgencias fin-->



<!--modal inactivacion inicio-->
<div class="modal modal2 fade" role="dialog" id="inactivacion">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">INACTIVACION</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
              FECHA
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              PIEZAS
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              DIAGNOSTICO
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              TRATAMIENTO
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              FIRMA
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              CONCLUSION
            </div>
          </div>

          <?php
          $inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'inactivation');
          for ($i=0; $i < count($inainfo); $i++) {
            $sms='';
            if($i==0){
              $sms.= "<div id=\"informationinactivation\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"inactivacion\" class=\"inactivacion\" value=\"".$inainfo[$i]['controlid']."\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control inafecha\" name=\"inafecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline inapieza\" placeholder=\"piezas\" name=\"inapieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"inadiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline inadiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline inatratamiento\" placeholder=\"tratamiento\" name=\"inatratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                "</div>";

                $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                if($inainfo[$i]["controlstart"]==''){


                  $sms.="   <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlstart"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"inainicio text-success\" name=\"inainicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

                $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                if($inainfo[$i]["controlend"]==''){


                  $sms.="   <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlend"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"inafin text-success\" name=\"inafin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

              $sms.="</div>".
              "</div>";

              echo $sms;
            }else{
                $sms.= "<div>".

                "<hr>".
                "<div class=\"row\">".
                  "<input type=\"hidden\" name=\"inactivacion\" class=\"inactivacion\" value=\"".$inainfo[$i]['controlid']."\">".
                  "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                  "  <input type=\"date\" id=\"\" class=\"form-control inafecha\" name=\"inafecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                  "  <input type=\"text\" class=\"form-control d-inline inapieza\" placeholder=\"piezas\" name=\"inapieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                    "<textarea name=\"inadiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline inadiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "  <input type=\"text\" class=\"form-control d-inline inatratamiento\" placeholder=\"tratamiento\" name=\"inatratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                  "</div>";

                  $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlstart"]==''){


                    $sms.="   <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";

                  }else{
                    if($inainfo[$i]["controlstart"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"inainicio text-success\" name=\"inainicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>";

                  $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlend"]==''){


                    $sms.="   <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }else{
                    if($inainfo[$i]["controlend"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"inafin text-success\" name=\"inafin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>".

                "</div>".
                "<button type=\"button\" class=\"btn btn-danger btn-sm m-3 remove\" name=\"\"> - Eliminar</button>".

                "</div>";
                echo $sms;

            }
          }
          if($i==0){
            echo "<div id=\"informationinactivation\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"inactivacion\" class=\"inactivacion\" value=\"\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control inafecha\" name=\"inafecha[]\" value=\"\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline inapieza\" placeholder=\"piezas\" name=\"inapieza[]\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"inadiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline inadiagnostico\"></textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline inatratamiento\" placeholder=\"tratamiento\" name=\"inatratamiento[]\" >".
                "</div>".

                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".

                "<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">".
                "  <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".


              "</div>".
            "</div>";
          }

          ?>

          <button type="button" class="btn btn-success btn-sm m-3" id="addinactivacion" name=""> + Agregar Inactivacion</button>

        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) ) ){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"inactivacion_button\" name=\"inactivacion_button\">Enviar Inactivacion</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--modal inactivacion fin-->


<!--modal quimico inicio-->
<div class="modal modal2 fade" role="dialog" id="quimico">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">CONTROL QUIMICO - MECANICO DEL FIL</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
              FECHA
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              PIEZAS
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              DIAGNOSTICO
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              TRATAMIENTO
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              FIRMA
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              CONCLUSION
            </div>
          </div>

          <?php
          $inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'quimic');
          for ($i=0; $i < count($inainfo); $i++) {
            $sms='';
            if($i==0){
              $sms.= "<div id=\"informationquimic\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"quimico\" class=\"quimico\" value=\"".$inainfo[$i]['controlid']."\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control quifecha\" name=\"quifecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline quipieza\" placeholder=\"piezas\" name=\"quipieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"quidiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline quidiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline quitratamiento\" placeholder=\"tratamiento\" name=\"quitratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                "</div>";

                $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                if($inainfo[$i]["controlstart"]==''){


                  $sms.="   <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlstart"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"quiinicio text-success\" name=\"quiinicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

                $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                if($inainfo[$i]["controlend"]==''){


                  $sms.="   <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlend"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"quifin text-success\" name=\"quifin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

              $sms.="</div>".
              "</div>";

              echo $sms;
            }else{
                $sms.= "<div>".

                "<hr>".
                "<div class=\"row\">".
                  "<input type=\"hidden\" name=\"quimico\" class=\"quimico\" value=\"".$inainfo[$i]['controlid']."\">".
                  "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                  "  <input type=\"date\" id=\"\" class=\"form-control quifecha\" name=\"quifecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                  "  <input type=\"text\" class=\"form-control d-inline quipieza\" placeholder=\"piezas\" name=\"quipieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                    "<textarea name=\"quidiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline quidiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "  <input type=\"text\" class=\"form-control d-inline quitratamiento\" placeholder=\"tratamiento\" name=\"quitratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                  "</div>";

                  $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlstart"]==''){


                    $sms.="   <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";

                  }else{
                    if($inainfo[$i]["controlstart"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"quiinicio text-success\" name=\"quiinicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>";

                  $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlend"]==''){


                    $sms.="   <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }else{
                    if($inainfo[$i]["controlend"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"quifin text-success\" name=\"quifin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>".

                "</div>".
                "<button type=\"button\" class=\"btn btn-danger btn-sm m-3 remove\" name=\"\"> - Eliminar</button>".

                "</div>";
                echo $sms;

            }
          }
          if($i==0){
            echo "<div id=\"informationquimic\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"quimico\" class=\"quimico\" value=\"\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control quifecha\" name=\"quifecha[]\" value=\"\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline quipieza\" placeholder=\"piezas\" name=\"quipieza[]\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"quidiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline quidiagnostico\"></textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline quitratamiento\" placeholder=\"tratamiento\" name=\"quitratamiento[]\" >".
                "</div>".

                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".

                "<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">".
                "  <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".


              "</div>".
            "</div>";
          }

          ?>

          <button type="button" class="btn btn-success btn-sm m-3" id="addquimico" name=""> + Agregar Mas</button>

        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) ) ){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"quimico_button\" name=\"quimico_button\">Enviar</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--modal Quimico fin-->


<!--modal morfologico inicio-->
<div class="modal modal2 fade" role="dialog" id="morfologico">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">REFUERZO MORFOLÓGICO</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
              FECHA
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              PIEZAS
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              DIAGNOSTICO
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              TRATAMIENTO
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              FIRMA
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              CONCLUSION
            </div>
          </div>

          <?php
          $inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'morfologic');
          for ($i=0; $i < count($inainfo); $i++) {
            $sms='';
            if($i==0){
              $sms.= "<div id=\"informationmorfologic\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"morfologico\" class=\"morfologico\" value=\"".$inainfo[$i]['controlid']."\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control morfecha\" name=\"morfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline morpieza\" placeholder=\"piezas\" name=\"morpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"mordiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline mordiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline mortratamiento\" placeholder=\"tratamiento\" name=\"mortratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                "</div>";

                $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                if($inainfo[$i]["controlstart"]==''){


                  $sms.="   <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlstart"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"morinicio text-success\" name=\"morinicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

                $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                if($inainfo[$i]["controlend"]==''){


                  $sms.="   <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlend"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"morfin text-success\" name=\"morfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

              $sms.="</div>".
              "</div>";

              echo $sms;
            }else{
                $sms.= "<div>".

                "<hr>".
                "<div class=\"row\">".
                  "<input type=\"hidden\" name=\"morfologico\" class=\"morfologico\" value=\"".$inainfo[$i]['controlid']."\">".
                  "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                  "  <input type=\"date\" id=\"\" class=\"form-control morfecha\" name=\"morfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                  "  <input type=\"text\" class=\"form-control d-inline morpieza\" placeholder=\"piezas\" name=\"morpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                    "<textarea name=\"mordiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline mordiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "  <input type=\"text\" class=\"form-control d-inline mortratamiento\" placeholder=\"tratamiento\" name=\"mortratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                  "</div>";

                  $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlstart"]==''){


                    $sms.="   <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";

                  }else{
                    if($inainfo[$i]["controlstart"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"morinicio text-success\" name=\"morinicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>";

                  $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlend"]==''){


                    $sms.="   <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }else{
                    if($inainfo[$i]["controlend"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"morfin text-success\" name=\"morfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>".

                "</div>".
                "<button type=\"button\" class=\"btn btn-danger btn-sm m-3 remove\" name=\"\"> - Eliminar</button>".

                "</div>";
                echo $sms;

            }
          }
          if($i==0){
            echo "<div id=\"informationmorfologic\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"morfologico\" class=\"morfologico\" value=\"\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control morfecha\" name=\"morfecha[]\" value=\"\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline morpieza\" placeholder=\"piezas\" name=\"morpieza[]\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"mordiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline mordiagnostico\"></textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline mortratamiento\" placeholder=\"tratamiento\" name=\"mortratamiento[]\" >".
                "</div>".

                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".

                "<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">".
                "  <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".


              "</div>".
            "</div>";
          }

          ?>

          <button type="button" class="btn btn-success btn-sm m-3" id="addmorfologico" name=""> + Agregar Mas</button>

        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) ) ){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"morfologico_button\" name=\"morfologico_button\">Enviar</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--modal Morfologico fin-->

<!--modal Estrutural inicio-->
<div class="modal modal2 fade" role="dialog" id="estructural">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">REFUERZO ESTRUCTURAL</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
              FECHA
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              PIEZAS
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              DIAGNOSTICO
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              TRATAMIENTO
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              FIRMA
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              CONCLUSION
            </div>
          </div>

          <?php
          $inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'estruct');
          for ($i=0; $i < count($inainfo); $i++) {
            $sms='';
            if($i==0){
              $sms.= "<div id=\"informationestruct\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"estructural\" class=\"estructural\" value=\"".$inainfo[$i]['controlid']."\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control estfecha\" name=\"estfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline estpieza\" placeholder=\"piezas\" name=\"estpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"estdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline estdiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline esttratamiento\" placeholder=\"tratamiento\" name=\"esttratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                "</div>";

                $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                if($inainfo[$i]["controlstart"]==''){


                  $sms.="   <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlstart"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"estinicio text-success\" name=\"estinicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

                $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                if($inainfo[$i]["controlend"]==''){


                  $sms.="   <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlend"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"estfin text-success\" name=\"estfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

              $sms.="</div>".
              "</div>";

              echo $sms;
            }else{
                $sms.= "<div>".

                "<hr>".
                "<div class=\"row\">".
                  "<input type=\"hidden\" name=\"estructural\" class=\"estructural\" value=\"".$inainfo[$i]['controlid']."\">".
                  "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                  "  <input type=\"date\" id=\"\" class=\"form-control estfecha\" name=\"estfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                  "  <input type=\"text\" class=\"form-control d-inline estpieza\" placeholder=\"piezas\" name=\"estpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                    "<textarea name=\"estdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline estdiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "  <input type=\"text\" class=\"form-control d-inline esttratamiento\" placeholder=\"tratamiento\" name=\"esttratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                  "</div>";

                  $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlstart"]==''){


                    $sms.="   <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";

                  }else{
                    if($inainfo[$i]["controlstart"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"estinicio text-success\" name=\"estinicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>";

                  $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlend"]==''){


                    $sms.="   <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }else{
                    if($inainfo[$i]["controlend"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"estfin text-success\" name=\"estfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>".

                "</div>".
                "<button type=\"button\" class=\"btn btn-danger btn-sm m-3 remove\" name=\"\"> - Eliminar</button>".

                "</div>";
                echo $sms;

            }
          }
          if($i==0){
            echo "<div id=\"informationestruct\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"estructural\" class=\"estructural\" value=\"\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control estfecha\" name=\"estfecha[]\" value=\"\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline estpieza\" placeholder=\"piezas\" name=\"estpieza[]\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"estdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline estdiagnostico\"></textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline esttratamiento\" placeholder=\"tratamiento\" name=\"esttratamiento[]\" >".
                "</div>".

                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".

                "<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">".
                "  <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".


              "</div>".
            "</div>";
          }

          ?>

          <button type="button" class="btn btn-success btn-sm m-3" id="addestructural" name=""> + Agregar Mas</button>

        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) ) ){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"estructural_button\" name=\"estructural_button\">Enviar</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--modal Estructural fin-->

<!--modal Pulpar inicio-->
<div class="modal modal2 fade" role="dialog" id="pulpar">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">Tratamiento Pulpar</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
              FECHA
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              PIEZAS
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              DIAGNOSTICO
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              TRATAMIENTO
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              SESIONES
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              CONCLUSION
            </div>
          </div>

          <?php
          $keymodals=0;
          $inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'pulpar');
          for ($i=0; $i < count($inainfo); $i++) {
            $sms='';
            if($i==0){
              $sms.= "<div id=\"informationpulpar\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"pulpar\" idf=\"".$i."\" class=\"pulpar\" value=\"".$inainfo[$i]['controlid']."\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control pulfecha\" name=\"pulfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline pulpieza\" placeholder=\"piezas\" name=\"pulpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"puldiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline puldiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline pultratamiento\" placeholder=\"tratamiento\" name=\"pultratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                "</div>";

                $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".

                "<div class='divchangeadd'></div>".
                "<div class='divchangeremove'>".

                " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionpulpar$i\">Ver Sessiones</a>".

                "</div>".

                "</div>";
                $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                if($inainfo[$i]["controlend"]==''){


                  $sms.="   <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlend"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"pulfin text-success\" name=\"pulfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

              $sms.="</div>".
              "</div>";

              echo $sms;
            }else{
                $sms.= "<div>".

                "<hr>".
                "<div class=\"row\">".
                  "<input type=\"hidden\" name=\"pulpar\" idf=\"".$i."\" class=\"pulpar\" value=\"".$inainfo[$i]['controlid']."\">".
                  "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                  "  <input type=\"date\" id=\"\" class=\"form-control pulfecha\" name=\"pulfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                  "  <input type=\"text\" class=\"form-control d-inline pulpieza\" placeholder=\"piezas\" name=\"pulpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                    "<textarea name=\"puldiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline puldiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "  <input type=\"text\" class=\"form-control d-inline pultratamiento\" placeholder=\"tratamiento\" name=\"pultratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                  "</div>";

                  $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".

                  "<div class='divchangeremove'>".

                  " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionpulpar$i\">Ver Sessiones</a>".

                  "</div>".

                  "</div>";

                  $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlend"]==''){


                    $sms.="   <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }else{
                    if($inainfo[$i]["controlend"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"pulfin text-success\" name=\"pulfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>".

                "</div>".

                "<button type=\"button\" class=\"btn btn-danger btn-sm mx-3 removepulpar\" name=\"sessionpulpar".$i."\"> - Eliminar</button>".
                "</div>";
                echo $sms;

            }
            $keymodals++;
          }
          if($i==0){
            echo "<div id=\"informationpulpar\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"pulpar\" idf=\"0\" class=\"pulpar\" value=\"\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control pulfecha\" name=\"pulfecha[]\" value=\"\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline pulpieza\" placeholder=\"piezas\" name=\"pulpieza[]\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"puldiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline puldiagnostico\"></textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline pultratamiento\" placeholder=\"tratamiento\" name=\"pultratamiento[]\" >".
                "</div>".

                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".

                "<div class='divchangeadd'></div>".
                "<div class='divchangeremove'>".
                " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionpulpar0\">Ver Sessiones</a>".

                "</div>".

                "</div>".

                "<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">".
                "  <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".


              "</div>".
            "</div>";

            $keymodals++;
          }

          ?>

          <button type="button" class="btn btn-success btn-sm m-3" id="addpulpar" name=""> + Agregar Mas</button>


        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) ) ){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"pulpar_button\" name=\"pulpar_button\">Enviar</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--modal Pulpar fin-->
<?php
//modal para sessiones inicio
//php inicio
$ses="<div class=\"modal fade\" role=\"dialog\" id=\"sessionpulparindex\">".
"<div class=\"modal-dialog\">".
"  <div class=\"modal-content\">".
"    <div class=\"modal-header\">".
"      <h3 class=\"modal-title\">Sessiones</h3>".
"      <button type=\"button\" class=\"close\" data-dismiss=\"modal\" name=\"bu\">&times;</button>".
"    </div>".
"    <div class=\"modal-body\">".
"      <div class=\"from-group border border-primary rounded\">".
"        <div class=\"container\">".
"          <hr>".
"          <div class=\"row\">".
"            <div class=\"col-3 border pl-4 py-3\">".
"datafirmo".
            "</div>".

            "<div class=\"col-3 border pl-4 py-3\">".
"datafirmt".
            "</div>".
            "<div class=\"col-3 border pl-4 py-3\">".
"datafirmh".
            "</div>".
            "<div class=\"col-3 border pl-4 py-3\">".
"datafirmf".
            "</div>".
          "</div>".
          "<hr>".
      "</div>".
    "</div>".
  "</div>".
  "    <div class=\"modal-footer\">".
  "      <button type=\"button\" class=\"mx-5 btn btn-danger\" data-dismiss=\"modal\" name=\"cancel_update\">Cancelar</button>".
  "buttonregistersession".
      "</div>".
"    </div>".
"  </div>".
"</div>";
$isbutton=false;
//php fin
//modal para sessiones fin
if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
(!isset($pat['observationaccepted'])) ) && ( (isset($pat['st']) && $pat['st']=='t')||(!isset($pat['st'])) ) ){
    $isbutton=true;
}

$valor='';
$inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'pulpar');
$i=0;
for ($i=0; $i < count($inainfo); $i++) {
  $org=str_replace('index', $i, $ses);
  $valor=$org;
  $key=$inainfo[$i]['controlid'];
  if($inainfo[$i][$key."sessionpulpar-0"]==''){
    $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  }else{
    if($inainfo[$i][$key."sessionpulpar-0"]=='t'){
      $valor=str_replace('datafirmo', "<span class=\"sessionpulpar$i text-success\" name=\"sessionpulpar".$i."[]\" >Firmado</span>", $valor);
    }else{
      $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
    }
  }

  if($inainfo[$i][$key."sessionpulpar-1"]==''){
    $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  }else{
    if($inainfo[$i][$key."sessionpulpar-1"]=='t'){
      $valor=str_replace('datafirmt', "<span class=\"sessionpulpar$i text-success\" name=\"sessionpulpar".$i."[]\" >Firmado</span>", $valor);
    }else{
      $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
    }
  }

  if($inainfo[$i][$key."sessionpulpar-2"]==''){
    $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  }else{
    if($inainfo[$i][$key."sessionpulpar-2"]=='t'){
      $valor=str_replace('datafirmh', "<span class=\"sessionpulpar$i text-success\" name=\"sessionpulpar".$i."[]\" >Firmado</span>", $valor);
    }else{
      $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
    }
  }

  if($inainfo[$i][$key."sessionpulpar-3"]==''){
    $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  }else{
    if($inainfo[$i][$key."sessionpulpar-3"]=='t'){
      $valor=str_replace('datafirmf', "<span class=\"sessionpulpar$i text-success\" name=\"sessionpulpar".$i."[]\" >Firmado</span>", $valor);
    }else{
      $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
    }
  }

  if ($isbutton) {
    $valor=str_replace('buttonregistersession', "<button type=\"submit\" class=\"btn btn-success\" data-dismiss=\"modal\" data-dismiss=\"modal\" id=\"controlsession_button\" name=\"controlsession_button\">Enviar</button>", $valor);
  }else{
    $valor=str_replace('buttonregistersession', "", $valor);
  }
  echo $valor;
}
if($i==0){
  //str_replace('a buscar', 'a remplazar', 'cadena')
  $valor=str_replace('index', '0', $ses);
  $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionpulpar0\" name=\"sessionpulpar0[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionpulpar0\" name=\"sessionpulpar0[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionpulpar0\" name=\"sessionpulpar0[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionpulpar0\" name=\"sessionpulpar0[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  if ($isbutton) {
    $valor=str_replace('buttonregistersession', "<button type=\"submit\" class=\"btn btn-success\" data-dismiss=\"modal\" id=\"controlsession_button\" name=\"controlsession_button\">Enviar</button>", $valor);
  }else{
    $valor=str_replace('buttonregistersession', "", $valor);
  }
  echo $valor;
}

?>
<!--el div es como identificador para añadir antes de addmodalid-->
<div class="addmodalid" id="addmodalid"></div>

<!--modal Rehabilitacion inicio-->
<div class="modal modal2 fade" role="dialog" id="rehabilitacion">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">REHABILITACION</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
              FECHA
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              PIEZAS
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              DIAGNOSTICO
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              TRATAMIENTO
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              SESIONES
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              CONCLUSION
            </div>
          </div>

          <?php
          $keymodalsreh=0;
          $inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'rehabilitation');
          for ($i=0; $i < count($inainfo); $i++) {
            $sms='';
            if($i==0){
              $sms.= "<div id=\"informationrehabilitation\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"rehabilitation\" idf=\"".$i."\" class=\"rehabilitation\" value=\"".$inainfo[$i]['controlid']."\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control rehfecha\" name=\"rehfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline rehpieza\" placeholder=\"piezas\" name=\"rehpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"rehdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline rehdiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline rehtratamiento\" placeholder=\"tratamiento\" name=\"rehtratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                "</div>";

                $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".

                "<div class='divchangeadd'></div>".
                "<div class='divchangeremove'>".

                " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionrehabilitation$i\">Ver Sessiones</a>".

                "</div>".

                "</div>";
                $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                if($inainfo[$i]["controlend"]==''){


                  $sms.="   <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlend"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"rehfin text-success\" name=\"rehfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

              $sms.="</div>".
              "</div>";

              echo $sms;
            }else{
                $sms.= "<div>".

                "<hr>".
                "<div class=\"row\">".
                  "<input type=\"hidden\" name=\"rehabilitation\" idf=\"".$i."\" class=\"rehabilitation\" value=\"".$inainfo[$i]['controlid']."\">".
                  "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                  "  <input type=\"date\" id=\"\" class=\"form-control rehfecha\" name=\"rehfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                  "  <input type=\"text\" class=\"form-control d-inline rehpieza\" placeholder=\"piezas\" name=\"rehpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                    "<textarea name=\"rehdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline rehdiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "  <input type=\"text\" class=\"form-control d-inline rehtratamiento\" placeholder=\"tratamiento\" name=\"rehtratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                  "</div>";

                  $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".

                  "<div class='divchangeremove'>".

                  " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionrehabilitation$i\">Ver Sessiones</a>".

                  "</div>".

                  "</div>";

                  $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlend"]==''){


                    $sms.="   <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }else{
                    if($inainfo[$i]["controlend"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"rehfin text-success\" name=\"rehfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>".

                "</div>".

                "<button type=\"button\" class=\"btn btn-danger btn-sm mx-3 removerehabilitation\" name=\"sessionrehabilitation".$i."\"> - Eliminar</button>".
                "</div>";
                echo $sms;

            }
            $keymodalsreh++;
          }
          if($i==0){
            echo "<div id=\"informationrehabilitation\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"rehabilitation\" idf=\"0\" class=\"rehabilitation\" value=\"\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control rehfecha\" name=\"rehfecha[]\" value=\"\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline rehpieza\" placeholder=\"piezas\" name=\"rehpieza[]\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"rehdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline rehdiagnostico\"></textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline rehtratamiento\" placeholder=\"tratamiento\" name=\"rehtratamiento[]\" >".
                "</div>".

                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".

                "<div class='divchangeadd'></div>".
                "<div class='divchangeremove'>".
                " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionrehabilitation0\">Ver Sessiones</a>".

                "</div>".

                "</div>".

                "<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">".
                "  <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".


              "</div>".
            "</div>";

            $keymodalsreh++;
          }

          ?>

          <button type="button" class="btn btn-success btn-sm m-3" id="addrehabilitation" name=""> + Agregar Mas</button>


        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) ) ){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"rehabilitation_button\" name=\"rehabilitation_button\">Enviar</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--modal Rehabilitacion fin-->
<?php
//modal para sessiones inicio
//php inicio
$ses="<div class=\"modal fade\" role=\"dialog\" id=\"sessionrehabilitationindex\">".
"<div class=\"modal-dialog\">".
"  <div class=\"modal-content\">".
"    <div class=\"modal-header\">".
"      <h3 class=\"modal-title\">Sessiones</h3>".
"      <button type=\"button\" class=\"close\" data-dismiss=\"modal\" name=\"bu\">&times;</button>".
"    </div>".
"    <div class=\"modal-body\">".
"      <div class=\"from-group border border-primary rounded\">".
"        <div class=\"container\">".
"          <hr>".
"          <div class=\"row\">".
"            <div class=\"col-3 border pl-4 py-3\">".
"datafirmo".
            "</div>".

            "<div class=\"col-3 border pl-4 py-3\">".
"datafirmt".
            "</div>".
            "<div class=\"col-3 border pl-4 py-3\">".
"datafirmh".
            "</div>".
            "<div class=\"col-3 border pl-4 py-3\">".
"datafirmf".
            "</div>".
          "</div>".
          "<hr>".
      "</div>".
    "</div>".
  "</div>".
  "    <div class=\"modal-footer\">".
  "      <button type=\"button\" class=\"mx-5 btn btn-danger\" data-dismiss=\"modal\" name=\"cancel_update\">Cancelar</button>".
  "buttonregistersession".
      "</div>".
"    </div>".
"  </div>".
"</div>";
$isbutton=false;
//php fin
//modal para sessiones fin
if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
(!isset($pat['observationaccepted'])) ) ){
    $isbutton=true;
}

$valor='';
$inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'rehabilitation');
$i=0;
for ($i=0; $i < count($inainfo); $i++) {
  $org=str_replace('index', $i, $ses);
  $valor=$org;
  $key=$inainfo[$i]['controlid'];
  if(!isset($inainfo[$i][$key."sessionrehabilitation-0"]) || (isset($inainfo[$i][$key."sessionrehabilitation-0"])&&$inainfo[$i][$key."sessionrehabilitation-0"]=='')){
    $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  }else{
    if(isset($inainfo[$i][$key."sessionrehabilitation-0"])&&$inainfo[$i][$key."sessionrehabilitation-0"]=='t'){
      $valor=str_replace('datafirmo', "<span class=\"sessionrehabilitation$i text-success\" name=\"sessionrehabilitation".$i."[]\" >Firmado</span>", $valor);
    }else{
      $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
    }
  }

  if(!isset($inainfo[$i][$key."sessionrehabilitation-1"]) || (isset($inainfo[$i][$key."sessionrehabilitation-1"])&&$inainfo[$i][$key."sessionrehabilitation-1"]=='')){
    $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  }else{
    if(isset($inainfo[$i][$key."sessionrehabilitation-1"])&&$inainfo[$i][$key."sessionrehabilitation-1"]=='t'){
      $valor=str_replace('datafirmt', "<span class=\"sessionrehabilitation$i text-success\" name=\"sessionrehabilitation".$i."[]\" >Firmado</span>", $valor);
    }else{
      $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
    }
  }

  if(!isset($inainfo[$i][$key."sessionrehabilitation-2"]) || (isset($inainfo[$i][$key."sessionrehabilitation-2"])&&$inainfo[$i][$key."sessionrehabilitation-2"]=='')){
    $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  }else{
    if(isset($inainfo[$i][$key."sessionrehabilitation-2"])&&$inainfo[$i][$key."sessionrehabilitation-2"]=='t'){
      $valor=str_replace('datafirmh', "<span class=\"sessionrehabilitation$i text-success\" name=\"sessionrehabilitation".$i."[]\" >Firmado</span>", $valor);
    }else{
      $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
    }
  }

  if(!isset($inainfo[$i][$key."sessionrehabilitation-3"]) || (isset($inainfo[$i][$key."sessionrehabilitation-3"])&&$inainfo[$i][$key."sessionrehabilitation-3"]=='')){
    $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  }else{
    if(isset($inainfo[$i][$key."sessionrehabilitation-3"])&&$inainfo[$i][$key."sessionrehabilitation-3"]=='t'){
      $valor=str_replace('datafirmf', "<span class=\"sessionrehabilitation$i text-success\" name=\"sessionrehabilitation".$i."[]\" >Firmado</span>", $valor);
    }else{
      $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
    }
  }

  if ($isbutton) {
    $valor=str_replace('buttonregistersession', "<button type=\"submit\" class=\"btn btn-success\" data-dismiss=\"modal\" data-dismiss=\"modal\" id=\"controlsessionreh_button\" name=\"controlsessionreh_button\">Enviar</button>", $valor);
  }else{
    $valor=str_replace('buttonregistersession', "", $valor);
  }
  echo $valor;
}
if($i==0){
  //str_replace('a buscar', 'a remplazar', 'cadena')
  $valor=str_replace('index', '0', $ses);
  $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionrehabilitation0\" name=\"sessionrehabilitation0[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionrehabilitation0\" name=\"sessionrehabilitation0[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionrehabilitation0\" name=\"sessionrehabilitation0[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionrehabilitation0\" name=\"sessionrehabilitation0[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
  if ($isbutton) {
    $valor=str_replace('buttonregistersession', "<button type=\"submit\" class=\"btn btn-success\" data-dismiss=\"modal\" id=\"controlsessionreh_button\" name=\"controlsessionreh_button\">Enviar</button>", $valor);
  }else{
    $valor=str_replace('buttonregistersession', "", $valor);
  }
  echo $valor;
}

?>
<!--el div es como identificador para añadir antes de addmodalid-->
<div class="addmodalidreh" id="addmodalidreh"></div>

<!--modal Cirugia inicio-->
<div class="modal modal2 fade" role="dialog" id="cirugia">
<div class="modal-dialog modal-dialog2">
  <div class="modal-content modal-content2">
    <div class="modal-header">
      <h3 class="modal-title">CIRUGIA</h3>
      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">

      <div class="from-group border border-primary rounded">
        <div class="container">

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6">
              FECHA
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              PIEZAS
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              DIAGNOSTICO
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-6">
              TRATAMIENTO
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              FIRMA
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-6">
              CONCLUSION
            </div>
          </div>

          <?php
          $inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'surgery');
          for ($i=0; $i < count($inainfo); $i++) {
            $sms='';
            if($i==0){
              $sms.= "<div id=\"informationsurgery\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"cirugia\" class=\"cirugia\" value=\"".$inainfo[$i]['controlid']."\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control cirfecha\" name=\"cirfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline cirpieza\" placeholder=\"piezas\" name=\"cirpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"cirdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline cirdiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline cirtratamiento\" placeholder=\"tratamiento\" name=\"cirtratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                "</div>";

                $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                if($inainfo[$i]["controlstart"]==''){


                  $sms.="   <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlstart"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"cirinicio text-success\" name=\"cirinicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

                $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                if($inainfo[$i]["controlend"]==''){


                  $sms.="   <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\">".
                  "   <div>".
                  "     <label class=\"form-check-label\">Solicitar</label>".
                  "   </div>";

                }else{
                  if($inainfo[$i]["controlend"]=='t'){
                    $sms.=" <div class=\"divremove\"> <span class=\"cirfin text-success\" name=\"cirfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                  }else{
                    $sms.="   <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\" checked>".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }
                }
                $sms.="</div>";

              $sms.="</div>".
              "</div>";

              echo $sms;
            }else{
                $sms.= "<div>".

                "<hr>".
                "<div class=\"row\">".
                  "<input type=\"hidden\" name=\"cirfologico\" class=\"cirfologico\" value=\"".$inainfo[$i]['controlid']."\">".
                  "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                  "  <input type=\"date\" id=\"\" class=\"form-control cirfecha\" name=\"cirfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\">".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                  "  <input type=\"text\" class=\"form-control d-inline cirpieza\" placeholder=\"piezas\" name=\"cirpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" >".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                    "<textarea name=\"cirdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline cirdiagnostico\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                  "</div>".
                  "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "  <input type=\"text\" class=\"form-control d-inline cirtratamiento\" placeholder=\"tratamiento\" name=\"cirtratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\">".
                  "</div>";

                  $sms.="<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlstart"]==''){


                    $sms.="   <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";

                  }else{
                    if($inainfo[$i]["controlstart"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"cirinicio text-success\" name=\"cirinicio[]\" >Firmado</span></div><div class=\"divadd\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>";

                  $sms.="<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">";

                  if($inainfo[$i]["controlend"]==''){


                    $sms.="   <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\">".
                    "   <div>".
                    "     <label class=\"form-check-label\">Solicitar</label>".
                    "   </div>";
                  }else{
                    if($inainfo[$i]["controlend"]=='t'){
                      $sms.=" <div class=\"divremove\"> <span class=\"cirfin text-success\" name=\"cirfin[]\" >Firmado</span></div><div class=\"divadd2\"></div>";

                    }else{
                      $sms.="   <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\" checked>".
                      "   <div>".
                      "     <label class=\"form-check-label\">Solicitar</label>".
                      "   </div>";
                    }
                  }

                  $sms.="</div>".

                "</div>".
                "<button type=\"button\" class=\"btn btn-danger btn-sm m-3 remove\" name=\"\"> - Eliminar</button>".
                "</div>";
                echo $sms;

            }
          }
          if($i==0){
            echo "<div id=\"informationsurgery\">".
              "<hr>".
              "<div class=\"row\">".
                "<input type=\"hidden\" name=\"cirugia\" class=\"cirugia\" value=\"\">".
                "<div class=\"col-lg-3 col-md-3 col-sm-6 col-6\">".
                "  <input type=\"date\" id=\"\" class=\"form-control cirfecha\" name=\"cirfecha[]\" value=\"\" min=\"2015-01-01\" max=\"2099-01-01\">".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input type=\"text\" class=\"form-control d-inline cirpieza\" placeholder=\"piezas\" name=\"cirpieza[]\" >".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                  "<textarea name=\"cirdiagnostico[]\" rows=\"2\" placeholder=\"diagnostico\" class=\"form-control d-inline cirdiagnostico\"></textarea>".
                "</div>".
                "<div class=\"col-lg-2 col-md-2 col-sm-12 col-12\">".
                "  <input type=\"text\" class=\"form-control d-inline cirtratamiento\" placeholder=\"tratamiento\" name=\"cirtratamiento[]\" >".
                "</div>".

                "<div class=\"col-lg-2 col-md-2 col-sm-6 col-6\">".
                "  <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".

                "<div class=\"col-lg-1 col-md-1 col-sm-6 col-6\">".
                "  <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\">".
                "  <div>".
                "     <label class=\"form-check-label\">Solicitar</label>".
                "  </div>".
                "</div>".


              "</div>".
            "</div>";
          }

          ?>

          <button type="button" class="btn btn-success btn-sm m-3" id="addcirugia" name=""> + Agregar Mas</button>

        </div>

      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php

      if((isset($pat['pediatricsistatus']) && $pat['pediatricsistatus']!='fail'&&
      $pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end') &&
      ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
      (!isset($pat['observationaccepted'])) )){
          echo "<button type=\"submit\" class=\"btn btn-success\" id=\"cirugia_button\" name=\"cirugia_button\">Enviar Cirugia</button>";
      }

      ?>

    </div>

  </div>

  </div>
</div>
<!--modal Cirugia fin-->





<!--MODALS END-->

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

<!--odontograma inicio js-->

<?php
include("../leftodontogramjs.php");
?>
<!--odontograma fin js-->
  <!--oleary-->
  <script type="text/javascript">
  function createOleary() {
      var htmlTT="";
      var i=8;
      var sw=true,c='l';
      while(i>0&&i<9){
        htmlTT += '<div class="dienteb">' +
          '<svg width="40px" height="40px" class="bg-primary" id="indext'+c+i+'">' +
            '<polygon fill="white" stroke="black" stroke-width="1px" points="20 20, 0 0, 40 0" class="cursor clickoleary" name="triangulo" id="indext'+c+'t'+i+'"/>' +
            '<polygon fill="white" stroke="black" stroke-width="1px" points="0 0, 20 20, 0 40" class="cursor clickoleary" name="triangulo" id="indext'+c+'l'+i+'"/>' +
            '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 0 40" class="cursor clickoleary" name="triangulo" id="indext'+c+'b'+i+'"/>' +
            '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 40 0" class="cursor clickoleary" name="triangulo" id="indext'+c+'r'+i+'"/>' +
          '</svg>' +
          '<br>' +
          '<span style="padding-left: 14px; padding-right:14px" class="label label-info border">'+i+'</span>' +
          '<br>' +
          '<svg width="40px" height="40px" class="bg-primary" id="indexb'+c+i+'">' +
            '<polygon fill="white" stroke="black" stroke-width="1px" points="20 20, 0 0, 40 0" class="cursor clickoleary" name="triangulo" id="indexb'+c+'t'+i+'"/>' +
            '<polygon fill="white" stroke="black" stroke-width="1px" points="0 0, 20 20, 0 40" class="cursor clickoleary" name="triangulo" id="indexb'+c+'l'+i+'"/>' +
            '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 0 40" class="cursor clickoleary" name="triangulo" id="indexb'+c+'b'+i+'"/>' +
            '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 40 0" class="cursor clickoleary" name="triangulo" id="indexb'+c+'r'+i+'"/>' +
          '</svg>' +
        '</div>';

        if(sw&&i==1){
          sw=false;
          i--;
          c='r';
        }
        if(sw)
          i--;
        else
          i++;
      }

      $("#oleary").append(replaceAll('index', 't', htmlTT));
      $("#oleary2").append(replaceAll('index', 'b', htmlTT));
      $("#oleary3").append(replaceAll('index', 'c', htmlTT));
      //$("#oleary2").append(htmlBB);
  }

  //createOleary();
  </script>
    </body>
</html>
<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>
<script>
function round(num, decimales = 2) {
  var signo = (num >= 0 ? 1 : -1);
  num = num * signo;
  if (decimales === 0) //con 0 decimales
      return signo * Math.round(num);
  // round(x * 10 ^ decimales)
  num = num.toString().split('e');
  num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
  // x * 10 ^ (-decimales)
  num = num.toString().split('e');
  return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}
function result(){
  var p=0;
  var p2=0;
  var p3=0;
  var paint=0;
  var paint2=0;
  var paint3=0;
  var i=8;
  var sw=true,c='l';
  while(i>0&&i<9){
    var cont=0,cc=0;
    $('#tt'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p++;
      paint+=cc;
    }
    cont=0,cc=0;
    $('#tb'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p++;
      paint+=cc;
    }

    cont=0,cc=0;
    $('#bt'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p2++;
      paint2+=cc;
    }
    cont=0,cc=0;
    $('#bb'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p2++;
      paint2+=cc;
    }
    //para 3 inicio
    cont=0,cc=0;
    $('#ct'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p3++;
      paint3+=cc;
    }
    cont=0,cc=0;
    $('#cb'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p3++;
      paint3+=cc;
    }
    //para 3 fin

    if(sw&&i==1){
      sw=false;
      i--;
      c='r';
    }
    if(sw)
      i--;
    else
      i++;

  }
  //console.log('total: '+p);
  //$('#info').val(p+':'+paint);
  var r=(paint/(4*p))*100;
  var r2=(paint2/(4*p2))*100;
  var r3=(paint3/(4*p3))*100;
  r=round(r);
  r2=round(r2);
  r3=round(r3);
  $('#info').text(r+'%');
  $('#info2').text(r2+'%');
  $('#info3').text(r3+'%');
}

$(document).ready(function(){
      var oly=new Array();
      oly['ttlt8']='';oly['ttlb8']='';oly['ttll8']='';oly['ttlr8']=''; oly['ttrt8']='';oly['ttrb8']='';oly['ttrl8']='';oly['ttrr8']='';
      oly['ttlt7']='';oly['ttlb7']='';oly['ttll7']='';oly['ttlr7']=''; oly['ttrt7']='';oly['ttrb7']='';oly['ttrl7']='';oly['ttrr7']='';
      oly['ttlt6']='';oly['ttlb6']='';oly['ttll6']='';oly['ttlr6']=''; oly['ttrt6']='';oly['ttrb6']='';oly['ttrl6']='';oly['ttrr6']='';
      oly['ttlt5']='';oly['ttlb5']='';oly['ttll5']='';oly['ttlr5']=''; oly['ttrt5']='';oly['ttrb5']='';oly['ttrl5']='';oly['ttrr5']='';
      oly['ttlt4']='';oly['ttlb4']='';oly['ttll4']='';oly['ttlr4']=''; oly['ttrt4']='';oly['ttrb4']='';oly['ttrl4']='';oly['ttrr4']='';
      oly['ttlt3']='';oly['ttlb3']='';oly['ttll3']='';oly['ttlr3']=''; oly['ttrt3']='';oly['ttrb3']='';oly['ttrl3']='';oly['ttrr3']='';
      oly['ttlt2']='';oly['ttlb2']='';oly['ttll2']='';oly['ttlr2']=''; oly['ttrt2']='';oly['ttrb2']='';oly['ttrl2']='';oly['ttrr2']='';
      oly['ttlt1']='';oly['ttlb1']='';oly['ttll1']='';oly['ttlr1']=''; oly['ttrt1']='';oly['ttrb1']='';oly['ttrl1']='';oly['ttrr1']='';

      oly['tblt8']='';oly['tblb8']='';oly['tbll8']='';oly['tblr8']=''; oly['tbrt8']='';oly['tbrb8']='';oly['tbrl8']='';oly['tbrr8']='';
      oly['tblt7']='';oly['tblb7']='';oly['tbll7']='';oly['tblr7']=''; oly['tbrt7']='';oly['tbrb7']='';oly['tbrl7']='';oly['tbrr7']='';
      oly['tblt6']='';oly['tblb6']='';oly['tbll6']='';oly['tblr6']=''; oly['tbrt6']='';oly['tbrb6']='';oly['tbrl6']='';oly['tbrr6']='';
      oly['tblt5']='';oly['tblb5']='';oly['tbll5']='';oly['tblr5']=''; oly['tbrt5']='';oly['tbrb5']='';oly['tbrl5']='';oly['tbrr5']='';
      oly['tblt4']='';oly['tblb4']='';oly['tbll4']='';oly['tblr4']=''; oly['tbrt4']='';oly['tbrb4']='';oly['tbrl4']='';oly['tbrr4']='';
      oly['tblt3']='';oly['tblb3']='';oly['tbll3']='';oly['tblr3']=''; oly['tbrt3']='';oly['tbrb3']='';oly['tbrl3']='';oly['tbrr3']='';
      oly['tblt2']='';oly['tblb2']='';oly['tbll2']='';oly['tblr2']=''; oly['tbrt2']='';oly['tbrb2']='';oly['tbrl2']='';oly['tbrr2']='';
      oly['tblt1']='';oly['tblb1']='';oly['tbll1']='';oly['tblr1']=''; oly['tbrt1']='';oly['tbrb1']='';oly['tbrl1']='';oly['tbrr1']='';


      oly['btlt8']='';oly['btlb8']='';oly['btll8']='';oly['btlr8']=''; oly['btrt8']='';oly['btrb8']='';oly['btrl8']='';oly['btrr8']='';
      oly['btlt7']='';oly['btlb7']='';oly['btll7']='';oly['btlr7']=''; oly['btrt7']='';oly['btrb7']='';oly['btrl7']='';oly['btrr7']='';
      oly['btlt6']='';oly['btlb6']='';oly['btll6']='';oly['btlr6']=''; oly['btrt6']='';oly['btrb6']='';oly['btrl6']='';oly['btrr6']='';
      oly['btlt5']='';oly['btlb5']='';oly['btll5']='';oly['btlr5']=''; oly['btrt5']='';oly['btrb5']='';oly['btrl5']='';oly['btrr5']='';
      oly['btlt4']='';oly['btlb4']='';oly['btll4']='';oly['btlr4']=''; oly['btrt4']='';oly['btrb4']='';oly['btrl4']='';oly['btrr4']='';
      oly['btlt3']='';oly['btlb3']='';oly['btll3']='';oly['btlr3']=''; oly['btrt3']='';oly['btrb3']='';oly['btrl3']='';oly['btrr3']='';
      oly['btlt2']='';oly['btlb2']='';oly['btll2']='';oly['btlr2']=''; oly['btrt2']='';oly['btrb2']='';oly['btrl2']='';oly['btrr2']='';
      oly['btlt1']='';oly['btlb1']='';oly['btll1']='';oly['btlr1']=''; oly['btrt1']='';oly['btrb1']='';oly['btrl1']='';oly['btrr1']='';

      oly['bblt8']='';oly['bblb8']='';oly['bbll8']='';oly['bblr8']=''; oly['bbrt8']='';oly['bbrb8']='';oly['bbrl8']='';oly['bbrr8']='';
      oly['bblt7']='';oly['bblb7']='';oly['bbll7']='';oly['bblr7']=''; oly['bbrt7']='';oly['bbrb7']='';oly['bbrl7']='';oly['bbrr7']='';
      oly['bblt6']='';oly['bblb6']='';oly['bbll6']='';oly['bblr6']=''; oly['bbrt6']='';oly['bbrb6']='';oly['bbrl6']='';oly['bbrr6']='';
      oly['bblt5']='';oly['bblb5']='';oly['bbll5']='';oly['bblr5']=''; oly['bbrt5']='';oly['bbrb5']='';oly['bbrl5']='';oly['bbrr5']='';
      oly['bblt4']='';oly['bblb4']='';oly['bbll4']='';oly['bblr4']=''; oly['bbrt4']='';oly['bbrb4']='';oly['bbrl4']='';oly['bbrr4']='';
      oly['bblt3']='';oly['bblb3']='';oly['bbll3']='';oly['bblr3']=''; oly['bbrt3']='';oly['bbrb3']='';oly['bbrl3']='';oly['bbrr3']='';
      oly['bblt2']='';oly['bblb2']='';oly['bbll2']='';oly['bblr2']=''; oly['bbrt2']='';oly['bbrb2']='';oly['bbrl2']='';oly['bbrr2']='';
      oly['bblt1']='';oly['bblb1']='';oly['bbll1']='';oly['bblr1']=''; oly['bbrt1']='';oly['bbrb1']='';oly['bbrl1']='';oly['bbrr1']='';


      oly['ctlt8']='';oly['ctlb8']='';oly['ctll8']='';oly['ctlr8']=''; oly['ctrt8']='';oly['ctrb8']='';oly['ctrl8']='';oly['ctrr8']='';
      oly['ctlt7']='';oly['ctlb7']='';oly['ctll7']='';oly['ctlr7']=''; oly['ctrt7']='';oly['ctrb7']='';oly['ctrl7']='';oly['ctrr7']='';
      oly['ctlt6']='';oly['ctlb6']='';oly['ctll6']='';oly['ctlr6']=''; oly['ctrt6']='';oly['ctrb6']='';oly['ctrl6']='';oly['ctrr6']='';
      oly['ctlt5']='';oly['ctlb5']='';oly['ctll5']='';oly['ctlr5']=''; oly['ctrt5']='';oly['ctrb5']='';oly['ctrl5']='';oly['ctrr5']='';
      oly['ctlt4']='';oly['ctlb4']='';oly['ctll4']='';oly['ctlr4']=''; oly['ctrt4']='';oly['ctrb4']='';oly['ctrl4']='';oly['ctrr4']='';
      oly['ctlt3']='';oly['ctlb3']='';oly['ctll3']='';oly['ctlr3']=''; oly['ctrt3']='';oly['ctrb3']='';oly['ctrl3']='';oly['ctrr3']='';
      oly['ctlt2']='';oly['ctlb2']='';oly['ctll2']='';oly['ctlr2']=''; oly['ctrt2']='';oly['ctrb2']='';oly['ctrl2']='';oly['ctrr2']='';
      oly['ctlt1']='';oly['ctlb1']='';oly['ctll1']='';oly['ctlr1']=''; oly['ctrt1']='';oly['ctrb1']='';oly['ctrl1']='';oly['ctrr1']='';

      oly['cblt8']='';oly['cblb8']='';oly['cbll8']='';oly['cblr8']=''; oly['cbrt8']='';oly['cbrb8']='';oly['cbrl8']='';oly['cbrr8']='';
      oly['cblt7']='';oly['cblb7']='';oly['cbll7']='';oly['cblr7']=''; oly['cbrt7']='';oly['cbrb7']='';oly['cbrl7']='';oly['cbrr7']='';
      oly['cblt6']='';oly['cblb6']='';oly['cbll6']='';oly['cblr6']=''; oly['cbrt6']='';oly['cbrb6']='';oly['cbrl6']='';oly['cbrr6']='';
      oly['cblt5']='';oly['cblb5']='';oly['cbll5']='';oly['cblr5']=''; oly['cbrt5']='';oly['cbrb5']='';oly['cbrl5']='';oly['cbrr5']='';
      oly['cblt4']='';oly['cblb4']='';oly['cbll4']='';oly['cblr4']=''; oly['cbrt4']='';oly['cbrb4']='';oly['cbrl4']='';oly['cbrr4']='';
      oly['cblt3']='';oly['cblb3']='';oly['cbll3']='';oly['cblr3']=''; oly['cbrt3']='';oly['cbrb3']='';oly['cbrl3']='';oly['cbrr3']='';
      oly['cblt2']='';oly['cblb2']='';oly['cbll2']='';oly['cblr2']=''; oly['cbrt2']='';oly['cbrb2']='';oly['cbrl2']='';oly['cbrr2']='';
      oly['cblt1']='';oly['cblb1']='';oly['cbll1']='';oly['cblr1']=''; oly['cbrt1']='';oly['cbrb1']='';oly['cbrl1']='';oly['cbrr1']='';


      function encriptoleary(){
        var str='';
        for (const key in oly) {
          //console.log(`${key}: ${a[key]}`);
        //  console.log(a[key]);
          str+='['+key+'='+oly[key]+']';
        }
        $('#olygram').val(str);
        //para imprimir
      }

      function descriptoleary(str){
        var data=str.split(']');
        //console.log(a.length);
        for(var i=0;i<data.length-1;i++){
          var b=data[i].split('[');
          var c=b[1].split('=');
          oly[c[0]]=c[1];

          if(c[1]=='red'){
            //console.log(c[0]+' = '+c[1]);
            $('#'+c[0]).attr('fill','red');
          }
          if(c[1]=='gra'){
            $('#'+c[0]).parent().append('<i style="color:black;" class="fa fa-times fa-3x fa-fw cursor fabians"></i>');
            $('#'+c[0]).parent().children("i").css({
                "position": "absolute",
                "top": "24%",
                "left": "18.58ex"
            });
          }
          //[xdateu='+$('#date1').val()+']
          //if(c[0]=='xdateu')//paramos aqhi.....
          //  $('#date1').val(c[1]);

          //console.log(c[0]+' = '+c[1]);
        }
      }

      createOleary();

      descriptoleary(`<?php echo trim($pat["pediatricsioleary"]); ?>`);
      result();

      //cancel cancel_button
     $('#cancel_button').click(function(){
        location.reload();
     });


     function registeroleary(){
       var olygram = $('#olygram').val()+'[xu='+$('#info').text()+']'+'[xt='+$('#info2').text()+']'+
       '[xr='+$('#info3').text()+']'+'[xdateu='+$('#date1').val()+']'+'[xdatet='+$('#date2').val()+']'+
       '[xdater='+$('#date3').val()+']'+'[xevaluedu='+$('#evaluedoleary1').text()+']'+'[xevaluedt='+$('#evaluedoleary2').text()+']'+
       '[xevaluedr='+$('#evaluedoleary3').text()+']';



       var ficha = $('#ficha').val();
           $.ajax({

              url:"../include/i_pediatrics.php",
              method:"POST",
              data: {olygram:olygram, ficha:ficha},

              success:function(data)
              {

                if(data=='yes'){
                  alert('Se envio o lary');
                  //location.reload();
                  $('#tartrectomia').hide();
                  if ($('.modal-backdrop').is(':visible')) {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                  };

                }else{
                  alert(data);
                  console.log(data);
                }
              }
           });

     }
     //funcion para registrar los datos de la ficha clinica de odontopediatria I
     function registerpatient(){


      var patientid=$('#patientid').val();
      var ficha=$('#ficha').val();
      var patientdatebirth=$('#patientdatebirth').val();
      var patientplacebirth=$('#patientplacebirth').val();
      var patientfathername=$('#patientfathername').val();
      var patientfatheroccupation=$('#patientfatheroccupation').val();
      var patientmothername=$('#patientmothername').val();
      var patientmotheroccupation=$('#patientmotheroccupation').val();
      var name='';//$('#name').val();
      $(".names").each(function() {
         //taskArray.Push($(this).val());
         name+=$(this).val()+',';
      });
      //alert(name);
      var age='';//$('#age').val();
      $(".ages").each(function() {
         //taskArray.Push($(this).val());
         age+=$(this).val()+',';

      });

      var patientschools=$('#patientschools').val();
      var patientschool=$('#patientschool').val();
      var refer=$('#refer').val();
      var reason=$('#reason').val();
      var temp=$('#temp').val();
      var fc=$('#fc').val();
      var fr=$('#fr').val();
      var pd=$('#pd').val();
      var talla=$('#talla').val();
      var peso=$('#peso').val();
      var constit=$('#constit').val();
      var pulso=$('#pulso').val();
      var diast=$('#diast').val();
      var motconsult=$('#motconsult').val();
      var attitude=$('#attitude').val();
      var chair=$('#chair').val();
      var prior=$('#prior').val();
      var lastattention=$('#lastattention').val();
      var periodica=$('#periodica').val();
      var periodicacuales=$('#periodicacuales').val();
      var traumaticas=$('#traumaticas').val();
      var traumaticascuales=$('#traumaticascuales').val();
      var attitudeodont=$('#attitudeodont').val();
      var diseases=$('#diseases').val();
      var interventions=$('#interventions').val();
      var conexplicaciones=$('#conexplicaciones').val();
      var sinconexplicaciones=$('#sinconexplicaciones').val();
      var experienciastraumaticas=$('#experienciastraumaticas').val();
      var experienciastraumaticasotros=$('#experienciastraumaticasotros').val();
      var medicoperiodicamente=$('#medicoperiodicamente').val();
      var medicoirregularmente=$('#medicoirregularmente').val();
      var consistency=$('#consistency').val();
      var desayuno=$('#desayuno').val();
      var desayunoalmuerzo=$('#desayunoalmuerzo').val();
      var almuerzo=$('#almuerzo').val();
      var merienda=$('#merienda').val();
      var cena=$('#cena').val();
      var despuescena=$('#despuescena').val();
      var despierta=$('#despierta').val();
      var dulcedia=$('#dulcedia').val();
      var riesgocaries=$('#riesgocaries').val();
      var actitudalimentacion=$('#actitudalimentacion').val();
      var tecnicabacterial=$('select[name=tecnicabacterial]').val();//$('#tecnicabacterial').val();
      var ensenadopor=$('#ensenadopor').val();
      var tipocepillo=$('#tipocepillo').val();
      var dentifrico=$('select[name=dentifrico]').val();//$('#dentifrico').val();
      var fluoruros=$('select[name=fluoruros]').val();//$('#fluoruros').val();
      var foururoedad=$('#foururoedad').val();
      var foururocontinua=$('#foururocontinua').val();
      var topicos=$('select[name=topicos]').val();//$('#topicos').val();
      var topicostiempo=$('#topicostiempo').val();
      var topicoscontinua=$('#topicoscontinua').val();
      var enjuagatorio=$('select[name=enjuagatorio]').val();//$('#enjuagatorio').val();
      var enjuagatoriocontinua=$('#enjuagatoriocontinua').val();
      var sealants=$('select[name=sealants]').val();//$('#sealants').val();
      var oralhabits=$('#oralhabits').val();
      var resumefather=$('#resumefather').val();
      var actituddelnino=$('#actituddelnino').val();
      var actituddelpadre=$('#actituddelpadre').val();
      var actitudacompanante=$('#actitudacompanante').val();
      var firstsynthesis=$('#firstsynthesis').val();
      var cpod=$('#cpod').val();
      var cpos=$('#cpos').val();
      var ceod=$('#ceod').val();
      var ceos=$('#ceos').val();
      var pri=$('#pri').val();
      var per=$('#per').val();
      var activa=$('#activa').val();
      var lenta=$('#lenta').val();
      var detenida=$('#detenida').val();



       //var tongue = $('select[name=tongue]').val();// $('select[name=tongue]').val();// $('input:radio[name=tongue]:checked').val();


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
       //metadatos inicio
       var tl8=$('#tl8').val(),tl7=$('#tl7').val(),tl6=$('#tl6').val(),tl5=$('#tl5').val(),tl4=$('#tl4').val(),tl3=$('#tl3').val(),tl2=$('#tl2').val(),tl1=$('#tl1').val();
       var tr8=$('#tr8').val(),tr7=$('#tr7').val(),tr6=$('#tr6').val(),tr5=$('#tr5').val(),tr4=$('#tr4').val(),tr3=$('#tr3').val(),tr2=$('#tr2').val(),tr1=$('#tr1').val();
       var bl8=$('#bl8').val(),bl7=$('#bl7').val(),bl6=$('#bl6').val(),bl5=$('#bl5').val(),bl4=$('#bl4').val(),bl3=$('#bl3').val(),bl2=$('#bl2').val(),bl1=$('#bl1').val();
       var br8=$('#br8').val(),br7=$('#br7').val(),br6=$('#br6').val(),br5=$('#br5').val(),br4=$('#br4').val(),br3=$('#br3').val(),br2=$('#br2').val(),br1=$('#br1').val();
       //metadatos fin

       var monitoreo = $('#monitoreo').val();
       var comentario = $('#comentario').val();
       //especialmente para odonpediatria II inicio
       var dentaria=$('#dentaria').val();
       var anquilosis=$('#anquilosis').val();
       var agenesias=$('#agenesias').val();
       var ectopica=$('#ectopica').val();
       var supernumerarios=$('#supernumerarios').val();
       var precoz=$('#precoz').val();
       var dentariaobs=$('#dentariaobs').val();

       var iniciacion=$('#iniciacion').prop('checked');
       var histo=$('#histo').prop('checked');
       var morfo=$('#morfo').prop('checked');
       var aposicion=$('#aposicion').prop('checked');
       var calcificacion=$('#calcificacion').prop('checked');
       var erupcion=$('#erupcion').prop('checked');
       var abrasion=$('#abrasion').prop('checked');
       var anomaliaobs=$('#anomaliaobs').val();
       //console.log(iniciacion+' '+histo+' '+morfo+' '+aposicion+' '+calcificacion+' '+erupcion+' '+abrasion);
       //especialmente para odontopediatria II fin
           $.ajax({

              url:"../include/i_pediatrics.php",
              method:"POST",
              data: {patientid:patientid, ficha:ficha, patientdatebirth:patientdatebirth, patientplacebirth:patientplacebirth,
                patientfathername:patientfathername, patientfatheroccupation:patientfatheroccupation, patientmothername:patientmothername,
                patientmotheroccupation:patientmotheroccupation, name:name, age:age, patientschools:patientschools,
                patientschool:patientschool, refer:refer, reason:reason, temp:temp, fc:fc, fr:fr, pd:pd, talla:talla,
                peso:peso, constit:constit, pulso:pulso, diast:diast, motconsult:motconsult, attitude:attitude, chair:chair,
                prior:prior, lastattention:lastattention, periodica:periodica, periodicacuales:periodicacuales, traumaticas:traumaticas,
                traumaticascuales:traumaticascuales, attitudeodont:attitudeodont, diseases:diseases, interventions:interventions,
                conexplicaciones:conexplicaciones, sinconexplicaciones:sinconexplicaciones, experienciastraumaticas:experienciastraumaticas,
                experienciastraumaticasotros:experienciastraumaticasotros, medicoperiodicamente:medicoperiodicamente,
                medicoirregularmente:medicoirregularmente, consistency:consistency, desayuno:desayuno, desayunoalmuerzo:desayunoalmuerzo,
                almuerzo:almuerzo, merienda:merienda, cena:cena, despuescena:despuescena, despierta:despierta, dulcedia:dulcedia,
                riesgocaries:riesgocaries, actitudalimentacion:actitudalimentacion, tecnicabacterial:tecnicabacterial, ensenadopor:ensenadopor,
                tipocepillo:tipocepillo, dentifrico:dentifrico, fluoruros:fluoruros, foururoedad:foururoedad, foururocontinua:foururocontinua,
                topicos:topicos, topicostiempo:topicostiempo, topicoscontinua:topicoscontinua, enjuagatorio:enjuagatorio, enjuagatoriocontinua:enjuagatoriocontinua,
                sealants:sealants, oralhabits:oralhabits, resumefather:resumefather, actituddelnino:actituddelnino, actituddelpadre:actituddelpadre,
                actitudacompanante:actitudacompanante, firstsynthesis:firstsynthesis, cpod:cpod, cpos:cpos, ceod:ceod, ceos:ceos, pri:pri, per:per,
                activa:activa, lenta:lenta, detenida:detenida,
                odontogram:odontogram, tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr,
                odontodiagnostico:odontodiagnostico, odontodraw:odontodraw, monitoreo:monitoreo, comentario:comentario,
                tl8:tl8, tl7:tl7, tl6:tl6, tl5:tl5, tl4:tl4, tl3:tl3, tl2:tl2, tl1:tl1,
                tr8:tr8, tr7:tr7, tr6:tr6, tr5:tr5, tr4:tr4, tr3:tr3, tr2:tr2, tr1:tr1,
                bl8:bl8, bl7:bl7, bl6:bl6, bl5:bl5, bl4:bl4, bl3:bl3, bl2:bl2, bl1:bl1,
                br8:br8, br7:br7, br6:br6, br5:br5, br4:br4, br3:br3, br2:br2, br1:br1,
                dentaria:dentaria,anquilosis:anquilosis,agenesias:agenesias,ectopica:ectopica,
                supernumerarios:supernumerarios,precoz:precoz,dentariaobs:dentariaobs,
                iniciacion:iniciacion,histo:histo,morfo:morfo,aposicion:aposicion,calcificacion:calcificacion,
                erupcion:erupcion,abrasion:abrasion,anomaliaobs:anomaliaobs},
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
       }else{
           location.reload();
       }
     });

     //plan de tratamiento

     $('#plan_button').click(function(){
       if (confirm("Guardar Plan de tratamiento?")) {
         var plantxt = $('#plantxt').val();
         var ficha=$('#ficha').val();
         $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, plantxt:plantxt},

            success:function(data)
            {

              if(data=='yes'){
                alert('Se guardó');
                $('#plan').hide();
                if ($('.modal-backdrop').is(':visible')) {
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                };
                //location.reload();
                //ocultar
              }else{
                alert(data);
                console.log(data);
              }
            }
         });

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
         var s1date1 = $('#session1date1').val();
         var s1date2 = $('#session1date2').val();
         var s1date3 = $('#session1date3').val();
         var treatment = $('select[name=treatment]').val();

         var s1evalued1 = $('#session1evalued1').val();
         var s1evalued2 = $('#session1evalued2').val();
         var s1evalued3 = $('#session1evalued3').val();
         $.ajax({

						  url:"../include/i_session.php",
						  method:"POST",
						  data: {s1evalued1:s1evalued1 ,s1evalued2:s1evalued2 ,s1evalued3:s1evalued3 ,treatment:treatment, ficha:ficha, s1date1:s1date1, s1date2:s1date2, s1date3:s1date3},

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
         var s2date1 = $('#session2date1').val();
         var s2date2 = $('#session2date2').val();
         var s2date3 = $('#session2date3').val();
         var s2evalued1 = $('#session2evalued1').val();
         var s2evalued2 = $('#session2evalued2').val();
         var s2evalued3 = $('#session2evalued3').val();

         var treatment = $('select[name=treatment]').val();

         $.ajax({

						  url:"../include/i_session.php",
						  method:"POST",
						  data: {s2evalued1:s2evalued1, s2evalued2:s2evalued2, s2evalued3:s2evalued3, treatment:treatment, ficha:ficha, s2date1:s2date1, s2date2:s2date2, s2date3:s2date3},

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
     $('#oleary_button').click(function(){
       registeroleary();

     });
     $('#urgencias_button').click(function(){

       var ficha=$('#ficha').val();

       var urgfecha='';
       $(".urgfecha").each(function() {
          urgfecha+=$(this).val()+',';
       });
       var urgpieza='';
       $(".urgpieza").each(function() {
          urgpieza+=$(this).val()+'.:.';
       });
       var urgdiagnostico='';
       $(".urgdiagnostico").each(function() {
          urgdiagnostico+=$(this).val()+'.:.';
       });
       var urgtratamiento='';
       $(".urgtratamiento").each(function() {
          urgtratamiento+=$(this).val()+'.:.';
       });
       var urgencias='';
       $(".urgencias").each(function() {
          urgencias+=$(this).val()+'.:.';
       });

       var conta=0;
       var iniciofirma='';
       $(".firmainicio").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            iniciofirma+='t,';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              iniciofirma+='f,';
            }else{
              iniciofirma+=',';
            }
          }
          conta++;
          //urgencias+=$(this).val()+'.:.';
       });

       var conta1=0;
       var finfirma='';
       $(".firmafin").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            finfirma+='t,';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              finfirma+='f,';
            }else{
              finfirma+=',';
            }
          }
          conta1++;
          //urgencias+=$(this).val()+'.:.';
       });

       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, urgencias:urgencias, urgfecha:urgfecha, urgpieza:urgpieza, urgdiagnostico:urgdiagnostico, urgtratamiento:urgtratamiento, iniciofirma:iniciofirma, finfirma:finfirma},

            success:function(data)
            {

              if(data=='yes'){
                alert('Se envió los datos');
                $('#urgencias').hide();
                if ($('.modal-backdrop').is(':visible')) {
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                };
                //location.reload();
              }else{
                alert(data);
                console.log(data);
              }

            }
       });
       //registeroleary();
     });

//correccion inicio


     $('#inactivacion_button').click(function(){

       var ficha=$('#ficha').val();

       var inafecha='';
       $(".inafecha").each(function() {
          inafecha+=$(this).val()+',';
       });
       var inapieza='';
       $(".inapieza").each(function() {
          inapieza+=$(this).val()+'.:.';
       });
       var inadiagnostico='';
       $(".inadiagnostico").each(function() {
          inadiagnostico+=$(this).val()+'.:.';
       });
       var inatratamiento='';
       $(".inatratamiento").each(function() {
          inatratamiento+=$(this).val()+'.:.';
       });
       var inactivacion='';
       $(".inactivacion").each(function() {
          inactivacion+=$(this).val()+'.:.';
       });

       var conta=0;
       var inainicio='';
       $(".inainicio").each(function() {
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            inainicio+='t,';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              inainicio+='f,';
            }else{
              inainicio+=',';
            }
          }
          conta++;
          //urgencias+=$(this).val()+'.:.';
       });

       var conta1=0;
       var inafin='';
       $(".inafin").each(function() {
          if($(this).prop('checked')=== undefined){
            inafin+='t,';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              inafin+='f,';
            }else{
              inafin+=',';
            }
          }
          conta1++;
       });


       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, inactivacion:inactivacion, inafecha:inafecha, inapieza:inapieza, inadiagnostico:inadiagnostico, inatratamiento:inatratamiento, inainicio:inainicio, inafin:inafin},

            success:function(data)
            {

              if(data=='yes'){
                alert('Se envió los datos');
                $('#inactivacion').hide();
                if ($('.modal-backdrop').is(':visible')) {
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                };
                //location.reload();
              }else{
                alert(data);
                console.log(data);
              }

            }
       });
    });





       $('#quimico_button').click(function(){


         var ficha=$('#ficha').val();

         var quifecha='';
         $(".quifecha").each(function() {
            quifecha+=$(this).val()+',';
         });
         var quipieza='';
         $(".quipieza").each(function() {
            quipieza+=$(this).val()+'.:.';
         });
         var quidiagnostico='';
         $(".quidiagnostico").each(function() {
            quidiagnostico+=$(this).val()+'.:.';
         });
         var quitratamiento='';
         $(".quitratamiento").each(function() {
            quitratamiento+=$(this).val()+'.:.';
         });
         var quimico='';
         $(".quimico").each(function() {
            quimico+=$(this).val()+'.:.';
         });

         var conta=0;
         var quiinicio='';
         $(".quiinicio").each(function() {
            if($(this).prop('checked')=== undefined){
              //console.log($(this)+"no es checkbox"+conta);
              quiinicio+='t,';
            }else{
              //console.log($(this)+"es checkbox"+conta);
              if($(this).prop('checked')==true){
                quiinicio+='f,';
              }else{
                quiinicio+=',';
              }
            }
            conta++;
            //urgencias+=$(this).val()+'.:.';
         });

         var conta1=0;
         var quifin='';
         $(".quifin").each(function() {
            if($(this).prop('checked')=== undefined){
              quifin+='t,';
            }else{
              //console.log($(this)+"es checkbox"+conta);
              if($(this).prop('checked')==true){
                quifin+='f,';
              }else{
                quifin+=',';
              }
            }
            conta1++;
         });

       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, quimico:quimico, quifecha:quifecha, quipieza:quipieza, quidiagnostico:quidiagnostico, quitratamiento:quitratamiento, quiinicio:quiinicio, quifin:quifin},

            success:function(data)
            {

              if(data=='yes'){
                alert('Se envió los datos');
                $('#quimico').hide();
                if ($('.modal-backdrop').is(':visible')) {
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                };
                //location.reload();
              }else{
                alert(data);
                console.log(data);
              }

            }
       });

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
      				  url:"../include/i_pediatrics.php",
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
      							   //$('#subproblem').hide();
      							   //location.reload();
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
     $('#morfologico_button').click(function(){

       var ficha=$('#ficha').val();

       var morfecha='';
       $(".morfecha").each(function() {
          morfecha+=$(this).val()+',';
       });
       var morpieza='';
       $(".morpieza").each(function() {
          morpieza+=$(this).val()+'.:.';
       });
       var mordiagnostico='';
       $(".mordiagnostico").each(function() {
          mordiagnostico+=$(this).val()+'.:.';
       });
       var mortratamiento='';
       $(".mortratamiento").each(function() {
          mortratamiento+=$(this).val()+'.:.';
       });
       var morfologico='';
       $(".morfologico").each(function() {
          morfologico+=$(this).val()+'.:.';
       });

       var conta=0;
       var morinicio='';
       $(".morinicio").each(function() {
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            morinicio+='t,';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              morinicio+='f,';
            }else{
              morinicio+=',';
            }
          }
          conta++;
          //urgencias+=$(this).val()+'.:.';
       });

       var conta1=0;
       var morfin='';
       $(".morfin").each(function() {
          if($(this).prop('checked')=== undefined){
            morfin+='t,';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              morfin+='f,';
            }else{
              morfin+=',';
            }
          }
          conta1++;
       });

     $.ajax({

          url:"../include/i_pediatrics.php",
          method:"POST",
          data: {ficha:ficha, morfologico:morfologico, morfecha:morfecha, morpieza:morpieza, mordiagnostico:mordiagnostico, mortratamiento:mortratamiento, morinicio:morinicio, morfin:morfin},

          success:function(data)
          {
            if(data=='yes'){
              alert('Se envió los datos');
              $('#morfologico').hide();
              if ($('.modal-backdrop').is(':visible')) {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
              };
            }else{
              alert(data);
              console.log(data);
            }

          }
     });
   });



    $('#estructural_button').click(function(){

      var ficha=$('#ficha').val();

      var estfecha='';
      $(".estfecha").each(function() {
         estfecha+=$(this).val()+',';
      });
      var estpieza='';
      $(".estpieza").each(function() {
         estpieza+=$(this).val()+'.:.';
      });
      var estdiagnostico='';
      $(".estdiagnostico").each(function() {
         estdiagnostico+=$(this).val()+'.:.';
      });
      var esttratamiento='';
      $(".esttratamiento").each(function() {
         esttratamiento+=$(this).val()+'.:.';
      });
      var estructural='';
      $(".estructural").each(function() {
         estructural+=$(this).val()+'.:.';
      });

      var conta=0;
      var estinicio='';
      $(".estinicio").each(function() {
         if($(this).prop('checked')=== undefined){
           //console.log($(this)+"no es checkbox"+conta);
           estinicio+='t,';
         }else{
           //console.log($(this)+"es checkbox"+conta);
           if($(this).prop('checked')==true){
             estinicio+='f,';
           }else{
             estinicio+=',';
           }
         }
         conta++;
         //urgencias+=$(this).val()+'.:.';
      });

      var conta1=0;
      var estfin='';
      $(".estfin").each(function() {
         if($(this).prop('checked')=== undefined){
           estfin+='t,';
         }else{
           //console.log($(this)+"es checkbox"+conta);
           if($(this).prop('checked')==true){
             estfin+='f,';
           }else{
             estfin+=',';
           }
         }
         conta1++;
      });

    $.ajax({

         url:"../include/i_pediatrics.php",
         method:"POST",
         data: {ficha:ficha, estructural:estructural, estfecha:estfecha, estpieza:estpieza, estdiagnostico:estdiagnostico, esttratamiento:esttratamiento, estinicio:estinicio, estfin:estfin},

         success:function(data)
         {
           if(data=='yes'){
             alert('Se envió los datos');
             $('#estructural').hide();
             if ($('.modal-backdrop').is(':visible')) {
               $('body').removeClass('modal-open');
               $('.modal-backdrop').remove();
             };
             //location.reload();
           }else{
             alert(data);
             console.log(data);
           }

         }
    });
  });
  //tratamiento pulpar con session
  function pulpar(sw=true){
    var ficha=$('#ficha').val();
    var pulfecha='';
    $(".pulfecha").each(function() {
       pulfecha+=$(this).val()+',';
    });
    var pulpieza='';
    $(".pulpieza").each(function() {
       pulpieza+=$(this).val()+'.:.';
    });
    var puldiagnostico='';
    $(".puldiagnostico").each(function() {
       puldiagnostico+=$(this).val()+'.:.';
    });
    var pultratamiento='';
    $(".pultratamiento").each(function() {
       pultratamiento+=$(this).val()+'.:.';
    });
    var pulpar='';
    var key='';
    var pulparsession='';
    $(".pulpar").each(function() {
       pulpar+=$(this).val()+'.:.';
       key=$(this).attr('idf');
       pulparsession+='[';
       //console.log(".sessionpulpar"+key);
       $(".sessionpulpar"+key).each(function() {
         //console.log($(this).prop('checked'));
         //pulparsession+=$(this).prop('checked')+',';

         if($(this).prop('checked')=== undefined){
           pulparsession+='t,';
         }else{
           //console.log($(this)+"es checkbox"+conta);
           if($(this).prop('checked')==true){
             pulparsession+='f,';
           }else{
             pulparsession+=',';
           }
         }

       });
       pulparsession+=']';
    });
    //console.log(pulparsession);

    var conta1=0;
    var pulfin='';
    $(".pulfin").each(function() {
       if($(this).prop('checked')=== undefined){
         pulfin+='t,';
       }else{
         //console.log($(this)+"es checkbox"+conta);
         if($(this).prop('checked')==true){
           pulfin+='f,';
         }else{
           pulfin+=',';
         }
       }
       conta1++;
    });

    $.ajax({

         url:"../include/i_pediatrics.php",
         method:"POST",
         data: {ficha:ficha, pulpar:pulpar, pulfecha:pulfecha, pulpieza:pulpieza, puldiagnostico:puldiagnostico, pultratamiento:pultratamiento, pulparsession:pulparsession, pulfin:pulfin},

         success:function(data)
         {
           if(data=='yes'){
             alert('Se envió los datos');
             if(sw){
               //location.reload();
               $('#pulpar').hide();
               if ($('.modal-backdrop').is(':visible')) {
                 $('body').removeClass('modal-open');
                 $('.modal-backdrop').remove();
               };
             }

           }else{
             alert(data);
             console.log(data);
           }

         }
    });
  }
  $('#pulpar_button').click(function(){

    pulpar();
  });
  $("[name='controlsession_button']").click(function(){
    //alert('boton session');
    pulpar(false);
  });

  //rehabilitacion
  function rehabilitation(sw=true){
    var ficha=$('#ficha').val();
    var rehfecha='';
    $(".rehfecha").each(function() {
       rehfecha+=$(this).val()+',';
    });
    var rehpieza='';
    $(".rehpieza").each(function() {
       rehpieza+=$(this).val()+'.:.';
    });
    var rehdiagnostico='';
    $(".rehdiagnostico").each(function() {
       rehdiagnostico+=$(this).val()+'.:.';
    });
    var rehtratamiento='';
    $(".rehtratamiento").each(function() {
       rehtratamiento+=$(this).val()+'.:.';
    });
    var rehabilitation='';
    var key='';

    var rehabilitationsession='';
    $(".rehabilitation").each(function() {

       rehabilitation+=$(this).val()+'.:.';
       key=$(this).attr('idf');
       rehabilitationsession+='[';
       //console.log(".sessionrehabilitation"+key);
       $(".sessionrehabilitation"+key).each(function() {
         //console.log($(this).prop('checked'));
         //pulparsession+=$(this).prop('checked')+',';

         if($(this).prop('checked')=== undefined){
           rehabilitationsession+='t,';
         }else{
           //console.log($(this)+"es checkbox"+conta);
           if($(this).prop('checked')==true){
             rehabilitationsession+='f,';
           }else{
             rehabilitationsession+=',';
           }
         }

       });
       rehabilitationsession+=']';

    });
    //alert('rehabilitation');
    //console.log(rehabilitationsession);

    var conta1=0;
    var rehfin='';
    $(".rehfin").each(function() {
       if($(this).prop('checked')=== undefined){
         rehfin+='t,';
       }else{
         //console.log($(this)+"es checkbox"+conta);
         if($(this).prop('checked')==true){
           rehfin+='f,';
         }else{
           rehfin+=',';
         }
       }
       conta1++;
    });

    $.ajax({

         url:"../include/i_pediatrics.php",
         method:"POST",
         data: {ficha:ficha, rehabilitation:rehabilitation, rehfecha:rehfecha, rehpieza:rehpieza, rehdiagnostico:rehdiagnostico, rehtratamiento:rehtratamiento, rehabilitationsession:rehabilitationsession, rehfin:rehfin},

         success:function(data)
         {
           if(data=='yes'){
             alert('Se envió los datos');
             if(sw){
               //location.reload();
               $('#rehabilitacion').hide();
               if ($('.modal-backdrop').is(':visible')) {
                 $('body').removeClass('modal-open');
                 $('.modal-backdrop').remove();
               };
             }

           }else{
             alert(data);
             console.log(data);
           }

         }
    });
  }

  $('#rehabilitation_button').click(function(){

    rehabilitation();
  });
  $("[name='controlsessionreh_button']").click(function(){
    //alert('boton session');
    rehabilitation(false);
  });

  //revisado
    $('#cirugia_button').click(function(){

      var ficha=$('#ficha').val();

      var cirfecha='';
      $(".cirfecha").each(function() {
         cirfecha+=$(this).val()+',';
      });
      var cirpieza='';
      $(".cirpieza").each(function() {
         cirpieza+=$(this).val()+'.:.';
      });
      var cirdiagnostico='';
      $(".cirdiagnostico").each(function() {
         cirdiagnostico+=$(this).val()+'.:.';
      });
      var cirtratamiento='';
      $(".cirtratamiento").each(function() {
         cirtratamiento+=$(this).val()+'.:.';
      });
      var cirugia='';
      $(".cirugia").each(function() {
         cirugia+=$(this).val()+'.:.';
      });

      var conta=0;
      var cirinicio='';
      $(".cirinicio").each(function() {
         if($(this).prop('checked')=== undefined){
           //console.log($(this)+"no es checkbox"+conta);
           cirinicio+='t,';
         }else{
           //console.log($(this)+"es checkbox"+conta);
           if($(this).prop('checked')==true){
             cirinicio+='f,';
           }else{
             cirinicio+=',';
           }
         }
         conta++;
         //urgencias+=$(this).val()+'.:.';
      });

      var conta1=0;
      var cirfin='';
      $(".cirfin").each(function() {
         if($(this).prop('checked')=== undefined){
           cirfin+='t,';
         }else{
           //console.log($(this)+"es checkbox"+conta);
           if($(this).prop('checked')==true){
             cirfin+='f,';
           }else{
             cirfin+=',';
           }
         }
         conta1++;
      });

    $.ajax({

         url:"../include/i_pediatrics.php",
         method:"POST",
         data: {ficha:ficha, cirugia:cirugia, cirfecha:cirfecha, cirpieza:cirpieza, cirdiagnostico:cirdiagnostico, cirtratamiento:cirtratamiento, cirinicio:cirinicio, cirfin:cirfin},

         success:function(data)
         {
           if(data=='yes'){
             alert('Se envió los datos');
             $('#cirugia').hide();
             if ($('.modal-backdrop').is(':visible')) {
               $('body').removeClass('modal-open');
               $('.modal-backdrop').remove();
             };
             //location.reload();
           }else{
             alert(data);
             console.log(data);
           }

         }
    });
  });

     $(".clickoleary").click(function(event) {
        //id de elemento seleccionado
         var desc=$(this).attr('id');//que es una X
         console.log(desc);

         if(desc.charAt(0)=='t' || desc.charAt(0)=='l' ||desc.charAt(0)=='b' ||desc.charAt(0)=='r' ||desc.charAt(0)=='c'){

           if(desc.charAt(1)=='t' || desc.charAt(1)=='b'){
             //para oleary
             var option = $('select[name=option]').val();
             if(option=='2'){
               var cont=0;
               $(this).parent().children().each(function(index, el) {
                   console.log(index);
                   cont++;
               });
               console.log('contador: '+cont);
               if(cont>=4){
                 if(cont==4){
                   $(this).parent().append('<i style="color:black;" class="fa fa-times fa-3x fa-fw cursor fabians"></i>');
                   $(this).parent().children("i").css({
                       "position": "absolute",
                       "top": "24%",
                       "left": "18.58ex"
                   });
                   oly[desc]='gra';
                 }else{
                   $(this).parent().children("svg").remove();
                   oly[desc]='';
                   var com1=desc.charAt(0)+desc.charAt(1)+desc.charAt(2)+'t'+desc.charAt(4);
                   var com2=desc.charAt(0)+desc.charAt(1)+desc.charAt(2)+'l'+desc.charAt(4);
                   var com3=desc.charAt(0)+desc.charAt(1)+desc.charAt(2)+'r'+desc.charAt(4);
                   var com4=desc.charAt(0)+desc.charAt(1)+desc.charAt(2)+'b'+desc.charAt(4);
                   if(oly[com1]=='gra')
                     oly[com1]='';
                   if(oly[com2]=='gra')
                     oly[com2]='';
                   if(oly[com3]=='gra')
                     oly[com3]='';
                   if(oly[com4]=='gra')
                     oly[com4]='';
                 }

               }
             }else {
               var color=$(this).attr('fill');
               if(color=='white'){
                 $(this).attr('fill','red');
                 if(oly[desc]!='gra')
                   oly[desc]='red';
               }else{
                 $(this).attr('fill','white');
                 if(oly[desc]!='gra')
                   oly[desc]='';
               }

             }

             result();
             encriptoleary();
             //para oleary
           }

         }

         return false;

     });
});






</script>

<script type="text/javascript">

$('#add').click(function() {
  $('#information').clone().find("input:text").val("").end().append('<button type="button" class="btn btn-danger btn-sm m-3 remove" name=""> - Eliminar</button>').removeAttr('id').insertBefore('#add');

});

$('#addurgencias').click(function() {
  $('#informationurgencias').clone().find(".divadd").append('<input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divadd2").append('<input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divremove").remove().end().find("input:text").val("").end().find("input:hidden").val("").end().append('<button type="button" class="btn btn-danger btn-sm mx-3 remove" name=""> - Eliminar</button>').removeAttr('id').insertBefore('#addurgencias');

});

$('#addinactivacion').click(function() {
  $('#informationinactivation').clone().find(".divadd").append('<input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divadd2").append('<input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divremove").remove().end().find("input:text").val("").end().find("input:hidden").val("").end().append('<button type="button" class="btn btn-danger btn-sm mx-3 remove" name=""> - Eliminar</button>').removeAttr('id').insertBefore('#addinactivacion');

});

$('#addquimico').click(function() {
  $('#informationquimic').clone().find(".divadd").append('<input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divadd2").append('<input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divremove").remove().end().find("input:text").val("").end().find("input:hidden").val("").end().append('<button type="button" class="btn btn-danger btn-sm mx-3 remove" name=""> - Eliminar</button>').removeAttr('id').insertBefore('#addquimico');

});

$('#addmorfologico').click(function() {
  $('#informationmorfologic').clone().find(".divadd").append('<input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divadd2").append('<input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divremove").remove().end().find("input:text").val("").end().find("input:hidden").val("").end().append('<button type="button" class="btn btn-danger btn-sm mx-3 remove" name=""> - Eliminar</button>').removeAttr('id').insertBefore('#addmorfologico');

});

$('#addestructural').click(function() {
  $('#informationestruct').clone().find(".divadd").append('<input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divadd2").append('<input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divremove").remove().end().find("input:text").val("").end().find("input:hidden").val("").end().append('<button type="button" class="btn btn-danger btn-sm mx-3 remove" name=""> - Eliminar</button>').removeAttr('id').insertBefore('#addestructural');

});
$('#addcirugia').click(function() {
  $('#informationsurgery').clone().find(".divadd").append('<input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divadd2").append('<input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\"> <div><label class=\"form-check-label\">Solicitar</label></div>').end().find(".divremove").remove().end().find("input:text").val("").end().find("input:hidden").val("").end().append('<button type="button" class="btn btn-danger btn-sm mx-3 remove" name=""> - Eliminar</button>').removeAttr('id').insertBefore('#addcirugia');

});
var num=Number('<?php echo $keymodals; ?>');
$('#addpulpar').click(function() {

  $('#informationpulpar').clone().find('.pulpar').attr('idf', num).end().find('.divchangeremove').remove().end().find('.divchangeadd').append('<a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionpulpar'+num+'\">Ver Sessiones</a>').end().find(".divremove").remove().end().find("input:text").val("").end().find("input:hidden").val("").end().append('<button type="button" class="btn btn-danger btn-sm mx-3 removepulpar" name="sessionpulpar'+num+'"> - Eliminar</button>').removeAttr('id').insertBefore('#addpulpar');

  var modalnew='<div class="modal fade" role="dialog" id="sessionpulpar'+num+'">'+
  '<div class="modal-dialog">'+
  '  <div class="modal-content">'+
  '    <div class="modal-header">'+
  '      <h3 class="modal-title">Sessiones</h3>'+
  '      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>'+
  '    </div>'+
  '    <div class="modal-body">'+
  '      <div class="from-group border border-primary rounded">'+
  '        <div class="container">'+
  '          <hr>'+
  '          <div class="row">'+
  '            <div class="col-3 border pl-4 py-3">'+

  '<input class="form-check-input sessionpulpar'+num+'" name="sessionpulpar'+num+'[]" type="checkbox"><div><label class="form-check-label">Solicitar</label></div>'+
              '</div>'+

              '<div class="col-3 border pl-4 py-3">'+

  '<input class="form-check-input sessionpulpar'+num+'" name="sessionpulpar'+num+'[]" type="checkbox"><div><label class="form-check-label">Solicitar</label></div>'+
              '</div>'+
              '<div class="col-3 border pl-4 py-3">'+

  '<input class="form-check-input sessionpulpar'+num+'" name="sessionpulpar'+num+'[]" type="checkbox"><div><label class="form-check-label">Solicitar</label></div>'+
              '</div>'+
              '<div class="col-3 border pl-4 py-3">'+

  '<input class="form-check-input sessionpulpar'+num+'" name="sessionpulpar'+num+'[]" type="checkbox"><div><label class="form-check-label">Solicitar</label></div>'+
              '</div>'+
            '</div>'+
            '<hr>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '    <div class="modal-footer">'+
    '      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>';
    var is='<?php if(isset($isbutton)&&$isbutton=='true'){echo 'true';}else{echo 'false';} ?>';
    if(is=='true'){
      modalnew+='<button type="submit" class="btn btn-success" id="controlsession_button" data-dismiss="modal" name="controlsession_button">Enviar</button>';
    }

        modalnew+='</div>'+
  '    </div>'+
  '  </div>'+
  '</div>';


$('#addmodalid').append(modalnew);//.insertBefore('#addmodalid');


  num++;
});
var numr=Number('<?php echo $keymodalsreh; ?>');
$('#addrehabilitation').click(function() {

  $('#informationrehabilitation').clone().find('.rehabilitation').attr('idf', numr).end().find('.divchangeremove').remove().end().find('.divchangeadd').append('<a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionrehabilitation'+numr+'\">Ver Sessiones</a>').end().find(".divremove").remove().end().find("input:text").val("").end().find("input:hidden").val("").end().append('<button type="button" class="btn btn-danger btn-sm mx-3 removerehabilitation" name="sessionrehabilitation'+numr+'"> - Eliminar</button>').removeAttr('id').insertBefore('#addrehabilitation');

  var modalnew='<div class="modal fade" role="dialog" id="sessionrehabilitation'+numr+'">'+
  '<div class="modal-dialog">'+
  '  <div class="modal-content">'+
  '    <div class="modal-header">'+
  '      <h3 class="modal-title">Sessiones</h3>'+
  '      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>'+
  '    </div>'+
  '    <div class="modal-body">'+
  '      <div class="from-group border border-primary rounded">'+
  '        <div class="container">'+
  '          <hr>'+
  '          <div class="row">'+
  '            <div class="col-3 border pl-4 py-3">'+

  '<input class="form-check-input sessionrehabilitation'+numr+'" name="sessionrehabilitation'+numr+'[]" type="checkbox"><div><label class="form-check-label">Solicitar</label></div>'+
              '</div>'+

              '<div class="col-3 border pl-4 py-3">'+

  '<input class="form-check-input sessionrehabilitation'+numr+'" name="sessionrehabilitation'+numr+'[]" type="checkbox"><div><label class="form-check-label">Solicitar</label></div>'+
              '</div>'+
              '<div class="col-3 border pl-4 py-3">'+

  '<input class="form-check-input sessionrehabilitation'+numr+'" name="sessionrehabilitation'+numr+'[]" type="checkbox"><div><label class="form-check-label">Solicitar</label></div>'+
              '</div>'+
              '<div class="col-3 border pl-4 py-3">'+

  '<input class="form-check-input sessionrehabilitation'+numr+'" name="sessionrehabilitation'+numr+'[]" type="checkbox"><div><label class="form-check-label">Solicitar</label></div>'+
              '</div>'+
            '</div>'+
            '<hr>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '    <div class="modal-footer">'+
    '      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>';
    var is='<?php if(isset($isbutton)&&$isbutton=='true'){echo 'true';}else{echo 'false';} ?>';
    if(is=='true'){
      modalnew+='<button type="submit" class="btn btn-success" id="controlsessionreh_button" data-dismiss="modal" name="controlsessionreh_button">Enviar</button>';
    }

        modalnew+='</div>'+
  '    </div>'+
  '  </div>'+
  '</div>';


$('#addmodalidreh').append(modalnew);//.insertBefore('#addmodalid');


  numr++;
});



$('body').on('click', '.remove', function() {

  $(this).parent('div').remove();

})
$('body').on('click', '.removepulpar', function() {

  $('#'+$(this).attr('name')).remove();
  $(this).parent('div').remove();

})
$('body').on('click', '.removerehabilitation', function() {

  $('#'+$(this).attr('name')).remove();
  $(this).parent('div').remove();

})

</script>
