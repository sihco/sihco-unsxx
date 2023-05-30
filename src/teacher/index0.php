<?php
require('header.php');
if(isset($_POST["designed"]) && isset($_POST["clinical"]) && $_POST["designed"]!="" && $_POST["clinical"]!=""){
  DBDesignedTeacher($_SESSION["usertable"]["usernumber"], $_POST['designed'], $_POST["clinical"]);
}
if (isset($_GET["limit"]) && is_numeric($_GET['limit']) && $_GET["limit"]>0)
  $limit = myhtmlspecialchars($_GET["limit"]);
else $limit = 200;
?>

            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-4">

                        <h2 class="mt-4">Mis Fichas Clinicas Designadas</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>
<?php
$pr = DBAllDesignedUserNotInfo($_SESSION["usertable"]["usernumber"]);
$size=count($pr);
//old
/*for ($i=0; $i < $size; $i++) {
    $len=count($pr[$i]);
    for ($j=0; $j < $len ; $j++) {

      echo "<form action=\"index.php\" method=\"post\">".
      "<input type=\"hidden\" name=\"designed\" value=\"".$pr[$i][$j]["ficha"]."\">".
      "<input type=\"hidden\" name=\"clinical\" value=\"".$pr[$i][$j]["clinical"]."\">".
      "<div class=\"alert alert-success\" role=\"alert\">".
        "<b>".$pr[$i][$j]["student"] . "</b> llenó su ficha clinica de  " . $pr[$i][$j]["clinicalname"] . " <input type=\"submit\" class=\"btn btn-sm btn-success\" name=\"\" value=\"Click Aquí\"> para añadir a tus revisiones".
        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
        "  <span aria-hidden=\"true\">&times;</span>".
        "</button>".
        "</div>\n</form>\n";
    }
}*/
//new
/*for ($i=0; $i < $size; $i++) {
  echo "<form action=\"index.php\" method=\"post\">".
  "<input type=\"hidden\" name=\"designed\" value=\"".$pr[$i]["ficha"]."\">".
  "<input type=\"hidden\" name=\"clinical\" value=\"".$pr[$i]["clinical"]."\">".
  "<div class=\"alert alert-success\" role=\"alert\">".
    "<b>".$pr[$i]["student"] . "</b> llenó su ficha clinica de  " . $pr[$i]["clinicalname"] . " <input type=\"submit\" class=\"btn btn-sm btn-success\" name=\"\" value=\"Click Aquí\"> para añadir a tus revisiones".
    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
    "  <span aria-hidden=\"true\">&times;</span>".
    "</button>".
    "</div>\n</form>\n";
}


//old
$pr = DBAllDesignedUserInfo($_SESSION["usertable"]["usernumber"]);
$size=count($pr);
$rows=0;
for ($i=0; $i < $size; $i++) {
    $len=count($pr[$i]);
    for ($j=0; $j < $len ; $j++) {

      $msg="";
      if($pr[$i][$j]["clinical"]==1||$pr[$i][$j]["clinical"]==9){
        $re=DBRemovableInfo($pr[$i][$j]['ficha']);
        if(isset($re['remofirmyes'])&&$re['remofirmyes']>0){
          echo "<div class=\"alert alert-warning\" role=\"alert\">".
          "<b>".$pr[$i][$j]["student"] . "</b> Requiere visto bueno en la tabla de procedimientos de ".$pr[$i][$j]['clinicalname']." <a href=\"".$pr[$i][$j]["file"].".php?id=".$pr[$i][$j]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
          "</div>";
        }
      }
      if($pr[$i][$j]["clinical"]==2||$pr[$i][$j]["clinical"]==10){
        $s=DBFixedInfo($pr[$i][$j]['ficha']);
        if($s['vobo']>0){
          echo "<div class=\"alert alert-warning\" role=\"alert\">".
          "<b>".$pr[$i][$j]["student"] . "</b> Requiere visto bueno en la tabla de procedimientos de ".$pr[$i][$j]['clinicalname']." <a href=\"".$pr[$i][$j]["file"].".php?id=".$pr[$i][$j]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
          "</div>";
        }
        if($s['material']>0){
          echo "<div class=\"alert alert-warning\" role=\"alert\">".
          "<b>".$pr[$i][$j]["student"] . "</b> Requiere registro de materiales en la tabla de procedimientos de ".$pr[$i][$j]['clinicalname']." <a href=\"".$pr[$i][$j]["file"].".php?id=".$pr[$i][$j]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
          "</div>";
        }
      }
      if($pr[$i][$j]["clinical"]==6||$pr[$i][$j]["clinical"]==14){
        $s=DBSessionPeriodonticsiiInfo($pr[$i][$j]['ficha']);
        if($s['sessionevaluated']=='f'){
          echo "<div class=\"alert alert-warning\" role=\"alert\">".
          "<b>".$pr[$i][$j]["student"] . "</b> Registro su fecha de session de ficha clinica ".$pr[$i][$j]['clinicalname']." <a href=\"".$pr[$i][$j]["file"].".php?id=".$pr[$i][$j]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
          "</div>";
        }
      }
      if($pr[$i][$j]["clinical"]==7|| $pr[$i][$j]["clinical"]==15){
        $pd=DBPediatricsiInfo($pr[$i][$j]['ficha']);
        if(isset($pd['st'])&&$pd['st']=='f'){
          echo "<div class=\"alert alert-warning\" role=\"alert\">".
          "<b>".$pr[$i][$j]["student"] . "</b> Te envió su indice de O'leary ".$pr[$i][$j]['clinicalname']." <a href=\"".$pr[$i][$j]["file"].".php?id=".$pr[$i][$j]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
          "</div>";
        }

        $namestudent=$pr[$i][$j]["student"];
        $idficha=$pr[$i][$j]["ficha"];
        $ficha=$pr[$i][$j]["file"];

        $firms=DBAllControlFirmInfo($pr[$i][$j]['ficha']);
        $control = array('urgency' => 'Urgencias', 'inactivation' => 'Inactivacion',
        'quimic' => 'Control Quimico - Mecanico del Bio Fil', 'morfologic' => 'Refuerzo Morfologico',
        'estruct' => 'Refuerzo Estructural', 'surgery' => 'Cirugia', 'pulpar' => 'Pulpar', 'rehabilitation' => 'Rehabilitación');//añadir mas revisiones

        for ($c=0; $c <count($firms) ; $c++) {

            echo "<div class=\"alert alert-warning\" role=\"alert\">".
            "<b> $namestudent </b> Requiere firma para control de ".$control[$firms[$c]['controltype']]." de ".$pr[$i][$j]['clinicalname']." <a href=\"".$ficha.".php?id=".$idficha ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
            "</div>";

        }
      }
      if($pr[$i][$j]["evaluated"]=='f'&&$pr[$i][$j]["row"]>1){
        $msg="Te envió ";
        if($pr[$i][$j]["row"]>2){
          $msg.="nuevamente ";
        }
      }
      if($msg!=""){
        echo "<div class=\"alert alert-warning\" role=\"alert\">".
        "<b>".$pr[$i][$j]["student"] . "</b> $msg su ficha clinica de ".$pr[$i][$j]['clinicalname']." <a href=\"".$pr[$i][$j]["file"].".php?id=".$pr[$i][$j]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
        "</div>";
      }
      $rows++;
    }
}
*/
//new
for ($i=0; $i < $size; $i++) {
  echo "<form action=\"index.php\" method=\"post\">".
  "<input type=\"hidden\" name=\"designed\" value=\"".$pr[$i]["ficha"]."\">".
  "<input type=\"hidden\" name=\"clinical\" value=\"".$pr[$i]["clinical"]."\">".
  "<div class=\"alert alert-success\" role=\"alert\">".
    "<b>".$pr[$i]["student"] . "</b> llenó su ficha clinica de  " . $pr[$i]["clinicalname"] . " <input type=\"submit\" class=\"btn btn-sm btn-success\" name=\"\" value=\"Click Aquí\"> para añadir a tus revisiones".
    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
    "  <span aria-hidden=\"true\">&times;</span>".
    "</button>".
    "</div>\n</form>\n";
}


