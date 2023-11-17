<?php
require('header.php');
if (!isset($_GET["name"])&&isset($_GET["logout"])) {
	//
	//para la validacion de login yes
	if (ValidSession2())
	  	DBLogOut($_SESSION["usertable2"]["usernumber"], $_SESSION["usertable2"]["username"]=='admin');
  unset($_SESSION["usertable2"]);
  ForceLoad("listadmission.php");
}

if(function_exists("globalconf") && function_exists("sanitizeVariables")) {

  if(isset($_GET["name"]) && $_GET["name"] != "" ) {

    	$name = $_GET["name"];
    	$password = $_GET["password"];
			//para login ... log....
    	$usertable = DBLogIn2($name, $password);
			ForceLoad("listadmission.php");
      exit;
  }
} else {
  echo "<script language=\"JavaScript\">\n";
  echo "alert('No se pueden cargar los archivos de configuración. Posible problema de permisos de archivos en el directorio SIHCO.');\n";
  echo "</script>\n";
}
//para actualizar un registro
if(!isset($upreferred)){
		$upreferred=true;
}
?>


            <!--inicio de div contenido-->
            <!--<div id="layoutSidenav_content">-->
              <!--inicio de main-->
                <main>

                    <div class="container-fluid px-2">
<?php if($main==true){ ?>
<!--tabla para pacientes remitidos inicio-->
<div class="row mt-1">
	<div class="col-6">
		<a class="btn btn-primary btn-sm" href="newadmission.php">Remitir Paciente</a>
		<a class="" href="report.php">Descargar Plantilla</a>
	</div>
	<div class="col-6" align="right">
		<a class="btn btn-success btn-sm" href="reportadmission.php">Reportes Admisión</a>
	</div>
</div>

<div class="text-center text-success m-2">
  <u><b>REGISTRO DE PACIENTES REMITIDOS</b></u>
</div>

<div class="table-responsive">
	<div class="row">

		<div class="col-12 mx-2 p-1 bg-secondary bg-opacity-10 border border-secondary">

			<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">

				<input type="checkbox" class="btn-check" id="removibleii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-success" for="removibleii">Prostodoncia Removible II</label>
				<input type="checkbox" class="btn-check" id="removibleiii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-success" for="removibleiii">Prostodoncia Removible III</label>
			</div>
			<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
				<input type="checkbox" class="btn-check" id="fijaii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-success" for="fijaii">Prostodoncia Fija II</label>
				<input type="checkbox" class="btn-check" id="fijaiii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-success" for="fijaiii">Prostodoncia Fija III</label>
			</div>
			<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
				<input type="checkbox" class="btn-check" id="dentalii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-warning" for="dentalii">Operatoria Dental II</label>
				<input type="checkbox" class="btn-check" id="dentaliii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-warning" for="dentaliii">Operatoria Dental III</label>
			</div>
			<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
				<input type="checkbox" class="btn-check" id="endodonciaii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-warning" for="endodonciaii">Endodoncia II</label>
				<input type="checkbox" class="btn-check" id="endodonciaiii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-warning" for="endodonciaiii">Endodoncia III</label>
			</div>
			<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
				<input type="checkbox" class="btn-check" id="bucalii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-primary" for="bucalii">Cirugia Bucal II</label>
				<input type="checkbox" class="btn-check" id="bucaliii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-primary" for="bucaliii">Cirugia Bucal III</label>
			</div>
			<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
				<input type="checkbox" class="btn-check" id="periodonciaii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-primary" for="periodonciaii">Periodoncia II</label>
				<input type="checkbox" class="btn-check" id="periodonciaiii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-primary" for="periodonciaiii">Periodoncia III</label>
			</div>
			<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
				<input type="checkbox" class="btn-check" id="pediatriai" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-danger" for="pediatriai">Odontopediatria I</label>
				<input type="checkbox" class="btn-check" id="pediatriaii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-danger" for="pediatriaii">Odontopediatria II</label>
			</div>
			<div class="btn-group-vertical btn-group-sm" role="group" aria-label="Small checkbox toggle button group">
				<input type="checkbox" class="btn-check" id="ortodonciai" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-danger" for="ortodonciai">Ortodoncia I</label>
				<input type="checkbox" class="btn-check" id="ortodonciaii" autocomplete="off" checked>
				<label style="font-size: 12px" class="btn btn-outline-danger" for="ortodonciaii">Ortodoncia II</label>
			</div>

		</div>
	</div>
	<style media="screen">
		td,th{
			text-align: center;
		}
		table{
			font-size: 15px
		}
	</style>
	<table class="table table-sm table-hover">
			<thead>
					<tr>
							<th style="width: 5%" scope="col">#</th>
							<th style="width: 20%" scope="col">
								<label for="patientname">Paciente</label>
								<input type="text" name="patientname" id="patientname" class="form-control form-control-sm" value="">
							</th>
							<th style="width: 15%" scope="col">
								Consulta
							</th>
							<th scope="col col-1">
								Diagnostico
							</th>
							<th scope="col" class="bg-secondary bg-opacity-10 border border-top-0 border-secondary">Remisión</th>
							<th scope="col">
								Est. Designado
								<input type="text" name="studentname" id="studentname" class="form-control form-control-sm" value="">

							</th>
							<th scope="col">
								Fecha de registro
								<div class="input-group input-group-sm">
									<input type="date" id="stdate" name="stdate" value="2023-01-01" max="<?php echo date('Y-m-d'); ?>" class="form-control">
									<span class="input-group-text" id="inputGroup-sizing-sm"><></span>
									<input type="date" id="endate" name="endate" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" class="form-control">
								</div>
							</th>

							<th scope="col">Acciones</th>
					</tr>
			</thead>
			<tbody id = "table-data">
				<!--Los datos se generan de forma automatica-->
			</tbody>
	</table>
	<div class='d-flex flex-wrap flex-sm-row justify-content-between' id="pagination-data">
		<!--Los datos se generan de forma automatica-->
	</div>
</div>

<div class="table-responsive" id="patienttable">
	<?php include("patientadmissiontable.php");?>
</div>
<script>
	//funcion que carga la paginacion o de cuanto en cuanto quiere que se muestre en la tabla
	function PatientDerivative(page){
		//  var selectDateI = document.getElementById("selectDateI2").value;
		var search = document.getElementById("search").value;
		var select = document.getElementById("selectPage").value;
		//alert(page+"   "+select);
		var formData = new FormData(); // Crear un objeto FormData vacío
		//formData.append('selectDateI', selectDateI);
		formData.append('search', search);
		formData.append('page', page);
		formData.append('select', select);
		$.ajax({
			url: "patientadmissiontable.php",
			type: "POST",
			data: formData,
			contentType: false, // Deshabilitar la codificación de tipo MIME
			processData: false, // Deshabilitar la codificación de datos
			success: function(data) {
		//  alert(data+"dasdas");
				$("#patienttable").html(data);
			}
		});
	}
</script>
<!--tabla para pacientes remitidos fin-->

                    </div>

                </main>

			<?php }else{ ?>
      <div class="row">
          <center>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                <div class="card shadow mb-4">
                  <script language="JavaScript" src="sha256.js"></script>
                  <script language="JavaScript">
                  function computeHASH()
                  {
                  	var userHASH, passHASH;
                  	userHASH = document.form1.username.value;
                  	passHASH = js_myhash(js_myhash(document.form1.userpassword.value)+'<?php echo session_id(); ?>');
                  	document.form1.username.value = '';
                  	document.form1.userpassword.value = '                                                                                 ';
                  	document.location = 'listadmission.php?name='+userHASH+'&password='+passHASH;
                  }
                  </script>

                  <form name="form1" action="javascript:computeHASH()">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">Validación De Datos</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="input-group">
                            <label class="input-group-text"  for="patientdatebirth">Usuario:</label>
                            <input type="text" name="username" id="username" class="form-control" value="">
                          </div>
                          <br>
                          <div class="input-group">
                            <label class="input-group-text"  for="patientdatebirth">Contraseña:</label>
                            <input type="password" name="userpassword" id="userpassword" class="form-control" value="">
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-12">
                          <input type="submit" class="btn btn-success" name="" value="Validar">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
          </center>
      </div>
    <?php } ?>
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
				<script src="../assets/graphic/sweetalert2.min.js"></script>
    </body>
