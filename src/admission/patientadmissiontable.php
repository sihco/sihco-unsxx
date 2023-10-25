<?php
require_once('../globals.php');
require_once('../db.php');
if(isset($_POST["search"]) && $_POST["search"]!=""){ $search=trim($_POST["search"]);} else { $search=""; }
if (isset($_POST['page'])) { $currentPag = $_POST['page']; } else { $currentPag = 1; }
//variable que permite mostrar 5 filas se puede cambiar
if(isset($_POST["select"])) { $RegistrationPag = $_POST["select"]; } else { $RegistrationPag = 15; }
//echo $dateSearchi;
//echo $typeUser;
$TotalPages = 0;

?>
<table class="table table-sm table-striped table-hover ">
    <thead>
      <tr>
          <th scope="col">#</th>
          <th scope="col">Paciente</th>
          <th scope="col">Consulta</th>
          <th scope="col">Diagnostico</th>
          <th scope="col">Examinado Por</th>
          <th scope="col">Remision</th>
          <th scope="col">Estudiante Designado</th>
          <th scope="col">Fecha</th>
          <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
<?php
$size1 = count(DBAllPatientRemissionInfo(null, $search, false, false));

if ($size1>0) {

  //echo $currentPag;
  //calculamos el total de paginas
  $TotalPages = ceil($size1 / $RegistrationPag);
  //calculamos el registro inicial
  $RegistrationInitial = ($currentPag - 1) * $RegistrationPag;

  $pr=DBAllPatientRemissionInfo(null, $search, $RegistrationPag, $RegistrationInitial);
  //$pr = DBAllRemissionInfo(null, false, $limit);
  $size=count($pr);
  for ($i=0; $i < $size; $i++) {
    echo " <tr>\n";
    echo "   <td>" . $pr[$i]["patientadmissionid"] . "</td>";
    echo "   <td><a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\">" . $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</a></td>";
    echo "   <td>" . $pr[$i]["motconsult"] . "</td>";
    echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";
    $in=DBUserInfo($pr[$i]['studentid']);
    echo "   <td>".$in['userfullname']."</td>";
    echo "   <td>";
    $stdesigned=-1;
    if($pr[$i]['remission']!=null){
      $size2=count($pr[$i]['remission']);
      for ($j=0; $j < $size2 ; $j++) {
          $stdesigned = $pr[$i]['remission'][$j]['studentid'];

          if($pr[$i]['remission'][$j]['clinicalid']==6){
            $stmp=DBUserInfo($stdesigned);
            if(isset($_SESSION['usertable3'])&& $stmp['userfullname']==$_SESSION['usertable3']['userfullname']){
              echo "<a href=\"surgeryii.php?id=".$pr[$i]['remission'][$j]['remissionid']."\" class=\"btn btn-sm btn-outline-primary\">".$pr[$i]['remission'][$j]['clinicalspecialty']."</a>";
            }else{
              echo "<button type=\"button\" class=\"btn btn-sm btn-outline-primary\" name=\"data\" onclick=\"getdata('".$stmp['userfullname']."', '".$stmp['username']."', ".$pr[$i]['remission'][$j]['remissionid'].")\">".$pr[$i]['remission'][$j]['clinicalspecialty']."</button>";
            }
            //echo "<a href=\"#\" onclick="">".$pr[$i]['remission'][$j]['clinicalspecialty']."</a>";
          }else{
            echo $pr[$i]['remission'][$j]['clinicalspecialty'];
          }


      }
    }
    echo "</td>";

    if(is_numeric($stdesigned)&&$stdesigned>0){
      $stdesigned=DBUserInfo($stdesigned);
      echo "   <td>".$stdesigned['userfullname']."</td>";
    }else{
      echo "<td></td>";
    }


    echo "   <td>" . datetimeconv($pr[$i]["updatetime"]) ."</td>";
    echo "   <td><div class=\"btn-group\"><a href=\"admission.php?id=" .
      $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-primary btn-sm\" name=\"\" >Actualizar</a><a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Imprimir</a></div></td>";

    echo "</tr>";
  }

}else{
  echo "<center>no se encontro resultados</center>";
}
?>
  </tbody>
</table>
<?php
if($TotalPages!=0){
  $adjacents=1;
  $prevlabel = "&lsaquo; Anterior";
  $nextlabel = "Siguiente &rsaquo;";
    echo "<div class='d-flex flex-wrap flex-sm-row justify-content-between'>";
      echo '<ul class="pagination">';
        echo "pagina &nbsp;".$currentPag."&nbsp;con&nbsp;";
          $total=$RegistrationInitial+$RegistrationPag;
          if($total > $size1){
            $total = $size1;
          }
        echo '<li class="page-item active"><a class=" href="#"> '.($total).' </a></li> ';
        echo " &nbsp;de&nbsp;".$size1." registros";
      echo '</ul>';

      echo '<ul class="pagination d-flex flex-wrap">';

      // previous label
      if ($currentPag != 1) {
        echo "<li class='page-item'><a class='page-link'  onclick=\"PatientDerivative(1)\"><span aria-hidden='true'>&laquo;</span></a></li>";
      }
      if($currentPag==1) {
        echo "<li class='page-item'><a class='page-link text-muted'>$prevlabel</a></li>";
      } else if($currentPag==2) {
        echo "<li class='page-item'><a href='javascript:void(0);' onclick=\"PatientDerivative(1)\" class='page-link'>$prevlabel</a></li>";
      }else {
        echo "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"PatientDerivative($currentPag-1)\">$prevlabel</a></li>";

      }

      // first label
      if($currentPag>($adjacents+1)) {
        echo "<li class='page-item'><a href='javascript:void(0);' class='page-link' onclick=\"PatientDerivative(1)\">1</a></li>";
      }
      // interval
      if($currentPag>($adjacents+2)) {
        echo"<li class='page-item'><a class='page-link'>...</a></li>";
      }

      // pages

      $pmin = ($currentPag>$adjacents) ? ($currentPag-$adjacents) : 1;
      $pmax = ($currentPag<($TotalPages-$adjacents)) ? ($currentPag+$adjacents) : $TotalPages;
      for($i=$pmin; $i<=$pmax; $i++) {
        if($i==$currentPag) {
          echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
        }else if($i==1) {
          echo"<li class='page-item'><a href='javascript:void(0);' class='page-link'onclick=\"PatientDerivative(1)\">$i</a></li>";
        }else {
          echo "<li class='page-item'><a href='javascript:void(0);' onclick=\"PatientDerivative(".$i.")\" class='page-link'>$i</a></li>";
        }
      }

      // interval

      if($currentPag<($TotalPages-$adjacents-1)) {
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
      }
      // last

      if($currentPag<($TotalPages-$adjacents)) {
        echo "<li class='page-item'><a href='javascript:void(0);'class='page-link ' onclick=\"PatientDerivative($TotalPages)\">$TotalPages</a></li>";
      }
      // next

      if($currentPag<$TotalPages) {
        echo "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"PatientDerivative($currentPag+1)\">$nextlabel</a></li>";
      }else {
        echo "<li class='page-item'><a class='page-link text-muted'>$nextlabel</a></li>";
      }
      if ($currentPag != $TotalPages) {
        echo "<li class='page-item'><a class='page-link' onclick=\"PatientDerivative($TotalPages)\"><span aria-hidden='true'>&raquo;</span></a></li>";
      }

      echo "</ul>";
      echo "</div>";
}

?>