//new
$pr = DBAllDesignedUserInfo($_SESSION["usertable"]["usernumber"],false, $limit);
$size=count($pr);
$rows=0;
for ($i=0; $i < $size; $i++) {
  $msg="";
  if($pr[$i]["clinical"]==1||$pr[$i]["clinical"]==9){
    $re=DBRemovableInfo($pr[$i]['ficha']);
    if(isset($re['remofirmyes'])&&$re['remofirmyes']>0){
      echo "<div class=\"alert alert-warning\" role=\"alert\">".
      "<b>".$pr[$i]["student"] . "</b> Requiere visto bueno en la tabla de procedimientos de ".$pr[$i]['clinicalname']." <a href=\"".$pr[$i]["file"].".php?id=".$pr[$i]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
      "</div>";
    }
  }
  if($pr[$i]["clinical"]==2||$pr[$i]["clinical"]==10){
    $s=DBFixedInfo($pr[$i]['ficha']);
    if($s['vobo']>0){
      echo "<div class=\"alert alert-warning\" role=\"alert\">".
      "<b>".$pr[$i]["student"] . "</b> Requiere visto bueno en la tabla de procedimientos de ".$pr[$i]['clinicalname']." <a href=\"".$pr[$i]["file"].".php?id=".$pr[$i]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
      "</div>";
    }
    if($s['material']>0){
      echo "<div class=\"alert alert-warning\" role=\"alert\">".
      "<b>".$pr[$i]["student"] . "</b> Requiere registro de materiales en la tabla de procedimientos de ".$pr[$i]['clinicalname']." <a href=\"".$pr[$i]["file"].".php?id=".$pr[$i]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
      "</div>";
    }
  }
  if($pr[$i]["clinical"]==6||$pr[$i]["clinical"]==14){
    $s=DBSessionPeriodonticsiiInfo($pr[$i]['ficha']);
    if($s['sessionevaluated']=='f'){
      echo "<div class=\"alert alert-warning\" role=\"alert\">".
      "<b>".$pr[$i]["student"] . "</b> Registro su fecha de session de ficha clinica ".$pr[$i]['clinicalname']." <a href=\"".$pr[$i]["file"].".php?id=".$pr[$i]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
      "</div>";
    }
  }
  if($pr[$i]["clinical"]==7|| $pr[$i]["clinical"]==15){
    $pd=DBPediatricsiInfo($pr[$i]['ficha']);
    if(isset($pd['st'])&&$pd['st']=='f'){
      echo "<div class=\"alert alert-warning\" role=\"alert\">".
      "<b>".$pr[$i]["student"] . "</b> Te envió su indice de O'leary ".$pr[$i]['clinicalname']." <a href=\"".$pr[$i]["file"].".php?id=".$pr[$i]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
      "</div>";
    }

    $namestudent=$pr[$i]["student"];
    $idficha=$pr[$i]["ficha"];
    $ficha=$pr[$i]["file"];

    $firms=DBAllControlFirmInfo($pr[$i]['ficha']);
    $control = array('urgency' => 'Urgencias', 'inactivation' => 'Inactivacion',
    'quimic' => 'Control Quimico - Mecanico del Bio Fil', 'morfologic' => 'Refuerzo Morfologico',
    'estruct' => 'Refuerzo Estructural', 'surgery' => 'Cirugia', 'pulpar' => 'Pulpar', 'rehabilitation' => 'Rehabilitación');//añadir mas revisiones

    for ($c=0; $c <count($firms) ; $c++) {

        echo "<div class=\"alert alert-warning\" role=\"alert\">".
        "<b> $namestudent </b> Requiere firma para control de ".$control[$firms[$c]['controltype']]." de ".$pr[$i]['clinicalname']." <a href=\"".$ficha.".php?id=".$idficha ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
        "</div>";

    }
  }
  if(isset($pr[$i]["evaluated"])&&$pr[$i]["evaluated"]=='f'&&$pr[$i]["row"]>1){
    $msg="Te envió ";
    if($pr[$i]["row"]>2){
      $msg.="nuevamente ";
    }
  }
  if($msg!=""){
    echo "<div class=\"alert alert-warning\" role=\"alert\">".
    "<b>".$pr[$i]["student"] . "</b> $msg su ficha clinica de ".$pr[$i]['clinicalname']." <a href=\"".$pr[$i]["file"].".php?id=".$pr[$i]["ficha"] ."\" class=\"alert-link\">clik aquí</a>. para la revision.".
    "</div>";
  }
  $rows++;
}


