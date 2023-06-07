<?php
if(!isset($_SESSION)) session_start();
require_once("../globals.php");
require_once("../db.php");
if(isset($_POST["search"]) && $_POST["search"]!=""){ $search=trim($_POST["search"]);} else {$search=""; }
if (isset($_POST['page'])) { $currentPag = $_POST['page']; } else { $currentPag = 1; }
//variable que permite mostrar 5 filas se puede cambiar
if(isset($_POST["select"])) { $RegistrationPag = $_POST["select"]; } else { $RegistrationPag = 15; }
if(isset($_POST["selectspecialty"])) { $specialty = $_POST["selectspecialty"]; } else { $specialty = -1; }
if(isset($_POST["searchstudent"]) && $_POST["searchstudent"]!=""){ $searchstudent=trim($_POST["searchstudent"]);} else {$searchstudent=""; }
//echo $dateSearchi;
//echo $typeUser;
$TotalPages = 0;
?>
<?php
//$size1 = count(DBAllPatientRemissionInfo(null, $search, false, false));

$size1=count(DBAllRemissionPatientInfo($_SESSION['usertable']['usernumber'], false, true, false, false, $search, false, false, $specialty, $searchstudent));
//$student=null, $assigned=false, $all=false, $typeteacher=false, $typeteacherother=false, $search='', $RegistrationPag=false, $RegistrationInitial=false
if ($size1>0) {
  //echo $currentPag;
  //calculamos el total de paginas
  $TotalPages = ceil($size1 / $RegistrationPag);
  //calculamos el registro inicial
  $RegistrationInitial = ($currentPag - 1) * $RegistrationPag;

}
?>
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
