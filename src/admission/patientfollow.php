<?php
require('header.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
	//$pr = DBAllPatientRemissionInfo();
	if(($pr = DBAllPatientRemissionClinicalInfo(null, $_GET['id']))==null){
    ForceLoad("follow.php");
  }
}else{
	ForceLoad("follow.php");
}
$size=count($pr);
?>


            <!--inicio de div contenido-->
            <!--<div id="layoutSidenav_content">-->
              <!--inicio de main-->
                <main>

                    <div class="container-fluid px-2">
<!--tabla para pacientes remitidos inicio-->

<br>
<div class="text-center text-success">
  <u><b>HISTORIA CLÍNICA DEL PACIENTE</b></u>
</div>

<div class="container">
		<br>
		<div class="row">
			<div class="col-12">
				<div class="shadow p-3 mb-5 bg-body rounded">
					<div class="row">
						<div class="col-3">
							Nombres y Apellidos:
						</div>
						<div class="col-4">
							<span class="text-muted"><?php echo $pr[0]["patientname"].' '; echo $pr[0]["patientfirstname"].' '; echo $pr[0]["patientlastname"]; ?></span>
						</div>
						<div class="col-1">
							Edad:
						</div>
						<div class="col-2">
							<span class="text-muted"><?php echo $pr[0]["patientage"]; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-1">
							Dirección:
						</div>
						<div class="col-3">
							<span class="text-muted"><?php echo $pr[0]["patientdirection"]; ?></span>
						</div>
						<div class="col-1">
							Localidad:
						</div>
						<div class="col-2">
							<span class="text-muted"><?php echo $pr[0]["patientlocation"]; ?></span>
						</div>
						<div class="col-1">
							Telf:
						</div>
						<div class="col-2">
							<span class="text-muted"><?php echo $pr[0]["patientphone"]; ?></span>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-3">
							Motivo de consulta:
						</div>
						<div class="col-10">
							<span class="text-muted"><?php echo $pr[0]["motconsult"]; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<!--odontograma inicio-->
							<div class="panel panel-primary">

				          <div class="panel-heading">
				              <h3 class="panel-title text-muted">Odontograma</h3>
				          </div>
				          <!--cuerpo del panel-->

				              <script type="text/javascript">
				              function nextFocus(inputF, inputS) {
				                document.getElementById(inputF).addEventListener('keydown', function(event) {
				                  if (event.keyCode == 13) {
				                    document.getElementById(inputS).focus();
				                  }
				                });
				              }
				              </script>

				              <div class="row">
				                <div id="tr" class="col-12 col-sm-12 col-md-6 col-lg-6">
				                </div>
				                <div id="tl" class="col-12 col-sm-12 col-md-6 col-lg-6">
				                </div>
				                <div id="tlr" class="col-12 col-sm-12 col-md-6 col-lg-6 text-right">
				                </div>
				                <div id="tll" class="col-12 col-sm-12 col-md-6 col-lg-6">
				                </div>
				              </div>
				              <!--CERRAMOS UN FILA-->
				              <div class="row">
				                  <div id="blr" class="col-12 col-sm-12 col-md-6 col-lg-6 text-right">
				                  </div>
				                  <div id="bll" class="col-12 col-sm-12 col-md-6 col-lg-6">
				                  </div>
				                  <div id="br" class="col-12 col-sm-12 col-md-6 col-lg-6">
				                  </div>
				                  <div id="bl" class="col-12 col-sm-12 col-md-6 col-lg-6">
				                  </div>
				              </div>

				              <div class="container">
				                <!--INICIAMOS OTRA FILA-->
				                <div class="row">
				                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
				                      <div style="height: 20px; width:20px; display:inline-block;" class="click-red"></div> = Fractura/Caries
				                      <br>
				                      <div style="height: 20px; width:20px; display:inline-block;" class="click-blue"></div> = Obturado

				                      <br> Sellados = <i style="color:blue;" class="fa fa-solid fa-bacon fa-2x fa-fw"></i>

				                      <br> Extraido o Ausente = <i style="color:blue;" class="fa fa-solid fa-grip-lines fa-2x fa-fw"></i>
				                      <br>
				                      <span style="display:inline:block;"> Necrosis pulpar</span> = <img style="display:inline:block;" src="../images/extraccion.png">
				                      <br>
				                      <span style="display:inline:block;"> Coronas</span> = <img style="display:inline:block;" src="../images/pieza/corona.png">

				                      <br> Exodoncia Indicada = <i style="color:red;" class="fa fa-times fa-2x"></i>
				                    </div>
				                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">

				                        <textarea id="areadiagnostico" class="form-control border border-primary"  name="areadiagnostico" rows="7" readonly onmousedown="return false;"><?php if(isset($pat["description"])) echo $pat["description"];  ?></textarea>

				                    </div>


				                </div>
				              </div>



				              <!--CERRAMOS OTRA FILA-->

				      </div>
							        <?php
							        $odontogramstatus="false";
							        if (isset($pr[0]['draw'])){
							          $odontogramstatus="true";
							          $pat=decryptOdontogram($pr[0]);
							        }
							        ?>
							<!--odontograma fin-->
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="table-responsive ">

				<table class="table table-sm table-hover" id="table_admission">
				    <thead>
				        <tr>
				            <th scope="col">#</th>
				            <th scope="col">Fecha</th>
				            <th scope="col">Consulta</th>
				            <th scope="col">Diagnostico</th>
				            <th scope="col">Remision</th>
				            <th scope="col">Estudiante designado</th>
				            <th scope="col">Estado</th>
				        </tr>
				    </thead>
				    <tbody>


				<?php
				//$usr = DBAllUserInfo();

				//$pr = DBAllRemissionInfo(null, false, $limit);
				$namestatus=array(''=>'', 'new'=>'Nuevo', 'process'=>'En proceso', 'fail'=>'Abandonado', 'end'=>'Finalizado', 'canceled'=>'Anulado');

				for ($i=0; $i < $size; $i++) {
				      echo " <tr>\n";
				      echo "   <td>" . ($size-$i) . "</td>";
				      echo "   <td><a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\">" . datetimeconv($pr[$i]["updatetime"]) ."</a></td>";
				      echo "   <td>" . $pr[$i]["motconsult"] . "</td>";
				      echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";

							echo "   <td>";
							if($pr[$i]['remission']!=null){
								$size2=count($pr[$i]['remission']);
								for ($j=0; $j < $size2 ; $j++) {
										$namesp = $pr[$i]['remission'][$j]['clinicalspecialty'];
										if (isset($pr[$i]['remission'][$j]["inputfile"])&& $pr[$i]['remission'][$j]["inputfile"] != null) {
							        $tx = $pr[$i]['remission'][$j]["inputfilehash"];
							        echo "<a href=\"#\" class=\"btn btn-sm btn-outline-primary\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".filedownload($pr[$i]['remission'][$j]["inputfile"], $pr[$i]['remission'][$j]["inputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\">$namesp</a>";
							        
							      }else{
											echo $namesp;
										}
								}
							}
							echo "</td>";

							echo "   <td>";
							if($pr[$i]['remission']!=null){
								$size2=count($pr[$i]['remission']);
								for ($j=0; $j < $size2 ; $j++) {
										$in=DBUserInfo($pr[$i]['remission'][$j]['studentid']);

										echo $in['userfullname'].' ';


								}
							}
							echo "</td>";


							//echo "   <td>".$in['userfullname']."</td>";

							echo "   <td>";
							if($pr[$i]['remission']!=null){
								$size2=count($pr[$i]['remission']);
								for ($j=0; $j < $size2 ; $j++) {
										echo $namestatus[$pr[$i]['remission'][$j]['status']];

								}
							}
							echo "</td>";
				      echo "</tr>";
				}
				echo "</tbody></table>\n";

				?>
				</div>

				<!--tabla para pacientes remitidos fin-->
			</div>
		</div>
</div>







                    </div>
                </main>
                <!--pie de pagina-->
								<footer class="py-4 bg-light mt-auto">
						        <div class="container-fluid px-4">
						            <div class="d-flex align-items-center justify-content-between small">
						                <div class="text-muted">UNSXX &copy; Clinica Odontologica 2022-2023</div>
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
				<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>-->
				<script src="../assets/graphic/bootstrap/js/bootstrap.bundle.min.js"></script>
				<script src="../js/scripts.js"></script>
				<script src="../assets/graphic/jquery-3.5.1.min.js"></script>
				<script src="../assets/graphic/chart.js"></script>

<!--odontograma inicio js-->
<!-- jQuery -->
<!--<script src="../jquery-1.10.2.min.js"></script>-->
<!-- Bootstrap JavaScript -->
<!--<script src="../tools/bootstrap/bootstrap.js"></script>-->
<!--ABRIMOS JAVASCRIPT-->
<?php
include("../leftodontogramjs.php");
?>


<!--odontograma fin js-->



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



    $(".btn-primary").click(function(){
        $(".fffa").collapse('toggle');
    });
    $(".btn-success").click(function(){
        $(".fffa").collapse('show');
    });
    $(".btn-warning").click(function(){
        $(".fffa").collapse('hide');
    });
    $(".fffa").on('show.bs.collapse', function(){
        alert('The collapsible content is about to be shown.');
    });
    $(".fffa").on('shown.bs.collapse', function(){
        alert('The collapsible content is now fully shown.');
    });
    $(".fffa").on('hide.bs.collapse', function(){
        alert('The collapsible content is about to be hidden.');
    });
    $(".fffa").on('hidden.bs.collapse', function(){
        alert('The collapsible content is now hidden.');
    });
    $(".sierra").on('hide.bs.collapse', function(){
        alert('The collapsible content is about to be hidden.');
    });
    $(".sierra").on('hidden.bs.collapse', function(){
        alert('The collapsible content is now hidden.');
    });
});
</script>
<!--fin collapse-->
