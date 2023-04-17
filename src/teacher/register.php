<?php
require('header.php');
?>

                    <div class="container-fluid px-4">

                        <h2 class="mt-4">Especilidades designadas</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>
<div class="table-responsive">

<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre Completo</th>
            <th scope="col">Curso</th>
            <th scope="col">Especialidad</th>
            <th scope="col">Fecha de Inscripción</th>
            <th scope="col">Fecha de Baja</th>

        </tr>
    </thead>
    <tbody>



<?php
//$usr = DBAllUserInfo();
$a = DBAllSpecialtyInfo($_SESSION["usertable"]["usernumber"], true);
$size=count($a);
$ac = array(3 => '3er Año', 4 => '4to Año', 5 => '5to Año' );
for ($i=0; $i < $size; $i++) {
      $user=DBUserInfo($a[$i]['userid']);
      $clinical=DBClinicalInfo($a[$i]['clinicalid']);
      echo " <tr>\n";
			echo "	<td>$i</td>\n";
			echo "  <td>" . ucwords($user['userfullname']) . "</td>\n";
			echo "  <td>" . $ac[$a[$i]["coursenumber"]] . "</td>\n";
			echo "  <td>" . $clinical["clinicalspecialty"] . "</td>\n";//$a[$i]["specialty"]
			echo "  <td>" . datetimeconv($a[$i]["stdatetime"]) ."</td>\n";
			if($a[$i]['specialtyenabled']=='f'){
				echo "  <td>" . datetimeconv($a[$i]["updatetime"]) ."</td>\n";
			}else{
        echo "<td><button type=\"button\" onclick=\"save(".$user["usernumber"].",".$a[$i]["clinicalid"].
        ")\" class=\"btn btn-danger\" name=\"".$a[$i]["userid"]."\" id=\"\">Dar de baja</button></td>";
			}

			echo "</tr>";
}
echo "</tbody></table>\n";

?>
<!--tabla para pacientes remitidos fin-->
</div>


                    </div>

<?php
require('footer.php');
?>
<script>
function save(id, clinical){
  if(confirm("¿Estas seguro de finalizar? ¡No será visible tu nombre en la especilidad!")){
    var iduser=id;
    var idclinical=clinical;
    $.ajax({
         url:"../include/i_user.php",
         method:"POST",
         data: {userid:iduser, clinicalid:idclinical, status:''},
         success:function(data)
         {
            alert(data);
            location.reload();
         }
    });
  }

}
</script>
