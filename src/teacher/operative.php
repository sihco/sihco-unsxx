<?php
require('header.php');

if(isset($_POST["designed"]) && isset($_POST["clinical"]) && $_POST["designed"]!="" && $_POST["clinical"]!=""){
  DBDesignedTeacher($_SESSION["usertable"]["usernumber"], $_POST['designed'], $_POST["clinical"]);
}

if(isset($_POST['desc']) && isset($_POST['evaluated']) &&
  isset($_POST['status']) && isset($_POST['id'])){
    if($_POST['status']=='--'){
        MSGError('Debe Seleccionar Status');
        ForceLoad('operative.php?id='.$_POST['id']);
    }
    $accepted='f';
    if($_POST['status']=='end')
      $accepted='t';
    if($accepted=='t'&&$_POST['evaluated']=='f'){
      MSGError('Debe seleccionar en Si la fila Revisado');
      ForceLoad('operative.php?id='.$_POST['id']);
    }

  DBEvaluateOperative($_POST['desc'], $_POST['evaluated'], $accepted, $_POST['status'], $_POST['id']);
  MSGError('Se guardó la revisión');
}
if(isset($_GET['id']) && $_GET['id']!=""){
  //echo "sadf";
  $f=DBOperativeInfo2($_GET['id']);
  $pat=DBOperativeInfo($_GET['id']);
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
                          <form class="" action="operative.php" method="post">
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
                                      echo " <a href=\"#\" class=\"btn btn-sm btn-primary\" style=\"font-weight:bold\" onClick=\"window.open('reportoperative.php?id=".$f['ficha']."#toolbar=0', ".
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
                              <textarea name="desc" id="desc" class="form-control" rows="8" ><?php if(isset($f['description'])) echo $f['description'];?></textarea>
                            </div>
                          </div>
                          <div class="container row">
                            <div class="">
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#procedimiento">Tabla de Tratamiento</a>
                              <a class="btn btn-success" href="" data-toggle="modal" data-target="#materials">Añadir Materiales</a>
                            </div>

                            <style media="screen">
                            .modal2{
                             padding: 0 !important;
                            }
                            .modal-dialog2 {
                              max-width: 90% !important;
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
                        <!--modal materials inicio-->
                        <div class="modal modal fade" role="dialog" id="materials">
                        <div class="modal-dialog modal-dialog">
                          <div class="modal-content modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title">Materiales</h3>
                              <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-12">
                                  <label for="materialtext"></label>
                                  <textarea name="materialtext" id="materialtext" class="form-control" rows="8" cols="80"><?php if($pat['operativematerial']) echo $pat["operativematerial"]; ?></textarea>
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
                                  echo "<button type=\"submit\" class=\"btn btn-success\" id=\"materials_button\" name=\"materials_button\">Guardar</button>";
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                        </div>
                        <!--modal materials fin-->
                        <!--modal start-->
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
                                  <!--formulario de envio-->
                                  <form name="form_treatment" id="form_treatment" method="post">
                                  <div class="row">
                                    <div class="col-12 table-responsive">

                                      <input type="hidden" name="idficha" id="idficha" value="<?php echo $_GET['id']; ?>">
                                      <table id="procedurestable" class="table table-bordered ">
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
                                                  $content.="<td> <span class=\"text-primary\">".$pat['tableprocedures']['pieza'][$i]."</span></td>";
                                                  $content.="<td> <span class=\"text-primary\">".$pat['tableprocedures']['clase'][$i]."</span></td>";
                                                  $content.="<td> <span class=\"text-primary\">".$pat['tableprocedures']['caries'][$i]."</span></td>";
                                                  $firm=explode('=', $pat['tableprocedures']['inicio'][$i]);
                                                  if($firm[0]==''){
                                                    $content.="<td></td>";
                                                  }else{
                                                    if($firm[0]=='t'){
                                                      $content.="<td>".
                                                      "  <input class=\"form-check-input ml-1\" name=\"inicio[]\" type=\"checkbox\" value=\"$i\" checked>".
                                                      "  <div class=\"ml-4\">".
                                                      "     <label class=\"form-check-label\">Firmar</label>".
                                                      "  </div>";
                                                      if(isset($firm[1])&&is_numeric($firm[1])){
                                                        $content.="  <div><span>".datetimeconv($firm[1])."</span></div>";
                                                      }
                                                      $content.="</td>";
                                                    }else{
                                                      $content.="<td>".
                                                      "  <input class=\"form-check-input ml-1\" name=\"inicio[]\" type=\"checkbox\" value=\"$i\">".
                                                      "  <div class=\"ml-4\">".
                                                      "     <label class=\"form-check-label\">Firmar</label>".
                                                      "  </div>".
                                                      "</td>";
                                                    }
                                                  }
                                                  $firm=explode('=', $pat['tableprocedures']['preparacion'][$i]);
                                                  if($firm[0]==''){
                                                    $content.="<td></td>";
                                                  }else{
                                                    if($firm[0]=='t'){
                                                      $content.="<td>".
                                                      "  <input class=\"form-check-input ml-1\" name=\"preparacion[]\" type=\"checkbox\" value=\"$i\" checked>".
                                                      "  <div class=\"ml-4\">".
                                                      "     <label class=\"form-check-label\">Firmar</label>".
                                                      "  </div>";
                                                      if(isset($firm[1])&&is_numeric($firm[1])){
                                                        $content.="  <div><span>".datetimeconv($firm[1])."</span></div>";
                                                      }
                                                      $content.="</td>";
                                                    }else{
                                                      $content.="<td>".
                                                      "  <input class=\"form-check-input ml-1\" name=\"preparacion[]\" type=\"checkbox\" value=\"$i\">".
                                                      "  <div class=\"ml-4\">".
                                                      "     <label class=\"form-check-label\">Firmar</label>".
                                                      "  </div>".
                                                      "</td>";
                                                    }
                                                  }
                                                  $firm=explode('=', $pat['tableprocedures']['cavitaria'][$i]);
                                                  if($firm[0]==''){
                                                    $content.="<td></td>";
                                                  }else{
                                                    if($firm[0]=='t'){
                                                      $content.="<td>".
                                                      "  <input class=\"form-check-input ml-1\" name=\"cavitaria[]\" type=\"checkbox\" value=\"$i\" checked>".
                                                      "  <div class=\"ml-4\">".
                                                      "     <label class=\"form-check-label\">Firmar</label>".
                                                      "  </div>";
                                                      if(isset($firm[1])&&is_numeric($firm[1])){
                                                        $content.="  <div><span>".datetimeconv($firm[1])."</span></div>";
                                                      }
                                                      $content.="</td>";
                                                    }else{
                                                      $content.="<td>".
                                                      "  <input class=\"form-check-input ml-1\" name=\"cavitaria[]\" type=\"checkbox\" value=\"$i\">".
                                                      "  <div class=\"ml-4\">".
                                                      "     <label class=\"form-check-label\">Firmar</label>".
                                                      "  </div>".
                                                      "</td>";
                                                    }
                                                  }
                                                  $content.="<td> <input type=\"text\" name=\"obturacion[]\" class=\"form-control\" value=\"".$pat['tableprocedures']['obturacion'][$i]."\"></td>";
                                                  $firm=explode('=', $pat['tableprocedures']['pulido'][$i]);
                                                  if($firm[0]==''){
                                                    $content.="<td></td>";
                                                  }else{
                                                    if($firm[0]=='t'){
                                                      $content.="<td>".
                                                      "  <input class=\"form-check-input ml-1\" name=\"pulido[]\" type=\"checkbox\" value=\"$i\" checked>".
                                                      "  <div class=\"ml-4\">".
                                                      "     <label class=\"form-check-label\">Firmar</label>".
                                                      "  </div>";
                                                      if(isset($firm[1])&&is_numeric($firm[1])){
                                                        $content.="  <div><span>".datetimeconv($firm[1])."</span></div>";
                                                      }
                                                      $content.="</td>";
                                                    }else{
                                                      $content.="<td>".
                                                      "  <input class=\"form-check-input ml-1\" name=\"pulido[]\" type=\"checkbox\" value=\"$i\">".
                                                      "  <div class=\"ml-4\">".
                                                      "     <label class=\"form-check-label\">Firmar</label>".
                                                      "  </div>".
                                                      "</td>";
                                                    }
                                                  }
                                                  $content.="</tr>";
                                                }

                                                if($content!=""){
                                                  echo $content;
                                                }
                                              }
                                              ?>
                                          </tbody>
                                      </table>

                                    </div>
                                    <div class="row">
                                      <div class="col-6">
                                        <label for="">Tratamientos(s) concluidos(s):</label>
                                        <input type="text" class="form-control" name="treatmentdesc" value="<?php if(isset($pat["treatmentdesc"])) echo $pat["treatmentdesc"];  ?>">
                                      </div>
                                      <div class="col-3">

                                        <label for="">Fecha:</label>
                                        <input type="date" class="form-control" name="treatmentdate" value="<?php if(isset($pat["treatmentdate"])) echo $pat["treatmentdate"];  ?>" min="2015-01-01" max="2099-01-01">
                                      </div>
                                      <div class="col-3">
                                        <label for="">Firma del docente</label>
                                        <br>
                                        <input class="form-check-input ml-1" name="treatmentfirm" type="checkbox" value="autoriza"  <?php if(isset($pat["treatmentfirm"])&&$pat['treatmentfirm']=='t') echo 'checked';  ?>>
                                        <div class="ml-4">
                                          <label class="form-check-label">Firmar</label>
                                        </div>
                                      </div>
                                    </div>
                                    </form>
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
                  location.reload();
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
     $('#materials_button').click(function(){
       var ficha=$('#ficha').val();
       var materials=$('#materialtext').val();
       console.log(materials);
       $.ajax({

          url:"../include/i_operative.php",
          method:"POST",
          data: {ficha:ficha, materials:materials},
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
