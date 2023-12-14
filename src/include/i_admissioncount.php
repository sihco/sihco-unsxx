<?php
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

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

$a = DBCountpatientclinicalInfo($stdate, $endate);

$prosthodontics= array(0,0,0,0);
$operative=array(0,0,0,0);
$surgery=array(0,0,0,0);
$pediatrics=array(0,0,0,0);

for ($i=0; $i < count($a); $i++) {
  switch ($a[$i]['clinicalid']) {
    case 2: $prosthodontics[0] = $a[$i]['amount']; break;
    case 3: $prosthodontics[1] = $a[$i]['amount']; break;
    case 10: $prosthodontics[2] = $a[$i]['amount']; break;
    case 11: $prosthodontics[3] = $a[$i]['amount']; break;

    case 4: $operative[0] = $a[$i]['amount']; break;
    case 5: $operative[1] = $a[$i]['amount']; break;
    case 12: $operative[2] = $a[$i]['amount']; break;
    case 13: $operative[3] = $a[$i]['amount']; break;

    case 6: $surgery[0] = $a[$i]['amount']; break;
    case 7: $surgery[1] = $a[$i]['amount']; break;
    case 14: $surgery[2] = $a[$i]['amount']; break;
    case 15: $surgery[3] = $a[$i]['amount']; break;

    case 8: $pediatrics[0] = $a[$i]['amount']; break;
    case 9: $pediatrics[1] = $a[$i]['amount']; break;
    case 16: $pediatrics[2] = $a[$i]['amount']; break;
    case 17: $pediatrics[3] = $a[$i]['amount']; break;
  }
}
$responseData = array('prosthodontics' => $prosthodontics, 'operative' => $operative,
  'surgery' => $surgery, 'pediatrics' => $pediatrics);
echo json_encode($responseData);
?>