?>



<div class="row">
  <div class="col-lg-1 col-md-1 col-sm-2 col-2">
    <label for="listar" class="text-primary"><u><b>Listar:</b></u></label>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-5 col-5">
    <select name="listar" id="listar" onchange="ListLog()" class="form-select form-control-sm" aria-label="Default select example">
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']<=200) echo "selected"; ?> value="200">200 registros</option>
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>200&&$_GET['limit']<=800) echo "selected"; ?> value="800">800 registros</option>
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>800&&$_GET['limit']<=1000) echo "selected"; ?> value="1000">1000 registros</option>
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>1000&&$_GET['limit']<=2000) echo "selected"; ?> value="2000">2000 registros</option>
      <option <?php if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>2000) echo "selected"; ?> value="8000000">Sin limite</option>
    </select>
    <script>
      function ListLog() {
        var number=document.getElementById("listar").value;
        location.href="index.php?limit="+number;
      }
    </script>
  </div>
</div>

<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Paciente</th>
            <th scope="col">Consulta</th>
            <th scope="col">Especilidad</th>
            <th scope="col">Estudiante</th>
            <th scope="col">Diagnostico</th>
            <th scope="col">Estado</th>
            <th scope="col">Revisado</th>
            <th scope="col">Fecha/hora</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>


