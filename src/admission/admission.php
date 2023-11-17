<?php
require('header.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  if(($pat=DBPatientRemissionInfo($id))==null){
    ForceLoad("newadmission.php");
  }
}

//para actualizar un registro
if(!isset($upreferred)){
		$upreferred=true;
}
?>

<div class="container-fluid px-2">

	<div class="accordion" id="accordionPanelsStayOpenExample">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
	      <button class="accordion-button btn-link text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
	        <a href="listadmission.php" class="text-warning"><i class="fa fa-solid fa-reply-all"></i></a>&nbsp;&nbsp;&nbsp; Datos Personales O Filiación
	      </button>
	    </h2>
	    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
	      <div class="accordion-body">
					<!--formulario para paciente inicio-->
					<!--id para paciente-->
					<input type="hidden" name="padmissionid" id="padmissionid" value="<?php if(isset($pat["patientadmissionid"])) echo $pat["patientadmissionid"];  ?>">
					<div class="from-group">


					    <div class="row">
					      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
					        <font size="2"><span class="text-danger">Todos los campos con * son requeridos</span></font>
					      </div>
					      <div class="col-lg-6 col-md-6 col-sm-12 col-12">
					        <div class="row">
					          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
					            Fecha Hora de registro:
					          </div>
					          <div class="col-lg-6 col-md-6 col-sm-12 col-12">
					            <input type="datetime-local" id="meeting-time"
					       name="meeting-time" value="<?php  if(isset($pat['updatetime'])&&is_numeric($pat['updatetime'])&& $upreferred==true){
					         echo datetimeconv($pat['updatetime'],true); }else{echo datetimeconv(time(),true);}?>"
					       min="2000-01-01T00:00" max="2100-01-01T00:00" class="form-control">
					          </div>
					        </div>
					      </div>
					    </div>
					    <div class="row">
								<div class="col-12">
									<a href="" data-bs-toggle="modal" data-bs-target="#modalname">Nombres y Apellidos</a><span class="text-danger">*</span>
					        <!--<input type="text" name="patientfullname" class="form-control" id="patientfullname" value="<?php //echo $a["username"]; ?>"> readonly="readonly"-->
									<input type="hidden" name="mod" id="mod" value="<?php if($upreferred == true){echo "update";}else{echo "new";}?>">

									<!--Modal cambio de nombre inicio-->

									<div class="modal fade" id="modalname" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar Nombre Paciente</h1>
									        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									      </div>
									      <div class="modal-body">
									        <div class="row">
														<input type="hidden" name="patientidchange" id="patientidchange" value="<?php if(isset($pat["patientid"])) echo $pat["patientid"];  ?>">
														<div class="col-12">
															<div class="input-group">
																	<label for="patientnamemodal" class="input-group-text">Nombres</label>
																	<label for="patientfirstnamemodal" class="input-group-text">A. Paterno</label>
																	<label for="patientlastnamemodal" class="input-group-text">A. Materno</label>
															</div>
														</div>
														<div class="col-12">
															<div class="input-group">
																	<input type="text" class="form-control" id="patientnamemodal" name="patientnamemodal" autocomplete="off" value="<?php if(isset($pat["patientname"])) echo $pat["patientname"];  ?>">
																	<input type="text" class="form-control" id="patientfirstnamemodal" name="patientfirstnamemodal" autocomplete="off" value="<?php if(isset($pat["patientfirstname"])) echo $pat["patientfirstname"];  ?>">
																	<input type="text" class="form-control" id="patientlastnamemodal" name="patientlastnamemodal" autocomplete="off" value="<?php if(isset($pat["patientlastname"])) echo $pat["patientlastname"];  ?>">
															</div>
														</div>
									        </div>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
									        <button type="button" class="btn btn-primary" id="patientchange">Guardar Cambios</button>
									      </div>
									    </div>
									  </div>
									</div>
									<!--Modal cambio de nombre fin-->

								</div>
								<div class="col-12">
									<div class="input-group">
					            <label for="patientname" class="input-group-text">Nombres</label>
					            <label for="patientfirstname" class="input-group-text">A. Paterno</label>
					            <label for="patientlastname" class="input-group-text">A. Materno</label>


											<div class="dropdown">
												<?php
												if($upreferred == true){
													echo "<input type=\"text\" class=\"form-control text-primary\" id=\"patientname\" name=\"patientname\" value=\"".
													( (isset($pat["patientname"])?$pat["patientname"]:'') )."\" autocomplete=\"off\" data-bs-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" readonly>";
												}else{
													echo "<input type=\"text\" class=\"form-control\" id=\"patientname\" name=\"patientname\" value=\"".
													( (isset($pat["patientname"])?$pat["patientname"]:'') )."\" autocomplete=\"off\" data-bs-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
												}
												?>
												<div class="dropdown-menu" aria-labelledby="search" id="result1">
							          </div>
							        </div>
											<div class="dropdown">
												<?php
												if($upreferred == true){
													echo "<input type=\"text\" class=\"form-control text-primary\" id=\"patientfirstname\" name=\"patientfirstname\" value=\"".
													( (isset($pat["patientfirstname"])?$pat["patientfirstname"]:'') )."\" autocomplete=\"off\" data-bs-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" readonly>";
												}else{
													echo "<input type=\"text\" class=\"form-control\" id=\"patientfirstname\" name=\"patientfirstname\" value=\"".
													( (isset($pat["patientfirstname"])?$pat["patientfirstname"]:'') )."\" autocomplete=\"off\" data-bs-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
												}
												?>
												<div class="dropdown-menu" aria-labelledby="search" id="result2">
							          </div>
							        </div>
											<div class="dropdown">
												<?php
												if($upreferred == true){
													echo "<input type=\"text\" class=\"form-control text-primary\" id=\"patientlastname\" name=\"patientlastname\" value=\"".
													( (isset($pat["patientlastname"])?$pat["patientlastname"]:'') )."\" autocomplete=\"off\" data-bs-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" readonly>";
												}else{
													echo "<input type=\"text\" class=\"form-control\" id=\"patientlastname\" name=\"patientlastname\" value=\"".
													( (isset($pat["patientlastname"])?$pat["patientlastname"]:'') )."\" autocomplete=\"off\" data-bs-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
												}
												?>
												<div class="dropdown-menu" aria-labelledby="search" id="result3">
							          </div>
							        </div>
									</div>
								</div>
					    </div>

					</div>

					<br>
					<div class="from-group">

					  <div class="row">
					    <div class="col-6">
					      <label for="patientdirection">Direccion</label><span class="text-danger">*</span>
					      <input type="text" name="patientdirection" class="form-control" id="patientdirection" value="<?php if(isset($pat["patientdirection"])) echo $pat["patientdirection"];  ?>">
					    </div>
					    <div class="col-6">
					      <label for="patientlocation">Localidad</label><span class="text-danger">*</span>
					      <input type="text" name="patientlocation" class="form-control" id="patientlocation" value="<?php if(isset($pat["patientlocation"])) echo $pat["patientlocation"];  ?>">
					    </div>
					  </div>

					</div>
					<br>
					<div class="from-group">

					  <div class="row">
					    <div class="col-6">
					      <label for="patientage">Edad</label><span class="text-danger">*</span>
					      <input type="number" min="0" name="patientage" class="form-control" id="patientage" value="<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?>">
					    </div>
					    <div class="col-6">
					      <label for="patientprovenance">Procedencia</label><span class="text-danger">*</span>
					      <input type="text" name="patientprovenance" class="form-control" id="patientprovenance" value="<?php if(isset($pat["patientprovenance"])) echo $pat["patientprovenance"];  ?>">
					    </div>
					  </div>

					</div>
					<br>
					<div class="from-group">

					  <div class="row">
					    <div class="col-6">
					      <label for="patientphone">Tel.</label>
					      <input type="text" name="patientphone" class="form-control" id="patientphone" maxlength="9" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" value="<?php if(isset($pat["patientphone"])) echo $pat["patientphone"];  ?>">
					    </div>
					    <div class="col-6">
					      <label for="patientgender">Genero</label><span class="text-danger">*</span>
					      <select name="patientgender" class="form-select" aria-label="Default select example">
					        <option <?php if(!isset($pat) || $pat["patientgender"] == '--') echo "selected"; ?> value="--">--</option>
					        <option <?php if(isset($pat) && $pat["patientgender"] == 'masculino') echo "selected"; ?> value="masculino">Masculino</option>
					        <option <?php if(isset($pat) && $pat["patientgender"] == 'femenino') echo "selected"; ?> value="femenino">Femenino</option>
					      </select>

					    </div>
					  </div>

					</div>
					<br>
					<div class="from-group">

					  <div class="row">
					    <div class="col-6">
					      <label for="patientcivilstatus">Estado Civil</label><span class="text-danger">*</span>
					      <!--<input type="text" name="patientcivilstatus" class="form-control" id="patientcivilstatus" value="<?php //if(isset($pat["patientcivilstatus"])) echo $pat["patientcivilstatus"];  ?>">-->
								<select name="patientcivilstatus" id="patientcivilstatus" class="form-select">
						      <option <?php if(!isset($pat) || $pat["patientcivilstatus"] == '--') echo "selected"; ?> value="--">--</option>
						      <option <?php if(isset($pat) && $pat["patientcivilstatus"] == 'soltero') echo "selected"; ?> value="soltero">Soltero(a)</option>
						      <option <?php if(isset($pat) && $pat["patientcivilstatus"] == 'casado') echo "selected"; ?> value="casado">Casado(a)</option>
						      <option <?php if(isset($pat) && $pat["patientcivilstatus"] == 'conviviente') echo "selected"; ?> value="conviviente">Conviviente</option>
						      <option <?php if(isset($pat) && $pat["patientcivilstatus"] == 'anulado') echo "selected"; ?> value="anulado">Divorciado(a)</option>
						      <option <?php if(isset($pat) && $pat["patientcivilstatus"] == 'viudo') echo "selected"; ?> value="viudo">Viudo(a)</option>
						    </select>
							</div>
					    <div class="col-6">
					      <label for="patientoccupation">Ocupación</label><span class="text-danger">*</span>
					      <input type="text" name="patientoccupation" class="form-control" id="patientoccupation" value="<?php if(isset($pat["patientoccupation"])) echo $pat["patientoccupation"];  ?>">
					    </div>
					  </div>

					</div>
					<br>
					<div class="from-group">

					  <div class="row">
					    <div class="col-6">
					      <label for="patientnationality">Nacionalidad</label><span class="text-danger">*</span>
					      <!--<input type="text" name="patientnationality" class="form-control" id="patientnationality" value="<?php if(isset($pat["patientnationality"])) echo $pat["patientnationality"];  ?>">-->
								<select name="patientnationality" id="patientnationality" class="form-select">
						      <option <?php if(!isset($pat) || (isset($pat) && $pat["patientnationality"] == 'boliviana')) echo "selected"; ?> value="boliviana">Boliviana</option>
						      <option <?php if(isset($pat) && $pat["patientnationality"] == 'extranjera') echo "selected"; ?> value="extranjera">Extranjera</option>
						    </select>
							</div>
					    <div class="col-6">
					      <label for="patientschool">Grado de escolaridad</label>
					      <!--<input type="text" name="patientschool" class="form-control" id="patientschool" value="<?php //if(isset($pat["patientschool"])) echo $pat["patientschool"];  ?>">-->
								<select name="patientschool" id="patientschool" class="form-select">
						      <option <?php if(!isset($pat) || $pat["patientschool"] == '--') echo "selected"; ?> value="--">--</option>
						      <option <?php if(isset($pat) && $pat["patientschool"] == 'inicial') echo "selected"; ?> value="inicial">Educación inicial</option>
						      <option <?php if(isset($pat) && $pat["patientschool"] == 'primaria') echo "selected"; ?> value="primaria">Educación primaria</option>
						      <option <?php if(isset($pat) && $pat["patientschool"] == 'secundaria') echo "selected"; ?> value="secundaria">Educación secundaria</option>
						      <option <?php if(isset($pat) && $pat["patientschool"] == 'superior') echo "selected"; ?> value="superior">Educación superior</option>
						    </select>
							</div>
					  </div>

					</div>

					<div class="from-group">

					  <label for="patientattorney">Apoderado</label>
					  <input type="text" name="patientattorney" class="form-control" id="patientattorney" value="<?php if(isset($pat["patientattorney"])) echo $pat["patientattorney"];  ?>">

					</div>

					<!--formulario para paciente fin-->



				</div>
	    </div>
	  </div>
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
	      <button class="accordion-button collapsed btn-link text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
	        Antecedente Médico General
	      </button>
	    </h2>
	    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
	      <div class="accordion-body">

					<!--formulario para antecedentes medico general-->

					  <div class="row">
					    <div class="col-5">
					      <b><u>ENFERMEDAD</u></b>
					    </div>
					    <div class="col-2">
					      <b><u>SI NO</u></b>
					    </div>
					    <div class="col-5">
					      <b><u>OBSERVACIONES</u></b>
					    </div>
					  </div>
					<?php
					$a = array('Cardiopatías', 'Fiebre Reumática', 'Artritis', 'Tuberculosis', 'Silicosis',
					    'Epilepsia', 'Hepatitis', 'Diabetes', 'Hipertension Arterial', 'Alergias', 'Asma', 'Embarazo',
					    'Habitos / vicios', 'Otros');//Recibe tratamiento Medico

					$st=false;
					if(isset($pat["patientgmh"])){
					    $p=cleanpatientgmh($pat["patientgmh"]);
					    $st=true;
					}
					for ($i=0; $i <count($a) ; $i++) {
					  echo "<div class=\"row\">".
					       "  <div class=\"col-5\">".
					       "    <label class=\"form-check-label\" for=\"yesno$i\">".$a[$i]."</label>".
					       "  </div>";

					  echo "<div class=\"col-2\">".
					       "  <div class=\"form-check form-switch\">";
					  //$tt=$p[$i]["status"];
					  if($st){
					    if ($p[$i]["status"]=="true") {
					        echo "    <input class=\"form-check-input\" type=\"checkbox\" id=\"yesno$i\" checked>";
					    }else{
					        echo "    <input class=\"form-check-input\" type=\"checkbox\" id=\"yesno$i\">";
					    }
					  }else{
					    if (true) {
					        echo "    <input class=\"form-check-input\" type=\"checkbox\" id=\"yesno$i\" checked>";
					    }else{
					        echo "    <input class=\"form-check-input\" type=\"checkbox\" id=\"yesno$i\">";
					    }
					  }


					  echo "  </div>";
					  echo "</div>";

					  echo "  <div class=\"col-5\">";
					  if($st){
					    echo "    <input type=\"text\" name=\"obs$i\" class=\"form-control\" id=\"obs$i\" value=\"".$p[$i]["obs"]."\">";
					  }else{
					    echo "    <input type=\"text\" name=\"obs$i\" class=\"form-control\" id=\"obs$i\" value=\"\">";
					  }


					       echo "  </div>".
					       "</div>";
					}

					?>

					<!--formulario para entecedentes medico general fin-->
					        <br>
					        <div class="row">
					          <u><b>Presión Arterial actual:</b></u>
					          <br>
					          <div class="col-12">
					            <div class="row">
					              <div class="col-lg-2 col-md-3 col-sm-3 col-3">
					                Sistolica:
					              </div>
					              <div class="col-lg-2 col-md-2 col-sm-3 col-3">
					                <input type="text" class="form-control" name="sistolica" id="sistolica" value="<?php if(isset($pat["sistolica"])) echo $pat["sistolica"];  ?>">
					              </div>
					              <div class="col-lg-2 col-md-3 col-sm-3 col-3">
					                Diastolica:
					              </div>
					              <div class="col-lg-2 col-md-2 col-sm-3 col-3">
					                <input type="text" class="form-control" name="diastolica" id="diastolica" value="<?php if(isset($pat["diastolica"])) echo $pat["diastolica"];  ?>">
					              </div>
					              <div class="col-lg-2 col-md-3 col-sm-5 col-5">
					                mm de mercurio
					              </div>
					            </div>

					          </div>

					        </div>
	      </div>
	    </div>
	  </div>
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
	      <button class="accordion-button collapsed btn-link text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
	        Triage
	      </button>
	    </h2>
	    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
	      <div class="accordion-body">
					<!--contenido del triage inicio-->
					<div class="from-group">

					  <div class="row">
					    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
					      <label for="temperature">Temperatura</label>
					      <input type="text" name="temperature" class="form-control" id="temperature" value="<?php  if(isset($pat["triagetemperature"])) echo $pat["triagetemperature"]; else echo "36.5°"?>">
					    </div>
					    <div class="col-lg-1 col-md-1 col-sm-4 col-4">
					      <label for="headache">Cefalea</label>
					      <?php
					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"headache\" value=\"t\" id=\"headacheyes\" ";
					      if(isset($pat["triageheadache"]) && $pat["triageheadache"]=='t') echo "checked";
					      echo ">";
					      echo "  <label class=\"form-check-label\" for=\"headacheyes\">Si</label>";
					      echo "</div>";
					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"headache\" value=\"f\" id=\"headacheno\" ";
					      if(isset($pat["triageheadache"]) && $pat["triageheadache"]=='t') echo ">";
					      else echo "checked>";
					      echo "  <label class=\"form-check-label\" for=\"headacheno\">No</label>";
					      echo "</div>";
					      ?>
					    </div>
					    <div class="col-lg-3 col-md-3 col-sm-4 col-4">
					      <label for="headache">Dificultad Respiratoria</label>
					      <?php
					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"respiratory\" value='t' id=\"respiratoryyes\" ";
					      if(isset($pat["triagerespiratory"]) && $pat["triagerespiratory"]=='t') echo "checked";
					      echo ">";
					      echo "  <label class=\"form-check-label\" for=\"respiratoryyes\">Si</label>";
					      echo "</div>";

					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"respiratory\" value='f' id=\"respiratoryno\" ";
					      if(isset($pat["triagerespiratory"]) && $pat["triagerespiratory"]=='t') echo ">";
					      else echo "checked>";
					      echo "  <label class=\"form-check-label\" for=\"respiratoryno\">No</label>";
					      echo "</div>";
					      ?>
					    </div>
					    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
					      <label for="headache">Dolor de Garganta</label>
					      <?php
					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"throat\" value=\"t\" id=\"throatyes\" ";
					      if(isset($pat["triagethroat"]) && $pat["triagethroat"]=='t'){
					         echo "checked";
					      }
					      echo ">";
					      echo "  <label class=\"form-check-label\" for=\"throatyes\">Si</label>";
					      echo "</div>";

					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"throat\" value=\"f\" id=\"throatno\" ";
					      if(isset($pat["triagethroat"]) && $pat["triagethroat"]=='t') echo ">";
					      else echo "checked>";
					      echo "  <label class=\"form-check-label\" for=\"throatno\">No</label>";

					      echo "</div>";
					      ?>
					    </div>
					    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
					      <label for="headache">Malestar General</label>
					      <?php
					      //MSGError($pat['triagegeneral']);
					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"general\" value=\"t\" id=\"generalyes\" ";
					      if(isset($pat["triagegeneral"]) && $pat["triagegeneral"]=='t'){
					          echo "checked";
					      }
					      echo ">";
					      echo "  <label class=\"form-check-label\" for=\"generalyes\">Si</label>";
					      echo "</div>";
					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"general\" value=\"f\" id=\"generalno\" ";
					      if(isset($pat["triagegeneral"]) && $pat["triagegeneral"]=='t') echo ">";
					      else echo "checked>";
					      echo "  <label class=\"form-check-label\" for=\"generalno\">No</label>";
					      echo "</div>";
					      ?>
					    </div>
					    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
					      <label for="headache">Vacuna</label>
					      <?php
					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"vaccine\" value=\"1\" id=\"vaccine1\" ";
					      if(isset($pat["triagevaccine"]) && $pat["triagevaccine"]=='1') echo "checked";
					      echo ">";
					      echo "  <label class=\"form-check-label\" for=\"vaccine1\">1ra.</label>";
					      echo "</div>";

					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"vaccine\" value=\"2\" id=\"vaccine2\" ";
					      if(isset($pat["triagevaccine"]) && $pat["triagevaccine"]=='2') echo "checked";
					      echo ">";
					      echo "  <label class=\"form-check-label\" for=\"vaccine2\">2da.</label>";
					      echo "</div>";

					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"vaccine\" value=\"3\" id=\"vaccine3\" ";
					      if(isset($pat["triagevaccine"]) && $pat["triagevaccine"]=='3') echo "checked";
					      echo ">";
					      echo "  <label class=\"form-check-label\" for=\"vaccine3\">3ra.</label>";
					      echo "</div>";

					      echo "<div class=\"form-check\">";
					      echo "  <input class=\"form-check-input\" type=\"radio\" name=\"vaccine\" value=\"n\" id=\"vaccinen\" ";
					      if(isset($pat["triagevaccine"]) && $pat["triagevaccine"]=='n') echo "checked";
					      if(!isset($pat["triagevaccine"])) echo "checked";
					      echo ">";
					      echo "  <label class=\"form-check-label\" for=\"vaccinen\">Ninguna</label>";
					      echo "</div>";
					      ?>
					    </div>
					  </div>

					</div>
					<br>

					<!--contenido del triage fin-->
				</div>
	    </div>
	  </div>
		<div class="accordion-item">
	    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
	      <button class="accordion-button collapsed btn-link text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
	        Examen Bucodental
	      </button>
	    </h2>
	    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
	      <div class="accordion-body">
					<!--examen bucodental inicio-->
					<div class="from-group">

					  <div class="row">
					    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
					      <label for="patientgender">Lengua</label>
					      <select name="tongue" class="form-select" aria-label="Default select example">
					        <option <?php if(!isset($pat) || $pat["dentaltongue"] == 'normal') echo "selected"; ?> value="normal">Normal</option>
					        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'saburra') echo "selected"; ?> value="saburra">Saburral</option>
					        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'fisurada') echo "selected"; ?> value="fisurada">Fisurada</option>
					        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'geografica') echo "selected"; ?> value="geografica">Geográfica</option>
					        <option <?php if(isset($pat) && $pat["dentaltongue"] == 'otros') echo "selected"; ?> value="otros">Otros</option>
					      </select>
					    </div>
					    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
					      <label for="patientgender">Piso de la boca</label>
					      <select name="piso" class="form-select" aria-label="Default select example">
					        <option <?php if(!isset($pat) || $pat["dentalpiso"] == 'aparentemente') echo "selected"; ?> value="aparentemente">Aparentemente Normal</option>
					        <option <?php if(isset($pat) && $pat["dentalpiso"] == 'toruslingua') echo "selected"; ?> value="toruslingua">Torus Lingual</option>
					      </select>
					    </div>
					    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
					      <label for="encias">Encias</label>
					      <select name="encias" class="form-select" aria-label="Default select example">
					        <option <?php if(!isset($pat) || $pat["dentalencias"] == 'normal') echo "selected"; ?> value="normal">Normal</option>
					        <option <?php if(isset($pat) && $pat["dentalencias"] == 'difusa') echo "selected"; ?> value="difusa">Difusa</option>
					        <option <?php if(isset($pat) && $pat["dentalencias"] == 'gingivitis') echo "selected"; ?> value="gingivitis">Gingivitis cronica no complicada</option>
					        <option <?php if(isset($pat) && $pat["dentalencias"] == 'papilar') echo "selected"; ?> value="papilar">Papilar</option>
					      </select>
					    </div>
					    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
					      <label for="mucosa">Mucosa Bucal</label>
					      <select name="mucosa" class="form-select" aria-label="Default select example">
					        <option <?php if(!isset($pat) || $pat["dentalmucosa"] == 'normal') echo "selected"; ?> value="normal">Aparentemente Normal</option>
					        <option <?php if(isset($pat) && $pat["dentalmucosa"] == 'alteracion') echo "selected"; ?> value="alteracion">Con Alteración</option>
					      </select>
					    </div>
					    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
					      <label for="occlusion">Tipo de Oclusión</label>
					      <select name="occlusion" class="form-select" aria-label="Default select example">

								<option <?php if(!isset($pat) || $pat["dentaltypeo"] == '--') echo "selected"; ?> value="--">--</option>
								<option <?php if(isset($pat) && $pat["dentaltypeo"] == 'normal') echo "selected"; ?> value="normal">Mordida Normal</option>
								<option <?php if(isset($pat) && $pat["dentaltypeo"] == 'normal') echo "selected"; ?> value="malposicion">Mal posición dental</option>
								<option <?php if(isset($pat) && $pat["dentaltypeo"] == 'sobre') echo "selected"; ?> value="sobre">SobreMordida</option>
								<option <?php if(isset($pat) && $pat["dentaltypeo"] == 'abierta') echo "selected"; ?> value="abierta">Mordida Abierta</option>
								<option <?php if(isset($pat) && $pat["dentaltypeo"] == 'cruzada') echo "selected"; ?> value="cruzada">Mordida Cruzada</option>
								<option <?php if(isset($pat) && $pat["dentaltypeo"] == 'bis') echo "selected"; ?> value="bis">Mordida Bis a Bis</option>
								<!--<option <?php //if(!isset($pat) || $pat["dentaltypeo"] == 'normo') echo "selected"; ?> value="normo">Normo oclusion</option>
					        <option <?php //if(isset($pat) && $pat["dentaltypeo"] == 'disto') echo "selected"; ?> value="disto">Disto oclusion</option>
					        <option <?php //if(isset($pat) && $pat["dentaltypeo"] == 'mesio') echo "selected"; ?> value="mesio">Mesio oclusion</option>
					        <option <?php //if(isset($pat) && $pat["dentaltypeo"] == 'abierta') echo "selected"; ?> value="abierta">Abierta anterior</option>
								-->
								</select>
					    </div>
					  <div class="row">
					    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
					      <label for="occlusion">Tipo de Protesis</label>
					      <select name="prosthesis" class="form-select" aria-label="Default select example">
					        <option <?php if(!isset($pat) || $pat["dentaltypep"] == '') echo "selected"; ?> value="">--</option>
					        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'removible') echo "selected"; ?> value="removible">Removible</option>
					        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'fija') echo "selected"; ?> value="fija">Fija</option>
					        <option <?php if(isset($pat) && $pat["dentaltypep"] == 'total') echo "selected"; ?> value="total">Total</option>
					      </select>
					    </div>
					    <div class="col-lg-2 col-md-2 col-sm-6 col-6">
					      <label for="occlusion">Higiene Bucal</label>
					      <select name="hygiene" class="form-select" aria-label="Default select example">
					        <option <?php if(!isset($pat) || $pat["dentalhygiene"] == 'regular') echo "selected"; ?> value="regular">Regular</option>
					        <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'buena') echo "selected"; ?> value="buena">Buena</option>
					        <option <?php if(isset($pat) && $pat["dentalhygiene"] == 'mala') echo "selected"; ?> value="mala">Mala</option>
					      </select>
					    </div>
					  </div>
						<br>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-12 col-12">
					      <label for="lastconsultation"><u><b>Ultima Consulta</b></u></label>
					      <input type="text" name="lastconsultation" class="form-control" id="lastconsultation" value="<?php if(isset($pat["updatetime"])){ if($upreferred==false){echo 'En '.datetimeconv($pat["updatetime"]);}else{echo $pat['lastconsult'];}}  ?>">
					      <!--<input type="date" id="lastconsultation" class="form-control"  name="lastconsultation" value="<?php //if(isset($pat["lastconsult"])) echo $pat["lastconsult"];  ?>" min="2015-01-01" max="2099-01-01">-->
					    </div>
					    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
					      <label for="consultation"><u><b>Motivo de Consulta</b></u></label>
					      <input type="text" name="consultation" class="form-control" id="consultation" value="<?php if(isset($pat["motconsult"])) echo $pat["motconsult"];  ?>">
					    </div>
						</div>
					</div>
				</div>

				<br>
					<!--examen bucodental fin-->
				</div>
	    </div>
	  </div>
		<div class="accordion-item">
	    <h2 class="accordion-header" id="panelsStayOpen-headingFive">
	      <button class="accordion-button collapsed btn-link text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
	        Odontograma
	      </button>
	    </h2>
	    <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive">
	      <div class="accordion-body">
					<!--odontograma inicio-->
					        <?php
					        include("../leftodontogram.php");
					        $odontogramstatus="false";
					        if (isset($pat['draw'])){
					          $odontogramstatus="true";
					          $pat=decryptOdontogram($pat);
					        }
					        ?>
					<!--odontograma fin-->
					<input type="hidden" name="draw" id="draw" value="<?php if(isset($pat["draw"])) echo $pat["draw"];?>">

				</div>
	    </div>
	  </div>
		<div class="accordion-item">
	    <h2 class="accordion-header" id="panelsStayOpen-headingSix">
	      <button class="accordion-button collapsed btn-link text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
	        Historial de la Patologia Actual & Remision
	      </button>
	    </h2>
	    <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix">
	      <div class="accordion-body">
					<!--inicio finalizacion-->
					        <div class="row">
					          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
					            <label for="diagnostico"><u><b>Diagnostico presuntivo</b></u></label>
					            <!--<input type="text" name="diagnostico" class="form-control" id="diagnostico" value="<?php //if(isset($pat["diagnostico"])) echo $pat["diagnostico"];  ?>">-->
					            <textarea class="form-control" id="diagnostico" name="diagnostico" rows="4"><?php if(isset($pat["diagnosis"])) echo $pat["diagnosis"];  ?></textarea>
					          </div>

					          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
					            <label for=""><b><u>Remision:</u></b></label>
					            <!--onChange="contestch()" -->
					            <select id = "clinical"name="clinical" class="form-select" aria-label="Default select example">

					            <option value="" selected>--</option>
					            <?php
					            //DBAllClinicalInfo
					            $cs = DBAllClinicalInfo();
					            $isfake=true;
					            if(isset($pat['clinicalid'])) $isfake=false;
					            for ($i=1; $i<count($cs); $i++) {
					              echo "<option value=\"" . $cs[$i]["clinicalid"] . "\" ";

					              if(!$isfake){
					                if ($pat['clinicalid'] == $cs[$i]["clinicalid"]) {
					                  echo "selected";
					                }
					              }
					              echo ">" . $cs[$i]["clinicalspecialty"] ."</option>\n";
					            }
					            ?>
					            </select>
					          </div>
					          <div class="col-lg-4 col-md-4 col-sm-12 col-12">
					            <label for="examinedid"><u><b>Estudiante Designado</b></u></label>
					            <div class="dropdown">
					              <input type="hidden" name="examinedid" id="examinedid"value="<?php if(isset($pat['designedstudentid'])){ echo $pat['designedstudentid'];}  ?>">
					              <input type="text" class="dropdown-toggle form-control" autocomplete="off" name="examined" id="examined" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="<?php if(isset($pat['designedstudentid'])&& is_numeric($pat['designedstudentid'])){ echo $pat['userfullname'];}  ?>">
					              <div class="dropdown-menu" aria-labelledby="examined" id="resultstudent">
					                <!--<a class="dropdown-item text-primary" href="#" onclick="insert(1,'fabian')">fabian</a>
					                <a class="dropdown-item text-primary" href="#" onclick="insert(2,'sierra')">sierra</a>-->
					              </div>
					            </div>
					          </div>
					          <br><br><br><br><br>
					        </div>
					        <div class="row">
					          <div class="col-lg-4 col-md-4 col-sm-6 col-6">
					            <button id="patientregister_button" class="btn btn-success" type="button" name="patientregister_button">Enviar Datos</button>
					          </div>
					          <div class="col-lg-4 col-md-4 col-sm-6 col-6">
					            <button id="cancel_button" class="btn btn-danger" type="button" name="cancel_button">Cancelar</button>
					          </div>
					        </div>
					<!--fin finalizacion-->
				</div>
	    </div>
	  </div>
	</div>


