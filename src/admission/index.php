<?php
require('header.php');

if (isset($_GET["limit"]) && is_numeric($_GET['limit']) && $_GET["limit"]>0)
  $limit = myhtmlspecialchars($_GET["limit"]);
else $limit = 500;
?>


              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">PACIENTES REMITIDOS</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">MODULO PROSTODONCIA</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=1">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==1?"<b><u>PROSTODONCIA REMOVIBLE II</b></u>":"PROSTODONCIA REMOVIBLE II";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=2">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==2?"<b><u>PROSTODONCIA FIJA II</b></u>":"PROSTODONCIA FIJA II";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=9">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==9?"<b><u>PROSTODONCIA REMOVIBLE III</b></u>":"PROSTODONCIA REMOVIBLE III";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=10">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==10?"<b><u>PROSTODONCIA FIJA III</b></u>":"PROSTODONCIA FIJA III";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">MODULO OPERATORIA</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=3">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==3?"<b><u>OPERATORIA DENTAL II</b></u>":"OPERATORIA DENTAL II";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=4">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==4?"<b><u>ENDODONCIA II</b></u>":"ENDODONCIA II";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=11">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==11?"<b><u>OPERATORIA DENTAL III</b></u>":"OPERATORIA DENTAL III";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=12">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==12?"<b><u>ENDODONCIA III</b></u>":"ENDODONCIA III";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!--PARA MODULOS DE CIRUGIA II-->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">MODULO CIRUGIA</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=5">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==5?"<b><u>CIRUGIA BUCAL II</b></u>":"CIRUGIA BUCAL II";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>

                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=6">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==6?"<b><u>PERIODONCIA II</b></u>":"PERIODONCIA II";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=13">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==13?"<b><u>CIRUGIA BUCAL III</b></u>":"CIRUGIA BUCAL III";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=14">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==14?"<b><u>PERIODONCIA III</b></u>":"PERIODONCIA III";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">MODULO ODONTOPEDIATRIA</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=7">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==7?"<b><u>ODONTOPEDIATRIA I</b></u>":"ODONTOPEDIATRIA I";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=8">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==8?"<b><u>ORTODONCIA I</b></u>":"ORTODONCIA I";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=15">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==15?"<b><u>ODONTOPEDIATRIA II</b></u>":"ODONTOPEDIATRIA II";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white" href="index.php?id=16">
                                          <?php
                                          echo isset($_GET['id'])&&$_GET['id']==16?"<b><u>ORTODONCIA II</b></u>":"ORTODONCIA II";
                                          ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-1 col-md-1 col-sm-2 col-2">
                            <label for="listar" class="text-primary"><u><b>Listar:</b></u></label>
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-5 col-5">
                            <select name="listar" id="listar" onchange="ListLog()" class="form-select" aria-label="Default select example">
                              <option <?php if(isset($limit)&&is_numeric($limit)&&$limit<=50) echo "selected"; ?> value="50">50 registros</option>
                              <option <?php if(isset($limit)&&is_numeric($limit)&&$limit>50&&$limit<=100) echo "selected"; ?> value="100">100 registros</option>
                              <option <?php if(isset($limit)&&is_numeric($limit)&&$limit>100&&$limit<=500) echo "selected"; ?> value="500">500 registros</option>
                              <option <?php if(isset($limit)&&is_numeric($limit)&&$limit>500) echo "selected"; ?> value="1000000">Sin limite</option>
                            </select>
                            <script>
                              function ListLog() {
                                var number=document.getElementById("listar").value;
                                location.href="index.php?limit="+number;
                              }
                            </script>
                          </div>
                        </div>

                        <table class="table table-responsive table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Paciente</th>
                                    <th scope="col">Consulta</th>
                                    <th scope="col">Diagnostico</th>
                                    <th scope="col">Remision</th>
                                    <th scope="col">Examinado</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>


                        <?php
                        //$usr = DBAllUserInfo();

                        $pr = DBAllPatientRemissionClinicalInfo();
                        if(isset($_GET['id'])&& is_numeric($_GET['id'])){
                          $pr = DBAllPatientRemissionClinicalInfo($_GET['id']+1);
                        }
                        //$pr = DBAllRemissionInfo(null, false, $limit);
                        $size=count($pr);
                        for ($i=0; $i < $size; $i++) {
                              echo " <tr>\n";
                              echo "   <td>" . ($size-$i) . "</td>";
                              echo "   <td>" . $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</td>";
                              echo "   <td>" . $pr[$i]["motconsult"] . "</td>";
                              echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";

                        			echo "   <td>";
                        			if($pr[$i]['remission']!=null){
                        				$size2=count($pr[$i]['remission']);
                        				for ($j=0; $j < $size2 ; $j++) {
                        						echo $pr[$i]['remission'][$j]['clinicalspecialty'];
                        				}
                        			}
                        			echo "</td>";
                        			$in=DBUserInfo($pr[$i]['studentid']);
                        			echo "   <td>".$in['userfullname']."</td>";

                        			echo "   <td>" . datetimeconv($pr[$i]["updatetime"]) ."</td>";
                              echo "   <td><div class=\"btn-group\"><a href=\"admission.php?id=" .
                                $pr[$i]["patientadmissionid"] . "#patient\" class=\"btn btn-primary btn-sm\" name=\"\" >Actualizar</a><a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Imprimir</a></div></td>";

                              echo "</tr>";
                        }
                        echo "</tbody></table>\n";

                        ?>


                    </div>

<?php
require('footer.php');
?>
