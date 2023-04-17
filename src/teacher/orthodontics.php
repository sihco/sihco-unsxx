<?php
require('header.php');

if(isset($_POST["designed"]) && isset($_POST["clinical"]) && $_POST["designed"]!="" && $_POST["clinical"]!=""){
  DBDesignedTeacher($_SESSION["usertable"]["usernumber"], $_POST['designed'], $_POST["clinical"]);
}

if(isset($_POST['desc']) && isset($_POST['evaluated']) &&
  isset($_POST['status']) && isset($_POST['id'])){
    if($_POST['status']=='--'){
        MSGError('Debe Seleccionar Status');
        ForceLoad('orthodontics.php?id='.$_POST['id']);
    }
    $accepted='f';
    if($_POST['status']=='end')
      $accepted='t';
    if($accepted=='t'&&$_POST['evaluated']=='f'){
      MSGError('Debe seleccionar en Si la fila Revisado');
      ForceLoad('orthodontics.php?id='.$_POST['id']);
    }

  DBEvaluateOrthodontics($_POST['desc'], $_POST['evaluated'], $accepted, $_POST['status'], $_POST['id']);
  MSGError('Se guardó la revisión');
}
if(isset($_GET['id']) && $_GET['id']!=""){
  //echo "sadf";
  $f=DBOrthodonticsInfo2($_GET['id']);
  $pat=DBOrthodonticsInfo($_GET['id']);
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
                          <form class="" action="orthodontics.php" method="post">
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
                                      echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('reportorthodontics.php?id=".$f['ficha']."#toolbar=0', ".
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
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#impresiones">Toma de Impresiones</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#controles">Evolución y Controles</a>

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
                            .dienteb{
                              float: left;
                              display: inline-block;
                            }
                            .cursor:hover {
                                cursor: pointer;
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
                        <!--MODALS START-->
                        <!--inicio modal impresiones-->
                        <div class="">
                          <div class="modal modal2 fade" role="dialog" id="impresiones">
                          <div class="modal-dialog modal-dialog2">
                            <div class="modal-content modal-content2">

                              <div class="modal-header">
                                <h3 class="modal-title">TOMA DE IMPRESIONES</h3>

                                <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
                              </div>

                              <div class="modal-body">

                                <div class="from-group border border-success rounded">
                                  <div class="row">
                                    <div class="col-4">
                                      <label for="study">Estudio:</label>
                                      <?php
                                      $sms="<div class=\"ml-4\">";
                                      if($pat["orthodonticsstudy"]==''){
                                        $sms.="  <span class=\"study\" name=\"study\" id=\"study\" ></span>";
                                      }else{
                                        if($pat["orthodonticsstudy"]=='t'){
                                          $sms.="   <input class=\"form-check-input\" name=\"study\" id=\"study\" type=\"checkbox\" checked>".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"study\">Firmar</label>".
                                          "   </div>";
                                        }else{
                                          $sms.="   <input class=\"form-check-input\" name=\"study\" id=\"study\" type=\"checkbox\">".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"study\">Firmar</label>".
                                          "   </div>";
                                        }
                                      }
                                      $sms.="</div>";
                                      echo $sms;
                                      ?>
                                    </div>
                                    <div class="col-4">
                                      <label for="treatment">Trabajo:</label>
                                      <?php
                                      $sms="<div class=\"ml-4\">";
                                      if($pat["orthodonticstreatment"]==''){
                                        $sms.="  <span class=\"treatment\" name=\"treatment\" id=\"treatment\" ></span>";
                                      }else{
                                        if($pat["orthodonticstreatment"]=='t'){
                                          $sms.="   <input class=\"form-check-input\" name=\"treatment\" id=\"treatment\" type=\"checkbox\" checked>".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"treatment\">Firmar</label>".
                                          "   </div>";
                                        }else{
                                          $sms.="   <input class=\"form-check-input\" name=\"treatment\" id=\"treatment\" type=\"checkbox\">".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"treatment\">Firmar</label>".
                                          "   </div>";
                                        }
                                      }
                                      $sms.="</div>";
                                      echo $sms;
                                      ?>
                                    </div>
                                    <div class="col-4">
                                      <label for="design">Diseño:</label>
                                      <?php
                                      $sms="<div class=\"ml-4\">";
                                      if($pat["orthodonticsdesign"]==''){
                                        $sms.="  <span class=\"design\" name=\"design\" id=\"design\" ></span>";
                                      }else{
                                        if($pat["orthodonticsdesign"]=='t'){
                                          $sms.="   <input class=\"form-check-input\" name=\"design\" id=\"design\" type=\"checkbox\" checked>".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"design\">Firmar</label>".
                                          "   </div>";
                                        }else{
                                          $sms.="   <input class=\"form-check-input\" name=\"design\" id=\"design\" type=\"checkbox\">".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"design\">Firmar</label>".
                                          "   </div>";
                                        }
                                      }
                                      $sms.="</div>";
                                      echo $sms;
                                      ?>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-3">
                                      <label for="wire">Labrado de Alambre:</label>
                                      <?php
                                      $sms="<div class=\"ml-4\">";
                                      if($pat["orthodonticswire"]==''){
                                        $sms.="  <span class=\"wire\" name=\"wire\" id=\"wire\" ></span>";
                                      }else{
                                        if($pat["orthodonticswire"]=='t'){
                                          $sms.="   <input class=\"form-check-input\" name=\"wire\" id=\"wire\" type=\"checkbox\" checked>".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"wire\">Firmar</label>".
                                          "   </div>";
                                        }else{
                                          $sms.="   <input class=\"form-check-input\" name=\"wire\" id=\"wire\" type=\"checkbox\">".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"wire\">Firmar</label>".
                                          "   </div>";
                                        }
                                      }
                                      $sms.="</div>";
                                      echo $sms;
                                      ?>
                                    </div>
                                    <div class="col-3">
                                      <label for="wax">Encerado:</label>
                                      <?php
                                      $sms="<div class=\"ml-4\">";
                                      if($pat["orthodonticswax"]==''){
                                        $sms.="  <span class=\"wax\" name=\"wax\" id=\"wax\" ></span>";
                                      }else{
                                        if($pat["orthodonticswax"]=='t'){
                                          $sms.="   <input class=\"form-check-input\" name=\"wax\" id=\"wax\" type=\"checkbox\" checked>".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"wax\">Firmar</label>".
                                          "   </div>";
                                        }else{
                                          $sms.="   <input class=\"form-check-input\" name=\"wax\" id=\"wax\" type=\"checkbox\">".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"wax\">Firmar</label>".
                                          "   </div>";
                                        }
                                      }
                                      $sms.="</div>";
                                      echo $sms;
                                      ?>
                                    </div>
                                    <div class="col-3">
                                      <label for="making">Confección</label>
                                      <?php
                                      $sms="<div class=\"ml-4\">";
                                      if($pat["orthodonticsmaking"]==''){
                                        $sms.="  <span class=\"making\" name=\"making\" id=\"making\" ></span>";
                                      }else{
                                        if($pat["orthodonticsmaking"]=='t'){
                                          $sms.="   <input class=\"form-check-input\" name=\"making\" id=\"making\" type=\"checkbox\" checked>".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"making\">Firmar</label>".
                                          "   </div>";
                                        }else{
                                          $sms.="   <input class=\"form-check-input\" name=\"making\" id=\"making\" type=\"checkbox\">".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"making\">Firmar</label>".
                                          "   </div>";
                                        }
                                      }
                                      $sms.="</div>";
                                      echo $sms;
                                      ?>
                                    </div>
                                    <div class="col-3">
                                      <label for="acrylic">Autorización de Acrilizado:</label>
                                      <?php
                                      $sms="<div class=\"ml-4\">";
                                      if($pat["orthodonticsacrylic"]==''){
                                        $sms.="  <span class=\"acrylic\" name=\"acrylic\" id=\"acrylic\" ></span>";
                                      }else{
                                        if($pat["orthodonticsacrylic"]=='t'){
                                          $sms.="   <input class=\"form-check-input\" name=\"acrylic\" id=\"acrylic\" type=\"checkbox\" checked>".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"acrylic\">Firmar</label>".
                                          "   </div>";
                                        }else{
                                          $sms.="   <input class=\"form-check-input\" name=\"acrylic\" id=\"acrylic\" type=\"checkbox\">".
                                          "   <div>".
                                          "     <label class=\"form-check-label\" for=\"acrylic\">Firmar</label>".
                                          "   </div>";
                                        }
                                      }
                                      $sms.="</div>";
                                      echo $sms;
                                      ?>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="">
                                    <b><label for="">Instalación de Aparato Logia</label></b>
                                  </div>
                                  <div class="row">
                                    <?php
                                    if(isset($pat["orthodonticsfacility"])&&$pat["orthodonticsfacility"]!=''){
                                    ?>
                                    <div class="col-3">
                                      <input type="text" class="form-control" name="logiadesc" id="logiadesc" value="<?php if(isset($pat["logiadesc"])) echo $pat["logiadesc"];  ?>">
                                    </div>
                                    <div class="col-1">
                                      <?php
                                      $sms="<div class=\"ml-4\">";

                                      if((isset($pat["logiafirma"])&&$pat["logiafirma"]=='t')){
                                        $sms.="   <input class=\"form-check-input\" name=\"logiafirma\" id=\"logiafirma\" type=\"checkbox\" checked>".
                                        "   <div>".
                                        "     <label class=\"form-check-label\" for=\"logiafirma\">Firmar</label>".
                                        "   </div>";
                                      }else{
                                        $sms.="   <input class=\"form-check-input\" name=\"logiafirma\" id=\"logiafirma\" type=\"checkbox\">".
                                        "   <div>".
                                        "     <label class=\"form-check-label\" for=\"logiafirma\">Firmar</label>".
                                        "   </div>";
                                      }
                                      $sms.="</div>";
                                      echo $sms;
                                      ?>
                                    </div>
                                    <div class="col-4">
                                      <input type="date" id="logiadate" class="form-control d-inline" style="width:50%;"  name="logiadate" value="<?php if(isset($pat["logiadate"])) echo $pat["logiadate"];  ?>" min="2015-01-01" max="2099-01-01">
                                    </div>
                                    <?php
                                    }
                                    ?>
                                  </div>
                                  <br>
                                </div>

                              </div>

                              <div class="modal-footer">

                                <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
                                <?php
                                if((((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') ) || (!isset($pat['observationaccepted']))) &&isset($pat['orthodonticsstatus'])&&$pat['orthodonticsstatus']!='fail'&&$pat['orthodonticsstatus']!='canceled'&&$pat['orthodonticsstatus']!='end'){
                                  echo "<button type=\"submit\" class=\"btn btn-success\" id=\"impresiones_button\" name=\"impresiones_button\">Guardar</button>";
                                }
                                ?>

                              </div>

                            </div>

                            </div>
                          </div>

                        </div>
                        <!--fin modal impresiones-->
                        <!--modal plan inicio-->
                        <div class="modal modal2 fade" role="dialog" id="controles">
                        <div class="modal-dialog modal-dialog2">
                          <div class="modal-content modal-content2">
                            <div class="modal-header">
                              <h3 class="modal-title">EVOLUCIÓN Y CONTROLES</h3>
                              <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
                            </div>

                            <div class="modal-body">

                              <div class="from-group border border-primary rounded">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-12">
                                      <textarea name="controlesdesc" id="controlesdesc" rows="15" class="form-control plantxt"><?php if(isset($pat['orthodonticscontrols'])){ if($pat['orthodonticscontrols']==''){echo "1:  \n\n2:  \n\n3:  \n\n4:  \n\n5:  \n\n";}else{echo $pat['orthodonticscontrols'];}} ?></textarea>
                                    </div>
                                  </div>

                                </div>
                              </div>

                            </div>

                            <div class="modal-footer">

                              <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
                              <?php

                              if((isset($pat['orthodonticsstatus']) && $pat['orthodonticsstatus']!='fail'&&
                              $pat['orthodonticsstatus']!='canceled'&&$pat['orthodonticsstatus']!='end') &&
                              ( (isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f')||
                              (!isset($pat['observationaccepted'])) ) && ( (isset($pat['st']) && $pat['st']=='t')||(!isset($pat['st'])) ) ){
                                  echo "<button type=\"submit\" class=\"btn btn-success\" id=\"controles_button\" name=\"controles_button\">Guardar</button>";
                              }

                              ?>

                            </div>
                          </div>
                          </div>
                        </div>
                        <!--modal plan de tratamiento integral individualizado fin-->
                        <!--fin modal-->
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

     //Rehabilitacion
     $('#impresiones_button').click(function(){
       impresiones();

     });
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