</div>

<?php
require('footer.php');

include("../leftodontogramjs.php");
?>

<script>
//examined
function insert(id, val){
		event.preventDefault();
		$('#examinedid').val(id);
		$('#examined').val(val);
}

$(document).ready(function () {
	function searchfullname(){
		var searchname = $('#patientname').val()
		var searchfisrtname = $('#patientfirstname').val()
		var searchlastname = $('#patientlastname').val()

		$.ajax({
			type: 'POST',
			url: '../include/search.php',
			data: {'searchname': searchname, 'searchfisrtname': searchfisrtname, 'searchlastname': searchlastname},
			beforeSend: function(){
				$('#result').html('<img src="../images/google.gif">')
			}
		})
		.done(function(resultado){
			//div para mostrar resultado
			$('#result1').html(resultado)
			$('#result2').html(resultado)
			$('#result3').html(resultado)
		})
		.fail(function(){
			//alerta para un error
			alert('Hubo un error :(')
		})
	}
	//funcion para buscar pacientes
	$('#patientname, #patientfirstname, #patientlastname').on('keyup', function(){
			searchfullname()
	});

	$("#clinical").change(function(){
    //capturamos valor de campo de texto
      var examined = $('#examined').val()
      var clinical = $('select[name=clinical]').val()
      if(clinical!=NULL){
        $.ajax({
          type: 'POST',
          url: '../include/search.php',
          data: {'examined': examined, 'clinical':clinical},
          beforeSend: function(){
            $('#resultstudent').html('<img src="../images/google.gif">')
          }
        })
        .done(function(resultado){
          //div para mostrar resultado
          $('#resultstudent').html(resultado)
        })
        .fail(function(){
          //alerta para un error
          alert('Hubo un error :(')
        })
      }
  });

	//funcion para buscar estudiantes
  $('#examined').on('keyup', function(){
    //capturamos valor de campo de texto
      $('#examinedid').val('')
      var examined = $('#examined').val()
      var clinical = $('select[name=clinical]').val()

      $.ajax({
        type: 'POST',
        url: '../include/search.php',
        data: {'examined': examined, 'clinical':clinical},
        beforeSend: function(){
          $('#resultstudent').html('<img src="../images/google.gif">')
        }
      })
      .done(function(resultado){
        //div para mostrar resultado
        $('#resultstudent').html(resultado)
      })
      .fail(function(){
        //alerta para un error
        alert('Hubo un error :(')
      })

  });
	$('#cancel_button').click(function(){
		 location.reload();
	});

	//funcion para registrar datos del paciente
	function registerpatient(){

		var padmissionid = $('#padmissionid').val();
		//var patientfullname = $('#patientfullname').val();
		var patientname = $('#patientname').val();
		var patientfirstname = $('#patientfirstname').val();
		var patientlastname = $('#patientlastname').val();

		var patientdirection = $('#patientdirection').val();
		var patientlocation = $('#patientlocation').val();
		var patientage = $('#patientage').val();
		var patientprovenance = $('#patientprovenance').val();
		var patientphone = $('#patientphone').val();
		var patientgender = $('select[name=patientgender]').val();//$('#patientgender').val();
		var patientcivilstatus = $('select[name=patientcivilstatus]').val();//$('#patientcivilstatus').val();
		var patientoccupation = $('#patientoccupation').val();
		var patientnationality = $('select[name=patientnationality]').val();//$('#patientnationality').val();
		var patientschool = $('select[name=patientschool]').val();//$('#patientschool').val();
		var patientattorney = $('#patientattorney').val();

		//variables de antecedentes medico general
		var yesno0 = $('#yesno0').prop('checked'),yesno1 = $('#yesno1').prop('checked'),yesno2 = $('#yesno2').prop('checked'),yesno3 = $('#yesno3').prop('checked');
		var yesno4 = $('#yesno4').prop('checked'),yesno5 = $('#yesno5').prop('checked'),yesno6 = $('#yesno6').prop('checked'),yesno7 = $('#yesno7').prop('checked');
		var yesno8 = $('#yesno8').prop('checked'),yesno9 = $('#yesno9').prop('checked'),yesno10 = $('#yesno10').prop('checked'),yesno11 = $('#yesno11').prop('checked');
		var yesno12 = $('#yesno12').prop('checked'),yesno13 = $('#yesno13').prop('checked');

		var obs0 = $('#obs0').val(),obs1 = $('#obs1').val(),obs2 = $('#obs2').val(),obs3 = $('#obs3').val();
		var obs4 = $('#obs4').val(),obs5 = $('#obs5').val(),obs6 = $('#obs6').val(),obs7 = $('#obs7').val();
		var obs8 = $('#obs8').val(),obs9 = $('#obs9').val(),obs10 = $('#obs10').val(),obs11 = $('#obs11').val();
		var obs12 = $('#obs12').val(),obs13 = $('#obs13').val();

		var sistolica = $('#sistolica').val();
		var diastolica = $('#diastolica').val();

		//patient triage
		var temperature = $('#temperature').val();
		var headache = $('input:radio[name=headache]:checked').val();
		var respiratory = $('input:radio[name=respiratory]:checked').val();
		var throat = $('input:radio[name=throat]:checked').val();
		var general = $('input:radio[name=general]:checked').val();
		var vaccine = $('input:radio[name=vaccine]:checked').val();

		//exam buco dental
		var tongue = $('select[name=tongue]').val();// $('select[name=tongue]').val();// $('input:radio[name=tongue]:checked').val();
		var piso = $('select[name=piso]').val();// $('input:radio[name=piso]:checked').val();
		var encias = $('select[name=encias]').val();// $('input:radio[name=encias]:checked').val();
		var mucosa = $('select[name=mucosa]').val();// $('input:radio[name=mucosa]:checked').val();
		var occlusion = $('select[name=occlusion]').val();// $('input:radio[name=occlusion]:checked').val();
		var prosthesis = $('select[name=prosthesis]').val();// $('input:radio[name=prosthesis]:checked').val();
		var hygiene = $('select[name=hygiene]').val();// $('input:radio[name=hygiene]:checked').val();

		var lastconsultation = $('#lastconsultation').val();
		var consultation = $('#consultation').val();
		//alert(tongue);

		//datos del odontograma
		var tr = $('#tr').html();
		var tl = $('#tl').html();
		var tlr = $('#tlr').html();
		var tll = $('#tll').html();
		var bl = $('#bl').html();
		var br = $('#br').html();
		var bll = $('#bll').html();
		var blr = $('#blr').html();
		//datos del examinado
		var diagnostico = $('#diagnostico').val();
		var clinical = $('select[name=clinical]').val();
		var examined = $('#examined').val();
		var examinedid = $('#examinedid').val();

		//variable para el modo de registro
		var mod = $('#mod').val();
		//var mod = $('input:radio[name=mod]:checked').val();

		var odontodiagnostico = $('#areadiagnostico').val();
		var odontodraw = $('#draw').val();
		var meeting_time=$('#meeting-time').val();

		//if(mod=== undefined)
		//  mod="new";
		//alert(mod);
		if(patientgender=='--'){
			alert("Debe seleccionar genero.");
			return false;
		}

		if(patientdirection.trim()==''){
			alert("Debe completar campo direccion.");
			return false;
		}

		if(patientlocation.trim()==''){
			alert("Debe completar campo localidad.");
			return false;
		}
		if(patientage.trim()==''){
			alert("Debe completar campo edad.");
			return false;
		}
		if(patientprovenance.trim()==''){
			alert("Debe completar campo procedencia.");
			return false;
		}
		if(patientoccupation.trim()==''){
			alert("Debe completar campo ocupación.");
			return false;
		}
		if(patientnationality.trim()==''){
			alert("Debe completar campo nacionalidad.");
			return false;
		}
		//if(patientschool.trim()==''){
			//alert("Debe completar campo grado de escolaridad.");
			//return false;
		//}
		if(patientcivilstatus.trim()==''){
			alert("Debe completar campo estado civil.");
			return false;
		}
		if(patientname != '' && patientfirstname != '' && patientlastname != ''){
				//mejorado el envio inicio..
				Swal.fire({
				 title: 'Enviando datos del paciente...',
				 html: '<div class="lds-dual-ring"></div>',
				 showConfirmButton: false,
				 allowOutsideClick: false,
				 allowEscapeKey: false,
				 allowEnterKey: false,
				 didOpen: () => {
					 Swal.showLoading();
				 }
			 });

			 $.ajax({
				 url:"../include/i_patientadmission.php",
				 method:"POST",
				 data: {mod:mod, padmissionid:padmissionid, patientname:patientname,
	patientfirstname:patientfirstname, patientlastname:patientlastname, patientdirection:patientdirection, patientlocation:patientlocation, patientage:patientage, patientprovenance:patientprovenance,
					 patientphone:patientphone, patientgender:patientgender, patientcivilstatus:patientcivilstatus, patientoccupation:patientoccupation, patientnationality:patientnationality,
					 patientschool:patientschool, patientattorney:patientattorney, yesno0:yesno0, yesno1:yesno1, yesno2:yesno2, yesno3:yesno3, yesno4:yesno4, yesno5:yesno5, yesno6:yesno6,
					 yesno7:yesno7, yesno8:yesno8, yesno9:yesno9, yesno10:yesno10, yesno11:yesno11, yesno12:yesno12, yesno13:yesno13,
					 obs0:obs0, obs1:obs1, obs2:obs2, obs3:obs3, obs4:obs4, obs5:obs5, obs6:obs6, obs7:obs7, obs8:obs8, obs9:obs9, obs10:obs10, obs11:obs11, obs12:obs12, obs13:obs13, sistolica:sistolica, diastolica:diastolica,
					 temperature:temperature, headache:headache, respiratory:respiratory, throat:throat, general:general, vaccine:vaccine,
					 tongue:tongue, piso:piso, encias:encias, mucosa:mucosa, occlusion:occlusion,
					 prosthesis:prosthesis, hygiene:hygiene, lastconsultation:lastconsultation, consultation:consultation,
					 tr:tr, tl:tl, tlr:tlr, tll:tll, bl:bl, br:br, bll:bll, blr:blr,
					 diagnostico:diagnostico, clinical:clinical, examined:examined, examinedid:examinedid, odontodiagnostico:odontodiagnostico, odontodraw:odontodraw, meeting_time:meeting_time},
				 beforeSend: () => {
					 Swal.update({
						 title: 'Procesando datos del paciente...',
						 html: 'Estamos procesando los datos enviados...',
					 });
				 },
				 success: (response) => {
					 if(response=='yes'){
						 Swal.fire({
							 icon: 'success',
							 title: '¡Terminado!',
							 html: 'Se guardó los datos del paciente con éxito.',
							 showConfirmButton: true,
							 didOpen: () => {
								 Swal.hideLoading();
                 setTimeout(()=>{
                   location.href="listadmission.php";
                 }, 2000);
							 }
						 });
					 }else{
						 alert(response);
						 /*console.log(response);
						 Swal.fire({
							 icon: 'error',
							 title: '¡Error!',
							 html: 'Hubo un error en el envio de datos del paciente: ' + response,
							 showConfirmButton: true,
							 didOpen: () => {
								 Swal.hideLoading();
							 }
						 });*/
					 }
				 },
				 error: (jqXHR, textStatus) => {
					 Swal.fire({
						 icon: 'error',
						 title: '¡Error!',
						 html: 'Hubo un error en el envio de datos del paciente: ' + textStatus,
						 showConfirmButton: true,
						 didOpen: () => {
							 Swal.hideLoading();
						 }
					 });
				 },
				 complete: () => {
					 //Swal.close(); // Cierra la ventana emergente de "Enviando datos..."
					 setTimeout(() => {
							 Swal.close(); // Cierra la ventana emergente después de 2 segundos
					 }, 1000);
				 }
			 });
		}else{
			alert('debe completar al menos nombres y apellidos');
		}
	}

	//register patient
	$('#patientregister_button').click(function(){
		Swal.fire({
			title: 'Confirmación',
			text: '¿Estás seguro de enviar los datos?',
			icon: 'question',
			showCancelButton: true,
			confirmButtonText: 'Enviar',
			cancelButtonText: 'Cancelar',
			customClass: {
				popup: 'my-custom-popup-class',
				title: 'my-custom-title-class',
				text: 'my-custom-text-class',
				confirmButton: 'btn btn-primary',
				cancelButton: 'btn btn-secondary'
			},
			buttonsStyling: false,
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {
				//...
				if ($('#patientname').val()==="" || $('#patientfirtname').val()==="" || $('#patientlastname').val()==="") {
					alert('debe completar el nombre del paciente');
				}else{
					var clinical = $('select[name=clinical]').val();
					var examined = $('#examined').val();
					if(clinical!=""&&examined!=""){
						$.ajax({
							 url:"../include/i_patientadmission.php",
							 method:"POST",
							 data: {designed:clinical, student:examined},
							 success:function(data)
							 {
									if(data == 'yes'){
										registerpatient();
									}else{
										alert(data);
									}
							 }
						});
					}else{
						registerpatient();
					}

				}
			}
		});
	});

	//register patient
	$('#patientchange').click(function(){
		if($('#patientid').val()==''){
			$('#modalname').modal('hide');
		}
		if ($('#patientname').val()==="" || $('#patientfirtname').val()==="" || $('#patientlastname').val()==="") {
			alert('debe completar todos los campos');
		}else{
			var patientid = $('#patientidchange').val();
			var patientadid = $('#padmissionid').val();
			var patientname = $('#patientnamemodal').val();
			var patientfirstname = $('#patientfirstnamemodal').val();
			var patientlastname = $('#patientlastnamemodal').val();
			$.ajax({
				 url:"../include/i_patientadmission.php",
				 method:"POST",
				 data: {patientidch:patientid, patientnamech:patientname, patientfirstnamech:patientfirstname,
					 patientlastnamech:patientlastname},
				 success:function(data)
				 {
						alert(data);
						$('#patientname').val(patientname);
						$('#patientfirstname').val(patientfirstname);
						$('#patientlastname').val(patientlastname);
						$('#modalname').modal('hide');
				 }
			});

		}
	});


});

</script>
