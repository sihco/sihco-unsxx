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
$sizedata = count(DBAllRemissionPatientInfo($patientfullname, $studentfullname, $clinicalids, $stdate, $endate, -1, -1, $_SESSION['usertable']['usernumber']));

$allpages = ceil($sizedata / $results_per_page);

if($sizedata>0){

  $start_limit = ($page - 1)*$results_per_page;

  $pr = DBAllRemissionPatientInfo($patientfullname, $studentfullname,
  	     $clinicalids, $stdate, $endate, $results_per_page, $start_limit, $_SESSION['usertable']['usernumber']);

  $color=array(''=>'', 'new'=>'table-default', 'process'=>'table-primary text-primary', 'fail'=>'table-danger', 'end'=>'table-success text-success', 'canceled'=>'table-dark');
  $namestatus=array(''=>'', 'new'=>'Nuevo', 'process'=>'En proceso', 'fail'=>'Abandonado', 'end'=>'Finalizado', 'canceled'=>'Anulado');
  $historytable=array(2=>'removable', 3=>'fixed', 4=>'operative', 5=>'endodontics',
    6=>'surgeryii', 7=>'periodonticsii', 8=>'pediatricsi', 9=>'orthodontics', 10=>'removable',
    11=>'fixed', 12=>'operative', 13=>'endodontics', 14=>'surgeryiii', 15=>'periodonticsiii',
    16=>'pediatricsi', 17=>'orthodontics');
  $size=count($pr);
  for ($i=0; $i < $size; $i++) {
        if(!empty($pr[$i]['status'])&&isset($color[$pr[$i]['status']]))
          $tabledata .= " <tr class=\"".$color[$pr[$i]['status']]."\">\n";
        else
          $tabledata .= " <tr>\n";
        $tabledata .= "   <td>" . ($size-$i) . "</td>";
        $tabledata .= "   <td>" . $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</td>";
        $tabledata .= "   <td>" . $pr[$i]["patientage"] . "</td>";
        $tabledata .= "   <td>" . $pr[$i]["motconsult"] . "</td>";
        $tabledata .= "   <td>" . $pr[$i]['clinicalspecialty'] . "</td>";
        if($pr[$i]["teacherid"]!=0&& is_numeric($pr[$i]["teacherid"])&& $pr[$i]['authorized']=='t'){
          $tabledata .= "   <td>".$pr[$i]['teacherfullname']."</td>";
        }else{
          if($pr[$i]["teacherid"]==0&& $pr[$i]['authorized']=='t'){
            $tabledata .= " <td><div class=\"catimg\"><img src=\"../images/loading.gif\" alt=\"...\"></div></td>";
          }else{
            $tabledata .= "<td>";
            //echo " <input type=\"button\" class=\"btn btn-sm btn-success btn_autorization\" name=\"btn_autorization\" hc=".$pr[$i]['remissionidch']." value=\"Solicitar\">";
            //inicio autorizar por qr
            $tabledata .= '<button type="button" class="btn btn-outline-success btn-sm" name="local_button" onclick="readqr('.$pr[$i]['remissionid'].',\'authorizeqr\')" data-bs-toggle="modal" data-bs-target="#modalqr">Solicitar <i class="fa fa-solid fa-qrcode"></i></button>';
            //fin autorizar por qr

            //echo "<button type=\"button\"".
            //"ch=\"".$pr[$i]['remissionidch']."\" class=\"btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
            //"data-bs-target=\"#modalautorization\"><i class=\"fa fa-2x fa-solid fa-info\"></i></button>";
            $tabledata .= "</td>";

          }
        }
        $tabledata .= "   <td>".$namestatus[$pr[$i]["status"]]."</td>";

        $tabledata .= "   <td>" . datetimeconv($pr[$i]["stdatetime"]) ."</td>";
        if(isset($pr[$i]['endatetime'])&& $pr[$i]['endatetime']!=-1) $tabledata .= '<td>'.dateconv($pr[$i]['endatetime']).'</td>';
        else $tabledata .= "   <td></td>";

        $tabledata .= "   <td>";
        $tabledata .= "<div class=\"btn-group\">" ;

        if(isset($pr[$i]["status"])&& $pr[$i]["status"]!='end'){
          $tabledata .= "<button type=\"button\"".
          "ch=\"".$pr[$i]['remissionid']."\" class=\"send_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
          "data-bs-target=\"#subfile\"><i class=\"fas fa-2x fa-regular fa-upload\"></i></button>";
        }

        if (isset($pr[$i]["inputfile"])&& $pr[$i]["inputfile"] != null) {
          $tx = $pr[$i]["inputfilehash"];
          $tabledata .= "<a href=\"#\" class=\"btn btn-sm btn-outline-primary\" style=\"font-weight:bold\" onClick=\"window.open('../filewindow.php?".
          filedownload($pr[$i]["inputfile"], $pr[$i]["inputfilename"])."', 'Ver - Ficha', 'width=680,height=600,scrollbars=yes,resizable=yes')\"><i class=\"fas fa-2x fa-solid fa-eye\"></i></a>";

          $tabledata .= "  <a class=\"btn btn-sm btn-outline-success\" href=\"../filedownload.php?" .
          filedownload($pr[$i]["inputfile"] ,$pr[$i]["inputfilename"]) ."\">" .
          "<i class=\"fas fa-2x fa-solid fa-download\"></i></a>";
        }
        $tabledata .= "<button type=\"button\"".
        "ch=\"".$pr[$i]['remissionid']."\" class=\"detail_modal btn btn-sm btn-outline-secondary\" data-bs-toggle=\"modal\" ".
        "data-bs-target=\"#detail\"><i class=\"fa fa-2x fa-solid fa-info\"></i></button>";
        if($pr[$i]['clinicalid']==6|| $pr[$i]['clinicalid']==14){
          $tabledata .= "  <a class=\"btn btn-sm btn-outline-primary\" href=\"".$historytable[$pr[$i]['clinicalid']].".php?id=".$pr[$i]['remissionid']."\">" .
                "<i class='fa fa-2x fa-edit'></i></a>";
        }

        $tabledata .= "</div>";

        $tabledata .= "</td>";
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
echo $tabledata;
//$responseData = array('tableData' => $tabledata, 'paginationData' => $paginationdata);
//echo json_encode($responseData);
?>
