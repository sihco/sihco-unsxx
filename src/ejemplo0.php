<?php

$d=time();
$msg=date ('Y-m-d\TH:i:s', $d);//strtotime($d)
//2000-01-01T00:00
$d2=strtotime($msg);
$msg2=date ('Y-m-d\TH:i:s', $d2);//strtotime($d)
echo $msg."===".$msg2;
echo "<br>";
echo $d."===".$d2;
?>
