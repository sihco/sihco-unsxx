<?php
session_start();
ob_end_flush();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

$results_per_page = 15;
$clinicalids="";

$page = isset($_POST['page']) ? $_POST['page'] : 1; //pagina actual
$patientfullname = isset($_POST['patientfullname']) ? htmlspecialchars(trim($_POST['patientfullname'])) : "";
$studentfullname = isset($_POST['studentfullname']) ? htmlspecialchars(trim($_POST['studentfullname'])) : "";

$currdate=time();
$stdate = isset($_POST['stdate']) ? $_POST['stdate'] : '2023-01-01';
$endate = isset($_POST['endate']) ? $_POST['endate'] : date("Y-m-d", $currdate);

$stdate = strtotime($stdate);
$endate = strtotime($endate);
if($stdate>$endate){
  $tmpdate=$stdate;
  $stdate=$endate;
  $endate=$tmpdate;
}
if($endate >= strtotime(date("Y-m-d", $currdate))){
  $endate=time();
}else{
  $endate=$endate+3600*24-1;
}

if(isset($_POST['specialty'])&& is_numeric($_POST['specialty'])){
  $clinicalids=$_POST['specialty'];
}else{
  if(isset($_SESSION['usertable']['usernumber'])){
    $ac = DBAllSpecialtyInfo($_SESSION['usertable']['usernumber'], true);
    $clinicalids="";
    for ($i=0; $i < count($ac); $i++) {
      if($i>0) $clinicalids.=", ";
      $clinicalids.=$ac[$i]['clinicalid'];
    }
  }else{
    exit;
  }
}

$tabledata='';
$paginationdata='';
$sizedata = count(DBAllRemissionPatientInfo($patientfullname, $studentfullname, $clinicalids, $stdate, $endate));
$allpages = ceil($sizedata / $results_per_page);

if($sizedata>0){

  $start_limit = ($page - 1)*$results_per_page;

  $pr = DBAllRemissionPatientInfo($patientfullname, $studentfullname,
  	     $clinicalids, $stdate, $endate, $results_per_page, $start_limit);

  $color=array(''=>'', 'new'=>'table-default', 'process'=>'table-primary text-primary', 'fail'=>'table-danger',
   'end'=>'table-success text-success', 'canceled'=>'table-dark');
  $size=count($pr);
  for ($i=0; $i < $size; $i++) {
        if(!empty($pr[$i]['status'])&&isset($color[$pr[$i]['status']]))
          $tabledata .= " <tr class=\"".$color[$pr[$i]['status']]."\">\n";
        else
          $tabledata .= " <tr>\n";

        $tabledata .= "   <td>" . $pr[$i]['remissionid'] . "</td>";
        $patientfullname = $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"];
        $tabledata .= "   <td>" . $patientfullname ."</td>";
        $tabledata .= "   <td>" . $pr[$i]["patientage"] . "</td>";
        $tabledata .= "   <td>" . $pr[$i]["diagnosis"] . "</td>";
        if($pr[$i]['clinicalid'] == 6)
          $tabledata .= "   <td><a href=\"surgeryiiread.php?id=".$pr[$i]['remissionid']."\" class=\"btn btn-sm btn-outline-secondary\">" . $pr[$i]['clinicalspecialty'] . "</a></td>";
        else
          $tabledata .= "   <td>" . $pr[$i]['clinicalspecialty'] . "</td>";

  			$tabledata .= "   <td>" . datetimeconv($pr[$i]["updatetimeremission"]) ."</td>";

        if(!empty($pr[$i]["userfullname"])){
          $tabledata .= " <td>".$pr[$i]['userfullname']."</td>";
        }else{
          $tabledata .= "   <td><div class=\"btn-group\"><button type=\"button\" cli=\"".$pr[$i]['clinicalid']."\" ".
          "pname=\"".$patientfullname."\" remp=\"".$pr[$i]['remissionid']."\" class=\"assigned btn btn-sm btn-primary\" data-bs-toggle=\"modal\" ".
          "data-bs-target=\"#modalassigned\">Designar</button>".
          "<a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Ver Ficha</a></div></td>";

        }
        $tabledata .= "<td>";
        if($pr[$i]["teacherid"]!=NULL&& is_numeric($pr[$i]["teacherid"])){
          if($pr[$i]["teacherid"]!=0){
            $tabledata .= $pr[$i]['teacherfullname'];
          }else{
            $tabledata .= "   <div class=\"btn-group\"><input type=\"button\" class=\"btn btn-sm btn-primary btn_autorization\" name=\"btn_autorization\" onclick=autorization(\"".$pr[$i]['remissionid']."\",$page) value=\"Autorizar\">".
            "<a href=\"admissionread.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Ver Ficha</a></div>";
          }

        }
        $tabledata .= "</dt>";
        $tabledata .= "</tr>";
  }

}else{
  $tabledata = "<center>No se encontro resultados</center>";
}

