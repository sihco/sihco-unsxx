<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");

if(isset($_SESSION['usertable']['usernumber'])&& is_numeric($_SESSION['usertable']['usernumber'])){
  DBUpdateInfoUser($_SESSION['usertable']['usernumber'], time());
  include('viewqr.php');
}else{
  echo "No";
}


?>
