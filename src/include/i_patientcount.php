<?php
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

$a = DBCountpatientclinicalInfo();

$prosthodontics=0;
$operative=0;
$surgery=0;
$pediatrics=0;
for ($i=0; $i < count($a); $i++) {
  switch ($a[$i]['clinicalid']) {
    case 2: $prosthodontics += $a[$i]['amount']; break;
    case 3: $prosthodontics += $a[$i]['amount']; break;
    case 10: $prosthodontics += $a[$i]['amount']; break;
    case 11: $prosthodontics += $a[$i]['amount']; break;

    case 4: $operative += $a[$i]['amount']; break;
    case 5: $operative += $a[$i]['amount']; break;
    case 12: $operative += $a[$i]['amount']; break;
    case 13: $operative += $a[$i]['amount']; break;

    case 6: $surgery += $a[$i]['amount']; break;
    case 7: $surgery += $a[$i]['amount']; break;
    case 14: $surgery += $a[$i]['amount']; break;
    case 15: $surgery += $a[$i]['amount']; break;

    case 8: $pediatrics += $a[$i]['amount']; break;
    case 9: $pediatrics += $a[$i]['amount']; break;
    case 16: $pediatrics += $a[$i]['amount']; break;
    case 17: $pediatrics += $a[$i]['amount']; break;
  }
}
$responseData = array('prosthodontics' => $prosthodontics, 'operative' => $operative,
  'surgery' => $surgery, 'pediatrics' => $pediatrics);
echo json_encode($responseData);
?>
