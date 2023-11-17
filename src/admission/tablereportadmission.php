<?php
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

$results_per_page = 15;
$clinicalids="";

$page = isset($_POST['page']) ? $_POST['page'] : 1; //pagina actual
$patientfullname = isset($_POST['patientfullname']) ? htmlspecialchars(trim($_POST['patientfullname'])) : "";
$studentfullname = isset($_POST['studentfullname']) ? htmlspecialchars(trim($_POST['studentfullname'])) : "";
$startage = isset($_POST['startage'])&&is_numeric($_POST['startage']) ? $_POST['startage'] : 0;
$endage = isset($_POST['endage'])&&is_numeric($_POST['endage']) ? $_POST['endage'] : 100;

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


$gender="";
if(isset($_POST['gender'])&& !empty($_POST['gender'])){
  if($_POST['gender'] == 'm') $gender = 'masculino';
  else $gender = 'femenino';
}

if($startage > $endage){
  $tmpage=$startage;
  $startage=$endage;
  $endage=$tmpage;
}

if(isset($_POST['checkboxStates'])){
  $checkboxStates = json_decode($_POST['checkboxStates'], true);
  $ac = array(2, 10, 3, 11, 4, 12, 5, 13, 6, 14, 7, 15, 8, 16, 9, 17);
  $clinicalids="";
  for ($i=0; $i < count($checkboxStates); $i++) {
    if($checkboxStates[$i]){
      if(!empty($clinicalids)){
        $clinicalids.=", ";
      }
      $clinicalids.=$ac[$i];
    }
  }
}

$tabledata='';
$paginationdata='';
$sizedata = count(DBAllPatientAdmission($patientfullname, $startage, $endage, $gender, $clinicalids, $studentfullname,
                                          $stdate, $endate));
$allpages = ceil($sizedata / $results_per_page);

if($sizedata>0){

  $start_limit = ($page - 1)*$results_per_page;

  $pr = DBAllPatientAdmission($patientfullname, $startage, $endage, $gender, $clinicalids, $studentfullname,
                                $stdate, $endate, $results_per_page, $start_limit);

  $size=count($pr);
  $regc = $sizedata;
  for ($i=0; $i < $size; $i++) {
        $tabledata .= " <tr>\n";
        $tabledata .= "   <td>" . $pr[$i]['patientadmissionid'] . "</td>";
        $tabledata .= "   <td><a href=\"patientfollow.php?id=".$pr[$i]['patientid']."\">" . $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</a></td>";
        $tabledata .= "   <td>" . $pr[$i]["patientage"] . "</td>";
        $tabledata .= "   <td>" . $pr[$i]["patientgender"] . "</td>";
        $tabledata .= "   <td>" . $pr[$i]["clinicalspecialty"] . "</td>";

        $tabledata .= "   <td>" . $pr[$i]["userfullname"] ."</td>";
        $tabledata .= "   <td>" . datetimeconv($pr[$i]["updatetime"]) ."</td>";
        //$tabledata .= "   <td><div class=\"btn-group\"><a href=\"patientfollow.php?id=".$pr[$i]['patientid']."\" class=\"btn btn-primary btn-sm\" name=\"\" >Ver</a></div></td>";

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
