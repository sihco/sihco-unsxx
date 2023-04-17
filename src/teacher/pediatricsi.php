<?php
require('header.php');

if(isset($_POST["designed"]) && isset($_POST["clinical"]) && $_POST["designed"]!="" && $_POST["clinical"]!=""){
  DBDesignedTeacher($_SESSION["usertable"]["usernumber"], $_POST['designed'], $_POST["clinical"]);
}

if(isset($_POST['desc']) && isset($_POST['evaluated']) &&
  isset($_POST['status']) && isset($_POST['id'])){
    if($_POST['status']=='--'){
        MSGError('Debe Seleccionar Status');
        ForceLoad('pediatricsi.php?id='.$_POST['id']);
    }
    $accepted='f';
    if($_POST['status']=='end')
      $accepted='t';
    if($accepted=='t'&&$_POST['evaluated']=='f'){
      MSGError('Debe seleccionar en Si la fila Revisado');
      ForceLoad('pediatricsi.php?id='.$_POST['id']);
    }

  DBEvaluatePediatrics($_POST['desc'], $_POST['evaluated'], $accepted, $_POST['status'], $_POST['id']);
  MSGError('Se guardó la revisión');
}
if(isset($_GET['id']) && $_GET['id']!=""){

  $f=DBPediatricsiInfo2($_GET['id']);
  $pat=DBPediatricsiInfo($_GET['id']);
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
                          <form class="" action="pediatricsi.php" method="post">
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
                                      echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('reportpediatricsi.php?id=".$f['ficha']."#toolbar=0', ".
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
                              <textarea name="desc" id="desc" rows="8" class="form-control"><?php if(isset($f['description'])) echo $f['description'];?></textarea>
                            </div>
                          </div>
                          <div class="container row">
                            <div class="">
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#tartrectomia">O'leary</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#plan">Plan de Tratamiento Int. Ind.</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#urgencias">Urgencias</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#inactivacion">Inactivacion</a>

                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#quimico">Quimico-Mecanico del Bio Fil</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#morfologico">Refuerzo Morfologico</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#estructural">Refuerzo Estructural</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#cirugia">Cirugia</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#pulpar">Tratamiento Pulpar</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#rehabilitation">Rehabilitación</a>

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
                            .dienteb{
                              float: left;
                              display: inline-block;
                            }
                            .cursor:hover {
                                cursor: pointer;
                            }
                            </style>
                            <div class="">
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
                                      <!--<div class="col-md-4 col-sm-4 col-lg-3">
                                        <select class="form-select" name="option" aria-label="Default select example">
                                        <option value="1" selected>Pintar</option>
                                        <option value="2">Aucente</option>
                                        </select>
                                      </div>-->
                                    </div>

                                    <div class="from-group border border-primary rounded">
                                      <div class="container">

                                        <input type="hidden" name="olygram" id="olygram" value="<?php if(isset($pat['pediatricsioleary'])) echo $pat['pediatricsioleary']; ?>">
                                        <div class="row border">
                                          <div class="col-6 border">
                                            CONTROL N. 1
                                          </div>
                                          <div align="center" class="col-2 border">
                                            <!--<input type="text" name="info" id="info"value="">%-->
                                            <label for="" id="info">%</label>
                                          </div>
                                          <div class="col-4 border">

                                            Fecha:
                                            <input type="date" id="date1" name="date1" value="<?php if(isset($pat['date1'])){echo $pat['date1'];}else{echo date("Y-m-d");}?>" min="1990-01-01" max="2099-01-01">
                                          </div>
                                        </div>
                                        <div class="">
                                          <div class="bg-danger mt-2" id='oleary'></div>
                                          <div class="">

                                            &nbsp;&nbsp;&nbsp;
                                            <select name="evaluedoleary1" aria-label="Default select example">
                                              <option <?php if(!isset($pat["evaluedoleary1"])) echo "selected"; ?> value="">--</option>
                                              <option <?php if(isset($pat["evaluedoleary1"]) && ($pat["evaluedoleary1"]== '--' || $pat["evaluedoleary1"] == '')) echo "selected"; ?> value="--">No verificado</option>
                                              <option <?php if(isset($pat["evaluedoleary1"]) && $pat["evaluedoleary1"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                              <option <?php if(isset($pat["evaluedoleary1"]) && $pat["evaluedoleary1"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                            </select>
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
                                          <div class="col-6 border">
                                            CONTROL N. 2
                                          </div>
                                          <div align="center" class="col-2 border">
                                            <!--<input type="text" name="info" id="info"value="">%-->
                                            <label for="" id="info2">%</label>
                                          </div>
                                          <div class="col-4 border">
                                            Fecha:
                                            <input type="date" id="date2" name="date2" value="<?php if(isset($pat['date2'])) echo $pat['date2'];?>" min="1990-01-01" max="2099-01-01">
                                          </div>
                                        </div>
                                        <div class="">
                                          <div class="bg-danger mt-2" id='oleary2'></div>
                                          <div class="">

                                            &nbsp;&nbsp;&nbsp;
                                            <select name="evaluedoleary2" aria-label="Default select example">
                                              <option <?php if(!isset($pat["evaluedoleary2"])) echo "selected"; ?> value="">--</option>
                                              <option <?php if(isset($pat["evaluedoleary2"]) && ($pat["evaluedoleary2"]== '--' || $pat["evaluedoleary2"] == '')) echo "selected"; ?> value="--">No verificado</option>
                                              <option <?php if(isset($pat["evaluedoleary2"]) && $pat["evaluedoleary2"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                              <option <?php if(isset($pat["evaluedoleary2"]) && $pat["evaluedoleary2"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                            </select>
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
                                          <div class="col-6 border">
                                            CONTROL N. 3
                                          </div>
                                          <div align="center" class="col-2 border">
                                            <!--<input type="text" name="info" id="info"value="">%-->
                                            <label for="" id="info3">%</label>
                                          </div>
                                          <div class="col-4 border">

                                            Fecha:
                                            <input type="date" id="date3" name="date3" value="<?php if(isset($pat['date3'])) echo $pat['date3'];?>" min="1990-01-01" max="2099-01-01">
                                          </div>
                                        </div>
                                        <div class="">
                                          <div class="bg-danger mt-2" id='oleary3'></div>
                                          <div class="">

                                            &nbsp;&nbsp;&nbsp;
                                            <select name="evaluedoleary3" aria-label="Default select example">
                                              <option <?php if(!isset($pat["evaluedoleary3"])) echo "selected"; ?> value="">--</option>
                                              <option <?php if(isset($pat["evaluedoleary3"]) && ($pat["evaluedoleary3"]== '--' || $pat["evaluedoleary3"] == '')) echo "selected"; ?> value="--">No verificado</option>
                                              <option <?php if(isset($pat["evaluedoleary3"]) && $pat["evaluedoleary3"] == 'correcto') echo "selected"; ?> value="correcto">Correcto</option>
                                              <option <?php if(isset($pat["evaluedoleary3"]) && $pat["evaluedoleary3"] == 'incorrecto') echo "selected"; ?> value="incorrecto">Incorrecto</option>
                                            </select>
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
                                    if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                      echo "<button type=\"submit\" class=\"btn btn-success\" id=\"oleary_button\" name=\"oleary_button\">Enviar O'leary</button>";
                                    }
                                    ?>

                                  </div>

                                </div>

                                </div>
                              </div>
                              <!--fin modal oleary-->

                            </div>
                            <!--fin modal-->

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
                                      <div class="col-3">
                                        FECHA
                                      </div>
                                      <div class="col-2">
                                        PIEZAS
                                      </div>
                                      <div class="col-2">
                                        DIAGNOSTICO
                                      </div>
                                      <div class="col-2">
                                        TRATAMIENTO
                                      </div>
                                      <div class="col-1">
                                        FIRMA
                                      </div>
                                      <div class="col-1">
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
                                          "<div class=\"col-3\">".
                                          "  <input type=\"date\" id=\"\" class=\"form-control d-inline urgfecha\" name=\"urgfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline urgpieza\" name=\"urgpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                            "<textarea name=\"urgdiagnostico[]\" rows=\"2\" class=\"form-control d-inline urgdiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline urgtratamiento\" name=\"urgtratamiento[]\" readonly onmousedown=\"return false;\" value=\"".$urginfo[$i]['controltreatment']."\">".
                                          "</div>".
                                          "<div class=\"col-2\">";

                                          if($urginfo[$i]["controlstart"]==''){
                                            $sms.="  <span class=\"firmainicio\" name=\"firmainicio[]\" ></span>";

                                          }else{
                                            if($urginfo[$i]["controlstart"]=='t'){
                                              $sms.="   <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>";

                                          $sms.="<div class=\"col-1\">";

                                          if($urginfo[$i]["controlend"]==''){

                                            $sms.="  <span class=\"firmafin\" name=\"firmafin[]\" ></span>";
                                          }else{
                                            if($urginfo[$i]["controlend"]=='t'){

                                              $sms.="   <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";


                                            }else{
                                              $sms.="   <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>".

                                        "</div>".
                                        "</div>";
                                        echo $sms;

                                      }else{
                                          $sms.= "<div>".

                                          "<hr>".
                                          "<div class=\"row\">".

                                            "<input type=\"hidden\" name=\"urgencias\" class=\"urgencias\" value=\"".$urginfo[$i]['controlid']."\">".
                                            "<div class=\"col-3\">".
                                            "  <input type=\"date\" id=\"\" class=\"form-control d-inline urgfecha\" name=\"urgfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline urgpieza\" name=\"urgpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                              "<textarea name=\"urgdiagnostico[]\" rows=\"2\" class=\"form-control d-inline urgdiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline urgtratamiento\" name=\"urgtratamiento[]\" value=\"".$urginfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".

                                            "<div class=\"col-2\">";

                                            if($urginfo[$i]["controlstart"]==''){
                                              $sms.="  <span class=\"firmainicio\" name=\"firmainicio[]\" ></span>";

                                            }else{
                                              if($urginfo[$i]["controlstart"]=='t'){
                                                $sms.="   <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }else{
                                                $sms.="   <input class=\"form-check-input firmainicio\" name=\"firmainicio[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>";

                                            $sms.="<div class=\"col-1\">";

                                            if($urginfo[$i]["controlend"]==''){

                                              $sms.="  <span class=\"firmafin\" name=\"firmafin[]\" ></span>";
                                            }else{
                                              if($urginfo[$i]["controlend"]=='t'){

                                                $sms.="   <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";


                                              }else{
                                                $sms.="   <input class=\"form-check-input firmafin\" name=\"firmafin[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>".


                                          "</div>".
                                          "</div>";
                                          echo $sms;
                                      }
                                    }


                                    ?>


                                  </div>

                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>

                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button class=\"btn btn-success\" id=\"urgencias_button\" name=\"oleary_button\">Guardar Urgencias</button>";
                                }
                                ?>

                              </div>

                            </div>

                            </div>
                          </div>
                          <!--modal urgencias fin-->

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
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button type=\"submit\" class=\"btn btn-success\" id=\"plan_button\" name=\"plan_button\">Guardar</button>";
                                }
                                ?>

                              </div>
                            </div>
                            </div>
                          </div>
                          <!--modal plan de tratamiento integral individualizado fin-->
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
                                      <div class="col-3">
                                        FECHA
                                      </div>
                                      <div class="col-2">
                                        PIEZAS
                                      </div>
                                      <div class="col-2">
                                        DIAGNOSTICO
                                      </div>
                                      <div class="col-2">
                                        TRATAMIENTO
                                      </div>
                                      <div class="col-1">
                                        FIRMA
                                      </div>
                                      <div class="col-1">
                                        CONCLUSION
                                      </div>
                                    </div>

                                    <?php
                                    $urginfo=DBAllPediatricsiControlInfo($_GET['id'], 'inactivation');
                                    for ($i=0; $i < count($urginfo); $i++) {
                                      $sms='';
                                      if($i==0){
                                        $sms.= "<div id=\"informationinactivation\">".
                                        "<hr>".
                                        "<div class=\"row\">".
                                          "<input type=\"hidden\" name=\"inactivacion\" class=\"inactivacion\" value=\"".$urginfo[$i]['controlid']."\">".
                                          "<div class=\"col-3\">".
                                          "  <input type=\"date\" id=\"\" class=\"form-control d-inline inafecha\" name=\"inafecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline inapieza\" name=\"inapieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                            "<textarea name=\"inadiagnostico[]\" rows=\"2\" class=\"form-control d-inline inadiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline inatratamiento\" name=\"inatratamiento[]\" readonly onmousedown=\"return false;\" value=\"".$urginfo[$i]['controltreatment']."\">".
                                          "</div>".
                                          "<div class=\"col-2\">";

                                          if($urginfo[$i]["controlstart"]==''){
                                            $sms.="  <span class=\"inainicio\" name=\"inainicio[]\" ></span>";

                                          }else{
                                            if($urginfo[$i]["controlstart"]=='t'){
                                              $sms.="   <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>";

                                          $sms.="<div class=\"col-1\">";

                                          if($urginfo[$i]["controlend"]==''){

                                            $sms.="  <span class=\"inafin\" name=\"inafin[]\" ></span>";
                                          }else{
                                            if($urginfo[$i]["controlend"]=='t'){

                                              $sms.="   <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";


                                            }else{
                                              $sms.="   <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>".

                                        "</div>".
                                        "</div>";
                                        echo $sms;

                                      }else{
                                          $sms.= "<div>".

                                          "<hr>".
                                          "<div class=\"row\">".

                                            "<input type=\"hidden\" name=\"inactivacion\" class=\"inactivacion\" value=\"".$urginfo[$i]['controlid']."\">".
                                            "<div class=\"col-3\">".
                                            "  <input type=\"date\" id=\"\" class=\"form-control d-inline inafecha\" name=\"inafecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline inapieza\" name=\"inapieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                              "<textarea name=\"inadiagnostico[]\" rows=\"2\" class=\"form-control d-inline inadiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline inatratamiento\" name=\"inatratamiento[]\" value=\"".$urginfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".

                                            "<div class=\"col-2\">";

                                            if($urginfo[$i]["controlstart"]==''){
                                              $sms.="  <span class=\"inainicio\" name=\"inainicio[]\" ></span>";

                                            }else{
                                              if($urginfo[$i]["controlstart"]=='t'){
                                                $sms.="   <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }else{
                                                $sms.="   <input class=\"form-check-input inainicio\" name=\"inainicio[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>";

                                            $sms.="<div class=\"col-1\">";

                                            if($urginfo[$i]["controlend"]==''){

                                              $sms.="  <span class=\"inafin\" name=\"inafin[]\" ></span>";
                                            }else{
                                              if($urginfo[$i]["controlend"]=='t'){

                                                $sms.="   <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";


                                              }else{
                                                $sms.="   <input class=\"form-check-input inafin\" name=\"inafin[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>".


                                          "</div>".
                                          "</div>";
                                          echo $sms;
                                      }
                                    }


                                    ?>


                                  </div>

                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>

                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button class=\"btn btn-success\" id=\"inactivacion_button\" name=\"inactivacion_button\">Guardar Inactivacion</button>";
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
                                <h3 class="modal-title">CONTROL QUIMICO - MECANICO DEL BIO FIL</h3>
                                <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
                              </div>

                              <div class="modal-body">

                                <div class="from-group border border-primary rounded">
                                  <div class="container">

                                    <div class="row">
                                      <div class="col-3">
                                        FECHA
                                      </div>
                                      <div class="col-2">
                                        PIEZAS
                                      </div>
                                      <div class="col-2">
                                        DIAGNOSTICO
                                      </div>
                                      <div class="col-2">
                                        TRATAMIENTO
                                      </div>
                                      <div class="col-1">
                                        FIRMA
                                      </div>
                                      <div class="col-1">
                                        CONCLUSION
                                      </div>
                                    </div>

                                    <?php
                                    $urginfo=DBAllPediatricsiControlInfo($_GET['id'], 'quimic');
                                    for ($i=0; $i < count($urginfo); $i++) {
                                      $sms='';
                                      if($i==0){
                                        $sms.= "<div id=\"informationquimic\">".
                                        "<hr>".
                                        "<div class=\"row\">".
                                          "<input type=\"hidden\" name=\"quimico\" class=\"quimico\" value=\"".$urginfo[$i]['controlid']."\">".
                                          "<div class=\"col-3\">".
                                          "  <input type=\"date\" id=\"\" class=\"form-control d-inline quifecha\" name=\"quifecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline quipieza\" name=\"quipieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                            "<textarea name=\"quidiagnostico[]\" rows=\"2\" class=\"form-control d-inline quidiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline quitratamiento\" name=\"quitratamiento[]\" readonly onmousedown=\"return false;\" value=\"".$urginfo[$i]['controltreatment']."\">".
                                          "</div>".
                                          "<div class=\"col-2\">";

                                          if($urginfo[$i]["controlstart"]==''){
                                            $sms.="  <span class=\"quiinicio\" name=\"quiinicio[]\" ></span>";

                                          }else{
                                            if($urginfo[$i]["controlstart"]=='t'){
                                              $sms.="   <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>";

                                          $sms.="<div class=\"col-1\">";

                                          if($urginfo[$i]["controlend"]==''){

                                            $sms.="  <span class=\"quifin\" name=\"quifin[]\" ></span>";
                                          }else{
                                            if($urginfo[$i]["controlend"]=='t'){

                                              $sms.="   <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";


                                            }else{
                                              $sms.="   <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>".

                                        "</div>".
                                        "</div>";
                                        echo $sms;

                                      }else{
                                          $sms.= "<div>".

                                          "<hr>".
                                          "<div class=\"row\">".

                                            "<input type=\"hidden\" name=\"quimico\" class=\"quimico\" value=\"".$urginfo[$i]['controlid']."\">".
                                            "<div class=\"col-3\">".
                                            "  <input type=\"date\" id=\"\" class=\"form-control d-inline quifecha\" name=\"quifecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline quipieza\" name=\"quipieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                              "<textarea name=\"quidiagnostico[]\" rows=\"2\" class=\"form-control d-inline quidiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline quitratamiento\" name=\"quitratamiento[]\" value=\"".$urginfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".

                                            "<div class=\"col-2\">";

                                            if($urginfo[$i]["controlstart"]==''){
                                              $sms.="  <span class=\"quiinicio\" name=\"quiinicio[]\" ></span>";

                                            }else{
                                              if($urginfo[$i]["controlstart"]=='t'){
                                                $sms.="   <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }else{
                                                $sms.="   <input class=\"form-check-input quiinicio\" name=\"quiinicio[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>";

                                            $sms.="<div class=\"col-1\">";

                                            if($urginfo[$i]["controlend"]==''){

                                              $sms.="  <span class=\"quifin\" name=\"quifin[]\" ></span>";
                                            }else{
                                              if($urginfo[$i]["controlend"]=='t'){

                                                $sms.="   <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";


                                              }else{
                                                $sms.="   <input class=\"form-check-input quifin\" name=\"quifin[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>".


                                          "</div>".
                                          "</div>";
                                          echo $sms;
                                      }
                                    }


                                    ?>


                                  </div>

                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>

                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button class=\"btn btn-success\" id=\"quimico_button\" name=\"quimico_button\">Guardar</button>";
                                }
                                ?>

                              </div>

                            </div>

                            </div>
                          </div>
                          <!--modal quimico fin-->


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
                                      <div class="col-3">
                                        FECHA
                                      </div>
                                      <div class="col-2">
                                        PIEZAS
                                      </div>
                                      <div class="col-2">
                                        DIAGNOSTICO
                                      </div>
                                      <div class="col-2">
                                        TRATAMIENTO
                                      </div>
                                      <div class="col-1">
                                        FIRMA
                                      </div>
                                      <div class="col-1">
                                        CONCLUSION
                                      </div>
                                    </div>

                                    <?php
                                    $urginfo=DBAllPediatricsiControlInfo($_GET['id'], 'morfologic');
                                    for ($i=0; $i < count($urginfo); $i++) {
                                      $sms='';
                                      if($i==0){
                                        $sms.= "<div id=\"informationmorfologic\">".
                                        "<hr>".
                                        "<div class=\"row\">".
                                          "<input type=\"hidden\" name=\"morfologico\" class=\"morfologico\" value=\"".$urginfo[$i]['controlid']."\">".
                                          "<div class=\"col-3\">".
                                          "  <input type=\"date\" id=\"\" class=\"form-control d-inline morfecha\" name=\"morfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline morpieza\" name=\"morpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                            "<textarea name=\"mordiagnostico[]\" rows=\"2\" class=\"form-control d-inline mordiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline mortratamiento\" name=\"mortratamiento[]\" readonly onmousedown=\"return false;\" value=\"".$urginfo[$i]['controltreatment']."\">".
                                          "</div>".
                                          "<div class=\"col-2\">";

                                          if($urginfo[$i]["controlstart"]==''){
                                            $sms.="  <span class=\"morinicio\" name=\"morinicio[]\" ></span>";

                                          }else{
                                            if($urginfo[$i]["controlstart"]=='t'){
                                              $sms.="   <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>";

                                          $sms.="<div class=\"col-1\">";

                                          if($urginfo[$i]["controlend"]==''){

                                            $sms.="  <span class=\"morfin\" name=\"morfin[]\" ></span>";
                                          }else{
                                            if($urginfo[$i]["controlend"]=='t'){

                                              $sms.="   <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";


                                            }else{
                                              $sms.="   <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>".

                                        "</div>".
                                        "</div>";
                                        echo $sms;

                                      }else{
                                          $sms.= "<div>".

                                          "<hr>".
                                          "<div class=\"row\">".

                                            "<input type=\"hidden\" name=\"morfologico\" class=\"morfologico\" value=\"".$urginfo[$i]['controlid']."\">".
                                            "<div class=\"col-3\">".
                                            "  <input type=\"date\" id=\"\" class=\"form-control d-inline morfecha\" name=\"morfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline morpieza\" name=\"morpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                              "<textarea name=\"mordiagnostico[]\" rows=\"2\" class=\"form-control d-inline mordiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline mortratamiento\" name=\"mortratamiento[]\" value=\"".$urginfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".

                                            "<div class=\"col-2\">";

                                            if($urginfo[$i]["controlstart"]==''){
                                              $sms.="  <span class=\"morinicio\" name=\"morinicio[]\" ></span>";

                                            }else{
                                              if($urginfo[$i]["controlstart"]=='t'){
                                                $sms.="   <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }else{
                                                $sms.="   <input class=\"form-check-input morinicio\" name=\"morinicio[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>";

                                            $sms.="<div class=\"col-1\">";

                                            if($urginfo[$i]["controlend"]==''){

                                              $sms.="  <span class=\"morfin\" name=\"morfin[]\" ></span>";
                                            }else{
                                              if($urginfo[$i]["controlend"]=='t'){

                                                $sms.="   <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";


                                              }else{
                                                $sms.="   <input class=\"form-check-input morfin\" name=\"morfin[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>".


                                          "</div>".
                                          "</div>";
                                          echo $sms;
                                      }
                                    }


                                    ?>


                                  </div>

                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>

                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button class=\"btn btn-success\" id=\"morfologico_button\" name=\"morfologico_button\">Guardar</button>";
                                }
                                ?>

                              </div>

                            </div>

                            </div>
                          </div>
                          <!--modal morfologico fin-->

                          <!--modal estructural inicio-->
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
                                      <div class="col-3">
                                        FECHA
                                      </div>
                                      <div class="col-2">
                                        PIEZAS
                                      </div>
                                      <div class="col-2">
                                        DIAGNOSTICO
                                      </div>
                                      <div class="col-2">
                                        TRATAMIENTO
                                      </div>
                                      <div class="col-1">
                                        FIRMA
                                      </div>
                                      <div class="col-1">
                                        CONCLUSION
                                      </div>
                                    </div>

                                    <?php
                                    $urginfo=DBAllPediatricsiControlInfo($_GET['id'], 'estruct');
                                    for ($i=0; $i < count($urginfo); $i++) {
                                      $sms='';
                                      if($i==0){
                                        $sms.= "<div id=\"informationestruct\">".
                                        "<hr>".
                                        "<div class=\"row\">".
                                          "<input type=\"hidden\" name=\"estructural\" class=\"estructural\" value=\"".$urginfo[$i]['controlid']."\">".
                                          "<div class=\"col-3\">".
                                          "  <input type=\"date\" id=\"\" class=\"form-control d-inline estfecha\" name=\"estfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline estpieza\" name=\"estpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                            "<textarea name=\"estdiagnostico[]\" rows=\"2\" class=\"form-control d-inline estdiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline esttratamiento\" name=\"esttratamiento[]\" readonly onmousedown=\"return false;\" value=\"".$urginfo[$i]['controltreatment']."\">".
                                          "</div>".
                                          "<div class=\"col-2\">";

                                          if($urginfo[$i]["controlstart"]==''){
                                            $sms.="  <span class=\"estinicio\" name=\"estinicio[]\" ></span>";

                                          }else{
                                            if($urginfo[$i]["controlstart"]=='t'){
                                              $sms.="   <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>";

                                          $sms.="<div class=\"col-1\">";

                                          if($urginfo[$i]["controlend"]==''){

                                            $sms.="  <span class=\"estfin\" name=\"estfin[]\" ></span>";
                                          }else{
                                            if($urginfo[$i]["controlend"]=='t'){

                                              $sms.="   <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";


                                            }else{
                                              $sms.="   <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>".

                                        "</div>".
                                        "</div>";
                                        echo $sms;

                                      }else{
                                          $sms.= "<div>".

                                          "<hr>".
                                          "<div class=\"row\">".

                                            "<input type=\"hidden\" name=\"estructural\" class=\"estructural\" value=\"".$urginfo[$i]['controlid']."\">".
                                            "<div class=\"col-3\">".
                                            "  <input type=\"date\" id=\"\" class=\"form-control d-inline estfecha\" name=\"estfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline estpieza\" name=\"estpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                              "<textarea name=\"estdiagnostico[]\" rows=\"2\" class=\"form-control d-inline estdiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline esttratamiento\" name=\"esttratamiento[]\" value=\"".$urginfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".

                                            "<div class=\"col-2\">";

                                            if($urginfo[$i]["controlstart"]==''){
                                              $sms.="  <span class=\"estinicio\" name=\"estinicio[]\" ></span>";

                                            }else{
                                              if($urginfo[$i]["controlstart"]=='t'){
                                                $sms.="   <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }else{
                                                $sms.="   <input class=\"form-check-input estinicio\" name=\"estinicio[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>";

                                            $sms.="<div class=\"col-1\">";

                                            if($urginfo[$i]["controlend"]==''){

                                              $sms.="  <span class=\"estfin\" name=\"estfin[]\" ></span>";
                                            }else{
                                              if($urginfo[$i]["controlend"]=='t'){

                                                $sms.="   <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";


                                              }else{
                                                $sms.="   <input class=\"form-check-input estfin\" name=\"estfin[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>".


                                          "</div>".
                                          "</div>";
                                          echo $sms;
                                      }
                                    }


                                    ?>


                                  </div>

                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>

                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button class=\"btn btn-success\" id=\"estructural_button\" name=\"estructural_button\">Guardar</button>";
                                }
                                ?>

                              </div>

                            </div>

                            </div>
                          </div>
                          <!--modal estructural fin-->

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
                                      <div class="col-3">
                                        FECHA
                                      </div>
                                      <div class="col-2">
                                        PIEZAS
                                      </div>
                                      <div class="col-2">
                                        DIAGNOSTICO
                                      </div>
                                      <div class="col-2">
                                        TRATAMIENTO
                                      </div>
                                      <div class="col-1">
                                        SESIONES
                                      </div>
                                      <div class="col-1">
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
                                          "<div class=\"col-3\">".
                                          "  <input type=\"date\" id=\"\" class=\"form-control d-inline pulfecha\" name=\"pulfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline pulpieza\" name=\"pulpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                            "<textarea name=\"puldiagnostico[]\" rows=\"2\" class=\"form-control d-inline puldiagnostico\" readonly onmousedown=\"return false;\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline pultratamiento\" name=\"pultratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                          "</div>";

                                          $sms.="<div class=\"col-2\">".

                                          " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionpulpar$i\">Ver Sessiones</a>".


                                          "</div>";


                                          $sms.="<div class=\"col-1\">";

                                          if($inainfo[$i]["controlend"]==''){

                                            $sms.="  <span class=\"pulfin\" name=\"pulfin[]\" ></span>";
                                          }else{
                                            if($inainfo[$i]["controlend"]=='t'){

                                              $sms.="   <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";


                                            }else{
                                              $sms.="   <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
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
                                            "<input type=\"hidden\" name=\"pulpar\" idf=\"".$i."\" class=\"pulpar\" value=\"".$inainfo[$i]['controlid']."\" >".
                                            "<div class=\"col-3\">".
                                            "  <input type=\"date\" id=\"\" class=\"form-control d-inline pulfecha\" name=\"pulfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline pulpieza\" name=\"pulpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                              "<textarea name=\"puldiagnostico[]\" rows=\"2\" class=\"form-control d-inline puldiagnostico\" readonly onmousedown=\"return false;\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline pultratamiento\" name=\"pultratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                            "</div>";

                                            $sms.="<div class=\"col-2\">".

                                            "<div class='divchangeremove'>".

                                            " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionpulpar$i\">Ver Sessiones</a>".

                                            "</div>".

                                            "</div>";

                                            $sms.="<div class=\"col-1\">";

                                            if($inainfo[$i]["controlend"]==''){

                                              $sms.="  <span class=\"pulfin\" name=\"pulfin[]\" ></span>";
                                            }else{
                                              if($inainfo[$i]["controlend"]=='t'){

                                                $sms.="   <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";


                                              }else{
                                                $sms.="   <input class=\"form-check-input pulfin\" name=\"pulfin[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>".

                                          "</div>".

                                          "</div>";
                                          echo $sms;

                                      }
                                      $keymodals++;
                                    }

                                    ?>

                                  </div>

                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>

                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button type=\"submit\" class=\"btn btn-success\" id=\"pulpar_button\" name=\"pulpar_button\">Guardar</button>";
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
                              $valor=str_replace('datafirmo', "<span class=\"sessionpulpar$i text-success\" name=\"sessionpulpar".$i."[]\" ></span>", $valor);
                            }else{
                              if($inainfo[$i][$key."sessionpulpar-0"]=='t'){
                                $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }else{
                                $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }
                            }

                            if($inainfo[$i][$key."sessionpulpar-1"]==''){
                              $valor=str_replace('datafirmt', "<span class=\"sessionpulpar$i text-success\" name=\"sessionpulpar".$i."[]\" ></span>", $valor);
                            }else{
                              if($inainfo[$i][$key."sessionpulpar-1"]=='t'){
                                $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }else{
                                $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }
                            }

                            if($inainfo[$i][$key."sessionpulpar-2"]==''){
                              $valor=str_replace('datafirmh', "<span class=\"sessionpulpar$i text-success\" name=\"sessionpulpar".$i."[]\" ></span>", $valor);
                            }else{
                              if($inainfo[$i][$key."sessionpulpar-2"]=='t'){
                                $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }else{
                                $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }
                            }

                            if($inainfo[$i][$key."sessionpulpar-3"]==''){
                              $valor=str_replace('datafirmf', "<span class=\"sessionpulpar$i text-success\" name=\"sessionpulpar".$i."[]\" ></span>", $valor);
                            }else{
                              if($inainfo[$i][$key."sessionpulpar-3"]=='t'){
                                $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }else{
                                $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }
                            }


                            //click sessiones o firmado
                            //$valor=str_replace('datafirmo', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);

                            //$valor=str_replace('datafirmt', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
                            //$valor=str_replace('datafirmh', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
                            //$valor=str_replace('datafirmf', "<input class=\"form-check-input sessionpulpar".$i."\" name=\"sessionpulpar".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Solicitar</label></div>", $valor);
                            if ($isbutton) {
                              $valor=str_replace('buttonregistersession', "<button type=\"submit\" class=\"btn btn-success\" id=\"controlsession_button\" data-dismiss=\"modal\" name=\"controlsession_button\">Guardar</button>", $valor);
                            }else{
                              $valor=str_replace('buttonregistersession', "", $valor);
                            }
                            echo $valor;
                          }


                          ?>

                          <!--modal Rehabilitacion inicio-->
                          <div class="modal modal2 fade" role="dialog" id="rehabilitation">
                          <div class="modal-dialog modal-dialog2">
                            <div class="modal-content modal-content2">
                              <div class="modal-header">
                                <h3 class="modal-title">Rehabilitación</h3>
                                <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
                              </div>

                              <div class="modal-body">

                                <div class="from-group border border-primary rounded">
                                  <div class="container">

                                    <div class="row">
                                      <div class="col-3">
                                        FECHA
                                      </div>
                                      <div class="col-2">
                                        PIEZAS
                                      </div>
                                      <div class="col-2">
                                        DIAGNOSTICO
                                      </div>
                                      <div class="col-2">
                                        TRATAMIENTO
                                      </div>
                                      <div class="col-1">
                                        SESIONES
                                      </div>
                                      <div class="col-1">
                                        CONCLUSION
                                      </div>
                                    </div>

                                    <?php
                                    $keymodals=0;
                                    $inainfo=DBAllPediatricsiControlInfo($_GET['id'], 'rehabilitation');
                                    for ($i=0; $i < count($inainfo); $i++) {
                                      $sms='';
                                      if($i==0){
                                        $sms.= "<div id=\"informationrehabilitation\">".
                                        "<hr>".
                                        "<div class=\"row\">".
                                          "<input type=\"hidden\" name=\"rehabilitation\" idf=\"".$i."\" class=\"rehabilitation\" value=\"".$inainfo[$i]['controlid']."\">".
                                          "<div class=\"col-3\">".
                                          "  <input type=\"date\" id=\"\" class=\"form-control d-inline rehfecha\" name=\"rehfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline rehpieza\" name=\"rehpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                            "<textarea name=\"rehdiagnostico[]\" rows=\"2\" class=\"form-control d-inline rehdiagnostico\" readonly onmousedown=\"return false;\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline rehtratamiento\" name=\"rehtratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                          "</div>";

                                          $sms.="<div class=\"col-2\">".

                                          " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionrehabilitation$i\">Ver Sessiones</a>".


                                          "</div>";


                                          $sms.="<div class=\"col-1\">";

                                          if($inainfo[$i]["controlend"]==''){

                                            $sms.="  <span class=\"rehfin\" name=\"rehfin[]\" ></span>";
                                          }else{
                                            if($inainfo[$i]["controlend"]=='t'){

                                              $sms.="   <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";


                                            }else{
                                              $sms.="   <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
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
                                            "<input type=\"hidden\" name=\"rehabilitation\" idf=\"".$i."\" class=\"rehabilitation\" value=\"".$inainfo[$i]['controlid']."\" >".
                                            "<div class=\"col-3\">".
                                            "  <input type=\"date\" id=\"\" class=\"form-control d-inline rehfecha\" name=\"rehfecha[]\" value=\"".$inainfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline rehpieza\" name=\"rehpieza[]\" value=\"".$inainfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                              "<textarea name=\"rehdiagnostico[]\" rows=\"2\" class=\"form-control d-inline rehdiagnostico\" readonly onmousedown=\"return false;\">".$inainfo[$i]['controldiagnosis']."</textarea>".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline rehtratamiento\" name=\"rehtratamiento[]\" value=\"".$inainfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                            "</div>";

                                            $sms.="<div class=\"col-2\">".

                                            "<div class='divchangeremove'>".

                                            " <a class=\"btn btn-sm btn-success\" href=\"\" data-toggle=\"modal\" data-target=\"#sessionrehabilitation$i\">Ver Sessiones</a>".

                                            "</div>".

                                            "</div>";

                                            $sms.="<div class=\"col-1\">";

                                            if($inainfo[$i]["controlend"]==''){

                                              $sms.="  <span class=\"rehfin\" name=\"rehfin[]\" ></span>";
                                            }else{
                                              if($inainfo[$i]["controlend"]=='t'){

                                                $sms.="   <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";


                                              }else{
                                                $sms.="   <input class=\"form-check-input rehfin\" name=\"rehfin[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>".

                                          "</div>".

                                          "</div>";
                                          echo $sms;

                                      }
                                      $keymodals++;
                                    }

                                    ?>

                                  </div>

                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>

                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button type=\"submit\" class=\"btn btn-success\" id=\"rehabilitation_button\" name=\"rehabilitation_button\">Guardar</button>";
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

                            if($inainfo[$i][$key."sessionrehabilitation-0"]==''){
                              $valor=str_replace('datafirmo', "<span class=\"sessionrehabilitation$i text-success\" name=\"sessionrehabilitation".$i."[]\" ></span>", $valor);
                            }else{
                              if($inainfo[$i][$key."sessionrehabilitation-0"]=='t'){
                                $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }else{
                                $valor=str_replace('datafirmo', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }
                            }

                            if($inainfo[$i][$key."sessionrehabilitation-1"]==''){
                              $valor=str_replace('datafirmt', "<span class=\"sessionrehabilitation$i text-success\" name=\"sessionrehabilitation".$i."[]\" ></span>", $valor);
                            }else{
                              if($inainfo[$i][$key."sessionrehabilitation-1"]=='t'){
                                $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }else{
                                $valor=str_replace('datafirmt', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }
                            }

                            if($inainfo[$i][$key."sessionrehabilitation-2"]==''){
                              $valor=str_replace('datafirmh', "<span class=\"sessionrehabilitation$i text-success\" name=\"sessionrehabilitation".$i."[]\" ></span>", $valor);
                            }else{
                              if($inainfo[$i][$key."sessionrehabilitation-2"]=='t'){
                                $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }else{
                                $valor=str_replace('datafirmh', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }
                            }

                            if($inainfo[$i][$key."sessionrehabilitation-3"]==''){
                              $valor=str_replace('datafirmf', "<span class=\"sessionrehabilitation$i text-success\" name=\"sessionrehabilitation".$i."[]\" ></span>", $valor);
                            }else{
                              if($inainfo[$i][$key."sessionrehabilitation-3"]=='t'){
                                $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\" checked><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }else{
                                $valor=str_replace('datafirmf', "<input class=\"form-check-input sessionrehabilitation".$i."\" name=\"sessionrehabilitation".$i."[]\" type=\"checkbox\"><div><label class=\"form-check-label\">Firmar</label></div>", $valor);
                              }
                            }

                            if ($isbutton) {
                              $valor=str_replace('buttonregistersession', "<button type=\"submit\" class=\"btn btn-success\" id=\"controlsessionreh_button\" data-dismiss=\"modal\" name=\"controlsessionreh_button\">Enviar</button>", $valor);
                            }else{
                              $valor=str_replace('buttonregistersession', "", $valor);
                            }
                            echo $valor;
                          }

                          ?>


                          <!--modal cirugia inicio-->
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
                                      <div class="col-3">
                                        FECHA
                                      </div>
                                      <div class="col-2">
                                        PIEZAS
                                      </div>
                                      <div class="col-2">
                                        DIAGNOSTICO
                                      </div>
                                      <div class="col-2">
                                        TRATAMIENTO
                                      </div>
                                      <div class="col-1">
                                        FIRMA
                                      </div>
                                      <div class="col-1">
                                        CONCLUSION
                                      </div>
                                    </div>

                                    <?php
                                    $urginfo=DBAllPediatricsiControlInfo($_GET['id'], 'surgery');
                                    for ($i=0; $i < count($urginfo); $i++) {
                                      $sms='';
                                      if($i==0){
                                        $sms.= "<div id=\"informationsurgery\">".
                                        "<hr>".
                                        "<div class=\"row\">".
                                          "<input type=\"hidden\" name=\"cirugia\" class=\"cirugia\" value=\"".$urginfo[$i]['controlid']."\">".
                                          "<div class=\"col-3\">".
                                          "  <input type=\"date\" id=\"\" class=\"form-control d-inline cirfecha\" name=\"cirfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline cirpieza\" name=\"cirpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                            "<textarea name=\"cirdiagnostico[]\" rows=\"2\" class=\"form-control d-inline cirdiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                          "</div>".
                                          "<div class=\"col-2\">".
                                          "  <input type=\"text\" class=\"form-control d-inline cirtratamiento\" name=\"cirtratamiento[]\" readonly onmousedown=\"return false;\" value=\"".$urginfo[$i]['controltreatment']."\">".
                                          "</div>".
                                          "<div class=\"col-2\">";

                                          if($urginfo[$i]["controlstart"]==''){
                                            $sms.="  <span class=\"cirinicio\" name=\"cirinicio[]\" ></span>";

                                          }else{
                                            if($urginfo[$i]["controlstart"]=='t'){
                                              $sms.="   <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }else{
                                              $sms.="   <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>";

                                          $sms.="<div class=\"col-1\">";

                                          if($urginfo[$i]["controlend"]==''){

                                            $sms.="  <span class=\"cirfin\" name=\"cirfin[]\" ></span>";
                                          }else{
                                            if($urginfo[$i]["controlend"]=='t'){

                                              $sms.="   <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\" checked>".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";


                                            }else{
                                              $sms.="   <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\">".
                                              "   <div>".
                                              "     <label class=\"form-check-label\">Firmar</label>".
                                              "   </div>";
                                            }
                                          }

                                          $sms.="</div>".

                                        "</div>".
                                        "</div>";
                                        echo $sms;

                                      }else{
                                          $sms.= "<div>".

                                          "<hr>".
                                          "<div class=\"row\">".

                                            "<input type=\"hidden\" name=\"cirugia\" class=\"cirugia\" value=\"".$urginfo[$i]['controlid']."\">".
                                            "<div class=\"col-3\">".
                                            "  <input type=\"date\" id=\"\" class=\"form-control d-inline cirfecha\" name=\"cirfecha[]\" value=\"".$urginfo[$i]["controldate"]."\" min=\"2015-01-01\" max=\"2099-01-01\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline cirpieza\" name=\"cirpieza[]\" value=\"".$urginfo[$i]['controlpart']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                              "<textarea name=\"cirdiagnostico[]\" rows=\"2\" class=\"form-control d-inline cirdiagnostico\" readonly onmousedown=\"return false;\">".$urginfo[$i]['controldiagnosis']."</textarea>".
                                            "</div>".
                                            "<div class=\"col-2\">".
                                            "  <input type=\"text\" class=\"form-control d-inline cirtratamiento\" name=\"cirtratamiento[]\" value=\"".$urginfo[$i]['controltreatment']."\" readonly onmousedown=\"return false;\">".
                                            "</div>".

                                            "<div class=\"col-2\">";

                                            if($urginfo[$i]["controlstart"]==''){
                                              $sms.="  <span class=\"cirinicio\" name=\"cirinicio[]\" ></span>";

                                            }else{
                                              if($urginfo[$i]["controlstart"]=='t'){
                                                $sms.="   <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }else{
                                                $sms.="   <input class=\"form-check-input cirinicio\" name=\"cirinicio[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>";

                                            $sms.="<div class=\"col-1\">";

                                            if($urginfo[$i]["controlend"]==''){

                                              $sms.="  <span class=\"cirfin\" name=\"cirfin[]\" ></span>";
                                            }else{
                                              if($urginfo[$i]["controlend"]=='t'){

                                                $sms.="   <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\" checked>".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";


                                              }else{
                                                $sms.="   <input class=\"form-check-input cirfin\" name=\"cirfin[]\" type=\"checkbox\">".
                                                "   <div>".
                                                "     <label class=\"form-check-label\">Firmar</label>".
                                                "   </div>";
                                              }
                                            }

                                            $sms.="</div>".


                                          "</div>".
                                          "</div>";
                                          echo $sms;
                                      }
                                    }


                                    ?>


                                  </div>

                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>

                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['pediatricsistatus'])&&$pat['pediatricsistatus']!='fail'&&$pat['pediatricsistatus']!='canceled'&&$pat['pediatricsistatus']!='end'){
                                  echo "<button class=\"btn btn-success\" id=\"cirugia_button\" name=\"cirugia_button\">Guardar Cirugia</button>";
                                }
                                ?>

                              </div>

                            </div>

                            </div>
                          </div>
                          <!--modal cirugia fin-->





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
        <!--oleary-->
        <script type="text/javascript">
        function replaceAll(find, replace, str) {

            return str.replace(new RegExp(find, 'g'), replace);
        }

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
function designed(f){
  alert(f);
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




    //profilaxis register
    function registersesionp(){
      //alert('se envio no juego');
      if (confirm("Guardar Sesion?")) {
        var ficha = $('#ficha').val();
        var s1date1 = $('#session1date1').val();
        var s1date2 = $('#session1date2').val();
        var s1date3 = $('#session1date3').val();
        var s1desc = $('#session1desc').val();
        var s1evalued1 = $('select[name=session1evalued1]').val();
        var s1evalued2 = $('select[name=session1evalued2]').val();
        var s1evalued3 = $('select[name=session1evalued3]').val();
        $.ajax({

             url:"../include/i_session.php",
             method:"POST",
             data: {s1desc:s1desc, s1evalued1:s1evalued1,s1evalued2:s1evalued2, s1evalued3:s1evalued3, ficha:ficha, s1date1:s1date1, s1date2:s1date2, s1date3:s1date3},

             success:function(data)
             {
               alert(data);
             }
        });
      }
    }

    function registeroleary(){
      var olygram = $('#olygram').val()+'[xu='+$('#info').text()+']'+'[xt='+$('#info2').text()+']'+
      '[xr='+$('#info3').text()+']'+'[xdateu='+$('#date1').val()+']'+'[xdatet='+$('#date2').val()+']'+
      '[xdater='+$('#date3').val()+']'+'[xevaluedu='+$('select[name=evaluedoleary1]').val()+']'+
      '[xevaluedt='+$('select[name=evaluedoleary2]').val()+']'+'[xevaluedr='+$('select[name=evaluedoleary3]').val()+']';


      var ficha = $('#ficha').val();
          $.ajax({

             url:"../include/i_pediatrics.php",
             method:"POST",
             data: {olygram:olygram, ficha:ficha},

             success:function(data)
             {

               if(data=='yes'){
                 alert('Se envio o lary');
                 location.reload();
                 //location.href="index.php";
               }else{
                 alert(data);
                 console.log(data);
               }
             }
          });
    }

    $('#oleary_button').click(function(){
      registeroleary();
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
            iniciofirma+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              iniciofirma+='t,';
            }else{
              iniciofirma+='f,';
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
            finfirma+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              finfirma+='t,';
            }else{
              finfirma+='f,';
            }
          }
          conta++;
          //urgencias+=$(this).val()+'.:.';
       });
       //alert(iniciofirma);
       //$('#yesno0').prop('checked')
       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, urgencias:urgencias, urgfecha:urgfecha, urgpieza:urgpieza,
               urgdiagnostico:urgdiagnostico, urgtratamiento:urgtratamiento, iniciofirma:iniciofirma, finfirma:finfirma},

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
                location.reload();
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
     $('#inactivacion_button').click(function(){

       var ficha=$('#ficha').val();

       var inafecha='';
       $(".inafecha").each(function() {
          inafecha+=$(this).val()+',';
       });
       if(inafecha==''){
         return false;
       }
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
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            inainicio+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              inainicio+='t,';
            }else{
              inainicio+='f,';
            }
          }
          conta++;
       });
       var conta1=0;
       var inafin='';
       $(".inafin").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            inafin+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              inafin+='t,';
            }else{
              inafin+='f,';
            }
          }
          conta++;
       });
       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, inactivacion:inactivacion, inafecha:inafecha, inapieza:inapieza,
               inadiagnostico:inadiagnostico, inatratamiento:inatratamiento, inainicio:inainicio, inafin:inafin},

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

     });

     //Quimico
     $('#quimico_button').click(function(){

       var ficha=$('#ficha').val();

       var quifecha='';
       $(".quifecha").each(function() {
          quifecha+=$(this).val()+',';
       });
       if(quifecha==''){
         return false;
       }
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
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            quiinicio+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              quiinicio+='t,';
            }else{
              quiinicio+='f,';
            }
          }
          conta++;
       });
       var conta1=0;
       var quifin='';
       $(".quifin").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            quifin+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              quifin+='t,';
            }else{
              quifin+='f,';
            }
          }
          conta++;
       });
       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, quimico:quimico, quifecha:quifecha, quipieza:quipieza,
               quidiagnostico:quidiagnostico, quitratamiento:quitratamiento, quiinicio:quiinicio, quifin:quifin},

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

     });

     //Morfologico
     $('#morfologico_button').click(function(){

       var ficha=$('#ficha').val();

       var morfecha='';
       $(".morfecha").each(function() {
          morfecha+=$(this).val()+',';
       });
       if(morfecha==''){
         return false;
       }
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
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            morinicio+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              morinicio+='t,';
            }else{
              morinicio+='f,';
            }
          }
          conta++;
       });
       var conta1=0;
       var morfin='';
       $(".morfin").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            morfin+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              morfin+='t,';
            }else{
              morfin+='f,';
            }
          }
          conta++;
       });
       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, morfologico:morfologico, morfecha:morfecha, morpieza:morpieza,
               mordiagnostico:mordiagnostico, mortratamiento:mortratamiento, morinicio:morinicio, morfin:morfin},

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

     });
     //Estructural
     $('#estructural_button').click(function(){

       var ficha=$('#ficha').val();

       var estfecha='';
       $(".estfecha").each(function() {
          estfecha+=$(this).val()+',';
       });
       if(estfecha==''){
         return false;
       }
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
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            estinicio+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              estinicio+='t,';
            }else{
              estinicio+='f,';
            }
          }
          conta++;
       });
       var conta1=0;
       var estfin='';
       $(".estfin").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            estfin+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              estfin+='t,';
            }else{
              estfin+='f,';
            }
          }
          conta++;
       });
       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, estructural:estructural, estfecha:estfecha, estpieza:estpieza,
               estdiagnostico:estdiagnostico, esttratamiento:esttratamiento, estinicio:estinicio, estfin:estfin},

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

     });

     function pulpar(sw=true){
       var ficha=$('#ficha').val();

       var pulfecha='';
       $(".pulfecha").each(function() {
          pulfecha+=$(this).val()+',';
       });
       if(pulfecha==''){
         return false;
       }
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
              pulparsession+=',';
            }else{
              //console.log($(this)+"es checkbox"+conta);
              if($(this).prop('checked')==true){
                pulparsession+='t,';
              }else{
                pulparsession+='f,';
              }
            }

          });
          pulparsession+=']';
       });

       var conta=0;
       var pulfin='';
       $(".pulfin").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            pulfin+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              pulfin+='t,';
            }else{
              pulfin+='f,';
            }
          }
          conta++;
       });
       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, pulpar:pulpar, pulfecha:pulfecha, pulpieza:pulpieza,
               puldiagnostico:puldiagnostico, pultratamiento:pultratamiento, pulparsession:pulparsession, pulfin:pulfin},

            success:function(data)
            {

              if(data=='yes'){
                alert('Se envió los datos');
                if(sw){
                  location.reload();
                }

              }else{
                alert(data);
                console.log(data);
              }

            }
       });
     }

     //Pulpar
     $('#pulpar_button').click(function(){
       pulpar();

     });
     $("[name='controlsession_button']").click(function(){
       //alert('boton session');
       pulpar(false);
     });


     function rehabilitacion(sw=true){
       var ficha=$('#ficha').val();

       var rehfecha='';
       $(".rehfecha").each(function() {
          rehfecha+=$(this).val()+',';
       });

       if(rehfecha==''){
         return false;
       }

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
       var rehabilitationsession='';
       $(".rehabilitation").each(function() {
          rehabilitation+=$(this).val()+'.:.';
          key=$(this).attr('idf');

          rehabilitationsession+='[';
          //console.log(".sessionpulpar"+key);
          $(".sessionrehabilitation"+key).each(function() {
            //console.log($(this).prop('checked'));
            //pulparsession+=$(this).prop('checked')+',';

            if($(this).prop('checked')=== undefined){
              rehabilitationsession+=',';
            }else{
              //console.log($(this)+"es checkbox"+conta);
              if($(this).prop('checked')==true){
                rehabilitationsession+='t,';
              }else{
                rehabilitationsession+='f,';
              }
            }

          });
          rehabilitationsession+=']';
       });

       var conta=0;
       var rehfin='';
       $(".rehfin").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            rehfin+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              rehfin+='t,';
            }else{
              rehfin+='f,';
            }
          }
          conta++;
       });
       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, rehabilitation:rehabilitation, rehfecha:rehfecha, rehpieza:rehpieza,
               rehdiagnostico:rehdiagnostico, rehtratamiento:rehtratamiento, rehabilitationsession:rehabilitationsession, rehfin:rehfin},

            success:function(data)
            {

              if(data=='yes'){
                alert('Se envió los datos');
                if(sw){
                  location.reload();
                }

              }else{
                alert(data);
                console.log(data);
              }

            }
       });
     }

     //Rehabilitacion
     $('#rehabilitation_button').click(function(){
       rehabilitacion();

     });
     $("[name='controlsessionreh_button']").click(function(){
       //alert('boton session');
       rehabilitacion(false);
     });



     //Cirugia
     $('#cirugia_button').click(function(){

       var ficha=$('#ficha').val();

       var cirfecha='';
       $(".cirfecha").each(function() {
          cirfecha+=$(this).val()+',';
       });
       if(cirfecha==''){
         return false;
       }
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
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            cirinicio+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              cirinicio+='t,';
            }else{
              cirinicio+='f,';
            }
          }
          conta++;
       });
       var conta1=0;
       var cirfin='';
       $(".cirfin").each(function() {
          //console.log($(this));
          //console.log($(this).prop('checked'));
          if($(this).prop('checked')=== undefined){
            //console.log($(this)+"no es checkbox"+conta);
            cirfin+=',';
          }else{
            //console.log($(this)+"es checkbox"+conta);
            if($(this).prop('checked')==true){
              cirfin+='t,';
            }else{
              cirfin+='f,';
            }
          }
          conta++;
       });
       $.ajax({

            url:"../include/i_pediatrics.php",
            method:"POST",
            data: {ficha:ficha, cirugia:cirugia, cirfecha:cirfecha, cirpieza:cirpieza,
               cirdiagnostico:cirdiagnostico, cirtratamiento:cirtratamiento, cirinicio:cirinicio, cirfin:cirfin},

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

     });
});
</script>
