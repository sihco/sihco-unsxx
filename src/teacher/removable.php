<?php
require('header.php');

if(isset($_POST["designed"]) && isset($_POST["clinical"]) && $_POST["designed"]!="" && $_POST["clinical"]!=""){
  DBDesignedTeacher($_SESSION["usertable"]["usernumber"], $_POST['designed'], $_POST["clinical"]);
}

if(isset($_POST['desc']) && isset($_POST['evaluated']) &&
  isset($_POST['status']) && isset($_POST['id'])){
    if($_POST['status']=='--'){
        MSGError('Debe Seleccionar Status');
        ForceLoad('removable.php?id='.$_POST['id']);
    }
    $accepted='f';
    if($_POST['status']=='end')
      $accepted='t';
    if($accepted=='t'&&$_POST['evaluated']=='f'){
      MSGError('Debe seleccionar en Si la fila Revisado');
      ForceLoad('removable.php?id='.$_POST['id']);
    }

  DBEvaluateRemovable($_POST['desc'], $_POST['evaluated'], $accepted, $_POST['status'], $_POST['id']);
  MSGError('Se guardó la revisión');
}
if(isset($_GET['id']) && $_GET['id']!=""){
  //echo "sadf";
  $f=DBRemovableInfo2($_GET['id']);
  $pat=DBRemovableInfo($_GET['id']);
  $ob=DBAllObservationInfo($f['remission'],$_GET['id']);
}else{
  ForceLoad('index.php');
}

