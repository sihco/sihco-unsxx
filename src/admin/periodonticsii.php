<?php
require('header.php');
if(isset($_POST["designed"]) && isset($_POST["clinical"]) && $_POST["designed"]!="" && $_POST["clinical"]!=""){
  DBDesignedTeacher($_SESSION["usertable"]["usernumber"], $_POST['designed'], $_POST["clinical"]);
}

if(isset($_POST['desc']) && isset($_POST['evaluated']) &&
  isset($_POST['status']) && isset($_POST['id'])){
    if($_POST['status']=='--'){
        MSGError('Debe Seleccionar Status');
        ForceLoad('periodonticsii.php?id='.$_POST['id']);
    }
    $accepted='f';
    if($_POST['status']=='end')
      $accepted='t';
    if($accepted=='t'&&$_POST['evaluated']=='f'){
      MSGError('Debe seleccionar en Si la fila Revisado');
      ForceLoad('periodonticsii.php?id='.$_POST['id']);
    }

  DBEvaluatePeriodonticsii($_POST['desc'], $_POST['evaluated'], $accepted, $_POST['status'], $_POST['id']);
  MSGError('Se guardo la revisión');
}
if(isset($_GET['id']) && $_GET['id']!=""){

  $f=DBPeriodonticsiiInfo2($_GET['id']);
  $ob=DBAllObservationInfo($f['remission'],$_GET['id']);
}else{
  if(isset($_POST['cid'])&&is_numeric($_POST['cid'])){
    ForceLoad('index.php?id='.$_POST['cid']);
  }else{
      ForceLoad('index.php');
  }
}

