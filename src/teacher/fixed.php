<?php
require('header.php');

if(isset($_POST["designed"]) && isset($_POST["clinical"]) && $_POST["designed"]!="" && $_POST["clinical"]!=""){
  DBDesignedTeacher($_SESSION["usertable"]["usernumber"], $_POST['designed'], $_POST["clinical"]);
}

if(isset($_POST['desc']) && isset($_POST['evaluated']) &&
  isset($_POST['status']) && isset($_POST['id'])){
    if($_POST['status']=='--'){
        MSGError('Debe Seleccionar Status');
        ForceLoad('fixed.php?id='.$_POST['id']);
    }
    $accepted='f';
    if($_POST['status']=='end')
      $accepted='t';
    if($accepted=='t'&&$_POST['evaluated']=='f'){
      MSGError('Debe seleccionar en Si la fila Revisado');
      ForceLoad('fixed.php?id='.$_POST['id']);
    }

  DBEvaluateFixed($_POST['desc'], $_POST['evaluated'], $accepted, $_POST['status'], $_POST['id']);
  MSGError('Se guardó la revisión');
}
if(isset($_GET['id']) && $_GET['id']!=""){
  //echo "sadf";
  $f=DBFixedInfo2($_GET['id']);
  $pat=DBFixedInfo($_GET['id']);
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
                          <form class="" action="fixed.php" method="post">
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
                                      echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('reportfixed.php?id=".$f['ficha']."#toolbar=0', ".
                                  		"'Visualizar Ficha','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
                                  		"resizable=yes')\">Ver</a><br />\n";
                                      ?>
                                    </td>
                                  </tr>
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
                              <textarea name="desc" class="form-control" id="desc" rows="8" ><?php if(isset($f['description'])) echo $f['description'];?></textarea>
                            </div>
                          </div>
                          <div class="container row">
                            <div class="">
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#procedimiento">Procedimientos</a>
                            </div>

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


                          </div>
                          <div class="row">
                            <div align="center">
                              <input type="submit" name="" class="btn btn-primary col-4" value="Enviar">
                            </div>
                          </div>
                          <br>
                          </form>
                        </div>

                        <!--modal start-->
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
                                <div class="container">
                                  <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Procedimiento</th>
                                        <th scope="col">Vo. Bo. Docente</th>
                                        <th scope="col">Materiales</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <th scope="row">
                                            <input type="date" id="radfecha" class="form-control" style="width:80%;"name="radfecha" value="<?php if(isset($pat["radfecha"])) echo $pat["radfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>Radiografía</td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['radvobo']))||(isset($pat['radvobo'])&&$pat['radvobo']=='')){
                                              $sms.=" <span class=\"radvobo text-success\" name=\"radvobo\" id=\"radvobo\" ></span>";
                                          }else{
                                            if($pat['radvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input radvobo\" name=\"radvobo\" id=\"radvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input radvobo\" name=\"radvobo\" id=\"radvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['radmaterial']))||(isset($pat['radmaterial'])&&$pat['radmaterial']=='')){
                                            $sms.=" <span class=\"radmaterial text-success\" name=\"radmaterial\" id=\"radmaterial\" ></span>";
                                          }else{
                                            if($pat['radmaterial']=='f')
                                              $pat['radmaterial']='';

                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"radmaterial\"  id=\"radmaterial\" value=\"".$pat["radmaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="prefecha" class="form-control" style="width:80%;"name="prefecha" value="<?php if(isset($pat["prefecha"])) echo $pat["prefecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>Preparación Dentaria</td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['prevobo']))||(isset($pat['prevobo'])&&$pat['prevobo']=='')){
                                              $sms.=" <span class=\"prevobo text-success\" name=\"prevobo\" id=\"prevobo\" ></span>";
                                          }else{
                                            if($pat['prevobo']=='t'){
                                              $sms.="   <input class=\"form-check-input prevobo\" name=\"prevobo\" id=\"prevobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input prevobo\" name=\"prevobo\" id=\"prevobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['prematerial']))||(isset($pat['prematerial'])&&$pat['prematerial']=='')){
                                            $sms.=" <span class=\"prematerial text-success\" name=\"prematerial\" id=\"prematerial\" ></span>";
                                          }else{
                                            if($pat['prematerial']=='f')
                                              $pat['prematerial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"prematerial\"  id=\"prematerial\" value=\"".$pat["prematerial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="impfecha" class="form-control" style="width:80%;"name="impfecha" value="<?php if(isset($pat["impfecha"])) echo $pat["impfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>Impresión</td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['impvobo']))||(isset($pat['impvobo'])&&$pat['impvobo']=='')){
                                              $sms.=" <span class=\"impvobo text-success\" name=\"impvobo\" id=\"impvobo\" ></span>";
                                          }else{
                                            if($pat['impvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input impvobo\" name=\"impvobo\" id=\"impvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input impvobo\" name=\"impvobo\" id=\"impvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['impmaterial']))||(isset($pat['impmaterial'])&&$pat['impmaterial']=='')){
                                            $sms.=" <span class=\"impmaterial text-success\" name=\"impmaterial\" id=\"impmaterial\" ></span>";
                                          }else{
                                            if($pat['impmaterial']=='f')
                                              $pat['impmaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"impmaterial\"  id=\"impmaterial\" value=\"".$pat["impmaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="modfecha" class="form-control" style="width:80%;"name="modfecha" value="<?php if(isset($pat["modfecha"])) echo $pat["modfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>Modelo de trabajo y Antagonista</td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['modvobo']))||(isset($pat['modvobo'])&&$pat['modvobo']=='')){
                                              $sms.=" <span class=\"modvobo text-success\" name=\"modvobo\" id=\"modvobo\" ></span>";
                                          }else{
                                            if($pat['modvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input modvobo\" name=\"modvobo\" id=\"modvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input modvobo\" name=\"modvobo\" id=\"modvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['modmaterial']))||(isset($pat['modmaterial'])&&$pat['modmaterial']=='')){
                                            $sms.=" <span class=\"modmaterial text-success\" name=\"modmaterial\" id=\"modmaterial\" ></span>";
                                          }else{
                                            if($pat['modmaterial']=='f')
                                              $pat['modmaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"modmaterial\"  id=\"modmaterial\" value=\"".$pat["modmaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="tomfecha" class="form-control" style="width:80%;"name="tomfecha" value="<?php if(isset($pat["tomfecha"])) echo $pat["tomfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>Toma de mordida</td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['tomvobo']))||(isset($pat['tomvobo'])&&$pat['tomvobo']=='')){
                                              $sms.=" <span class=\"tomvobo text-success\" name=\"tomvobo\" id=\"tomvobo\" ></span>";
                                          }else{
                                            if($pat['tomvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input tomvobo\" name=\"tomvobo\" id=\"tomvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input tomvobo\" name=\"tomvobo\" id=\"tomvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['tommaterial']))||(isset($pat['tommaterial'])&&$pat['tommaterial']=='')){
                                            $sms.=" <span class=\"tommaterial text-success\" name=\"tommaterial\" id=\"tommaterial\" ></span>";
                                          }else{
                                            if($pat['tommaterial']=='f')
                                              $pat['tommaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"tommaterial\"  id=\"tommaterial\" value=\"".$pat["tommaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="monfecha" class="form-control" style="width:80%;"name="monfecha" value="<?php if(isset($pat["monfecha"])) echo $pat["monfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>Montaje de modelo en Oclusor</td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['monvobo']))||(isset($pat['monvobo'])&&$pat['monvobo']=='')){
                                              $sms.=" <span class=\"monvobo text-success\" name=\"monvobo\" id=\"monvobo\" ></span>";
                                          }else{
                                            if($pat['monvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input monvobo\" name=\"monvobo\" id=\"monvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input monvobo\" name=\"monvobo\" id=\"monvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['monmaterial']))||(isset($pat['monmaterial'])&&$pat['monmaterial']=='')){
                                            $sms.=" <span class=\"monmaterial text-success\" name=\"monmaterial\" id=\"monmaterial\" ></span>";
                                          }else{
                                            if($pat['monmaterial']=='f')
                                              $pat['monmaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"monmaterial\"  id=\"monmaterial\" value=\"".$pat["monmaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="corfecha" class="form-control" style="width:80%;"name="corfecha" value="<?php if(isset($pat["corfecha"])) echo $pat["corfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>
                                        <?php
                                        if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                                          echo "Puente provisional";
                                        }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                                          echo "Coronas Provisionales";
                                        }else{
                                          echo "Coronas Provisionales";
                                        }
                                        ?>
                                        </td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['corvobo']))||(isset($pat['corvobo'])&&$pat['corvobo']=='')){
                                              $sms.=" <span class=\"corvobo text-success\" name=\"corvobo\" id=\"corvobo\" ></span>";
                                          }else{
                                            if($pat['corvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input corvobo\" name=\"corvobo\" id=\"corvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input corvobo\" name=\"corvobo\" id=\"corvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['cormaterial']))||(isset($pat['cormaterial'])&&$pat['cormaterial']=='')){
                                            $sms.=" <span class=\"cormaterial text-success\" name=\"cormaterial\" id=\"cormaterial\" ></span>";
                                          }else{
                                            if($pat['cormaterial']=='f')
                                              $pat['cormaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"cormaterial\"  id=\"cormaterial\" value=\"".$pat["cormaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="talfecha" class="form-control" style="width:80%;"name="talfecha" value="<?php if(isset($pat["talfecha"])) echo $pat["talfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>
                                          <?php
                                          if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                                            echo "Tallado patrón de cera";
                                          }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                                            echo "Tallado patrón de corona";
                                          }else{
                                            echo "Tallado patrón de corona";
                                          }
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['talvobo']))||(isset($pat['talvobo'])&&$pat['talvobo']=='')){
                                              $sms.=" <span class=\"talvobo text-success\" name=\"talvobo\" id=\"talvobo\" ></span>";
                                          }else{
                                            if($pat['talvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input talvobo\" name=\"talvobo\" id=\"talvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input talvobo\" name=\"talvobo\" id=\"talvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['talmaterial']))||(isset($pat['talmaterial'])&&$pat['talmaterial']=='')){
                                            $sms.=" <span class=\"talmaterial text-success\" name=\"talmaterial\" id=\"talmaterial\" ></span>";
                                          }else{
                                            if($pat['talmaterial']=='f')
                                              $pat['talmaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"talmaterial\"  id=\"talmaterial\" value=\"".$pat["talmaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="profecha" class="form-control" style="width:80%;"name="profecha" value="<?php if(isset($pat["profecha"])) echo $pat["profecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>
                                          <?php
                                          if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                                            echo "Procesador del puente";
                                          }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                                            echo "Procesado de la corona";
                                          }else{
                                            echo "Procesado de la corona";
                                          }
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['provobo']))||(isset($pat['provobo'])&&$pat['provobo']=='')){
                                              $sms.=" <span class=\"provobo text-success\" name=\"provobo\" id=\"provobo\" ></span>";
                                          }else{
                                            if($pat['provobo']=='t'){
                                              $sms.="   <input class=\"form-check-input provobo\" name=\"provobo\" id=\"provobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input provobo\" name=\"provobo\" id=\"provobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['promaterial']))||(isset($pat['promaterial'])&&$pat['promaterial']=='')){
                                            $sms.=" <span class=\"promaterial text-success\" name=\"promaterial\" id=\"promaterial\" ></span>";
                                          }else{
                                            if($pat['promaterial']=='f')
                                              $pat['promaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"promaterial\"  id=\"promaterial\" value=\"".$pat["promaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="prufecha" class="form-control" style="width:80%;"name="prufecha" value="<?php if(isset($pat["prufecha"])) echo $pat["prufecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>Prueba en boca</td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['pruvobo']))||(isset($pat['pruvobo'])&&$pat['pruvobo']=='')){
                                              $sms.=" <span class=\"pruvobo text-success\" name=\"pruvobo\" id=\"pruvobo\" ></span>";
                                          }else{
                                            if($pat['pruvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input pruvobo\" name=\"pruvobo\" id=\"pruvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input pruvobo\" name=\"pruvobo\" id=\"pruvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['prumaterial']))||(isset($pat['prumaterial'])&&$pat['prumaterial']=='')){
                                            $sms.=" <span class=\"prumaterial text-success\" name=\"prumaterial\" id=\"prumaterial\" ></span>";
                                          }else{
                                            if($pat['prumaterial']=='f')
                                              $pat['prumaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"prumaterial\"  id=\"prumaterial\" value=\"".$pat["prumaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <input type="date" id="cemfecha" class="form-control" style="width:80%;"name="cemfecha" value="<?php if(isset($pat["cemfecha"])) echo $pat["cemfecha"];  ?>" min="2015-01-01" max="2099-01-01">
                                        </th>
                                        <td>
                                          <?php
                                          if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                                            echo "Cementado del puente protético";
                                          }elseif (isset($pat['clinicalid'])&&$pat['clinicalid']==2) {
                                            echo "Cementado de la corona";
                                          }else{
                                            echo "Cementado de la corona";
                                          }
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                          $sms='';
                                          if((!isset($pat['cemvobo']))||(isset($pat['cemvobo'])&&$pat['cemvobo']=='')){
                                              $sms.=" <span class=\"cemvobo text-success\" name=\"cemvobo\" id=\"cemvobo\" ></span>";
                                          }else{
                                            if($pat['cemvobo']=='t'){
                                              $sms.="   <input class=\"form-check-input cemvobo\" name=\"cemvobo\" id=\"cemvobo\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input cemvobo\" name=\"cemvobo\" id=\"cemvobo\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                        <td width="30%">
                                          <?php
                                          $sms='';
                                          if((!isset($pat['cemmaterial']))||(isset($pat['cemmaterial'])&&$pat['cemmaterial']=='')){
                                            $sms.=" <span class=\"cemmaterial text-success\" name=\"cemmaterial\" id=\"cemmaterial\" ></span>";
                                          }else{
                                            if($pat['cemmaterial']=='f')
                                              $pat['cemmaterial']='';
                                            $sms.="<input type=\"text\" class=\"form-control\" style=\"width:80%;\" name=\"cemmaterial\"  id=\"cemmaterial\" value=\"".$pat["cemmaterial"]."\">";
                                          }
                                          echo $sms;
                                          ?>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>

                                </div>

                              </div>

                            </div>

                            <div class="modal-footer">

                              <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
                              <?php

                              if((isset($pat['fixedstatus']) && $pat['fixedstatus']!='fail'&&
                              $pat['fixedstatus']!='canceled'&&$pat['fixedstatus']!='end') &&
                              ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
                              (!isset($pat['observationaccepted'])) )){
                                  echo "<button type=\"submit\" class=\"btn btn-success\" id=\"procedimiento_button\" name=\"procedimiento_button\">Guardar</button>";
                              }

                              ?>

                            </div>

                          </div>

                          </div>
                        </div>
                        <!--modal procedimiento fin-->
                        <!--modal end-->


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

     function procedimiento(){
       var ficha=$('#ficha').val();

       var radfecha=$('#radfecha').val();
       var radvobo='';
       if($('#radvobo').prop('checked')=== undefined){
         radvobo='';
       }else{
         if($('#radvobo').prop('checked')==true){
           radvobo='t';
         }else{
           radvobo='f';
         }
       }
       var radmaterial='';
       if($('#radmaterial').hasClass('text-success')){
           radmaterial='';
       }else{
           if($('#radmaterial').val()==''){
             radmaterial='f';
           }else{
             radmaterial=$('#radmaterial').val();
           }
       }

       var prefecha=$('#prefecha').val();
       var prevobo='';
       if($('#prevobo').prop('checked')=== undefined){
         prevobo='';
       }else{
         if($('#prevobo').prop('checked')==true){
           prevobo='t';
         }else{
           prevobo='f';
         }
       }
       var prematerial='';
       if($('#prematerial').hasClass('text-success')){
           prematerial='';
       }else{
           if($('#prematerial').val()==''){
             prematerial='f';
           }else{
             prematerial=$('#prematerial').val();
           }
       }

       var impfecha=$('#impfecha').val();
       var impvobo='';
       if($('#impvobo').prop('checked')=== undefined){
         impvobo='';
       }else{
         if($('#impvobo').prop('checked')==true){
           impvobo='t';
         }else{
           impvobo='f';
         }
       }
       var impmaterial='';
       if($('#impmaterial').hasClass('text-success')){
           impmaterial='';
       }else{
           if($('#impmaterial').val()==''){
             impmaterial='f';
           }else{
             impmaterial=$('#impmaterial').val();
           }
       }

       var modfecha=$('#modfecha').val();
       var modvobo='';
       if($('#modvobo').prop('checked')=== undefined){
         modvobo='';
       }else{
         if($('#modvobo').prop('checked')==true){
           modvobo='t';
         }else{
           modvobo='f';
         }
       }
       var modmaterial='';
       if($('#modmaterial').hasClass('text-success')){
           modmaterial='';
       }else{
           if($('#modmaterial').val()==''){
             modmaterial='f';
           }else{
             modmaterial=$('#modmaterial').val();
           }
       }

       var tomfecha=$('#tomfecha').val();
       var tomvobo='';
       if($('#tomvobo').prop('checked')=== undefined){
         tomvobo='';
       }else{
         if($('#tomvobo').prop('checked')==true){
           tomvobo='t';
         }else{
           tomvobo='f';
         }
       }
       var tommaterial='';
       if($('#tommaterial').hasClass('text-success')){
           tommaterial='';
       }else{
           if($('#tommaterial').val()==''){
             tommaterial='f';
           }else{
             tommaterial=$('#tommaterial').val();
           }
       }

       var monfecha=$('#monfecha').val();
       var monvobo='';
       if($('#monvobo').prop('checked')=== undefined){
         monvobo='';
       }else{
         if($('#monvobo').prop('checked')==true){
           monvobo='t';
         }else{
           monvobo='f';
         }
       }
       var monmaterial='';
       if($('#monmaterial').hasClass('text-success')){
           monmaterial='';
       }else{
           if($('#monmaterial').val()==''){
             monmaterial='f';
           }else{
             monmaterial=$('#monmaterial').val();
           }
       }

       var corfecha=$('#corfecha').val();
       var corvobo='';
       if($('#corvobo').prop('checked')=== undefined){
         corvobo='';
       }else{
         if($('#corvobo').prop('checked')==true){
           corvobo='t';
         }else{
           corvobo='f';
         }
       }
       var cormaterial='';
       if($('#cormaterial').hasClass('text-success')){
           cormaterial='';
       }else{
           if($('#cormaterial').val()==''){
             cormaterial='f';
           }else{
             cormaterial=$('#cormaterial').val();
           }
       }

       var talfecha=$('#talfecha').val();
       var talvobo='';
       if($('#talvobo').prop('checked')=== undefined){
         talvobo='';
       }else{
         if($('#talvobo').prop('checked')==true){
           talvobo='t';
         }else{
           talvobo='f';
         }
       }
       var talmaterial='';
       if($('#talmaterial').hasClass('text-success')){
           talmaterial='';
       }else{
           if($('#talmaterial').val()==''){
             talmaterial='f';
           }else{
             talmaterial=$('#talmaterial').val();
           }
       }

       var profecha=$('#profecha').val();
       var provobo='';
       if($('#provobo').prop('checked')=== undefined){
         provobo='';
       }else{
         if($('#provobo').prop('checked')==true){
           provobo='t';
         }else{
           provobo='f';
         }
       }
       var promaterial='';
       if($('#promaterial').hasClass('text-success')){
           promaterial='';
       }else{
           if($('#promaterial').val()==''){
             promaterial='f';
           }else{
             promaterial=$('#promaterial').val();
           }
       }

       var prufecha=$('#prufecha').val();
       var pruvobo='';
       if($('#pruvobo').prop('checked')=== undefined){
         pruvobo='';
       }else{
         if($('#pruvobo').prop('checked')==true){
           pruvobo='t';
         }else{
           pruvobo='f';
         }
       }
       var prumaterial='';
       if($('#prumaterial').hasClass('text-success')){
           prumaterial='';
       }else{
           if($('#prumaterial').val()==''){
             prumaterial='f';
           }else{
             prumaterial=$('#prumaterial').val();
           }
       }

       var cemfecha=$('#cemfecha').val();
       var cemvobo='';
       if($('#cemvobo').prop('checked')=== undefined){
         cemvobo='';
       }else{
         if($('#cemvobo').prop('checked')==true){
           cemvobo='t';
         }else{
           cemvobo='f';
         }
       }
       var cemmaterial='';
       if($('#cemmaterial').hasClass('text-success')){
           cemmaterial='';
       }else{
           if($('#cemmaterial').val()==''){
             cemmaterial='f';
           }else{
             cemmaterial=$('#cemmaterial').val();
           }
       }

       $.ajax({

          url:"../include/i_prosthodontics.php",
          method:"POST",
          data: {ficha:ficha,
            radfecha:radfecha, radvobo:radvobo, radmaterial:radmaterial, prefecha:prefecha, prevobo:prevobo,
            prematerial:prematerial, impfecha:impfecha, impvobo:impvobo, impmaterial:impmaterial, modfecha:modfecha,
            modvobo:modvobo, modmaterial:modmaterial, tomfecha:tomfecha, tomvobo:tomvobo, tommaterial:tommaterial,
            monfecha:monfecha, monvobo:monvobo, monmaterial:monmaterial, corfecha:corfecha, corvobo:corvobo,
            cormaterial:cormaterial, talfecha:talfecha, talvobo:talvobo, talmaterial:talmaterial, profecha:profecha,
            provobo:provobo, promaterial:promaterial, prufecha:prufecha, pruvobo:pruvobo, prumaterial:prumaterial,
            cemfecha:cemfecha, cemvobo:cemvobo, cemmaterial:cemmaterial},

          success:function(data)
          {

            if(data=='yes'){
              alert('Se guardo los datos');
              location.reload();
            }else{
              alert(data);
              console.log(data);
            }
          }
       });


     }
     $('#procedimiento_button').click(function(){
       procedimiento();

     });
     function impresiones(){
       var ficha=$('#ficha').val();

       var study='';
       if($('#study').prop('checked')=== undefined){
         study='';
       }else{
         if($('#study').prop('checked')==true){
           study='t';
         }else{
           study='f';
         }
       }
       var treatment='';
       if($('#treatment').prop('checked')=== undefined){
         treatment='';
       }else{
         if($('#treatment').prop('checked')==true){
           treatment='t';
         }else{
           treatment='f';
         }
       }
       var design='';
       if($('#design').prop('checked')=== undefined){
         design='';
       }else{
         if($('#design').prop('checked')==true){
           design='t';
         }else{
           design='f';
         }
       }
       var wire='';
       if($('#wire').prop('checked')=== undefined){
         wire='';
       }else{
         if($('#wire').prop('checked')==true){
           wire='t';
         }else{
           wire='f';
         }
       }
       var wax='';
       if($('#wax').prop('checked')=== undefined){
         wax='';
       }else{
         if($('#wax').prop('checked')==true){
           wax='t';
         }else{
           wax='f';
         }
       }
       var making='';
       if($('#making').prop('checked')=== undefined){
         making='';
       }else{
         if($('#making').prop('checked')==true){
           making='t';
         }else{
           making='f';
         }
       }
       var acrylic='';
       if($('#acrylic').prop('checked')=== undefined){
         acrylic='';
       }else{
         if($('#acrylic').prop('checked')==true){
           acrylic='t';
         }else{
           acrylic='f';
         }
       }
       var logiadesc=$('#logiadesc').val();
       var logiafirma='';
       var logiadate='';
       if(logiadesc===undefined){
           logiadesc='';
           logiafirma='';
           logiadate='';
       }else{
         if($('#logiafirma').prop('checked')=== undefined){
           logiafirma='';
         }else{
           if($('#logiafirma').prop('checked')==true){
             logiafirma='t';
           }else{
             logiafirma='f';
           }
         }
         logiadate=$('#logiadate').val();
       }

       $.ajax({
            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, study:study, treatment:treatment, design:design, wire:wire, wax:wax,
              making:making, acrylic:acrylic, logiadesc:logiadesc, logiafirma:logiafirma,
              logiadate:logiadate},
            success:function(data)
            {
              if(data=='yes'){
                alert('Se envió los datos');
                location.reload();
              }else{
                alert(data);
                console.log(data);
              }
            }
       });
     }

     $('#impresiones_button').click(function(){
       impresiones();

     });
     //Rehabilitacion
     $('#controles_button').click(function(){
       var ficha=$('#ficha').val();
       var controlesdesc=$('#controlesdesc').val();


       $.ajax({
            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, controlesdesc:controlesdesc},
            success:function(data)
            {
              if(data=='yes'){
                alert('Se guardó los datos');
                location.reload();
              }else{
                alert(data);
                console.log(data);
              }
            }
       });

     });

});
</script>
