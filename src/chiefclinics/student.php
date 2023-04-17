<?php
require('header.php');
if(!isset($_GET['student']) || ($_GET['student'])&&!is_numeric($_GET['student'])){
  ForceLoad("index.php");
}
?>

            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-4">

                        <h3 class="mt-4">Fichas Clinicas Del Estudiante: <span class="text-danger"><?php $userinfo=DBUserInfo($_GET['student']); echo ucwords($userinfo['userfullname']);?></span></h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>

<table class="table table-sm table-responsive table-hover">
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
$pr=array();

$pr = DBRemissionInfo($_GET['student']);
$size=count($pr);
for ($i=0; $i < $size; $i++) {
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



      if (isset($pr[$i]["inputfile"])&&$pr[$i]["inputfile"] != null) {
        $tx = $pr[$i]["inputfilehash"];
        echo "<td><a href=\"#\" class=\"btn btn-primary btn-sm\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".filedownload($pr[$i]["inputfile"], $pr[$i]["inputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\">". $pr[$i]["remission"] ."</a>" .
             //"<img title=\"hash: $tx\" alt=\"$tx\" width=\"25\" src=\"../images/bigballoontransp-hash.png\" />" .
               "</td>";
      }else{
        echo "   <td>" . $pr[$i]["remission"] . "</td>";
      }

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

        if (isset($pr[$i]["inputfile"])&&$pr[$i]["inputfile"] != null) {
          $tx = $pr[$i]["inputfilehash"];

          echo "   <td><div class=\"btn-group\"><a href=\"#\" class=\"btn btn-primary btn-sm\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?" .
          filedownload($pr[$i]["inputfile"], $pr[$i]["inputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\">" .
          "Ver PDF</a>" . "<a href=\"report$url?id=" . $ficha . "\" class=\"btn btn-success btn-sm\">Imprimir</a></div></td>";
        }else{

          echo "   <td><div class=\"btn-group\"><a href=\"report$url?id=" . $ficha . "\" class=\"btn btn-success btn-sm\">Imprimir</a></div></td>";

        }

      }else{
        echo "   <td><div class=\"btn-group\"><a href=\"report.php?id=" . $ficha . "\" class=\"btn btn-success btn-sm\">Imprimir</a></div></td>";

      }

      echo "</tr>";
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