<?php
$color=array(''=>'', 'new'=>'table-default', 'process'=>'table-primary text-primary', 'fail'=>'table-danger', 'end'=>'table-success text-success', 'canceled'=>'table-dark');
$namestatus=array(''=>'', 'new'=>'Nuevo', 'process'=>'En proceso', 'fail'=>'Abandonado', 'end'=>'Finalizado', 'canceled'=>'Anulado');
$size=count($pr);
//old
/*for ($i=0; $i < $size; $i++) {
    $len=count($pr[$i]);
    for ($j=0; $j < $len ; $j++) {
      echo " <tr class=\"".$color[$pr[$i][$j]["status"]]."\">\n";
      echo "   <td>" . ($rows) . "</td>";
      echo "   <td>" . $pr[$i][$j]["patientfullname"] . "</td>";
      echo "   <td>" . $pr[$i][$j]["consult"] . "</td>";
      echo "   <td>" . $pr[$i][$j]["clinicalname"] . "</td>";
      echo "   <td>" . $pr[$i][$j]["student"] . "</td>";
      echo "   <td>" . $pr[$i][$j]["diagnosis"] . "</td>";


      echo "   <td>" . $namestatus[$pr[$i][$j]["status"]] . "</td>";



      if($pr[$i][$j]["evaluated"] =='t')
        echo "   <td class=\"bg-success text-white\"><b>Si</b></td>";
      else
        echo "   <td class=\"bg-warning text-white\"><b>No</b></td>";
      echo "   <td>" . datetimeconv($pr[$i][$j]["time"]) . "</td>";
      $url="";
      if(isset($pr[$i][$j]["file"])){
        $url=$pr[$i][$j]["file"].".php";

      }else{
        $url='index.php';
      }



      echo "   <td><div class=\"btn-group\"><a href=\"$url?id=" . $pr[$i][$j]["ficha"] . "\" class=\"btn btn-success btn-sm\">Visualizar</a></div></td>";


      echo "</tr>";
      $rows--;
    }
}
echo "</tbody></table>\n";*/
//new
for ($i=0; $i < $size; $i++) {
  echo " <tr class=\"".$color[$pr[$i]["status"]]."\">\n";
  echo "   <td>" . ($rows) . "</td>";
  echo "   <td>" . $pr[$i]["patientfullname"] . "</td>";
  echo "   <td>" . $pr[$i]["consult"] . "</td>";
  echo "   <td>" . $pr[$i]["clinicalname"] . "</td>";
  echo "   <td>" . $pr[$i]["student"] . "</td>";
  echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";


  echo "   <td>" . $namestatus[$pr[$i]["status"]] . "</td>";


  if(isset($pr[$i]["evaluated"])){
    if($pr[$i]["evaluated"] =='t')
      echo "   <td class=\"bg-success text-white\"><b>Si</b></td>";
    else
      echo "   <td class=\"bg-warning text-white\"><b>No</b></td>";
  }else{
    echo "   <td class=\"bg-danger text-white\"><b>".$pr[$i]["ficha"]."</b></td>";
  }


  echo "   <td>" . datetimeconv($pr[$i]["time"]) . "</td>";
  $url="";
  if(isset($pr[$i]["file"])){
    $url=$pr[$i]["file"].".php";

  }else{
    $url='index.php';
  }



  echo "   <td><div class=\"btn-group\"><a href=\"$url?id=" . $pr[$i]["ficha"] . "\" class=\"btn btn-success btn-sm\">Visualizar</a></div></td>";


  echo "</tr>";
  $rows--;
}
echo "</tbody></table>\n";
?>
<!--tabla para pacientes remitidos fin-->



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
