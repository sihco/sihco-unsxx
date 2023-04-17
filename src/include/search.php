<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");
//examined
//clinical
if (isset($_POST["examined"]) && isset($_POST["clinical"])) {


   $search1=htmlspecialchars($_POST["examined"]);
   $search2=htmlspecialchars($_POST["clinical"]);
   //echo $search1." ".$search2;
   DBSpecialtySearchInfo($search1, $search2,'div','student');

    exit;
}
if (isset($_POST["searchname"])&& isset($_POST["searchfisrtname"])&& isset($_POST["searchlastname"])) {
   $searchname=htmlspecialchars($_POST["searchname"]);
   $searchfisrtname=htmlspecialchars($_POST["searchfisrtname"]);
   $searchlastname=htmlspecialchars($_POST["searchlastname"]);
   DBPatientSearchInfo($searchname, $searchfisrtname, $searchlastname);
}else {
  if (isset($_POST["search1"]) && isset($_POST["search2"])) {
     $search1=htmlspecialchars($_POST["search1"]);
     $search2=htmlspecialchars($_POST["search2"]);
      //SELECT nombre, url FROM videos WHERE nombre LIKE '%$search%'

      DBSpecialtySearchInfo($search1,$search2,'tab');
  }else {
    if (isset($_POST["search1"])) {
      $search1=htmlspecialchars($_POST["search1"]);
      DBUserSearchInfo($search1);
    }else{
        echo "Escribir";
    }
  }
}




//echo "<p><a href='$row[url]' target='_blank'>$row[nombre]</a></p>";
//echo "<a class=\"dropdown-item text-primary\" href=\"\">Nueva Paciente</a>";



?>
