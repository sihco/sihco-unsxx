<?php
require('header.php');
?>


                    <div class="container-fluid px-4">

                        <h1 class="mt-4">MODULOS DE LA CLINICA</h1>
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
                        <div class="table-responsive">

                          <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Paciente</th>
                                    <th scope="col">Consulta</th>
                                    <th scope="col">Diagnostico Admission</th>
                                    <th scope="col">Diagnostico</th>
                                    <th scope="col">Especilidad</th>
                                    <th scope="col">Docente</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>


                        <?php
                        //$usr = DBAllUserInfo();
                        $color=array(''=>'', 'new'=>'table-default', 'process'=>'table-primary text-primary', 'fail'=>'table-danger', 'end'=>'table-success text-success', 'canceled'=>'table-dark');
                        $namestatus=array(''=>'', 'new'=>'Nuevo', 'process'=>'En proceso', 'fail'=>'Abandonado', 'end'=>'Finalizado', 'canceled'=>'Anulado');

                        $pr = array();
                        if(isset($_GET['id'])&&is_numeric($_GET['id'])){
                          $pr = DBRemissionInfo($_GET['id'], true);
                        }
                        $size=count($pr);
                        for ($i=0; $i < $size; $i++) {
                              if(!isset($pr[$i]['ficha'])&&!isset($pr[$i]['status'])){
                                continue;
                              }

                              if(isset($pr[$i]['status'])&&isset($color[$pr[$i]['status']]))
                                echo " <tr class=\"".$color[$pr[$i]['status']]."\">\n";
                              else
                                echo " <tr class==\"\">\n";
                              echo "   <td>" . ($size-$i) . "</td>";
                              echo "   <td>" . $pr[$i]["fullname"] . "</td>";
                              echo "   <td>" . $pr[$i]["consult"] . "</td>";
                              echo "   <td>" . $pr[$i]["diagnostico"] . "</td>";
                              if(isset($pr[$i]["diagnosisd"]))
                                echo "   <td>" . $pr[$i]["diagnosisd"] . "</td>";
                              else
                                echo " <td></td>";
                              echo "   <td>" . $pr[$i]["remission"] . "</td>";
                              if(isset($pr[$i]["teacher"]) && $pr[$i]["teacher"]!=0){
                                $info=DBUserInfo($pr[$i]["teacher"]);
                                echo "   <td>" . $info["userfullname"] . "</td>";
                              }else{
                                echo "   <td>No designado</td>";
                              }
                              $name="";
                              $url="";
                              if(isset($pr[$i]["status"])){

                                echo "   <td>" . $namestatus[$pr[$i]["status"]] . "</td>";
                                if($pr[$i]["status"]=='new')
                                  $name='Nuevo';
                                else
                                  $name='Actualizar';
                                $url=$pr[$i]['clinicalname'].".php";
                              }else{
                                echo "  <td></td>";
                                $name='---';
                                $url='index.php';
                              }

                              if(isset($pr[$i]["timef"]))
                                echo "   <td>" . dateconv($pr[$i]["timef"]) . "</td>";
                              else
                                echo "<td></td>";
                              $ficha="";
                              if(isset($pr[$i]["ficha"])){
                                $ficha=$pr[$i]["ficha"];
                              }
                              if(!isset($pat['observationaccepted']) || (isset($pat['observationaccepted'])&&$pat['observationaccepted']==false)){
                                echo " <td><div class=\"btn-group\"> <a href=\"$url?id=$ficha\" class=\"btn btn-primary btn-sm\" name=\"\" >$name</a><a href=\"#\" class=\"btn btn-sm btn-success\" style=\"font-weight:bold\" onClick=\"window.open('report$url?id=".$ficha."#toolbar=0', ".
                                "'Visualizar Ficha','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
                                "resizable=yes')\">Ver</a></div></td>";
                              }else{
                                echo " <td><div class=\"btn-group\"> <a href=\"$url?id=$ficha\" class=\"btn btn-primary btn-sm\" name=\"\" >$name</a><a href=\"#\" class=\"btn btn-sm btn-success\" style=\"font-weight:bold\" onClick=\"window.open('report$url?id=".$ficha."#toolbar=0', ".
                                "'Visualizar Ficha','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
                                "resizable=yes')\">Ver</a></div></td>";
                              }

                              echo "</tr>";
                        }
                        echo "</tbody></table>\n";

                        ?>
                      </div>
                    </div>






<?php
require('footer.php');
?>