?>

            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-4">

                        <br>
                        <div class="border border-primary">
                          <form class="" action="removable.php" method="post">
                            <input type="hidden" name="id" id="ficha" value="<?php if(isset($f['ficha'])) echo $f['ficha']; ?>">
                          <div class="row">
                            <span align="center"><u><h5>EVALUACION</h5></u></span>
                          </div>
                          <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                              <table class="table table-bordered table-hover">

                                <tbody>
                                  <tr>
                                    <th scope="row">Estudiante</th>
                                    <td><?php if(isset($f['student'])) echo $f['student']; ?></td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Especilidad</th>
                                    <td><?php if(isset($f['clinicalname'])) echo $f['clinicalname']; ?></td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Visualizar Ficha</th>
                                    <td>
                                      <?php
                                      echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('reportremovable.php?id=".$f['ficha']."#toolbar=0', ".
                                  		"'Visualizar Ficha','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
                                  		"resizable=yes')\">Ver</a><br />\n";
                                      ?>
                                    </td>
                                  </tr>
                                  <?php
                                  echo "<tr>";
                                  echo "<th scope=\"row\">Ficha clínica concluida</th>";
                                  echo "<td>";
                                  if ($pat["removableinputfile"] != null) {
                        			          $tx = $pat["removableinputfilehash"];
                        			      	  echo "  <a href=\"../filedownload.php?" . filedownload($pat["removableinputfile"] ,$pat["removableinputfilename"]) ."\">" .
                        			  		          $pat["removableinputfilename"] . "</a> <a href=\"#\" class=\"btn btn-primary btn-sm\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".filedownload($pat["removableinputfile"], $pat["removableinputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\">Ver Ficha Clínica</a>" .
                        			  		         //"<img title=\"hash: $tx\" alt=\"$tx\" width=\"25\" src=\"../images/bigballoontransp-hash.png\" />" .
                        			                 "\n";
                        			     }
                        			     else{
                                     echo "  <span class=\"text-warning\"><b>Aun no subió el documento culminado</b></span>\n";
                                   }
                                   echo "</td>";
                        			     echo "<tr>\n";
                                  ?>
                                  <tr>
                                    <th scope="row">Fecha</th>
                                    <td><?php if(isset($f['time'])) echo dateconv($f['time']); ?></td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Docente Designado</th>
                                    <td><?php if(isset($f['teacher'])) echo DBUserInfo($f['teacher'])['userfullname'];?></td>

                                  </tr>
                                  <tr>
                                    <th scope="row">Revisado</th>
                                    <td>

                                      <select name="evaluated" class="form-select" aria-label="Default select example">

                                        <option <?php if(!isset($f) || $f["evaluated"] == '--') echo "selected"; ?> value="--">--</option>
                                        <option <?php if(isset($f) && $f["evaluated"] == 'f') echo "selected"; ?> value="f">No</option>
                                        <option <?php if(isset($f) && $f["evaluated"] == 't') echo "selected"; ?> value="t">Si</option>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th scope="row">Estado de Ficha</th>
                                    <td>
                                      <select name="status" class="form-select" aria-label="Default select example">
                                        <option <?php if(!isset($f) || $f["status"] == '--') echo "selected"; ?> value="--">--</option>
                                        <option <?php if(isset($f) && $f["status"] == 'process') echo "selected"; ?> value="process">En Proceso</option>
                                        <option <?php if(isset($f) && $f["status"] == 'canceled') echo "selected"; ?> value="canceled">Anulado</option>
                                        <option <?php if(isset($f) && $f["status"] == 'fail') echo "selected"; ?> value="fail">Abandonado</option>
                                        <option <?php if(isset($f) && $f["status"] == 'end') echo "selected"; ?> value="end">Finalizado</option>
                                      </select>
                                    </td>
                                  </tr>

                                </tbody>
                              </table>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                              <label for="desc"><u><b>Observaciones</b></u></label>
                              <textarea name="desc" class="form-control" id="desc" class="form-control" rows="8" ><?php if(isset($f['description'])) echo $f['description'];?></textarea>
                            </div>
                          </div>
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                            Tabla de Procedimiento
                          </button>
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tratamiento">
                            Plan de tratamiento
                          </button>
                          <div class="row">
                            <div align="center">
                              <input type="submit" name="" class="btn btn-primary col-4" value="Enviar">
                            </div>
                          </div>
                          <br>
                          </form>
                        </div>
                        <!--INICIO DE MODAL TRATAMIENTO-->
                        <!-- Inicio modal-->
                        <div class="modal fade" id="tratamiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Plan de Tratamiento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-7">
                                    <?php
                                    $srcgram='../images/protesis_nueva.png';
                                    if(isset($pat['removableodontogram'])&& $pat['removableodontogram']!=''){
                                      $srcgram=$pat['removableodontogram'];
                                    }
                                    echo "<img src=\"".$srcgram."\" alt=\"\">";
                                    ?>
                                  </div>
                                  <div class="col-5">
                                    <div class="row">
                                      <div class="col-12">
                                        <span>ESPECIFICACIONES DEL PLAN</span>
                                      </div>
                                      <div class="col-12">
                                        <span>1. APOYOS</span><br>
                                        <?php
                                        if(isset($pat['apoyos'])&&$pat['apoyos']){
                                          echo $pat['apoyos'];
                                        }else{
                                          echo "<br>";
                                        }
                                        ?>
                                      </div>
                                      <div class="col-12">
                                        <span>2. RETENCIÓN</span><br>
                                        <?php
                                        if(isset($pat['retencion'])&&$pat['retencion']){
                                          echo $pat['retencion'];
                                        }else{
                                          echo "<br>";
                                        }
                                        ?>

                                      </div>
                                      <div class="col-12">
                                        <span>3. RECIPROCIDAD</span><br>
                                        <?php
                                        if(isset($pat['reciprocidad'])&&$pat['reciprocidad']){
                                          echo $pat['reciprocidad'];
                                        }else{
                                          echo "<br>";
                                        }
                                        ?>
                                      </div>
                                      <div class="col-12">
                                        <span>4. CONECTOR MAYOR</span><br>
                                        <?php
                                        if(isset($pat['conector'])&&$pat['conector']){
                                          echo $pat['conector'];
                                        }else{
                                          echo "<br>";
                                        }
                                        ?>
                                      </div>
                                      <div class="col-12">
                                        <span>5. RETENCIÓN INDIRECTA</span><br>
                                        <?php
                                        if(isset($pat['indirecta'])&&$pat['indirecta']){
                                          echo $pat['indirecta'];
                                        }else{
                                          echo "<br>";
                                        }
                                        ?>
                                      </div>

                                      <div class="col-12">
                                        <span>6. PLANOS GUÍA</span><br>
                                        <?php
                                        if(isset($pat['planos'])&&$pat['planos']){
                                          echo $pat['planos'];
                                        }else{
                                          echo "<br>";
                                        }
                                        ?>
                                      </div>
                                      <div class="col-12">
                                        <span>7. RETENCIÓN PARA LA BASE</span><br>
                                        <?php
                                        if(isset($pat['base'])&&$pat['base']){
                                          echo $pat['base'];
                                        }else{
                                          echo "<br>";
                                        }
                                        ?>
                                      </div>
                                      <div class="col-12">
                                        <span>8. ÁREAS DE MODIFICAR O CONTORNEAR</span><br>
                                        <?php
                                        if(isset($pat['contornear'])&&$pat['contornear']){
                                          echo $pat['contornear'];
                                        }else{
                                          echo "<br>";
                                        }
                                        ?>
                                      </div>
                                    </div>

                                  </div>
                                  <div class="row">
                                    <div class="col-6">
                                      <div class="form-check form-check-inline border py-2 pr-2">
                                        <?php
                                        if ((!isset($pat['protesis']))||(isset($pat['protesis'])&&($pat['protesis']=='false'||$pat['protesis']==''))) {
                                          echo "<span class=\"text-primary\" id=\"protesis\"></span>";
                                        }elseif (isset($pat['protesis'])&&$pat['protesis']=='true') {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"protesis\" value=\"option1\">".
                                          "<label class=\"form-check-label\" for=\"protesis\">Firmar</label>";
                                        }elseif (isset($pat['protesis'])&&is_numeric($pat['protesis'])) {
                                          echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"protesis\" value=\"option1\" checked>".
                                          "<label class=\"form-check-label\" for=\"protesis\">Firmar</label>";
                                        }else{
                                          echo "<span class=\"text-primary\" id=\"protesis\"></span>";
                                        }
                                        ?>
                                        <br><span>Aprobación para la prótesis</span>
                                      </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                      <label for="protesisfecha"><b>Fecha:</b></label>
                                      <?php
                                      if ((isset($pat['protesis'])&&($pat['protesis']!='false'||$pat['protesis']!=''))) {
                                      ?>
                                      <input type="date" id="protesisfecha" class="form-control d-inline" style="width:50%;"  name="protesisfecha" value="<?php if(isset($pat["protesisfecha"])) echo $pat["protesisfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                    <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success" id="btn_tratamiento">Guardar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--modal de datos fin-->
                        <!--FIN DE MODAL TRATAMIENTO-->


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
                                    <br>
                                    <span><?php if(isset($pat["valortrabajo"])) echo $pat["valortrabajo"];  ?></span>
                                  </div>
                                  <div class="col-9">
                                    <label for="">Trabajos:</label>
                                    <br>
                                    <span><?php if(isset($pat["trabajo"])) echo $pat["trabajo"];  ?></span>

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
                                            echo "<span class=\"text-primary\" id=\"remopro1\"></span>";
                                          }elseif (isset($pat['remopro1'])&&$pat['remopro1']=='true') {
                                            echo "<select name=\"remopro1\" id=\"remopro1\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro1'])&&isset($pat['tearemopro1'])&&is_numeric($pat['tearemopro1'])) {
                                            $sel=$pat['selremopro1'];
                                            echo "<select name=\"remopro1\" id=\"remopro1\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro1\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro2']))||(isset($pat['remopro2'])&&($pat['remopro2']=='false'||$pat['remopro2']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro2\"></span>";
                                          }elseif (isset($pat['remopro2'])&&$pat['remopro2']=='true') {
                                            echo "<select name=\"remopro2\" id=\"remopro2\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro2'])&&isset($pat['tearemopro2'])&&is_numeric($pat['tearemopro2'])) {
                                            $sel=$pat['selremopro2'];
                                            echo "<select name=\"remopro2\" id=\"remopro2\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro2\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                    </tr>

                                    <tr>
                                      <td>Cubetas individuales</td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro3']))||(isset($pat['remopro3'])&&($pat['remopro3']=='false'||$pat['remopro3']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro3\"></span>";
                                          }elseif (isset($pat['remopro3'])&&$pat['remopro3']=='true') {
                                            echo "<select name=\"remopro3\" id=\"remopro3\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro3'])&&isset($pat['tearemopro3'])&&is_numeric($pat['tearemopro3'])) {
                                            $sel=$pat['selremopro3'];
                                            echo "<select name=\"remopro3\" id=\"remopro3\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro3\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro4']))||(isset($pat['remopro4'])&&($pat['remopro4']=='false'||$pat['remopro4']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro4\"></span>";
                                          }elseif (isset($pat['remopro4'])&&$pat['remopro4']=='true') {
                                            echo "<select name=\"remopro4\" id=\"remopro4\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro4'])&&isset($pat['tearemopro4'])&&is_numeric($pat['tearemopro4'])) {
                                            $sel=$pat['selremopro4'];
                                            echo "<select name=\"remopro4\" id=\"remopro4\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro4\"></span>";
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
                                            echo "<span class=\"text-primary\" id=\"remopro5\"></span>";
                                          }elseif (isset($pat['remopro5'])&&$pat['remopro5']=='true') {
                                            echo "<select name=\"remopro5\" id=\"remopro5\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro5'])&&isset($pat['tearemopro5'])&&is_numeric($pat['tearemopro5'])) {
                                            $sel=$pat['selremopro5'];
                                            echo "<select name=\"remopro5\" id=\"remopro5\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro5\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro6']))||(isset($pat['remopro6'])&&($pat['remopro6']=='false'||$pat['remopro6']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro6\"></span>";
                                          }elseif (isset($pat['remopro6'])&&$pat['remopro6']=='true') {
                                            echo "<select name=\"remopro6\" id=\"remopro6\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro6'])&&isset($pat['tearemopro6'])&&is_numeric($pat['tearemopro6'])) {
                                            $sel=$pat['selremopro6'];
                                            echo "<select name=\"remopro6\" id=\"remopro6\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro6\"></span>";
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
                                            echo "<span class=\"text-primary\" id=\"remopro7\"></span>";
                                          }elseif (isset($pat['remopro7'])&&$pat['remopro7']=='true') {
                                            echo "<select name=\"remopro7\" id=\"remopro7\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro7'])&&isset($pat['tearemopro7'])&&is_numeric($pat['tearemopro7'])) {
                                            $sel=$pat['selremopro7'];
                                            echo "<select name=\"remopro7\" id=\"remopro7\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro7\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro8']))||(isset($pat['remopro8'])&&($pat['remopro8']=='false'||$pat['remopro8']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro8\"></span>";
                                          }elseif (isset($pat['remopro8'])&&$pat['remopro8']=='true') {
                                            echo "<select name=\"remopro8\" id=\"remopro8\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro8'])&&isset($pat['tearemopro8'])&&is_numeric($pat['tearemopro8'])) {
                                            $sel=$pat['selremopro8'];
                                            echo "<select name=\"remopro8\" id=\"remopro8\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro8\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                    </tr>

                                    <tr>
                                      <td>Modelos de trabajo</td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro9']))||(isset($pat['remopro9'])&&($pat['remopro9']=='false'||$pat['remopro9']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro9\"></span>";
                                          }elseif (isset($pat['remopro9'])&&$pat['remopro9']=='true') {
                                            echo "<select name=\"remopro9\" id=\"remopro9\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro9'])&&isset($pat['tearemopro9'])&&is_numeric($pat['tearemopro9'])) {
                                            $sel=$pat['selremopro9'];
                                            echo "<select name=\"remopro9\" id=\"remopro9\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro9\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro10']))||(isset($pat['remopro10'])&&($pat['remopro10']=='false'||$pat['remopro10']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro10\"></span>";
                                          }elseif (isset($pat['remopro10'])&&$pat['remopro10']=='true') {
                                            echo "<select name=\"remopro10\" id=\"remopro10\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro10'])&&isset($pat['tearemopro10'])&&is_numeric($pat['tearemopro10'])) {
                                            $sel=$pat['selremopro10'];
                                            echo "<select name=\"remopro10\" id=\"remopro10\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro10\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                    </tr>

                                    <tr>
                                      <td>Placas de articulación</td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro11']))||(isset($pat['remopro11'])&&($pat['remopro11']=='false'||$pat['remopro11']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro11\"></span>";
                                          }elseif (isset($pat['remopro11'])&&$pat['remopro11']=='true') {
                                            echo "<select name=\"remopro11\" id=\"remopro11\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro11'])&&isset($pat['tearemopro11'])&&is_numeric($pat['tearemopro11'])) {
                                            $sel=$pat['selremopro11'];
                                            echo "<select name=\"remopro11\" id=\"remopro11\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro11\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro12']))||(isset($pat['remopro12'])&&($pat['remopro12']=='false'||$pat['remopro12']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro12\"></span>";
                                          }elseif (isset($pat['remopro12'])&&$pat['remopro12']=='true') {
                                            echo "<select name=\"remopro12\" id=\"remopro12\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro12'])&&isset($pat['tearemopro12'])&&is_numeric($pat['tearemopro12'])) {
                                            $sel=$pat['selremopro12'];
                                            echo "<select name=\"remopro12\" id=\"remopro12\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro12\"></span>";
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
                                            echo "<span class=\"text-primary\" id=\"remopro13\"></span>";
                                          }elseif (isset($pat['remopro13'])&&$pat['remopro13']=='true') {
                                            echo "<select name=\"remopro13\" id=\"remopro13\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro13'])&&isset($pat['tearemopro13'])&&is_numeric($pat['tearemopro13'])) {
                                            $sel=$pat['selremopro13'];
                                            echo "<select name=\"remopro13\" id=\"remopro13\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro13\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro14']))||(isset($pat['remopro14'])&&($pat['remopro14']=='false'||$pat['remopro14']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro14\"></span>";
                                          }elseif (isset($pat['remopro14'])&&$pat['remopro14']=='true') {
                                            echo "<select name=\"remopro14\" id=\"remopro14\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro14'])&&isset($pat['tearemopro14'])&&is_numeric($pat['tearemopro14'])) {
                                            $sel=$pat['selremopro14'];
                                            echo "<select name=\"remopro14\" id=\"remopro14\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro14\"></span>";
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
                                            echo "<span class=\"text-primary\" id=\"remopro15\"></span>";
                                          }elseif (isset($pat['remopro15'])&&$pat['remopro15']=='true') {
                                            echo "<select name=\"remopro15\" id=\"remopro15\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro15'])&&isset($pat['tearemopro15'])&&is_numeric($pat['tearemopro15'])) {
                                            $sel=$pat['selremopro15'];
                                            echo "<select name=\"remopro15\" id=\"remopro15\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro15\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro16']))||(isset($pat['remopro16'])&&($pat['remopro16']=='false'||$pat['remopro16']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro16\"></span>";
                                          }elseif (isset($pat['remopro16'])&&$pat['remopro16']=='true') {
                                            echo "<select name=\"remopro16\" id=\"remopro16\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro16'])&&isset($pat['tearemopro16'])&&is_numeric($pat['tearemopro16'])) {
                                            $sel=$pat['selremopro16'];
                                            echo "<select name=\"remopro16\" id=\"remopro16\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro16\"></span>";
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
                                            echo "<span class=\"text-primary\" id=\"remopro17\"></span>";
                                          }elseif (isset($pat['remopro17'])&&$pat['remopro17']=='true') {
                                            echo "<select name=\"remopro17\" id=\"remopro17\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro17'])&&isset($pat['tearemopro17'])&&is_numeric($pat['tearemopro17'])) {
                                            $sel=$pat['selremopro17'];
                                            echo "<select name=\"remopro17\" id=\"remopro17\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro17\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro18']))||(isset($pat['remopro18'])&&($pat['remopro18']=='false'||$pat['remopro18']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro18\"></span>";
                                          }elseif (isset($pat['remopro18'])&&$pat['remopro18']=='true') {
                                            echo "<select name=\"remopro18\" id=\"remopro18\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro18'])&&isset($pat['tearemopro18'])&&is_numeric($pat['tearemopro18'])) {
                                            $sel=$pat['selremopro18'];
                                            echo "<select name=\"remopro18\" id=\"remopro18\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro18\"></span>";
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
                                            echo "<span class=\"text-primary\" id=\"remopro19\"></span>";
                                          }elseif (isset($pat['remopro19'])&&$pat['remopro19']=='true') {
                                            echo "<select name=\"remopro19\" id=\"remopro19\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro19'])&&isset($pat['tearemopro19'])&&is_numeric($pat['tearemopro19'])) {
                                            $sel=$pat['selremopro19'];
                                            echo "<select name=\"remopro19\" id=\"remopro19\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro19\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro20']))||(isset($pat['remopro20'])&&($pat['remopro20']=='false'||$pat['remopro20']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro20\"></span>";
                                          }elseif (isset($pat['remopro20'])&&$pat['remopro20']=='true') {
                                            echo "<select name=\"remopro20\" id=\"remopro20\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro20'])&&isset($pat['tearemopro20'])&&is_numeric($pat['tearemopro20'])) {
                                            $sel=$pat['selremopro20'];
                                            echo "<select name=\"remopro20\" id=\"remopro20\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro20\"></span>";
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
                                            echo "<span class=\"text-primary\" id=\"remopro21\"></span>";
                                          }elseif (isset($pat['remopro21'])&&$pat['remopro21']=='true') {
                                            echo "<select name=\"remopro21\" id=\"remopro21\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro21'])&&isset($pat['tearemopro21'])&&is_numeric($pat['tearemopro21'])) {
                                            $sel=$pat['selremopro21'];
                                            echo "<select name=\"remopro21\" id=\"remopro21\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro21\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro22']))||(isset($pat['remopro22'])&&($pat['remopro22']=='false'||$pat['remopro22']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro22\"></span>";
                                          }elseif (isset($pat['remopro22'])&&$pat['remopro22']=='true') {
                                            echo "<select name=\"remopro22\" id=\"remopro22\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro22'])&&isset($pat['tearemopro22'])&&is_numeric($pat['tearemopro22'])) {
                                            $sel=$pat['selremopro22'];
                                            echo "<select name=\"remopro22\" id=\"remopro22\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro22\"></span>";
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
                                            echo "<span class=\"text-primary\" id=\"remopro23\"></span>";
                                          }elseif (isset($pat['remopro23'])&&$pat['remopro23']=='true') {
                                            echo "<select name=\"remopro23\" id=\"remopro23\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro23'])&&isset($pat['tearemopro23'])&&is_numeric($pat['tearemopro23'])) {
                                            $sel=$pat['selremopro23'];
                                            echo "<select name=\"remopro23\" id=\"remopro23\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro23\"></span>";
                                          }
                                          ?>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="form-check form-check-inline border py-2 pr-2">
                                          <?php
                                          if ((!isset($pat['remopro24']))||(isset($pat['remopro24'])&&($pat['remopro24']=='false'||$pat['remopro24']==''))) {
                                            echo "<span class=\"text-primary\" id=\"remopro24\"></span>";
                                          }elseif (isset($pat['remopro24'])&&$pat['remopro24']=='true') {
                                            echo "<select name=\"remopro24\" id=\"remopro24\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option selected value=\"\">--</option>".
                                                "<option value=\"a\">A</option>".
                                                "<option value=\"b\">B</option>".
                                                "<option value=\"c\">C</option>".
                                                "<option value=\"d\">D</option>".
                                            "</select>";
                                          }elseif (isset($pat['selremopro24'])&&isset($pat['tearemopro24'])&&is_numeric($pat['tearemopro24'])) {
                                            $sel=$pat['selremopro24'];
                                            echo "<select name=\"remopro24\" id=\"remopro24\" class=\"form-select\" aria-label=\"Default select example\">".
                                                "<option ".($sel==''?'selected':'')." value=\"\">--</option>".
                                                "<option ".($sel=='a'?'selected':'')." value=\"a\">A</option>".
                                                "<option ".($sel=='b'?'selected':'')." value=\"b\">B</option>".
                                                "<option ".($sel=='c'?'selected':'')." value=\"c\">C</option>".
                                                "<option ".($sel=='d'?'selected':'')." value=\"d\">D</option>".
                                            "</select>";

                                          }else{
                                            echo "<span class=\"text-primary\" id=\"remopro24\"></span>";
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
                                    <label for="">Observaciones</label>
                                    <input type="text" class="form-control" name="obstrabajo" id="obstrabajo" value="<?php if(isset($pat["obstrabajo"])) echo $pat["obstrabajo"];  ?>">
                                  </div>
                                  <div class="col-6">
                                    <label for="">Nota final:</label>
                                    <input type="text" class="form-control" name="notatrabajo" id="notatrabajo" value="<?php if(isset($pat["notatrabajo"])) echo $pat["notatrabajo"];  ?>">
                                  </div>
                                  <div class="col-6">
                                    <div class="form-check form-check-inline border py-2 pr-2">
                                      <?php
                                      if ((!isset($pat['firmtrabajo']))||(isset($pat['firmtrabajo'])&&($pat['firmtrabajo']=='false'||$pat['firmtrabajo']==''))) {
                                        echo "<span class=\"text-primary\" id=\"firmtrabajo\"></span>";
                                      }elseif (isset($pat['firmtrabajo'])&&$pat['firmtrabajo']=='true') {
                                        echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"firmtrabajo\" value=\"option1\">".
                                        "<label class=\"form-check-label\" for=\"firmtrabajo\">Firmar</label>";
                                      }elseif (isset($pat['firmtrabajo'])&&is_numeric($pat['firmtrabajo'])) {
                                        echo "<input class=\"form-check-input ml-1\" type=\"checkbox\" id=\"firmtrabajo\" value=\"option1\" checked>".
                                        "<label class=\"form-check-label\" for=\"firmtrabajo\">Firmar</label>";
                                      }else{
                                        echo "<span class=\"text-primary\" id=\"firmtrabajo\"></span>";
                                      }
                                      ?>
                                      <br><span>Firma del Docente</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success" id="btn_procedimiento">Guardar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--modal de datos fin-->

                        <br>
                        <div class="border border-success">
                          <div class="row container">
                            <span align="center"><u><h5>OBSERVACIONES REALIZADAS</h5></u></span>
                            <?php
                            $size=count($ob);
                            for ($i=0; $i <$size ; $i++) {
                              if($ob[$i]['evaluated']=='t'){
                                echo "<div class=\"alert alert-success\" role=\"alert\">".
                                  "<h4 class=\"alert-heading\">Observacion ".($size-$i)."</h4>".
                                  "<p>".$ob[$i]["description"]."</p>".
                                  "<hr>".
                                  "<p class=\"mb-0\">Fecha de observacion: ".dateconv($ob[$i]["time"])."</p>".
                                  "</div>";
                              }

                            }
                            ?>

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

    </body>
</html>
<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>
<script>

$(document).ready(function(){
    //registrar documentos
    $('#btn_procedimiento').click(function(){
      var ficha=$('#ficha').val();

      var remopro1 = $('select[name=remopro1]').val();
      var remopro2 = $('select[name=remopro2]').val();
      var remopro3 = $('select[name=remopro3]').val();
      var remopro4 = $('select[name=remopro4]').val();
      var remopro5 = $('select[name=remopro5]').val();
      var remopro6 = $('select[name=remopro6]').val();
      var remopro7 = $('select[name=remopro7]').val();
      var remopro8 = $('select[name=remopro8]').val();
      var remopro9 = $('select[name=remopro9]').val();
      var remopro10 = $('select[name=remopro10]').val();
      var remopro11 = $('select[name=remopro11]').val();
      var remopro12 = $('select[name=remopro12]').val();
      var remopro13 = $('select[name=remopro13]').val();
      var remopro14 = $('select[name=remopro14]').val();
      var remopro15 = $('select[name=remopro15]').val();
      var remopro16 = $('select[name=remopro16]').val();
      var remopro17 = $('select[name=remopro17]').val();
      var remopro18 = $('select[name=remopro18]').val();
      var remopro19 = $('select[name=remopro19]').val();
      var remopro20 = $('select[name=remopro20]').val();
      var remopro21 = $('select[name=remopro21]').val();
      var remopro22 = $('select[name=remopro22]').val();
      var remopro23 = $('select[name=remopro23]').val();
      var remopro24 = $('select[name=remopro24]').val();

      var obstrabajo=$('#obstrabajo').val();
      var notatrabajo=$('#notatrabajo').val();
      var firmtrabajo = $('#firmtrabajo').prop('checked');

      if(confirm('Guardar los cambios en tabla de procedimientos?')){
        $.ajax({
             url:"../include/i_prosthodontics.php",
             method:"POST",
             data: {ficha:ficha, remopro1:remopro1, remopro2:remopro2,
               remopro3:remopro3, remopro4:remopro4, remopro5:remopro5,
               remopro6:remopro6, remopro7:remopro7, remopro8:remopro8, remopro9:remopro9,
               remopro10:remopro10, remopro11:remopro11, remopro12:remopro12, remopro13:remopro13,
               remopro14:remopro14, remopro15:remopro15, remopro16:remopro16, remopro17:remopro17,
               remopro18:remopro18, remopro19:remopro19, remopro20:remopro20, remopro21:remopro21,
               remopro22:remopro22, remopro23:remopro23, remopro24:remopro24,
               obstrabajo:obstrabajo, notatrabajo:notatrabajo, firmtrabajo:firmtrabajo},
             success:function(data){
               //alert(data);
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
    $('#btn_tratamiento').click(function(){
      var ficha=$('#ficha').val();
      var protesis = $('#protesis').prop('checked');
      var protesisfecha = $('#protesisfecha').val();
      $.ajax({
           url:"../include/i_prosthodontics.php",
           method:"POST",
           data: {ficha:ficha, protesis:protesis, protesisfecha:protesisfecha},
           success:function(data){
             if(data=='yes'){
               alert('Se guardó los cambios');
               $('#tratamiento').hide();///.......
               if ($('.modal-backdrop').is(':visible')) {
                 $('body').removeClass('modal-open');
                 $('.modal-backdrop').remove();
               };
             }else{
                 alert(data);
             }
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



});
</script>