//para paginacion
if($allpages>0){
  $adjacents=1;
  $prevlabel = "&lsaquo; Anterior";
  $nextlabel = "Siguiente &rsaquo;";
  $paginationdata .= '  <ul class="pagination">';
  $paginationdata .= "  pagina &nbsp;".$page."&nbsp;con&nbsp;";

  //$total=$RegistrationInitial+$RegistrationPag;
  $all=$start_limit+$results_per_page;//10
  if($all > $sizedata){
    $all = $sizedata;
  }
  $paginationdata .= '<li class="page-item active"><a class=" href="#"> '.($all).' </a></li> ';
  $paginationdata .= " &nbsp;de&nbsp;".$sizedata." registros";
  $paginationdata .= '</ul>';
  $paginationdata .= '<ul class="pagination d-flex flex-wrap">';
  // previous label
  if ($page != 1) {
    $paginationdata .= "<li class='page-item'><a class='page-link'  onclick=\"loadData(1)\"><span aria-hidden='true'>&laquo;</span></a></li>";
  }
  if ($page==1) {
    $paginationdata .= "<li class='page-item'><a class='page-link text-muted'>$prevlabel</a></li>";
  } else if($page==2) {
    $paginationdata .= "<li class='page-item'><a href='javascript:void(0);' onclick=\"loadData(1)\" class='page-link'>$prevlabel</a></li>";
  }else {
    $paginationdata .= "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"loadData($page-1)\">$prevlabel</a></li>";
  }

  // first label
  if($page>($adjacents+1)) {
    $paginationdata .= "<li class='page-item'><a href='javascript:void(0);' class='page-link' onclick=\"loadData(1)\">1</a></li>";
  }
  // interval
  if($page>($adjacents+2)) {
    $paginationdata .= "<li class='page-item'><a class='page-link'>...</a></li>";
  }

  // pages

  $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
  $pmax = ($page<($allpages-$adjacents)) ? ($page+$adjacents) : $allpages;
  for($i=$pmin; $i<=$pmax; $i++) {
    if($i==$page) {
      $paginationdata .= "<li class='page-item active'><a class='page-link'>$i</a></li>";
    }else if($i==1) {
      $paginationdata .= "<li class='page-item'><a href='javascript:void(0);' class='page-link'onclick=\"loadData(1)\">$i</a></li>";
    }else {
      $paginationdata .= "<li class='page-item'><a href='javascript:void(0);' onclick=\"loadData(".$i.")\" class='page-link'>$i</a></li>";
    }
  }
  // interval

  if($page<($allpages-$adjacents-1)) {
    $paginationdata .= "<li class='page-item'><a class='page-link'>...</a></li>";
  }
  // last
  if($page<($allpages-$adjacents)) {
    $paginationdata .= "<li class='page-item'><a href='javascript:void(0);'class='page-link ' onclick=\"loadData($allpages)\">$allpages</a></li>";
  }
  // next

  if($page<$allpages) {
    $paginationdata .= "<li class='page-item'><a href='javascript:void(0);'class='page-link' onclick=\"loadData($page+1)\">$nextlabel</a></li>";
  }else {
    $paginationdata .= "<li class='page-item'><a class='page-link text-muted'>$nextlabel</a></li>";
  }
  if ($page != $allpages) {
    $paginationdata .= "<li class='page-item'><a class='page-link' onclick=\"loadData($allpages)\"><span aria-hidden='true'>&raquo;</span></a></li>";
  }

  $paginationdata .= "</ul>";
}
//echo $tabledata;
$responseData = array('tableData' => $tabledata, 'paginationData' => $paginationdata);
echo json_encode($responseData);
?>
