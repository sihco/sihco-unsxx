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

$size1=count(DBAllRemissionPatientInfo($_SESSION['usertable']['usernumber'], false, true, false, false, $search, false, false));
//$student=null, $assigned=false, $all=false, $typeteacher=false, $typeteacherother=false, $search='', $RegistrationPag=false, $RegistrationInitial=false
if ($size1>0) {

  //echo $currentPag;
  //calculamos el total de paginas
  $TotalPages = ceil($size1 / $RegistrationPag);
  //calculamos el registro inicial
  $RegistrationInitial = ($currentPag - 1) * $RegistrationPag;

  $pr=DBAllRemissionPatientInfo($_SESSION['usertable']['usernumber'], false, true, false, false, $search, $RegistrationPag, $RegistrationInitial, $specialty, $searchstudent);
  //$pr = DBAllRemissionInfo(null, false, $limit);
  //color por fila por tipo de estado
  $color=array(''=>'', 'new'=>'table-default', 'process'=>'table-primary text-primary', 'fail'=>'table-danger', 'end'=>'table-success text-success', 'canceled'=>'table-dark');
  $size=count($pr);
  for ($i=0; $i < $size; $i++) {
        if(isset($pr[$i]['status'])&&isset($color[$pr[$i]['status']]))
          echo " <tr class=\"".$color[$pr[$i]['status']]."\">\n";
        else
          echo " <tr class==\"\">\n";
        echo "   <td>" . $pr[$i]['remissionid'] . "</td>";
        $fullname=$pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"];
        echo "   <td>" . $fullname ."</td>";
        echo "   <td>" . $pr[$i]["patientage"] . "</td>";
        echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";
        if($pr[$i]['clinicalid'] == 6){
          echo "   <td><a href=\"surgeryiiread.php?id=".$pr[$i]['remissionid']."\" class=\"btn btn-sm btn-outline-secondary\">" . $pr[$i]['clinicalspecialty'] . "</a></td>";

        }else{
          echo "   <td>" . $pr[$i]['clinicalspecialty'] . "</td>";
        }

  			echo "   <td>" . datetimeconv($pr[$i]["updatetimeremission"]) ."</td>";

        if($pr[$i]["studentid"]!=NULL&& is_numeric($pr[$i]["studentid"])){
          $u=DBUserInfo($pr[$i]['studentid']);
          echo " <td>".$u['userfullname']."</td>";
        }else{
          echo "   <td><div class=\"btn-group\"><button type=\"button\" cli=\"".$pr[$i]['clinicalid']."\" ".
          "pname=\"".$fullname."\" remp=\"".$pr[$i]['remissionid']."\" class=\"assigned btn btn-sm btn-primary\" data-bs-toggle=\"modal\" ".
          "data-bs-target=\"#modalassigned\">Designar</button>".
          "<a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Ver Ficha</a></div></td>";

        }
        echo "<td>";
        if($pr[$i]["teacherid"]!=NULL&& is_numeric($pr[$i]["teacherid"])){
          if($pr[$i]["teacherid"]!=0){
            $u=DBUserInfo($pr[$i]['teacherid']);
            echo $u['userfullname'];
          }else{
            echo "   <div class=\"btn-group\"><input type=\"button\" class=\"btn btn-sm btn-primary btn_autorization\" name=\"btn_autorization\" onclick=autorization(\"".$pr[$i]['remissionidch']."\",$currentPag) value=\"Autorizar\">".
            "<a href=\"admissionread.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Ver Ficha</a></div>";
          }

        }
        echo "</dt>";
        echo "</tr>";
  }

}else{
  echo "<center>No se encontro resultados</center>";
}
?>