?>

            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-4">

                        <br>
                        <div class="border border-primary">
                          <form class="" action="periodonticsii.php" method="post">
                            <input type="hidden" name="id" id="ficha" value="<?php if(isset($f['ficha'])) echo $f['ficha']; ?>">
                            <input type="hidden" name="cid" id="cid" value="<?php if(isset($pat['clinicalid'])) echo $pat['clinicalid']; ?>">
                          <div class="row">
                            <span align="center"><u><h5>EVALUACION</h5></u></span>
                          </div>
                          <div class="row">
                            <div class="col-7">
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
                                      if(isset($f['clinical'])&&$f['clinical']==14){
                                        echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('reportperiodonticsiii.php?id=".$f['ficha']."#toolbar=0', ".
                                    		"'Visualizar Ficha','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
                                    		"resizable=yes')\">Ver</a><br />\n";
                                      }else{
                                        echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('reportperiodonticsii.php?id=".$f['ficha']."#toolbar=0', ".
                                    		"'Visualizar Ficha','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
                                    		"resizable=yes')\">Ver</a><br />\n";
                                      }

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
                                  <tr>
                                    <th>
                                      <?php
                                      if($f['clinical']==14){
                                        echo "Controles";
                                      }else{
                                        echo "Sessiones";
                                      }
                                      ?>
                                    </th>
                                    <td>
                                      <?php

                                      $s=DBSessionPeriodonticsiiInfo($_GET['id']);

                                      if(isset($f['treatment']) && $f['treatment']!=''){
                                        if($f['treatment']=='profilaxis'){
                                          echo "<a class=\"btn btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#profilaxis\">Profilaxis - Fluorización</a>";
                                        }
                                        if($f['treatment']=='tartrectomia'){
                                          echo "<a class=\"btn btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#tartrectomia\">Tartrectomia</a>";
                                        }
                                        if($f['treatment']=='gingivectomia'){
                                          echo "<a class=\"btn btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#profilaxis\">Gingivectomía</a>";
                                        }
                                        if($f['treatment']=='despigmentacion'){
                                          echo "<a class=\"btn btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#tartrectomia\">Despigmentación</a>";
                                        }
                                      }

                                      ?>
                                      <!--ventanas modales inicio-->
                                      <!--inicio modal sesion profilaxis-->
                                      <div class="modal fade" role="dialog" id="profilaxis">
                                      <?php $a=DBUserInfo($_SESSION["usertable"]["usernumber"]);?>
                                      <div class="modal-dialog">
                                        <div class="modal-content">

                                          <div class="modal-header">
                                            <h3 class="modal-title"><?php if($f['clinical']==14){echo "Gingivectomía";}else{echo "Profilaxis y Fluorización";} ?></h3>

                                            <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
                                          </div>

                                          <div class="modal-body">
                                            <input type="hidden" name="namecontrol1" id="namecontrol1" value="<?php if($f['clinical']==14){echo 'gingivectomia';}else{echo 'profilaxis';} ?>">
                                            <?php
                                            if($f['clinical']==14){
                                            ?>
                                            <div class="from-group border border-primary rounded">
                                              <div class="container">
                                                <label for="">Inicio de sesión</label>
                                                <input type="date" id="session1date0" class="form-control"  name="sesion1date0" value="<?php if(isset($f["session1date0"])) echo $f["session1date0"];  ?>" min="2015-01-01" max="2099-01-01">

                                                <select name="session1evalued0" class="form-select" aria-label="Default select example">
                                                  <option <?php if(!isset($f["session1evalued0"]) || $f["session1evalued0"] == '--' || $f["session1evalued0"] == '') echo "selected"; ?> value="--">No verificado</option>
                                                  <option <?php if(isset($f["session1evalued0"]) && $f["session1evalued0"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                                  <option <?php if(isset($f["session1evalued0"]) && $f["session1evalued0"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                                </select>

                                                <br>
                                              </div>
                                            </div>
                                            <?php  }?>
                                            <div class="from-group border border-primary rounded">
                                              <div class="container">
                                                <label for=""><?php if($f['clinical']==14){echo "1. Control:";}else{echo "1. Sesión:";} ?></label>
                                                <input type="date" id="session1date1" class="form-control"  name="sesion1date1" value="<?php if(isset($f["session1date1"])) echo $f["session1date1"];  ?>" min="2015-01-01" max="2099-01-01">

                                                <select name="session1evalued1" class="form-select" aria-label="Default select example">
                                                  <option <?php if(!isset($f) || $f["session1evalued1"] == '--' || $f["session1evalued1"] == '') echo "selected"; ?> value="--">No verificado</option>
                                                  <option <?php if(isset($f) && $f["session1evalued1"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                                  <option <?php if(isset($f) && $f["session1evalued1"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                                </select>

                                                <br>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="from-group border border-warning rounded">
                                              <div class="container">
                                                <label for=""><?php if($f['clinical']==14){echo "2. Control:";}else{echo "2. Sesión:";} ?></label>
                                                <input type="date" id="session1date2" class="form-control"  name="sesion1date2" value="<?php if(isset($f["session1date2"])) echo $f["session1date2"];  ?>" min="2015-01-01" max="2099-01-01">
                                                <select name="session1evalued2" class="form-select" aria-label="Default select example">
                                                  <option <?php if(!isset($f) || $f["session1evalued2"] == '--' || $f["session1evalued2"] == '') echo "selected"; ?> value="--">No verificado</option>
                                                  <option <?php if(isset($f) && $f["session1evalued2"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                                  <option <?php if(isset($f) && $f["session1evalued2"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                                </select>
                                                <br>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="from-group border border-success rounded">
                                              <div class="container">
                                                <label for=""><?php if($f['clinical']==14){echo "3. Control:";}else{echo "3. Sesión:";} ?></label>
                                                <input type="date" id="session1date3" class="form-control"  name="sesion1date3" value="<?php if(isset($f["session1date3"])) echo $f["session1date3"];  ?>" min="2015-01-01" max="2099-01-01">
                                                <select name="session1evalued3" class="form-select" aria-label="Default select example">
                                                  <option <?php if(!isset($f) || $f["session1evalued3"] == '--' || $f["session1evalued3"] == '') echo "selected"; ?> value="--">No verificado</option>
                                                  <option <?php if(isset($f) && $f["session1evalued3"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                                  <option <?php if(isset($f) && $f["session1evalued3"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                                </select>
                                                <br>
                                              </div>
                                            </div>


                                                <?php
                                                if($f['clinical']==6){
                                                  echo "<div class=\"form-group\">".
                                                  "  <div class=\"container\">";
                                                  echo "Fluorización:";
                                                  $ss=DBSessionPeriodonticsiiInfo($_GET['id']);
                                                  if(isset($ss['sessionfluor'])){
                                                    echo ucfirst($ss['sessionfluor']);
                                                  }
                                                  echo "  </div>".
                                                  "</div>";
                                                }


                                                ?>

                                            <div class="from-group">
                                              <label for="">Observación:</label>
                                              <textarea class="form-control" name="session1desc" id="session1desc" rows="2" ><?php if(isset($f["sessiondesc"])) echo $f["sessiondesc"];  ?></textarea>
                                            </div>


                                          </div>

                                          <div class="modal-footer">
                                            <?php
                                            if(isset($s['sessionevaluated']) && $s['sessionevaluated']=='f'){
                                              echo "<button type=\"button\" class=\"mx-5 btn btn-danger\" data-dismiss=\"modal\" name=\"cancel_update\">Cancelar</button>
                                              <button type=\"button\" class=\"btn btn-success\" id=\"profilaxis_button\" name=\"profilaxis_button\">Guardar Sesion</button>
";
                                            }
                                            ?>

                                          </div>

                                        </div>

                                        </div>
                                      </div>
                                      <!--fin modal profilaxis-->

                                      <!--inicio modal tartrectomia-->
                                      <div class="modal fade" role="dialog" id="tartrectomia">
                                      <?php $a=DBUserInfo($_SESSION["usertable"]["usernumber"]);?>
                                      <div class="modal-dialog">
                                        <div class="modal-content">

                                          <div class="modal-header">
                                            <h3 class="modal-title"><?php if($f['clinical']==14){echo "Despigmentación";}else{echo "Tartrectomia";} ?></h3>

                                            <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
                                          </div>

                                          <div class="modal-body">

                                            <input type="hidden" name="namecontrol2" id="namecontrol2" value="<?php if($f['clinical']==14){echo 'despigmentacion';}else{echo 'tartrectomia';} ?>">
                                            <?php
                                            if($f['clinical']==14){
                                            ?>
                                            <div class="from-group border border-primary rounded">
                                              <div class="container">
                                                <label for="">Inicio de sesión</label>
                                                <input type="date" id="session2date0" class="form-control"  name="sesion2date0" value="<?php if(isset($f["session2date0"])) echo $f["session2date0"];  ?>" min="2015-01-01" max="2099-01-01">

                                                <select name="session2evalued0" class="form-select" aria-label="Default select example">
                                                  <option <?php if(!isset($f["session2evalued0"]) || $f["session2evalued0"] == '--' || $f["session2evalued0"] == '') echo "selected"; ?> value="--">No verificado</option>
                                                  <option <?php if(isset($f["session2evalued0"]) && $f["session2evalued0"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                                  <option <?php if(isset($f["session2evalued0"]) && $f["session2evalued0"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                                </select>

                                                <br>
                                              </div>
                                            </div>
                                            <?php  }?>
                                            <div class="from-group border border-primary rounded">
                                              <div class="container">
                                                <label for=""><?php if($f['clinical']==14){echo "1. Control:";}else{echo "1. Sesión:";} ?></label>
                                                <input type="date" id="session2date1" class="form-control"  name="session2date1" value="<?php if(isset($f["session2date1"])) echo $f["session2date1"];  ?>" min="2015-01-01" max="2099-01-01">
                                                <select name="session2evalued1" class="form-select" aria-label="Default select example">
                                                  <option <?php if(!isset($f) || $f["session2evalued1"] == '--' || $f["session2evalued1"] == '') echo "selected"; ?> value="--">No verificado</option>
                                                  <option <?php if(isset($f) && $f["session2evalued1"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                                  <option <?php if(isset($f) && $f["session2evalued1"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                                </select>
                                                <br>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="from-group border border-warning rounded">
                                              <div class="container">
                                                <label for=""><?php if($f['clinical']==14){echo "2. Control:";}else{echo "2. Sesión:";} ?></label>
                                                <input type="date" id="session2date2" class="form-control"  name="sesion2date2" value="<?php if(isset($f["session2date2"])) echo $f["session2date2"];  ?>" min="2015-01-01" max="2099-01-01">
                                                <select name="session2evalued2" class="form-select" aria-label="Default select example">
                                                  <option <?php if(!isset($f) || $f["session2evalued2"] == '--' || $f["session2evalued2"] == '') echo "selected"; ?> value="--">No verificado</option>
                                                  <option <?php if(isset($f) && $f["session2evalued2"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                                  <option <?php if(isset($f) && $f["session2evalued2"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                                </select>
                                                <br>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="from-group border border-success rounded">
                                              <div class="container">
                                                <label for=""><?php if($f['clinical']==14){echo "3. Control:";}else{echo "3. Sesión:";} ?></label>
                                                <input type="date" id="session2date3" class="form-control"  name="sesion2date3" value="<?php if(isset($f["session2date3"])) echo $f["session2date3"];  ?>" min="2015-01-01" max="2099-01-01">
                                                <select name="session2evalued3" class="form-select" aria-label="Default select example">
                                                  <option <?php if(!isset($f) || $f["session2evalued3"] == '--' || $f["session2evalued3"] == '') echo "selected"; ?> value="--">No verificado</option>
                                                  <option <?php if(isset($f) && $f["session2evalued3"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                                  <option <?php if(isset($f) && $f["session2evalued3"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                                </select>
                                                <br>
                                              </div>
                                            </div>
                                            <div class="from-group">
                                              <label for="">Observación:</label>
                                              <textarea class="form-control" name="session2desc" id="session2desc" rows="2" ><?php if(isset($f["sessiondesc"])) echo $f["sessiondesc"];  ?></textarea>
                                            </div>

                                          </div>

                                          <div class="modal-footer">
                                            <?php
                                            if(isset($s['sessionevaluated']) && $s['sessionevaluated']=='f'){
                                              echo "<button type=\"button\" class=\"mx-5 btn btn-danger\" data-dismiss=\"modal\" name=\"cancel_update\">Cancelar</button>
                                              <button type=\"button\" class=\"btn btn-success\" id=\"tartrectomia_button\" name=\"tartrectomia_button\">Guardar Session</button>
";
                                            }

                                            ?>

                                          </div>

                                        </div>

                                        </div>
                                      </div>
                                      <!--fin modal tartrectomia-->
                                      <!--ventanas modales fin-->
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="col-5">
                              <label for="desc"><u><b>Observaciones</b></u></label>
                              <textarea class="form-control" name="desc" id="desc" rows="8" ><?php if(isset($f['description'])) echo $f['description'];?></textarea>
                            </div>
                          </div>
                          <div class="row">
                            <div align="center">
                              <input type="submit" name="" class="btn btn-primary col-4" value="Enviar">
                            </div>
                          </div>
                          <br>
                          </form>
                        </div>
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
function designed(f){
  alert(f);
}
$(document).ready(function(){

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
        var s1desc = $('#session1desc').val();
        var s1evalued0 = $('select[name=session1evalued0]').val();
        var s1evalued1 = $('select[name=session1evalued1]').val();
        var s1evalued2 = $('select[name=session1evalued2]').val();
        var s1evalued3 = $('select[name=session1evalued3]').val();
        $.ajax({

             url:"../include/i_session.php",
             method:"POST",
             data: {namecontrol1:namecontrol1, s1desc:s1desc, s1evalued0:s1evalued0, s1evalued1:s1evalued1,s1evalued2:s1evalued2, s1evalued3:s1evalued3, ficha:ficha, s1date0:s1date0, s1date1:s1date1, s1date2:s1date2, s1date3:s1date3},

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
        var s2desc = $('#session2desc').val();
        var s2evalued0 = $('select[name=session2evalued0]').val();
        var s2evalued1 = $('select[name=session2evalued1]').val();
        var s2evalued2 = $('select[name=session2evalued2]').val();
        var s2evalued3 = $('select[name=session2evalued3]').val();

        $.ajax({

             url:"../include/i_session.php",
             method:"POST",
             data: {namecontrol2:namecontrol2, s2desc:s2desc, s2evalued0:s2evalued0, s2evalued1:s2evalued1, s2evalued2:s2evalued2, s2evalued3:s2evalued3, ficha:ficha, s2date0:s2date0, s2date1:s2date1, s2date2:s2date2, s2date3:s2date3},

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