</html>
<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>

<script>
function getdata(e, u, remid){


	Swal.fire({
	  title: e+'. Tu contraseña porfavor',
	  input: 'password',
	  inputAttributes: {
	    autocapitalize: 'off'
	  },
	  showCancelButton: true,
	  confirmButtonText: 'Entrar',
	  showLoaderOnConfirm: true,
	  preConfirm: (login) => {
			//password hash
			var userHASH, passHASH;
			userHASH = u;
			passHASH = js_myhash(js_myhash(login)+'<?php echo session_id(); ?>');

			return $.ajax({
				url: '../include/i_uservalid.php',
				method: 'POST',
				data: { name:userHASH, pass:passHASH},
				success: function (response) {
					return response;
				}, error: function (xhr, status, error){
					Swal.showValidationMessage(
	          `Debe introducir su contraseña: ${error}`
	        );
				}
			});
	    /*return fetch(`//api.github.com/users/${login}`)
	      .then(response => {
	        if (!response.ok) {
	          throw new Error(response.statusText)
	        }
	        return response.json()
	      })
	      .catch(error => {
	        Swal.showValidationMessage(
	          `Debe introducir su contraseña: ${error}`
	        )
	      })*/
	  },
	  allowOutsideClick: () => !Swal.isLoading()
	}).then((result) => {
	  if (result.isConfirmed) {
			if(result.value=='true'){
				Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Correcto',
				  showConfirmButton: false,
				  timer: 1500
				}).then(() => {
				  // Esta función se ejecutará después de que la notificación se cierre
				  location.href="surgeryii.php?id="+remid;
				});

			}else{
				Swal.fire({
		      title: `${'Contraseña incorrecta'}`,
		      imageUrl: result.value.avatar_url
		    })
			}


		}
	});
}
$(document).ready(function(){
		//setInterval(function(){
		//	PatientDerivative(1);
		//}, 1000);//actualizacion de cada segundo
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
<!--fin collapse-->
